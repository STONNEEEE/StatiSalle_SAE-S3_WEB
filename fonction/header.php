<header class="header row d-flex align-items-center fixed-top px-3">
    <!-- Conteneur pour organiser le contenu à gauche et à droite -->
    <div class="d-flex w-100 justify-content-between align-items-center">
        <!-- Partie gauche -->
        <div class="d-flex align-items-center gap-3">
            <!-- Logo cliquable pour revenir à l'accueil -->
            <a href="accueil.php" title="Page d'accueil" class="d-flex align-items-center d-none d-sm-block">
                <img src="../img/LogoStatisalle.jpg" alt="Logo de StatiSalle" class="img-fluid">
            </a>

            <!-- Boutons principaux -->
            <div class="menu-pages d-flex flex-row gap-3 align-items-center">
                <!-- Bouton Accueil (visible sur écrans md et plus) -->
                <button class="rounded bouton-header d-none d-md-block" type="button"
                        onclick="window.location.href='accueil.php';">
                    Accueil
                </button>


                <!-- Menu déroulant pour le choix des pages -->
                <div class="dropdown d-none d-md-block">
                    <button class="rounded dropdown-toggle bouton-header custom-dropdown-toggle"
                            type="button" id="menuDeroulantPage" data-bs-toggle="dropdown" aria-expanded="false">
                        Pages
                        <i class="fas fa-angle-down"></i>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="menuDeroulantPage">
                        <!-- Accueil visible seulement sur écrans sm et moins -->
                        <li><a class="dropdown-item d-md-none" href="accueil.php">Accueil</a></li>
                        <li><a class="dropdown-item" href="affichageReservation.php">Réservations</a></li>
                        <li><a class="dropdown-item" href="affichageSalle.php">Salles</a></li>
                    </ul>
                </div>

                <!-- Boutons "Exporter" et "Utilisateurs" (visibles sur md et plus) -->
                <button class="rounded bouton-header d-none d-md-block" type="button" onclick="window.location.href='exportation.php';">
                    Exporter
                </button>
                <button class="rounded bouton-header d-none d-md-block" type="button" onclick="window.location.href='affichageEmploye.php';">
                    Utilisateurs
                </button>

                <!-- Menu déroulant pour "Exporter" et "Utilisateurs" (visible sur sm et moins) -->
                <div class="dropdown d-md-none">
                    <button class="rounded dropdown-toggle bouton-header custom-dropdown-toggle"
                            type="button" id="menuDeroulantOption" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-compass"></i>
                        Naviguer
                        <i class="fas fa-angle-down"></i>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="menuDeroulantOption">
                        <li><a class="dropdown-item" href="accueil.php">Accueil</a></li>
                        <li><a class="dropdown-item" href="affichageReservation.php">Réservations</a></li>
                        <li><a class="dropdown-item" href="affichageSalle.php">Salles</a></li>
                        <li><a class="dropdown-item" href="#">Exporter</a></li>
                        <li><a class="dropdown-item" href="#">Utilisateurs</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Partie droite (Bouton Nom de l'Employé) -->
        <div class="d-flex justify-content-end">
            <div class="dropdown">
                <button class="rounded dropdown-toggle bouton-header-employer custom-dropdown-toggle"
                        type="button"
                        id="menuDeroulantEmployer"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">
                    Nom_De_Employer
                    <i class="fas fa-angle-down"></i>
                </button>
                <ul class="dropdown-menu" aria-labelledby="menuDeroulantEmployer">
                    <li><a class="dropdown-item" href="#">Déconnexion</a></li>
                </ul>
            </div>
        </div>
    </div>
</header>
