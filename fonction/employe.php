<?php
    include 'liaisonBD.php';
    $pdo = connecteBD();

    function renvoyerEmployes(): array {
        global $pdo;

        $requete = "SELECT nom, prenom, login.login AS id_compte, 
                           telephone, type_utilisateur.nom_type AS type_utilisateur, 
                           employe.id_employe
                    FROM employe
                    JOIN login
                    ON login.id_employe = employe.id_employe
                    JOIN type_utilisateur
                    ON type_utilisateur.id_type = login.id_type
                    ORDER BY nom, prenom";
        $stmt = $pdo->query($requete);
        return $stmt->fetchAll();
    }

    function supprimerEmploye($id_employe): void {
        global $pdo;

        try {
            // Démarrage de la transaction
            $pdo->beginTransaction();

            // Requête SQL pour supprimer le login
            $requeteLogin = "DELETE FROM login WHERE id_employe = :id_employe";
            $stmtLogin = $pdo->prepare($requeteLogin);
            $stmtLogin->bindParam(':id_employe', $id_employe);
            $stmtLogin->execute();

            // Requête SQL pour supprimer l'employé
            $requeteEmploye = "DELETE FROM employe WHERE id_employe = :id_employe";
            $stmtEmployer = $pdo->prepare($requeteEmploye);
            $stmtEmployer->bindParam(':id_employe', $id_employe);
            $stmtEmployer->execute();

            // Validation de la transaction
            $pdo->commit();
        } catch (Exception $e) {
            // Annulation de la transaction en cas d'erreur
            $pdo->rollBack();
            throw new Exception($e->getMessage(), $e->getCode());
        }
    }

    function verifMdp($mdp): bool {
        // Vérifier que le mot de passe fait plus de 8 caractères
        if (strlen($mdp) <= 8) {
            return false;
        }

        // Vérifier qu'il contient au moins un caractère spécial
        if (!preg_match('/[\@\#\$\%\&\*\!\?]/', $mdp)) {
            return false;
        }

        // Si toutes les vérifications sont bonnes
        return true;
    }
    function verifLogin($login): bool {
        global $pdo;

        $sql = "SELECT COUNT(*) 
                FROM login 
                WHERE login = :login";
        $stmtVerif = $pdo->prepare($sql);
        $stmtVerif->bindParam(':login', $login);
        $stmtVerif->execute();
        $result = $stmtVerif->fetchColumn();

        return $result > 0;  // Si le nombre est supérieur à 0, le login existe déjà
    }

    function ajouterEmploye($nom, $prenom, $login, $telephone, $mdp, $id_type): void {
        global $pdo;

        try {
            // Démarrer une transaction
            $pdo->beginTransaction();

            // Récupérer le dernier ID employé au format 'E00000X'
            $requeteId = "SELECT id_employe 
                          FROM employe 
                          WHERE id_employe LIKE 'E%' 
                          ORDER BY id_employe DESC 
                          LIMIT 1";
            $dernierId = $pdo->query($requeteId)->fetchColumn();

            // Générer le nouvel ID
            $numero = $dernierId ? (int)substr($dernierId, 1) + 1 : 1;
            $id = 'E' . str_pad($numero, 6, '0', STR_PAD_LEFT);

            // Insérer dans la table employe
            $requeteEmploye = "INSERT INTO employe (id_employe, nom, prenom, telephone) VALUES (:id, :nom, :prenom, :telephone)";
            $stmtEmploye = $pdo->prepare($requeteEmploye);
            $stmtEmploye->execute([
                ':id' => $id,
                ':nom' => $nom,
                ':prenom' => $prenom,
                ':telephone' => $telephone
            ]);

            // Vérifier si le type d'utilisateur existe
            if (!verifIdType($id_type)) {
                throw new Exception('Le type d\'utilisateur n\'existe pas dans la table type_utilisateur.');
            }

            // Hashage du mot de passe
            $mdpHash = sha1($mdp);

            // Insérer dans la table login
            $requeteLogin = "INSERT INTO login (login, mdp, id_type, id_employe) 
                             VALUES (:login, :mdp, :id_type, :id_employe)";
            $stmtLogin = $pdo->prepare($requeteLogin);
            $stmtLogin->execute([
                ':login' => $login,
                ':mdp' => $mdpHash,
                ':id_type' => $id_type,
                ':id_employe' => $id
            ]);

            // Valider la transaction
            $pdo->commit();

        } catch (Exception $e) {
            // Annuler la transaction en cas d'erreur
            $pdo->rollBack();
            throw $e; // Propager l'exception pour gestion par l'appelant
        }
    }

    function recupAttributLogin($idEmploye) {
        global $pdo;
        try{
            // Récupérer les informations de la table salle
            $stmt = $pdo->prepare("SELECT login, mdp, id_type
                                         FROM login 
                                         WHERE id_employe = :id_employe");
            $stmt->bindParam(':id_employe', $idEmploye, PDO::PARAM_INT);
            $stmt->execute();
            $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
            return $resultat;
        }catch(Exception $e){
            // Gestion des erreurs
            echo "Erreur lors de la récupération des attributs des logins : " . $e->getMessage();
            return null;
        }
    }

    function recupAttributEmploye($idEmploye) {
        global $pdo;
        try {
            // Récupérer les informations de la table employe
            $stmt = $pdo->prepare("SELECT nom, prenom, telephone
                                          FROM employe
                                          WHERE id_employe = :id_employe");
            $stmt->bindParam(':id_employe', $idEmploye, PDO::PARAM_INT);
            $stmt->execute();
            $resultat = $stmt->fetch(PDO::FETCH_ASSOC); // Une seule ligne attendue

            // Retourner les résultats combinés
            return $resultat;

        } catch (PDOException $e) {
            // Gestion des erreurs
            echo "Erreur lors de la récupération des attributs des employés : " . $e->getMessage();
            return null;
        }
    }


    function modifierEmploye($id, $nom, $prenom, $login, $telephone, $mdp, $id_type) {
        global $pdo;
        try {
            // Début de la transaction
            $pdo->beginTransaction();

            // Première requête : mise à jour des informations de connexion
            $requete = "UPDATE login 
                SET login = :login, mdp = :mdp, id_type = :id_type
                WHERE id_employe = :id_employe";
            $stmt = $pdo->prepare($requete);
            $stmt->bindParam(':login', $login);
            $hashMdp = sha1($mdp);
            $stmt->bindParam(':mdp', $hashMdp);
            $stmt->bindParam(':id_type', $id_type);
            $stmt->bindParam(':id_employe', $id);
            $stmt->execute();

            // Deuxième requête : mise à jour des informations personnelles
            $requete = "UPDATE employe
                SET nom = :nom, prenom = :prenom, telephone = :telephone
                WHERE id_employe = :id_employe";
            $stmt = $pdo->prepare($requete);
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':prenom', $prenom);
            $stmt->bindParam(':telephone', $telephone);
            $stmt->bindParam(':id_employe', $id);
            $stmt->execute();

            // Validation de la transaction
            $pdo->commit();

            echo "Mise à jour réussie.";
        } catch (Exception $e) {
            // Annulation de la transaction en cas d'erreur
            $pdo->rollBack();
            echo "Une erreur est survenue : " . $e->getMessage();
        }

    }

    function verifIdType($id_type) {
        global $pdo;

        $requeteVerifType = "SELECT COUNT(id_type) FROM type_utilisateur WHERE id_type = :id_type";
        $stmtVerif = $pdo->prepare($requeteVerifType);
        $stmtVerif->execute(['id_type' => $id_type]);
        return $stmtVerif->fetchColumn(); // Retourne le nombre d'occurrences de id_type
    }

    // Fonction pour vérifier si le login existe déjà
    function verifLoginExiste($login): bool {
        global $pdo;
        $query = $pdo->prepare("SELECT COUNT(*) FROM login WHERE login = :login");
        $query->execute(['login' => $login]);
        return $query->fetchColumn() > 0;
    }
?>