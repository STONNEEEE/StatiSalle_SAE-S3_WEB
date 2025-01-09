<?php
require("liaisonBD.php");

$pdo = connecteBD();

// Récupération des données depuis la base de données
function recupererDonnees($table): array {
    global $pdo;

    $donnees = [];
    try {
        $requete = "SELECT * FROM $table";
        $resultat = $pdo->query($requete);
        $donnees = $resultat->fetchAll(PDO::FETCH_ASSOC);

        switch ($table) {
            case 'reservation':
                foreach ($donnees as &$ligne) {
                    $ligne['id_salle'] = str_pad($ligne['id_salle'], 8, '0', STR_PAD_LEFT);
                    $ligne['date_reservation'] = date("d/m/Y", strtotime($ligne['date_reservation']));
                    $ligne['heure_debut'] = date("H\hi", strtotime($ligne['heure_debut']));
                    $ligne['heure_fin'] = date("H\hi", strtotime($ligne['heure_fin']));

                    $id_activite = $ligne['id_activite'];
                    $stmt_activite = $pdo->prepare("SELECT nom_activite FROM activite WHERE id_activite = ?");
                    $stmt_activite->execute([$id_activite]);
                    $activite = $stmt_activite->fetch(PDO::FETCH_ASSOC);

                    if ($activite) {
                        $ligne['id_activite'] = $activite['nom_activite'];
                        $requete_details = match ($activite['nom_activite']) {
                            'Réunion' => "SELECT objet FROM reservation_reunion WHERE id_reservation = ?",
                            'Formation' => "SELECT sujet, nom_formateur, prenom_formateur, num_tel_formateur FROM reservation_formation WHERE id_reservation = ?",
                            'Entretien de la salle' => "SELECT nature FROM reservation_entretien WHERE id_reservation = ?",
                            'Autre' => "SELECT description FROM reservation_autre WHERE id_reservation = ?",
                            default => null,
                        };

                        if ($requete_details) {
                            $stmt_details = $pdo->prepare($requete_details);
                            $stmt_details->execute([$ligne['id_reservation']]);
                            $details = $stmt_details->fetch(PDO::FETCH_ASSOC);
                            $ligne = array_merge($ligne, $details ?: []);
                        }
                    }
                }
                break;

            case 'salle':
                foreach ($donnees as &$ligne) {
                    $ligne['videoproj'] = $ligne['videoproj'] ? 'oui' : 'non';
                    $ligne['ecran_xxl'] = $ligne['ecran_xxl'] ? 'oui' : 'non';
                    $ligne['imprimante'] = $ligne['imprimante'] ? 'oui' : 'non';
                    $ligne['id_salle'] = str_pad($ligne['id_salle'], 8, '0', STR_PAD_LEFT);
                }
                break;
        }
    } catch (Exception $e) {
        error_log("Erreur lors de la récupération des données : " . $e->getMessage());
    }

    return $donnees;
}

function genererCSV($nomFichier, $colonnes, $donnees): void {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $nomFichier . '"');

    $fichier = fopen('php://output', 'w');
    if ($fichier) {
        fputcsv($fichier, $colonnes, ';');

        foreach ($donnees as $ligne) {
            $ligne = array_map(fn($val) => $val ?? '', $ligne); // Remplace les valeurs nulles par des chaînes vides
            fputcsv($fichier, $ligne, ';');
        }

        fclose($fichier);
    } else {
        error_log("Erreur lors de la création du fichier CSV.");
    }
    exit();
}

function genererZip($nomZip, $fichiers): void {
    $zipTemp = tempnam(sys_get_temp_dir(), 'zip');
    $zip = new ZipArchive();

    if ($zip->open($zipTemp, ZipArchive::CREATE) === TRUE) {
        foreach ($fichiers as $nomFichier => $contenu) {
            $zip->addFromString($nomFichier, $contenu);
        }
        $zip->close();

        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="' . $nomZip . '"');
        header('Content-Length: ' . filesize($zipTemp));
        readfile($zipTemp);
        unlink($zipTemp);
    } else {
        error_log("Erreur lors de la création du fichier ZIP.");
    }
    exit();
}
?>
