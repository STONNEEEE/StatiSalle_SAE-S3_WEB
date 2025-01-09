<footer class="footer row">
    <?php
    // Récupérer le nom de la page actuelle
    $_SESSION['nom_page'] = basename($_SERVER['PHP_SELF'], '.php'); // Exemple : "index" pour "index.php"

    // Associer les pages d'aide aux noms de pages
    $aides = [
        'index'               => '   pagesAides/aideConnexion.php',
        'accueil'             => '../pagesAides/aideAccueil.php',
        'affichageEmploye'    => '../pagesAides/aideAffichageEmploye.php',
        'affichageSalle'      => '../pagesAides/aideAffichageSalle.php',
        'creationEmploye'     => '../pagesAides/aideCreationEmploye.php',
        'creationReservation' => '../pagesAides/aideCreationReservation.php',
        'creationSalle'       => '../pagesAides/aideCreationSalle.php',
        'mesReservation'      => '../pagesAides/aideMesReservation.php',
        'contact'            => '#',
    ];

    $page_aide = isset($aides[$_SESSION['nom_page']]) ? $aides[$_SESSION['nom_page']] : 'aideAccueil.php';
    ?>
    <script>
        // Stocker la page d'aide dans une variable JavaScript
        const pageAide = "<?php echo $page_aide; ?>";
    </script>
    <div class="col-12 col-sm-6 col-md-4 d-flex flex-column gap-2 align-items-center align-items-sm-start justify-content-center mb-md-0 mb-3">
        <button class="rounded bouton-footer"
                 type="button" onclick="window.open(pageAide, '_blank');"
                 aria-label="Ouvrir la page d'aide">
            Besoin d'aide ?
        </button>
        <button class="rounded bouton-footer"
                type="button" onclick="window.open('contact.php', '_blank');"
                aria-label="Ouvrir la page de contact">
            Contactez-nous
        </button>
    </div>

    <div class="col-12 col-sm-6 col-md-4 d-flex flex-column text-center text-sm-end text-md-center mb-md-0 mb-3">
        <h1>StatiSalle</h1>
        <div>
            <a href="https://maps.app.goo.gl/c9EToxRbfGmHKnPk9" target="_blank" class="text-white text-decoration-none" title="Google Maps">
                50 avenue de Bordeaux
            </a>
        </div>
        <div>
            <a href="https://www.ville-rodez.fr/" target="_blank" class="text-white text-decoration-none" title="Site de la ville de Rodez">
                12000 Rodez
            </a>
        </div>

        <div class="mt-3">
            <a href="https://www.facebook.com/" target="_blank" title="Facebook"><i class="fa-brands fa-square-facebook fa-2x"></i></a>
            <a href="https://www.instagram.com/" target="_blank" title="Instagram"><i class="fa-brands fa-square-instagram fa-2x ms-2"></i></a>
            <a href="https://www.linkedin.com/" target="_blank" title="Linkedin"><i class="fa-brands fa-linkedin fa-2x ms-2"></i></a>
        </div>
    </div>

    <div class="col-12 col-md-4 d-flex justify-content-md-end justify-content-center">
        <!-- TODO changer le lien -->
        <a href="../index.php" title="Page d'accueil">
            <img src="../img/LogoStatisalle.jpg" alt="Logo de StatiSalle" class="img-fluid d-none d-sm-none d-md-block">
        </a>
    </div>
</footer>
