<?php
    require("liaisonBD.php");

    $pdo = connecteBD();

    function verifNomSalle($nomSalle) {
        global $pdo;

        try {
            // Préparer la requête pour vérifier si le nom de la salle existe
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM salle WHERE nom = :Nom");
            $stmt->bindParam(':Nom', $nomSalle);
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

        try {
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

            echo "<div class='alert alert-success'>Les données ont été insérées avec succès. ID créé : </div>";
        } catch (PDOException $e) {
            echo "<div class='alert alert-danger'>Erreur lors de l'insertion : " . $e->getMessage() . "</div>";
        }
    }
?>