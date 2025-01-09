<?php
    require 'liaisonBD.php';
    $pdo = connecteBD();

    function listeDesSalles() {
        global $pdo;
        // Retourne la liste des salles sous forme de tableau
        $tableauRetour = array();
        try {
            $maRequete = $pdo->prepare("SELECT id_salle, nom, capacite, videoproj, ecran_xxl, ordinateur, type, logiciels, imprimante 
                                               FROM salle 
                                               ORDER BY nom ASC");
            if ($maRequete->execute()) {
                while ($ligne=$maRequete->fetch()) {
                    $tabSalle["id_salle"] = $ligne->id_salle;
                    $tabSalle["nom"] = $ligne->nom;
                    $tabSalle["capacite"] = $ligne->capacite;
                    $tabSalle["videoproj"] = $ligne->videoproj;
                    $tabSalle["ecran_xxl"] = $ligne->ecran_xxl;
                    $tabSalle["ordinateur"] = $ligne->ordinateur;
                    $tabSalle["type"] = $ligne->type;
                    $tabSalle["logiciels"] = $ligne->logiciels;
                    $tabSalle["imprimante"] = $ligne->imprimante;
                    $tableauRetour[] = $tabSalle;
                }
            }
            return $tableauRetour;
        } catch (PDOException $e) {
            // Erreur de BD
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }

    function listeDesNoms() {
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

    function listeDesCapacites() {
        global $pdo;
        // Retourne la liste des capacites des salles dans un tableau
        $tableauRetour = array();
        try {
            $maRequete = $pdo->prepare("SELECT DISTINCT capacite FROM salle ORDER BY capacite ASC");

            if ($maRequete->execute()) {
                while ($ligne = $maRequete->fetch()) {
                    $tableauRetour[] = $ligne->capacite;
                }
            }
            return $tableauRetour;
        } catch (Exception $e) {
            // Erreur de BD
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }

    function listeDesOrdinateurs() {
        global $pdo;
        // Retourne la liste des nombres d'ordinateurs des salles dans un tableau
        $tableauRetour = array();
        try {
            $maRequete = $pdo->prepare("SELECT DISTINCT ordinateur FROM salle ORDER BY ordinateur ASC");

            if ($maRequete->execute()) {
                while ($ligne = $maRequete->fetch()) {
                    $tableauRetour[] = $ligne->ordinateur;
                }
            }
            return $tableauRetour;
        }catch (Exception $e) {
            // Erreur de BD
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }

    function listeDesLogiciels() {
        global $pdo;
        // Retourne la liste des logiciels des salles dans un tableau
        $tableauRetour = array();
        try {
            $maRequete = $pdo->prepare("SELECT DISTINCT logiciels FROM salle ORDER BY logiciels ASC");

            if ($maRequete->execute()) {
                while ($ligne = $maRequete->fetch()) {
                    // Vérifier si le champ 'logiciels' n'est pas vide avant de l'ajouter
                    if (!empty($ligne->logiciels)) {
                        $tableauRetour[] = $ligne->logiciels;
                    }
                }
            }
            return $tableauRetour;
        } catch (Exception $e) {
            // Erreur de BD
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }

    function supprimerSalle($id_salle) {
        global $pdo;
        try {
            $requete = "DELETE FROM salle WHERE id_salle = :id_salle";
            $stmt = $pdo->prepare($requete);
            $stmt->execute(['id_salle' => $id_salle]);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Vérifie si une salle a des réservations
     * Retourne un tableau contenant les IDs des réservations ou un tableau vide si aucune réservation
     */
    function verifierReservations($id_salle) {
        global $pdo;
        try {
            $requete = "SELECT id_reservation FROM reservation WHERE id_salle = :id_salle";
            $stmt = $pdo->prepare($requete);
            $stmt->execute(['id_salle' => $id_salle]);
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }

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

            $stmt->bindParam(':id_salle', $idSalle, PDO::PARAM_INT);
            $stmt->execute();
            $resultat = $stmt->fetch(PDO::FETCH_ASSOC);

            return $resultat;

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

            $stmt->bindParam(':Nom', $nomSalle);
            $stmt->bindParam(':Capacite', $capacite, PDO::PARAM_INT);
            $stmt->bindParam(':videoproj', $videoProjecteur, PDO::PARAM_INT);
            $stmt->bindParam(':ecranXXL', $ordinateurXXL, PDO::PARAM_INT);
            $stmt->bindParam(':nbrOrdi', $nbrOrdi, PDO::PARAM_INT);
            $stmt->bindParam(':type', $typeMateriel);
            $stmt->bindParam(':logiciels', $logiciel);
            $stmt->bindParam(':imprimante', $imprimante, PDO::PARAM_INT);
            $stmt->bindParam(':id_salle', $idSalle, PDO::PARAM_INT);
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