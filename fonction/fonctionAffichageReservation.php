<?php
    require 'liaisonBD.php';
    $pdo = connecteBD();

    function affichageReservation() {
        global $pdo;
        $requete = "SELECT reservation.id_reservation as id_reservation, salle.nom as nom_salle, employe.nom as nom_employe,
                    employe.prenom as prenom_employe, activite.nom_activite as nom_activite, reservation.date_reservation 
                    as date, reservation.heure_debut as heure_debut, reservation.heure_fin as heure_fin
                    FROM reservation
                    JOIN salle
                    ON reservation.id_salle = salle.id_salle
                    JOIN employe
                    ON reservation.id_employe = employe.id_employe
                    JOIN activite
                    ON reservation.id_activite = activite.id_activite";
        $requete = $pdo->prepare($requete);
        $requete->execute();
        $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
        return $resultat;
    }

    function affichageMesReservations($idEmploye) {
        global $pdo;
        try {
            $requete = "
                SELECT 
                    reservation.id_reservation AS id_reservation,
                    salle.nom AS nom_salle,
                    employe.nom AS nom_employe,
                    employe.prenom AS prenom_employe,
                    activite.nom_activite AS nom_activite,
                    reservation.date_reservation AS date,
                    reservation.heure_debut AS heure_debut,
                    reservation.heure_fin AS heure_fin
                FROM 
                    reservation
                JOIN 
                    salle ON reservation.id_salle = salle.id_salle
                JOIN 
                    employe ON reservation.id_employe = employe.id_employe
                JOIN 
                    activite ON reservation.id_activite = activite.id_activite
                WHERE 
                    reservation.id_employe = :id_employe
            ";

            $stmt = $pdo->prepare($requete);
            $stmt->bindValue(':id_employe', $idEmploye, PDO::PARAM_INT); // Vérifie que $idEmploye est un entier
            $stmt->execute();
            $resultat = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $resultat;

        } catch (PDOException $e) {
            error_log("Erreur dans affichageMesReservations: " . $e->getMessage());
            return [];
        }
    }

    function affichageTypeReservation($idReservation){
        global $pdo;
        $requete = "SELECT reservation_entretien.*, 
                           reservation_formation.*, 
                           reservation_pret_louer.*, 
                           reservation_autre.*, 
                           reservation_reunion.objet
                    FROM reservation
                    LEFT JOIN reservation_entretien
                    ON reservation.id_reservation = reservation_entretien.id_reservation
                    LEFT JOIN reservation_formation
                    ON reservation.id_reservation = reservation_formation.id_reservation
                    LEFT JOIN reservation_pret_louer
                    ON reservation.id_reservation = reservation_pret_louer.id_reservation
                    LEFT JOIN reservation_autre
                    ON reservation.id_reservation = reservation_autre.id_reservation
                    LEFT JOIN reservation_reunion
                    ON reservation.id_reservation = reservation_reunion.id_reservation
                    WHERE reservation.id_reservation = :id_reservation";
        $requete = $pdo->prepare($requete);
        $requete->bindParam(':id_reservation', $idReservation, PDO::PARAM_STR);
        $requete->execute();
        $resultat = $requete->fetch(PDO::FETCH_ASSOC);

        return $resultat;
    }

    function listeEmployesNom() {
        global $pdo;
        // Retourne la liste des noms des employés dans un tableau
        $tableauRetour = array();
        try {
            $maRequete = $pdo->prepare("SELECT DISTINCT nom FROM employe");

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

    function listeEmployesPrenom() {
        global $pdo;
        // Retourne la liste des prénoms des employés dans un tableau
        $tableauRetour = array();
        try {
            $maRequete = $pdo->prepare("SELECT DISTINCT prenom FROM employe");

            if ($maRequete->execute()) {
                while ($ligne = $maRequete->fetch()) {
                    $tableauRetour[] = $ligne->prenom;
                }
            }
            return $tableauRetour;
        } catch (Exception $e) {
            // Erreur de BD
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }

    function listeSalles() {
        global $pdo;
        // Retourne la liste des noms de salles dans un tableau
        $tableauRetour = array();
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

    function listeActivites() {
        global $pdo;
        // Retourne la liste des noms d'activités dans un tableau
        $tableauRetour = array();
        try {
            $maRequete = $pdo->prepare("SELECT DISTINCT nom_activite FROM activite ORDER BY nom_activite ASC");

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

    function listeDate() {
        global $pdo;
        // Retourne la liste des dates dans un tableau
        $tableauRetour = array();
        try {
            $maRequete = $pdo->prepare("SELECT DISTINCT date_reservation FROM reservation 
                                               ORDER BY date_reservation ASC");

            if ($maRequete->execute()) {
                while ($ligne = $maRequete->fetch()) {
                    $tableauRetour[] = $ligne->date_reservation;
                }
            }
            return $tableauRetour;
        } catch (Exception $e) {
            // Erreur de BD
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }

    function listeHeureDebut() {
        global $pdo;
        // Retourne la liste des heures de début dans un tableau
        $tableauRetour = array();
        try {
            $maRequete = $pdo->prepare("SELECT DISTINCT heure_debut FROM reservation 
                                               ORDER BY heure_debut ASC");

            if ($maRequete->execute()) {
                while ($ligne = $maRequete->fetch()) {
                    $tableauRetour[] = $ligne->heure_debut;
                }
            }
            return $tableauRetour;
        } catch (Exception $e) {
            // Erreur de BD
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }

    function listeHeureFin() {
        global $pdo;
        // Retourne la liste des heures de fin dans un tableau
        $tableauRetour = array();
        try {
            $maRequete = $pdo->prepare("SELECT DISTINCT heure_fin FROM reservation 
                                                   ORDER BY heure_fin ASC");

            if ($maRequete->execute()) {
                while ($ligne = $maRequete->fetch()) {
                    $tableauRetour[] = $ligne->heure_fin;
                }
            }
            return $tableauRetour;
        } catch (Exception $e) {
            // Erreur de BD
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }

    function supprimerResa($id_reservation) {
        global $pdo;

        // Liste des tables à parcourir
        $tables = [
            'reservation_autre',
            'reservation_entretien',
            'reservation_formation',
            'reservation_pret_louer',
            'reservation_reunion',
            'reservation' // la table réservation est mise en dernier car les autres tables héritent de celle-ci
        ];

        try {
             foreach ($tables as $table) {
                $requete = "DELETE FROM $table WHERE id_reservation = :id_reservation";
                $stmt = $pdo->prepare($requete);
                $stmt->execute(['id_reservation' => $id_reservation]);

            }
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }
?>