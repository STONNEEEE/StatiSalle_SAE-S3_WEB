<?php
    require 'liaisonBD.php';
    $pdo = connecteBD();

    function listeDesSalles() {
        global $pdo;
        // Retourne la liste des salles sous forme de tableau
        $tableauRetour = array(); // Tableau qui sera retourné
        try {
            $maRequete = $pdo->prepare("SELECT id_salle, nom, capacite, videoproj, ecran_xxl, ordinateur, type, logiciels, imprimante FROM salle ORDER BY nom ASC");
            if ($maRequete->execute()) {
                while ($ligne = $maRequete->fetch(PDO::FETCH_ASSOC)) {
                    /*$tabSalle["id_salle"] = $ligne->id_salle;
                    $tabSalle["nom"] = $ligne->nom;
                    $tabSalle["capacite"] = $ligne->capacite;
                    $tabSalle["videoproj"] = $ligne->videoproj;
                    $tabSalle["ecran_xxl"] = $ligne->ecran_xxl;
                    $tabSalle["ordinateur"] = $ligne->ordinateur;
                    $tabSalle["type"] = $ligne->type;
                    $tabSalle["logiciels"] = $ligne->logiciels;
                    $tabSalle["imprimante"] = $ligne->imprimante;
                    $tableauRetour[] = $tabSalle;*/
                    $tableauRetour[] = $ligne;
                }

            }
            return $tableauRetour;
        } catch (Exception $e) {
            // Erreur de BD
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }

    /*function listeDesNoms() {
        global $pdo;
        // Retourne la liste des noms de salles dans un tableau
        $tableauRetour = array(); // Tableau qui sera retourné
        try {
            $maRequete = $pdo->prepare("SELECT nom FROM salle ORDER BY nom ASC");

            if ($maRequete->execute()) {
                while ($ligne = $maRequete->fetch()) {
                    $tableauRetour[] = $ligne->nom;
                }
            }
            return $tableauRetour;
        }catch (Exception $e) {
            // Erreur de BD
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }*/
?>