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
                <h1 class="text-center">Liste des Salles</h1>
            </div>
            <br><br><br>
        </div>

        <!-- 1ère ligne avec le bouton "Ajouter" -->
        <div class="row mb-3">
            <div class="col-12 text-center text-md-end">
                <button class="btn-ajouter rounded-2">
                    <span class="fa-plus">
                     Ajouter
                    </span>
                </button>
            </div>
        </div>

        <div class="row g-1 justify-content-start"> <!-- Grande row des filtres avec espacement réduit -->
            <!-- Nom des salles -->
            <div class="col-12 col-sm-4 col-md-2 mb-1">
                <select class="form-select select-nom">
                    <option selected>Tous les ...</option>
                    <option>Filtre 1</option>
                    <option>Filtre 2</option>
                    <option>Filtre 3</option>
                </select>
            </div>
            <!-- Nom des employés -->
            <div class="col-12 col-sm-4 col-md-2 mb-1">
                <select class="form-select select-nom">
                    <option selected>Tous les ...</option>
                    <option>Filtre 1</option>
                    <option>Filtre 2</option>
                    <option>Filtre 3</option>
                </select>
            </div>
            <!-- Nom des activités -->
            <div class="col-12 col-sm-4 col-md-2 mb-1">
                <select class="form-select select-nom">
                    <option selected>Tous les ...</option>
                    <option>Filtre 1</option>
                    <option>Filtre 2</option>
                    <option>Filtre 3</option>
                </select>
            </div>
            <!-- Date de début -->
            <div class="col-12 col-sm-4 col-md-1 mb-1">
                <select class="form-select select-time">
                    <option selected>Tous les ...</option>
                    <option>Filtre 1</option>
                    <option>Filtre 2</option>
                    <option>Filtre 3</option>
                </select>
            </div>
            <!-- Date de fin -->
            <div class="col-12 col-sm-4 col-md-1 mb-1">
                <select class="form-select select-time">
                    <option selected>Tous les ...</option>
                    <option>Filtre 1</option>
                    <option>Filtre 2</option>
                    <option>Filtre 3</option>
                </select>
            </div>
            <!-- Heure de début -->
            <div class="col-12 col-sm-4 col-md-1 mb-1">
                <select class="form-select select-time">
                    <option selected>Tous les ...</option>
                    <option>Filtre 1</option>
                    <option>Filtre 2</option>
                    <option>Filtre 3</option>
                </select>
            </div>
            <!-- Heure de fin -->
            <div class="col-12 col-sm-4 col-md-1 mb-1">
                <select class="form-select select-time">
                    <option selected>Tous les ...</option>
                    <option>10/12/2024</option>
                    <option>Filtre 2</option>
                    <option>Filtre 3</option>
                </select>
            </div>
            <!-- Bouton de réinitialisation des filtres -->
            <div class="col-6 col-sm-6 col-md-1 mb-1">
                <button class="btn-reset rounded-1 col-md-12">
                    Réinitialiser filtres
                </button>
            </div>
        </div>

        <!-- Tableau des données -->
        <div class="row mt-3">
            <div class="col-12">
                <table class="table table-striped">
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Capacite</th>
                        <th>Video Projecteur</th>
                        <th>ecran XXL</th>
                        <th>Ordinateur</th>
                        <th>Type</th>
                        <th>Logiciels</th>
                        <th>Imprimante</th>
                        <th></th>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                        <td>@mdo</td>
                        <td>@mdo</td>
                        <td>@mdo</td>
                        <td>@mdo</td>
                        <td>@mdo</td>
                        <td class="btn-colonne">
                            <button class="btn-suppr rounded-2"><span class="fa-solid fa-trash"></span></button>
                            <button class="btn-modifier rounded-2"><span class="fa-regular fa-pen-to-square"></span></button>
                        </td >
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                        <td>@mdo</td>
                        <td>@mdo</td>
                        <td>@mdo</td>
                        <td>@mdo</td>
                        <td>@mdo</td>
                        <td class="btn-colonne">
                            <button class="btn-suppr rounded-2"><span class="fa-solid fa-trash"></span></button>
                            <button class="btn-modifier rounded-2"><span class="fa-regular fa-pen-to-square"></span></button>
                        </td >
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Larry</td>
                        <td>the Bird</td>
                        <td>@twitter</td>
                        <td>@mdo</td>
                        <td>@mdo</td>
                        <td>@mdo</td>
                        <td>@mdo</td>
                        <td>@mdo</td>
                        <td class="btn-colonne">
                            <button class="btn-suppr rounded-2"><span class="fa-solid fa-trash"></span></button>
                            <button class="btn-modifier rounded-2"><span class="fa-regular fa-pen-to-square"></span></button>
                        </td >
                    </tr>
                </table>
                <br><br><br><br><br><br><br><br><br><br>
            </div>
        </div>
        <?php include '../fonction/footer.php'; ?>
    </div>
<!-- Bootstrap JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
