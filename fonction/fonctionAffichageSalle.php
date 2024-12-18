<?php
    require 'liaisonBD.php';
    $pdo = connecteBD();

    function listeDesSalles() {
        global $pdo;
        // Retourne la liste des salles sous forme de tableau
        $tableauRetour = array(); // Tableau qui sera retourné
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

    function listeDesCapacites() {
        global $pdo;
        // Retourne la liste des capacites des salles dans un tableau
        $tableauRetour = array(); // Tableau qui sera retourné
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
        $tableauRetour = array(); // Tableau qui sera retourné
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
        $tableauRetour = array(); // Tableau qui sera retourné
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
    // Requête SQL pour supprimer la salle
    $requete = "DELETE FROM salle WHERE id_salle = :id_salle";
    $stmt = $pdo->prepare($requete);
    $stmt->execute(['id_salle' => $id_salle]);
}

?>