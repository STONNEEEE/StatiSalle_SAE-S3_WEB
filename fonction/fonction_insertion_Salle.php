<?php
    require("liaisonBD.php");

    $pdo = connecteBD();

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