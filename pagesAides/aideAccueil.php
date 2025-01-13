<?php
$startTime = microtime(true); // temps de chargement de la page
require("../fonction/connexion.php");

session_start();
verif_session();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>StatiSalle - Aides Generales</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- CSS -->
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <!-- Icon du site -->
    <link rel="icon" href=" ../img/logo.ico">
</head>
<body>
<div class="container-fluid">
    <!-- Header de la page -->
    <?php include '../include/header.php'; ?>

    <div class="full-screen padding-header">
        <div class="row text-center">
            <h1>StatiSalle</h1>
        </div>

        <div class="row d-flex justify-content-center align-items-start w-100 mb-5">
            <div class="acc-container p-4 w-50">
                <p>
                    <!-- Lien vers la page pour faire une réservation -->
                    La page d'accueil permet de montrer les différents types de fonctionnalités présentes dans l’application.
                    <br>En commençant avec la possibilité d’effectuer une réservation
                    <br><a href="#" class="text-decoration-none">🕒 Nouvelle réservation (ajout rapide).</a>

                </p>
                <p>
                    <!-- Lien vers la page pour afficher les réservations -->
                    <a href="#" class="text-decoration-none">
                        <?php
                        // si l'utilisateur est un admin alors, il peut accéder à la liste des employés
                        if ($_SESSION['typeUtilisateur'] === 1) {
                            echo '📅 Gérer les réservations. </a>';
                            echo " <br> Ceci correspond à l'affichage de toutes les reservations, mais c'est aussi l'endroit où l'administrateur peut gérer les salles.";
                        } else {
                            echo '📅 Afficher les réservations. </a>';
                            echo " <br> Ceci correspond à l'affichage de toutes les reservations.";
                        }
                        ?>
                    </a>

                </p>
                <p>
                    <!-- Lien vers la page pour afficher les réservations relié au compte -->
                    <a href="#" class="text-decoration-none">✏️ Gérer mes réservations.</a>
                    <br>Ensuite, nous avons l’affichage des réservations que vous avez effectuées avec votre compte.
                </p>
                <p>
                    <!-- Lien vers la page pour afficher ou gérer les salles -->
                    <a href="#" class="text-decoration-none">
                        <?php
                        // si l'utilisateur est un admin alors, il peut accéder à la liste des employés
                        if ($_SESSION['typeUtilisateur'] === 1) {
                            echo '🏢 Gérer les salles. </a>';
                            echo "<br> Pour continuer, nous avons la page d'affichage des salles où, en tant d'administrateur, vous pouvez également gérer les salles.";
                        } else {
                            echo '🏢 Afficher les salles.</a>';
                            echo '<br> Pour continuer avec les affichages, nous avons la liste de toutes les salles que l’entreprise dispose.';
                        }
                        ?>
                </p>
                <p>
                    <!-- Lien vers la page pour exporter les données -->
                    <a href="#" class="text-decoration-none">📊 Exporter des données.</a>
                    <br> Nous avons la fonctionnalité d’exportation des données en fichier au format CSV.
                </p>
                <p>
                    <?php
                    //si l'utilisateur est un admin alors, il peut accéder à la liste des employés
                    if($_SESSION['typeUtilisateur'] === 1){
                        echo '<a href="#" class="text-decoration-none">👥 Gérer les utilisateurs.</a>';
                        echo "<br> Pour finir, nous avons l'affichage de tous les utilisateurs, mais aussi la possibilité pour un administrateur de modifier ou supprimer un utilisateur.";
                    }
                    ?>
                </p>
            </div>
        </div>
    </div>

    <!-- Footer de la page -->
    <?php include '../include/footer.php'; ?>
</div>
</body>
</html>
