<?php

    // Fonction pour modifier une réservation
    function recupAttributReservation($id_Resa)
    {
        global $pdo;

        try {
            // Récupérer les informations principales de la réservation
            $query = "SELECT r.id_reservation, r.date_reservation, r.heure_debut, r.heure_fin,
                         r.id_salle, r.id_employe, r.id_activite
                  FROM reservation r
                  WHERE r.id_reservation = :idReservation";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':idReservation', $id_Resa, PDO::PARAM_STR);
            $stmt->execute();
            $reservation = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$reservation) {
                return null; // Aucune réservation trouvée
            }

            // Récupérer le nom de la salle
            $querySalle = "SELECT nom FROM salle WHERE id_salle = :idSalle";
            $stmt = $pdo->prepare($querySalle);
            $stmt->bindParam(':idSalle', $reservation['id_salle'], PDO::PARAM_INT);
            $stmt->execute();
            $reservation['nomSalle'] = $stmt->fetchColumn();

            // Récupérer le nom complet de l'employé
            $queryEmploye = "SELECT CONCAT(nom, ' ', prenom) AS nomComplet FROM employe WHERE id_employe = :idEmploye";
            $stmt = $pdo->prepare($queryEmploye);
            $stmt->bindParam(':idEmploye', $reservation['id_employe'], PDO::PARAM_STR);
            $stmt->execute();
            $reservation['nomEmploye'] = $stmt->fetchColumn();

            // Récupérer le nom de l'activité
            $queryActivite = "SELECT nom_activite FROM activite WHERE id_activite = :idActivite";
            $stmt = $pdo->prepare($queryActivite);
            $stmt->bindParam(':idActivite', $reservation['id_activite'], PDO::PARAM_STR);
            $stmt->execute();
            $reservation['nomActivite'] = $stmt->fetchColumn();

            // Initialiser les détails supplémentaires
            $reservation['details'] = [];

            // Récupérer les détails supplémentaires en fonction de l'activité
            $queryDetails = "";
            switch ($reservation['id_activite']) {
                case 'Reunion':
                    $queryDetails = "SELECT objet FROM reservation_reunion WHERE id_reservation = :idReservation";
                    break;

                case 'Formation':
                    $queryDetails = "SELECT sujet, nom_formateur, prenom_formateur, num_tel_formateur 
                                 FROM reservation_formation WHERE id_reservation = :idReservation";
                    break;

                case 'Entretien':
                    $queryDetails = "SELECT nature FROM reservation_entretien WHERE id_reservation = :idReservation";
                    break;

                case 'PretLouer':
                    $queryDetails = "SELECT nom_organisme, nom_interlocuteur, prenom_interlocuteur, num_tel_interlocuteur, type_activite 
                                 FROM reservation_pret_louer WHERE id_reservation = :idReservation";
                    break;

                case 'Autre':
                    $queryDetails = "SELECT description FROM reservation_autre WHERE id_reservation = :idReservation";
                    break;

                default:
                    $queryDetails = null;
                    break;
            }

            if ($queryDetails) {
                $stmt = $pdo->prepare($queryDetails);
                $stmt->bindParam(':idReservation', $idReservation, PDO::PARAM_STR);
                $stmt->execute();
                $reservation['details'] = $stmt->fetch(PDO::FETCH_ASSOC);
            }

            return $reservation;
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des détails de la réservation : " . $e->getMessage());
            return null;
        }
    }

    function modifReservation($nomSalle, $nomActivite, $date, $heureDebut, $heureFin, $objet, $nom, $prenom, $numTel, $precisActivite, $idLogin) {
        global $pdo;

        try {
            // Récupère l'identifiant de la réservation
            $sqlIdResa = "SELECT id_reservation FROM reservation WHERE id_salle = 
                                                (SELECT id_salle FROM salle WHERE nom = :nomSalle) 
                                                AND date_reservation = :date AND heure_debut = :heureDebut";
            $stmtId = $pdo->prepare($sqlIdResa);
            $stmtId->bindParam(':nomSalle', $nomSalle);
            $stmtId->bindParam(':date', $date);
            $stmtId->bindParam(':heureDebut', $heureDebut);
            $stmtId->execute();
            $idReservation = $stmtId->fetchColumn();

            // Récupère l'identifiant de la salle
            $sqlSalle = "SELECT id_salle FROM salle WHERE nom = :nomSalle";
            $stmtSalle = $pdo->prepare($sqlSalle);
            $stmtSalle->bindParam(':nomSalle', $nomSalle);
            $stmtSalle->execute();
            $idSalle = $stmtSalle->fetchColumn();

            // Récupère l'identifiant de l'employé à partir de l'identifiant de login
            $sqlEmploye = "SELECT id_employe FROM login WHERE id_login = :idLogin";
            $stmtEmploye = $pdo->prepare($sqlEmploye);
            $stmtEmploye->bindParam(':idLogin', $idLogin);
            $stmtEmploye->execute();
            $idEmploye = $stmtEmploye->fetchColumn();

            // Récupère l'identifiant de l'activité
            $sqlActivite = "SELECT id_activite FROM activite WHERE nom_activite = :nomActivite";
            $stmtActivite = $pdo->prepare($sqlActivite);
            $stmtActivite->bindParam(':nomActivite', $nomActivite);
            $stmtActivite->execute();
            $idActivite = $stmtActivite->fetchColumn();

            // Mise à jour dans la table reservation
            $sqlReservation = "UPDATE reservation 
                               SET id_salle = :idSalle, id_employe = :idEmploye, id_activite = :idActivite, 
                                   date_reservation = :dateReservation, heure_debut = :heureDebut, heure_fin = :heureFin 
                               WHERE id_reservation = :idReservation";
            $stmtReservation = $pdo->prepare($sqlReservation);
            $stmtReservation->bindParam(':idReservation', $idReservation);
            $stmtReservation->bindParam(':idSalle', $idSalle);
            $stmtReservation->bindParam(':idEmploye', $idEmploye);
            $stmtReservation->bindParam(':idActivite', $idActivite);
            $stmtReservation->bindParam(':dateReservation', $date);
            $stmtReservation->bindParam(':heureDebut', $heureDebut);
            $stmtReservation->bindParam(':heureFin', $heureFin);
            $stmtReservation->execute();

            // Mise à jour dans la table correspondante à l'activité
            if ($nomActivite === 'Réunion') {
                $sqlReunion = "UPDATE reservation_reunion SET objet = :objet WHERE id_reservation = :idReservation";
                $stmtReunion = $pdo->prepare($sqlReunion);
                $stmtReunion->bindParam(':idReservation', $idReservation);
                $stmtReunion->bindParam(':objet', $objet);
                $stmtReunion->execute();

            } else if ($nomActivite === 'Formation') {
                $sqlFormation = "UPDATE reservation_formation 
                                 SET sujet = :sujet, nom_formateur = :nomFormateur, prenom_formateur = :prenomFormateur, num_tel_formateur = :numTelFormateur 
                                 WHERE id_reservation = :idReservation";
                $stmtFormation = $pdo->prepare($sqlFormation);
                $stmtFormation->bindParam(':idReservation', $idReservation);
                $stmtFormation->bindParam(':sujet', $objet);
                $stmtFormation->bindParam(':nomFormateur', $nom);
                $stmtFormation->bindParam(':prenomFormateur', $prenom);
                $stmtFormation->bindParam(':numTelFormateur', $numTel);
                $stmtFormation->execute();

            } else if ($nomActivite === 'Entretien de la salle') {
                $sqlEntretien = "UPDATE reservation_entretien SET nature = :nature WHERE id_reservation = :idReservation";
                $stmtEntretien = $pdo->prepare($sqlEntretien);
                $stmtEntretien->bindParam(':idReservation', $idReservation);
                $stmtEntretien->bindParam(':nature', $objet);
                $stmtEntretien->execute();

            } else if ($nomActivite === 'Prêt' || $nomActivite === 'Location') {
                $sqlPretLouer = "UPDATE reservation_pret_louer 
                                 SET nom_organisme = :nomOrganisme, nom_interlocuteur = :nomInterlocuteur, prenom_interlocuteur = :prenomInterlocuteur, 
                                     num_tel_interlocuteur = :numTelInterlocuteur, type_activite = :typeActivite 
                                 WHERE id_reservation = :idReservation";
                $stmtPretLouer = $pdo->prepare($sqlPretLouer);
                $stmtPretLouer->bindParam(':idReservation', $idReservation);
                $stmtPretLouer->bindParam(':nomOrganisme', $nom);
                $stmtPretLouer->bindParam(':nomInterlocuteur', $prenom);
                $stmtPretLouer->bindParam(':prenomInterlocuteur', $objet);
                $stmtPretLouer->bindParam(':numTelInterlocuteur', $numTel);
                $stmtPretLouer->bindParam(':typeActivite', $precisActivite);
                $stmtPretLouer->execute();

            } else if ($nomActivite === 'Autre') {
                $sqlAutre = "UPDATE reservation_autre SET description = :description WHERE id_reservation = :idReservation";
                $stmtAutre = $pdo->prepare($sqlAutre);
                $stmtAutre->bindParam(':idReservation', $idReservation);
                $stmtAutre->bindParam(':description', $objet);
                $stmtAutre->execute();
            }

            return "Réservation modifiée avec succès";

        } catch (PDOException $e) {
            return "Erreur lors de la modification de la réservation : " . $e->getMessage();
        }
    }

?>