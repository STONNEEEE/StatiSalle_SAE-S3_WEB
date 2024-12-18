<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>StatiSalle - Réservation</title>
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
    <?php include '../include/header.php'; ?>

    <div class="full-screen">
        <div class="row text-center padding-header">
            <h1>Téléchargement des données</h1>
        </div>
        <br>
        <br>
        <div class="row d-flex justify-content-center align-items-start w-100 acc-row">
            <div class="acc-container p-4 w-50">
                <!-- TODO Généré le CSV quand on arrive sur la page -->
                <!--      Ecrasé le csv déja contenu dans le site avec les informations actuelles de la BD -->
                <!--      Généré le CSV quand on arrive sur la page -->
                <p>
                    Vous pouvez exporter les données que vous souhaitez en cliquant sur la ligne correspondante ci-dessous.<br>
                    Ou bien exporter toutes les données en cliquant sur le bouton.
                </p>
                <p>
                    <!-- Lien vers la page pour faire une réservation -->
                    <!-- TODO Lien vers le fichier CSV correspondant -->
                    <!-- TODO Ecrire la date et heure du jour de chargement de la page -->
                    <a href="../img/LogoStatisalle.jpg" download="LogoStatisalle.jpg">reservations 11_12_2024 13_40.csv</a>
                </p>
                <p>
                    <!-- Lien vers la page pour afficher les réservations -->
                    <!-- TODO Lien vers le fichier CSV correspondant -->
                    <!-- TODO Ecrire la date et heure du jour de chargement de la page -->
                    <a href="../img/LogoStatisalle.jpg" download="LogoStatisalle.jpg">salles 11_12_2024 13_40.csv</a>
                </p>
                <p>
                    <!-- Lien vers la page pour afficher ou gérer les salles -->
                    <!-- TODO Lien vers le fichier CSV correspondant -->
                    <!-- TODO Ecrire la date et heure du jour de chargement de la page -->
                    <a href="../img/LogoStatisalle.jpg" download="LogoStatisalle.jpg">employes 11_12_2024 13_40.csv</a>
                </p>
                <p>
                    <!-- Lien vers la page pour exporter les données -->
                    <!-- TODO Lien vers le fichier CSV correspondant -->
                    <!-- TODO Ecrire la date et heure du jour de chargement de la page -->
                    <a href="../img/LogoStatisalle.jpg" download="LogoStatisalle.jpg">activites 11_12_2024 13_40.csv</a>
                </p>
                <!-- Bouton "Tout télécharger" -->
                <div class="d-flex justify-content-end mt-3">
                    <button class="btn btn-primary" id="download-all" onclick="">
                        <i class="fas fa-download"></i> Tout télécharger
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer de la page -->
    <?php include '../include/footer.php'; ?>
</div>
</body>
</html>
