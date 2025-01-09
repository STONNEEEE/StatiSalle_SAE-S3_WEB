<?php
require("../fonction/connexion.php");
session_start();
verif_session();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>StatiSalle - aides exportation</title>
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
                    Page d’exportation (exportation.php)<br>
                    Etape 1 :<br>
                    Ouvrez votre fichier php.ini (situé dans votre installation de PHP, par exemple : C:\php\php.ini ou dans le dossier de configuration de votre serveur local comme WAMP, XAMPP, etc.).<br>
                    Recherchez cette ligne :<br>
                    ;extension=zip<br>
                    Supprimez le point-virgule ; au début de cette ligne pour activer l'extension :
                    extension=zip<br>
                    Sauvegardez le fichier php.ini.<br>
                    Etape 2 :<br>
                    Redémarrez la machine sur laquelle vous avez modifié la ligne
                </p>
            </div>
        </div>
    </div>

    <!-- Footer de la page -->
    <?php include '../include/footer.php'; ?>
</div>
</body>
</html>
