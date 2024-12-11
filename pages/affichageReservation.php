<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>StatiSalle - Salles</title>
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
    <?php include '../fonction/header.php'; ?>

    <!-- Titre de la page -->
    <div class="padding-header row">
        <div class="col-12">
            <h1 class="text-center">Liste des Réservations</h1>
        </div>
        <br><br><br>
    </div>

    <!-- 1ère ligne avec le bouton "Réserver" -->
    <div class="row mb-3">
        <div class="col-12 text-center text-md-end">
            <button class="btn-filtrer rounded-2">
                <i class="fa fa-calendar"></i>
                Réserver
            </button>
        </div>
    </div>

    <div class="row mb-3">
        <!-- Sur téléphone chaque filtre prend toute la largeur -->
        <!-- Sur tablette chaque filtre prend 1/3 de la largeur -->
        <!-- Sur grand écran chaque filtre prend 1/6 de la largeur -->
        <div class="col-12 col-sm-4 col-md-2 mb-2">
            <select class="select-filtre w-100">
                <option selected>Nom du filtre</option>
                <option>Filtre 1</option>
                <option>Filtre 2</option>
                <option>Filtre 3</option>
            </select>
        </div>

        <div class="col-12 col-sm-4 col-md-2 mb-2">
            <select class="select-filtre w-100">
                <option selected>Nom du filtre</option>
                <option>Filtre 1</option>
                <option>Filtre 2</option>
                <option>Filtre 3</option>
            </select>
        </div>

        <div class="col-12 col-sm-4 col-md-2 mb-2">
            <select class="select-filtre w-100">
                <option selected>Nom du filtre</option>
                <option>Filtre 1</option>
                <option>Filtre 2</option>
                <option>Filtre 3</option>
            </select>
        </div>

        <div class="col-12 col-sm-4 col-md-2 mb-2">
            <select class="select-filtre w-100">
                <option selected>Nom du filtre</option>
                <option>Filtre 1</option>
                <option>Filtre 2</option>
                <option>Filtre 3</option>
            </select>
        </div>

        <div class="col-12 col-sm-4 col-md-2 mb-2">
            <select class="select-filtre w-100">
                <option selected>Nom du filtre</option>
                <option>Filtre 1</option>
                <option>Filtre 2</option>
                <option>Filtre 3</option>
            </select>
        </div>

        <div class="col-12 col-sm-4 col-md-2 mb-2">
            <select class="select-filtre w-100">
                <option selected>Nom du filtre</option>
                <option>Filtre 1</option>
                <option>Filtre 2</option>
                <option>Filtre 3</option>
            </select>
        </div>
    </div>

    <!-- Tableau des données -->
    <div class="row mt-3">
        <div class="col-12">
            <table class="table table-striped">
                <tr>
                    <th scope="col">Identifiant</th>
                    <th scope="col">Salle</th>
                    <th scope="col">Employe</th>
                    <th scope="col">Activite</th>
                    <th scope="col">Date</th>
                    <th scope="col">Heure debut</th>
                    <th scope="col">Heure fin</th>
                    <th scope="col">optionnel</th>
                    <th scope="col">optionnel</th>
                    <th scope="col">optionnel</th>
                    <th scope="col">optionnel</th>
                    <th scope="col">optionnel</th>
                </tr>
                <tbody>
                <tr>
                    <td>1</td>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>fsiuh</td>
                    <td>fjkfhn</td>
                    <td>zoi</td>
                    <td>zsoio</td>
                    <td>@mdo</td>
                    <td>@mdo</td>
                    <td>@mdo</td>
                    <td>@mdo</td>
                    <td>@mdo</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Jacob</td>
                    <td>Thornton</td>
                    <td>@fat</td>
                    <td>fjkfhn</td>
                    <td>zoi</td>
                    <td>zsoio</td>
                    <td>@mdo</td>
                    <td>@mdo</td>
                    <td>@mdo</td>
                    <td>@mdo</td>
                    <td>@mdo</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Larry</td>
                    <td>the Bird</td>
                    <td>@twitter</td>
                    <td>fjkfhn</td>
                    <td>zoi</td>
                    <td>zsoio</td>
                    <td>@mdo</td>
                    <td>@mdo</td>
                    <td>@mdo</td>
                    <td>@mdo</td>
                    <td>@mdo</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <br><br><br><br><br><br><br><br><br><br>
    <?php include '../fonction/footer.php'; ?>
</div>
<!-- Bootstrap JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
