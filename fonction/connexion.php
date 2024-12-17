<?php
    function verif_connexion($pdo, $identifiant, $mdp){
        $requete = "SELECT * 
                    FROM login 
                    WHERE login = :identifiant 
                    AND mdp = :mdp";
        $resultat = $pdo->prepare($requete);
        $resultat->bindParam(':identifiant', $identifiant);
        $resultat->bindParam(':mdp', $mdp);
        $resultat = $requete->execute();
        return $resultat->fetch();
    }

    function type_utilisateur($pdo, $identifiant, $mdp){
        $requete = "SELECT nom_type 
                    FROM type_utilisateur 
                    JOIN login 
                    ON type_utilisateur.id_type = login.id_type 
                    WHERE login = :identifiant 
                    AND mdp = :mdp";
        $resultat = $pdo->prepare($requete);
        $resultat->bindParam(':identifiant', $identifiant);
        $resultat->bindParam(':mdp', $mdp);
        $resultat->execute();
        return $resultat->fetch();
    }
?>