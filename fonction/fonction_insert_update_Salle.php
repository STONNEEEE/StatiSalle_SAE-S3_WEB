<?php
    require("liaisonBD.php");

    $pdo = connecteBD();

    function verifNomSalle($nomSalle, $idSalle) {
        global $pdo;

        try {
            // Préparer la requête pour vérifier si le nom de la salle existe
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM salle WHERE nom = :Nom AND id_salle != :id_salle");
            $stmt->bindParam(':Nom', $nomSalle);
            $stmt->bindParam(':id_salle', $idSalle, PDO::PARAM_INT);
            $stmt->execute();
            $count = $stmt->fetchColumn();

            // Retourner vrai si le nom existe déjà, faux sinon
            return $count > 0;
        } catch (PDOException $e) {
            return false;  // Retourne false en cas d'erreur de la requête
        }
    }

    function creationSalle($nomSalle, $capacite, $videoProjecteur, $ordinateurXXL, $nbrOrdi, $typeMateriel, $logiciel, $imprimante){

        global $pdo;

        $stmt = $pdo->prepare("INSERT INTO salle ( nom, capacite, videoproj, ecran_xxl, ordinateur, type, logiciels, imprimante) 
                                   VALUES (:Nom, :Capacite, :videoproj, :ecranXXL, :nbrOrdi, :type, :logiciels, :imprimante);");
        $stmt->bindParam(':Nom', $nomSalle);
        $stmt->bindParam(':Capacite', $capacite);
        $stmt->bindParam(':videoproj', $videoProjecteur);
        $stmt->bindParam(':ecranXXL', $ordinateurXXL);
        $stmt->bindParam(':nbrOrdi', $nbrOrdi);
        $stmt->bindParam(':type', $typeMateriel);
        $stmt->bindParam(':logiciels', $logiciel);
        $stmt->bindParam(':imprimante', $imprimante);
        $stmt->execute();
    }

    function recupAttributSalle($idSalle) {
        global $pdo;

        try {
            // Sélectionner les attributs spécifiques de la salle au lieu de "*"
            $stmt = $pdo->prepare("SELECT nom, capacite, videoproj, ecran_xxl, ordinateur, type, logiciels, imprimante 
                                   FROM salle 
                                   WHERE id_salle = :id_salle");

            // Liaison du paramètre
            $stmt->bindParam(':id_salle', $idSalle, PDO::PARAM_INT);

            // Exécution de la requête
            $stmt->execute();

            // Récupérer les résultats dans un tableau associatif
            $resultat = $stmt->fetch(PDO::FETCH_ASSOC);

            // Vérification si des résultats sont obtenus
            return $resultat;  // Retourner les attributs de la salle sous forme d'un tableau associatif

        } catch (PDOException $e) {
            // Gérer les erreurs potentielles liées à la base de données
            echo "Erreur lors de la récupération des attributs de la salle : " . $e->getMessage();
            return null;  // Retourner null en cas d'erreur
        }
    }

    function mettreAJourSalle($idSalle, $nomSalle, $capacite, $videoProjecteur, $ordinateurXXL, $nbrOrdi, $typeMateriel, $logiciel, $imprimante): string
    {
        global $pdo;

        try {
            $videoProjecteur = (intval($videoProjecteur) == 1) ? 1 : 0;
            $ordinateurXXL = (intval($ordinateurXXL) == 1) ? 1 : 0;
            $imprimante = (intval($imprimante) == 1) ? 1 : 0;

            $stmt = $pdo->prepare("UPDATE salle
                                           SET nom = :Nom,
                                               capacite = :Capacite,
                                               videoproj = :videoproj,
                                               ecran_xxl = :ecranXXL,
                                               ordinateur = :nbrOrdi,
                                               type = :type,
                                               logiciels = :logiciels,
                                               imprimante = :imprimante
                                           WHERE id_salle = :id_salle;");

            // Liaison des paramètres
            $stmt->bindParam(':Nom', $nomSalle);
            $stmt->bindParam(':Capacite', $capacite, PDO::PARAM_INT);
            $stmt->bindParam(':videoproj', $videoProjecteur, PDO::PARAM_INT);
            $stmt->bindParam(':ecranXXL', $ordinateurXXL, PDO::PARAM_INT);
            $stmt->bindParam(':nbrOrdi', $nbrOrdi, PDO::PARAM_INT);
            $stmt->bindParam(':type', $typeMateriel);
            $stmt->bindParam(':logiciels', $logiciel);
            $stmt->bindParam(':imprimante', $imprimante, PDO::PARAM_INT);
            $stmt->bindParam(':id_salle', $idSalle, PDO::PARAM_INT);

            // Exécution de la requête
            $stmt->execute();

            // Vérifier si des lignes ont été mises à jour
            if ($stmt->rowCount() > 0) {
                return "Salle mise à jour avec succès !";
            } else {
                return "Aucune modification n'a été effectuée. Vérifiez les données.";
            }

        } catch (PDOException $e) {
            // En cas d'erreur, retourner l'erreur PDO
            return "Erreur lors de la mise à jour : " . $e->getMessage();
        }
    }
?>