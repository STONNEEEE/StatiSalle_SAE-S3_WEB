<?php
require("../fonction/connexion.php");
session_start();
verif_session();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>StatiSalle - Accueil</title>
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

    <div class="full-screen">
        <div class="padding-header">
            <!-- TODO A FINIR -->
            test
        </div>

        <div class="container">
            <div class="contact-card">
                <div class="contact-title">Contactez-nous</div>
                <p>
                    Pour nous contacter, veuillez envoyer un courriel à l'adresse suivante :
                    <a href="mailto:contact@statisalle.fr" class="contact-email">contact@statisalle.fr</a>
                </p>
                <p>Nous vous répondrons dans les plus brefs délais.</p>
            </div>
        </div>
    </div>

    <!-- Footer de la page -->
    <?php include '../include/footer.php'; ?>
</div>
</body>
</html>
