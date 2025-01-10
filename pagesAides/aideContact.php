<?php
$startTime = microtime(true);
require("../fonction/connexion.php");

// Détection de la page actuelle
$isAidePage = isset($_SESSION['nom_page']) && str_starts_with($_SESSION['nom_page'], 'aide');
$basePath = $isAidePage ? '../' : ''; // Ajuste le chemin de base
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>StatiSalle - Aides Contact</title>
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
        <!-- FontAwesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <!-- CSS -->
        <link rel="stylesheet" href="<?php echo $basePath; ?>css/style.css">
        <link rel="stylesheet" href="<?php echo $basePath; ?>css/header.css">
        <link rel="stylesheet" href="<?php echo $basePath; ?>css/footer.css">
        <!-- Icon du site -->
        <link rel="icon" href="<?php echo $basePath; ?>img/logo.ico">
    </head>
    <body>
        <div class="container-fluid">

            <!-- header custom statique -->
            <header class="header row align-items-center">
                <div class="header-gauche d-flex align-items-center gap-2">
                    <a href="<?php echo $basePath; ?>pages/accueil.php" title="Page d'accueil">
                        <img src="<?php echo $basePath; ?>img/LogoStatisalle.jpg" alt="Logo de StatiSalle" class="img-fluid">
                    </a>
                    <a href="<?php echo $basePath; ?>pages/accueil.php" class="text-decoration-none text-white" title="Page d'accueil">
                        <h1 class="m-0">StatiSalle</h1>
                    </a>
                </div>
            </header>

            <div class="full-screen padding-header">
                <div class="row text-center">
                    <h1>StatiSalle</h1>
                </div>

                <div class="row d-flex justify-content-center align-items-start w-100 mb-5">
                    <div class="acc-container p-4 w-50">
                        <p>
                            Cette page sert à nous contacter en cas de besoin, si vous avez le moindre problème réessayez ultérieurement avant de nous contacter. Puis, si le problème persiste, contactez-nous.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Footer de la page -->
            <?php include $basePath . 'include/footer.php'; ?>
        </div>
    </body>
</html>
