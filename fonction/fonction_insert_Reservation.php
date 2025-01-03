<?php
    require("liaisonBD.php");

    $pdo = connecteBD();

    // Fonction pour insérer une réservation
    function insertReservation($nomSalle, $nomActivite, $date, $heureDebut, $heureFin, $objet, $formateurNom, $formateurPrenom, $telephone, $precisActivite) {
        global $pdo;
        try {
            // Préparation de la requête d'insertion
            $sql = "INSERT INTO reservations (nomSalle, nomActivite, date, heureDebut, heureFin, objet, formateurNom, formateurPrenom, telephone, precisActivite)
                    VALUES (:nomSalle, :nomActivite, :date, :heureDebut, :heureFin, :objet, :formateurNom, :formateurPrenom, :telephone, :precisActivite)";

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':nomSalle', $nomSalle);
            $stmt->bindParam(':nomActivite', $nomActivite);
            $stmt->bindParam(':date', $date);
            $stmt->bindParam(':heureDebut', $heureDebut);
            $stmt->bindParam(':heureFin', $heureFin);
            $stmt->bindParam(':objet', $objet);
            $stmt->bindParam(':formateurNom', $formateurNom);
            $stmt->bindParam(':formateurPrenom', $formateurPrenom);
            $stmt->bindParam(':telephone', $telephone);
            $stmt->bindParam(':precisActivite', $precisActivite);

            // Exécution de la requête
            $stmt->execute();
            return "Réservation insérée avec succès";
        } catch (PDOException $e) {
            return "Erreur lors de l'insertion de la réservation : " . $e->getMessage();
        }
    }

    // Fonction pour récupérer les salles disponibles
    function listeDesSalles() {
        global $pdo;
        // Retourne la liste des noms de salles dans un tableau
        $tableauRetour = array(); // Tableau qui sera retourné
        try {
            $maRequete = $pdo->prepare("SELECT DISTINCT nom FROM salle ORDER BY nom ASC");

            if ($maRequete->execute()) {
                while ($ligne = $maRequete->fetch()) {
                    $tableauRetour[] = $ligne->nom;
                }
            }
            return $tableauRetour;
        } catch (Exception $e) {
            // Erreur de BD
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }

    // Fonction pour récupérer les activités disponibles
    function listeDesActivites() {
        global $pdo;
        // Retourne la liste des noms de salles dans un tableau
        $tableauRetour = array(); // Tableau qui sera retourné
        try {
            $maRequete = $pdo->prepare("SELECT nom_activite FROM activite");

            if ($maRequete->execute()) {
                while ($ligne = $maRequete->fetch()) {
                    $tableauRetour[] = $ligne->nom_activite;
                }
            }
            return $tableauRetour;
        } catch (Exception $e) {
            // Erreur de BD
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }
?>
