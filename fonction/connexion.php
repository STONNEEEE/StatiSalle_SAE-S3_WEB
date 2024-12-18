<?php
    function verif_utilisateur($pdo, $identifiant)
    {
        try {
            $requete = "SELECT id_login, login, mdp
                        FROM login 
                        WHERE login = :identifiant";
            $resultat = $pdo->prepare($requete);
            $resultat->bindParam(':identifiant', $identifiant);
            $resultat->execute();
            return $resultat->fetch();
        }catch(PDOException $e){
            echo 'Erreur : '.$e->getMessage();
        }
    }

    function verif_mdp($pdo, $mdp) {
        try {
            $requete = "SELECT id_login, login, mdp
                        FROM login 
                        WHERE mdp = :mdp";
            $resultat = $pdo->prepare($requete);
            $resultat->bindParam(':mdp', $mdp);
            $resultat->execute();
            return $resultat->fetch();
        }catch(PDOException $e){
            echo 'Erreur : '.$e->getMessage();
        }
    }

    function type_utilisateur($pdo, $identifiant, $mdp) {
        try {
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
        }catch(PDOException $e){
            echo 'Erreur : '.$e->getMessage();
        }
    }

    function verif_session() {

        //Si la session n'existe plus, on redirige vers la page de co
        if (!isset($_SESSION['id'])) {
            header('Location: ../index.php');
            exit;
        }
    }
?>