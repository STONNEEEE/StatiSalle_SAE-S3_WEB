<header class="header row d-flex align-items-center fixed-top">
    <!-- partie de gauche -->
    <div class="col-12 col-md-8 d-flex align-items-center gap-3">
        <!-- Logo cliquable pour revenir à l'accueil -->
        <a href="#" title="Page d'accueil" class="d-flex align-items-center">
            <img src="../img/LogoStatisalle.jpg" alt="Logo de StatiSalle" class="img-fluid">
        </a>

        <!-- Menu principal -->
        <div class="menu-pages d-flex flex-row gap-3">
            <!-- Bouton Accueil -->
            <button class="rounded bouton-header">
                Accueil
            </button>

            <!-- Menu déroulant pour l'affichage des salles ou des réservations -->
            <div class="dropdown">
                <button class="rounded dropdown-toggle bouton-header" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                    Affichage
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <li><a class="dropdown-item" href="#">Réservations</a></li>
                    <li><a class="dropdown-item" href="#">Salles</a></li>
                </ul>
            </div>
            <!-- Bouton afin de gérer les employes -->
            <a href="#" class="rounded">Gestion des employes</a>
            <!-- Bouton afin de gérer les employes -->
            <a href="#" class="rounded">Nouvelle réservation</a>
            <!-- Bouton pour exporter les données -->
            <a href="#" class="rounded">Exporter</a>
        </div>
    </div>

    <!-- partie de droite -->
    <div class="col-12 col-md-4 d-flex justify-content-end">
        <div class="dropdown">
            <button class="rounded dropdown-toggle" type="button" data-bs-toggle="dropdown">
                Nom_De_Employer
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Déconnexion</a></li>
            </ul>
        </div>
    </div>
</header>
