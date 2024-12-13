<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>StatiSalle - Erreur Base de Données</title>
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

            <br>
            <div class="row text-center padding-header">
                <h1>Erreur de la base de données</h1>
            </div>

            <div class="row d-flex justify-content-center align-items-start w-100 acc-row mb-5 " >
                <div class="acc-container p-4 w-50 "  style="background-color : #82231d;">
                    <h3> Une erreur est survenu lors du chargement de la base de données</h3>
                </div>
            </div>
            <!-- Footer de la page -->
            <?php include '../fonction/footer.php'; ?>
        </div>
    </body>
    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</html>
