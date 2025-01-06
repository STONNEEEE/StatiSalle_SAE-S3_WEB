<?php

// Récupération des données depuis la base de données
function recupererDonnees($table, $conn) {
    $requete = "SELECT * FROM $table";
    $resultat = $conn->query($requete);
    return $resultat->fetchAll(PDO::FETCH_ASSOC);
}

// Fonction pour générer un fichier CSV à partir de données
function genererCSV($nomFichier, $colonnes, $donnees) : void {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $nomFichier . '"');
    $fichier = fopen('php://output', 'w');
    if ($fichier) {
        // Ajouter les colonnes au fichier
        fputcsv($fichier, $colonnes);
        // Ajouter les données
        foreach ($donnees as $ligne) {
            fputcsv($fichier, $ligne);
        }
        fclose($fichier);
    }
    exit();
}

function genererCSVString($colonnes, $donnees) {
    ob_start();
    $fichier = fopen('php://output', 'w');
    fputcsv($fichier, $colonnes);
    foreach ($donnees as $ligne) {
        fputcsv($fichier, $ligne);
    }
    fclose($fichier);
    return ob_get_clean();
    exit();
}

function genererZip($nomZip, $fichiers) {
    $zipTemp = tempnam(sys_get_temp_dir(), 'zip'); // Crée un fichier temporaire
    $zip = new ZipArchive();

    if ($zip->open($zipTemp, ZipArchive::CREATE) === TRUE) {
        foreach ($fichiers as $nomFichier => $contenu) {
            $zip->addFromString($nomFichier, $contenu);
        }
        $zip->close();

        // Envoyer le fichier ZIP à l'utilisateur
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="' . $nomZip . '"');
        header('Content-Length: ' . filesize($zipTemp));

        // Lire le fichier temporaire et l'envoyer à l'utilisateur
        readfile($zipTemp);
        unlink($zipTemp); // Supprimer le fichier temporaire
    }

    exit();
}

?>