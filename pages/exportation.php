<?php

require "../fonction/liaisonBD.php";
require '../fonction/exportation.php';
session_start();

// Définir les erreurs et le message de succès
$erreurs = isset($_SESSION['erreurs']) ? $_SESSION['erreurs'] : [];
$messageSucces = isset($_SESSION['messageSucces']) ? $_SESSION['messageSucces'] : '';

// Génération du fichier CSV lorsque le bouton est cliqué
if (isset($_GET['action'])) {
    $conn = connecteBD();
    $date = date('d_m_Y'); // Format jour_mois_année

    switch ($_GET['action']) {
        case 'reservations':
            try {
                var_dump($_SESSION['messageSucces']); // TODO réparer les affichages de messages
                genererCSV(
                    "reservations_$date.csv",
                    ['ID Réservation', 'ID Salle', 'ID Employé', 'ID Activité', 'Date Réservation', 'Heure Début', 'Heure Fin'],
                    recupererDonnees('reservation', $conn)
                );
                $_SESSION['messageSucces'] = "Le fichier des réservations a été généré avec succès.";
                var_dump($_SESSION['messageSucces']);
            } catch (Exception $e) {
                $_SESSION['erreurs'][] = "Erreur lors de la génération du fichier des réservations: " . $e->getMessage();
            }
            break;

        case 'salles':
            try {
                genererCSV(
                    "salles_$date.csv",
                    ['ID Salle', 'Nom', 'Capacité', 'Vidéoprojecteur', 'Écran XXL', 'Ordinateur', 'Type', 'Logiciels', 'Imprimante'],
                    recupererDonnees('salle', $conn)
                );
                $_SESSION['messageSucces'] = "Le fichier des salles a été généré avec succès.";
            } catch (Exception $e) {
                $_SESSION['erreurs'][] = "Erreur lors de la génération du fichier des salles: " . $e->getMessage();
            }
            break;

        case 'employes':
            try {
                genererCSV(
                    "employes_$date.csv",
                    ['ID Employé', 'Nom', 'Prénom', 'Téléphone'],
                    recupererDonnees('employe', $conn)
                );
                $_SESSION['messageSucces'] = "Le fichier des employés a été généré avec succès.";
            } catch (Exception $e) {
                $_SESSION['erreurs'][] = "Erreur lors de la génération du fichier des employés: " . $e->getMessage();
            }
            break;

        case 'activites':
            try {
                genererCSV(
                    "activites_$date.csv",
                    ['ID Activité', 'Nom Activité'],
                    recupererDonnees('activite', $conn)
                );
                $_SESSION['messageSucces'] = "Le fichier des activités a été généré avec succès.";
            } catch (Exception $e) {
                $_SESSION['erreurs'][] = "Erreur lors de la génération du fichier des activités: " . $e->getMessage();
            }
            break;

        case 'tous':
            try {
                $fichiers = [];
                $fichiers["activites_$date.csv"] = genererCSVString(
                    ['ID Activité', 'Nom Activité'],
                    recupererDonnees('activite', $conn)
                );
                $fichiers["employes_$date.csv"] = genererCSVString(
                    ['ID Employé', 'Nom', 'Prénom', 'Téléphone'],
                    recupererDonnees('employe', $conn)
                );
                $fichiers["salles_$date.csv"] = genererCSVString(
                    ['ID Salle', 'Nom', 'Capacité', 'Vidéoprojecteur', 'Écran XXL', 'Ordinateur', 'Type', 'Logiciels', 'Imprimante'],
                    recupererDonnees('salle', $conn)
                );
                $fichiers["reservations_$date.csv"] = genererCSVString(
                    ['ID Réservation', 'ID Salle', 'ID Employé', 'ID Activité', 'Date Réservation', 'Heure Début', 'Heure Fin'],
                    recupererDonnees('reservation', $conn)
                );

                // Créer et envoyer le fichier ZIP
                genererZip("fichiers_$date.zip", $fichiers);
                $_SESSION['messageSucces'] = "Les fichiers ont été générés et compressés avec succès.";
            } catch (Exception $e) {
                $_SESSION['erreurs'][] = "Erreur lors de la génération des fichiers ZIP: " . $e->getMessage();
            }
            break;
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>StatiSalle - Téléchargement des données</title>
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
        <!-- FontAwesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <!-- CSS -->
        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="../css/header.css">
        <link rel="stylesheet" href="../css/footer.css">
        <!-- Icon du site -->
        <link rel="icon" href="../img/logo.ico">
    </head>
    <body>
        <div class="container-fluid">
            <!-- Header de la page -->
            <?php //include '../include/header.php'; ?>

            <div class="full-screen padding-header">
                <!-- Titre de la page -->
                <div class="row text-center padding-header">
                    <h1>Téléchargement des données</h1>
                </div>

                <!-- Affichage des erreurs globales seulement après soumission -->
                <?php if (!empty($erreurs)): ?>
                    <div class="row">
                        <div class="col-md-6 offset-md-3">
                            <div class="alert alert-danger">
                                <ul>
                                    <?php foreach ($erreurs as $erreur): ?>
                                        <li><?= $erreur ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Affichage du message de succès -->
                <?php if ($messageSucces): ?>
                    <div class="row">
                        <div class="col-md-6 offset-md-3">
                            <div class="alert alert-success">
                                <?= $messageSucces ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Contenu -->
                <div class="row d-flex justify-content-center align-items-start w-100 acc-row mt-3">
                    <div class="acc-container p-4 w-50">
                        <p>
                            Vous pouvez télécharger les données actuelles au format CSV pour les différentes catégories
                            ci-dessous. Chaque fichier contient les informations à jour de la base de données.
                        </p>
                        <div class="row">
                            <div class="col-md-6 col-sm-12 mb-3">
                                <button type="button" class="btn-bleu rounded w-100"
                                        onclick="window.location.href='?action=reservations'">
                                    Télécharger le fichier Réservations
                                </button>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-3">
                                <button type="button" class="btn-bleu rounded w-100"
                                        onclick="window.location.href='?action=salles'">
                                    Télécharger le fichier Salles
                                </button>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-3">
                                <button type="button" class="btn-bleu rounded w-100"
                                        onclick="window.location.href='?action=employes'">
                                    Télécharger le fichier Employés
                                </button>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-3">
                                <button type="button" class="btn-bleu rounded w-100"
                                        onclick="window.location.href='?action=activites'">
                                    Télécharger le fichier Activités
                                </button>
                            </div>
                            <div class="col-12 mb-3">
                                <button type="button" class="btn-bleu rounded w-100"
                                        onclick="window.location.href='?action=tous'">
                                    Télécharger tous les fichiers
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer de la page -->
            <?php include '../include/footer.php'; ?>
        </div>
    </body>
</html>
