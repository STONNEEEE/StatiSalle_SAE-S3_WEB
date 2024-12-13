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
    </head>
    <body>
        <div class="container-fluid">
            <!-- Header de la page -->
            <?php include '../fonction/header.php'; ?>

            <div class="row text-center padding-header">
                <h1>StatiSalle</h1>
            </div>

            <div class="row d-flex justify-content-center align-items-start w-100 acc-row mb-5">
                <div class="acc-container p-4 w-50">
                    <!-- TODO Écrire le nom de l'utilisateur en fonction de celui qui est connecté-->
                    <p>Bienvenue, [Nom de l'utilisateur] !</p>
                    <p>
                        Ce site vous permet de gérer facilement les réservations des salles partagées pour vos réunions, formations, et autres activités.
                        <br>
                        Que voulez-vous faire ?
                    </p>
                    <p>
                        <!-- Lien vers la page pour faire une réservation -->
                        <a href="reservation.php" target="blank" class="text-decoration-none">🕒 Nouvelle réservation (ajouter une réservation rapidement).</a>
                    </p>
                    <p>
                        <!-- Lien vers la page pour afficher les réservations -->
                        <a href="affichageReservation.php" target="blank" class="text-decoration-none">📅 Afficher les réservations.</a>
                    </p>
                    <p>
                        <!-- Lien vers la page pour afficher ou gérer les salles -->
                        <!-- TODO Pour les admins "Gérer les salles", Pour les employés " Afficher les salles"-->
                        <a href="affichageSalle.php" target="blank" class="text-decoration-none">🏢 Gérer les salles.</a>
                    </p>
                    <p>
                        <!-- Lien vers la page pour exporter les données -->
                        <a href="exportation.php" target="blank" class="text-decoration-none">📊 Exporter des données.</a>
                    </p>
                    <p>
                        <!-- TODO Faire en sorte que cela s'affiche que pour les admins -->
                        <!-- Lien vers la page de gestion des employés -->
                        <a href="affichageEmploye.php" target="blank" class="text-decoration-none">👥 Gérer les employés.</a>
                    </p>
                </div>
            </div>
            <!-- Footer de la page -->
            <?php include '../fonction/footer.php'; ?>
        </div>
    </body>
    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
</html>
