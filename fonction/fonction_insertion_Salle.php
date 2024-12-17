<?php
    require("liaisonBD.php");

    $pdo = connecteBD();

    function creationSalle($nomSalle, $capacite, $videoProjecteur, $ordinateurXXL, $nbrOrdi, $typeMateriel, $logiciel, $imprimante){

        global $pdo;

        try {

        $stmt = $pdo->prepare("INSERT INTO salle (Ident, Nom, Capacite, videoproj, ecranXXL, ordinateur, type, logiciels, imprimante) 
                                   VALUES (:Nom, :Capacite, :videoproj, :ecranXXL, :nbrOrdi, :type, :logiciels, :imprimante)");
        $stmt->bindParam(':Nom', $nomSalle);
        $stmt->bindParam(':Capacite', $capacite);
        $stmt->bindParam(':videoproj', $videoProjecteur);
        $stmt->bindParam(':ecranXXL', $ordinateurXXL);
        $stmt->bindParam(':nbrOrdi', $nbrOrdi);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':logiciels', $logiciel);
        $stmt->bindParam(':imprimante', $imprimante);
        $stmt->execute();
        // Recuperer l'ID de le derniere insertion
        $lastInsertId = $pdo->lastInsertId();
        echo "<div class='alert alert-success'>Les données ont été insérées avec succès. ID créé : " . $lastInsertId . "</div>";
    } catch (PDOException $e) {
        echo "<div class='alert alert-danger'>Erreur lors de l'insertion : " . $e->getMessage() . "</div>";
    }
    }
?>