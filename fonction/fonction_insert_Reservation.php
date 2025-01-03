<?php
    require("liaisonBD.php");

    $pdo = connecteBD();

    // Fonction pour insérer une réservation
    function insertionReservation($nomSalle, $nomActivite, $date, $heureDebut, $heureFin, $objet, $nom, $prenom, $numTel, $precisActivite, $idLogin) {
        global $pdo;

        try {
            // Récupère le dernier identifiant de la table 'reservation'
            $sqlLastId = "SELECT id_reservation FROM reservation ORDER BY id_reservation DESC LIMIT 1";
            $stmtLastId = $pdo->prepare($sqlLastId);
            $stmtLastId->execute();
            $lastId = $stmtLastId->fetchColumn();

            // Si aucune réservation n'existe encore, démarrer à "R000001"
            if ($lastId === false) {
                $idReservation = 'R000001';
            } else {
                // 3. Extraire la partie numérique et l'incrémenter
                $partieNumerique = (int)substr($lastId, 1); // Extrait la partie numérique de l'ID
                $nouvellePartieNumerique = $partieNumerique + 1;

                // 4. Formater le nouvel identifiant en "R000001"
                $idReservation = 'R' . str_pad($nouvellePartieNumerique, 6, '0', STR_PAD_LEFT);
            }

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

            // Insère dans la table reservation
            $sqlReservation = "INSERT INTO reservation (id_reservation, id_salle, id_employe, id_activite, date_reservation, heure_debut, heure_fin) 
                               VALUES (:idReservation, :idSalle, :idEmploye, :idActivite, :dateReservation, :heureDebut, :heureFin)";
            $stmtReservation = $pdo->prepare($sqlReservation);
            $stmtReservation->bindParam(':idReservation', $idReservation);
            $stmtReservation->bindParam(':idSalle', $idSalle);
            $stmtReservation->bindParam(':idEmploye', $idEmploye);
            $stmtReservation->bindParam(':idActivite', $idActivite);
            $stmtReservation->bindParam(':dateReservation', $date);
            $stmtReservation->bindParam(':heureDebut', $heureDebut);
            $stmtReservation->bindParam(':heureFin', $heureFin);
            $stmtReservation->execute();

            // Insère dans la table correspondante à l'activité
            if ($nomActivite === 'Réunion') {
                $sqlReunion = "INSERT INTO reservation_reunion (id_reservation, objet) VALUES (:idReservation, :objet)";
                $stmtReunion = $pdo->prepare($sqlReunion);
                $stmtReunion->bindParam(':idReservation', $idReservation);
                $stmtReunion->bindParam(':objet', $objet);
                $stmtReunion->execute();

            } else if ($nomActivite === 'Formation') {
                $sqlFormation = "INSERT INTO reservation_formation (id_reservation, sujet, nom_formateur, prenom_formateur, num_tel_formateur) 
                                 VALUES (:idReservation, :sujet, :nomFormateur, :prenomFormateur, :numTelFormateur)";
                $stmtFormation = $pdo->prepare($sqlFormation);
                $stmtFormation->bindParam(':idReservation', $idReservation);
                $stmtFormation->bindParam(':sujet', $objet);
                $stmtFormation->bindParam(':nomFormateur', $nom);
                $stmtFormation->bindParam(':prenomFormateur', $prenom);
                $stmtFormation->bindParam(':numTelFormateur', $numTel);
                $stmtFormation->execute();

            } else if ($nomActivite === 'Entretien de la salle') {
                $sqlEntretien = "INSERT INTO reservation_entretien (id_reservation, nature) VALUES (:idReservation, :nature)";
                $stmtEntretien = $pdo->prepare($sqlEntretien);
                $stmtEntretien->bindParam(':idReservation', $idReservation);
                $stmtEntretien->bindParam(':nature', $objet);
                $stmtEntretien->execute();

            } else if ($nomActivite === 'Prêt' || $nomActivite === 'Location') {
                $sqlPretLouer = "INSERT INTO reservation_pret_louer (id_reservation, nom_organisme, nom_interlocuteur, prenom_interlocuteur, num_tel_interlocuteur, type_activite) 
                                 VALUES (:idReservation, :nomOrganisme, :nomInterlocuteur, :prenomInterlocuteur, :numTelInterlocuteur, :typeActivite)";
                $stmtPretLouer = $pdo->prepare($sqlPretLouer);
                $stmtPretLouer->bindParam(':idReservation', $idReservation);
                $stmtPretLouer->bindParam(':nomOrganisme', $nom);
                $stmtPretLouer->bindParam(':nomInterlocuteur', $prenom);
                $stmtPretLouer->bindParam(':prenomInterlocuteur', $objet);
                $stmtPretLouer->bindParam(':numTelInterlocuteur', $numTel);
                $stmtPretLouer->bindParam(':typeActivite', $precisActivite);
                $stmtPretLouer->execute();

            } else if ($nomActivite === 'Autre') {
                $sqlAutre = "INSERT INTO reservation_autre (id_reservation, description) VALUES (:idReservation, :description)";
                $stmtAutre = $pdo->prepare($sqlAutre);
                $stmtAutre->bindParam(':idReservation', $idReservation);
                $stmtAutre->bindParam(':description', $objet);
                $stmtAutre->execute();
            }

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
