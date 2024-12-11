<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>StatiSalle - Employés</title>
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
    <div class="padding-header row">
        <div class="col-12">
            <h1 class="text-center">Liste des Employés</h1>
        </div>
        <br><br><br>
    </div>


    <!-- Bouton aligné à droite -->
    <div class="row">
        <div class="col-3 offset-10 col-md-5">
            <button class="btn-ajouter rounded-2">
                <span class="fa-plus"></span> Ajouter
            </button>
        </div>
    </div>
    <!-- Filtre -->
    <div class="row"> <!-- Grande row -->
        <div class="form-group col-md-2 mb-2"> <!-- Filtre 1 -->
            <select class="form-select" name="filtre1" id="filtre1" required>
                <option value="" disabled selected>Nom du filtre</option>
                <option value="filtre1-1">Filtre 1</option>
                <option value="filtre1-2">Filtre 2</option>
                <option value="filtre1-3">Filtre 3</option>
            </select>
        </div>

        <div class="form-group col-md-2 mb-2"> <!-- Filtre 2 -->
            <select class="form-select" name="filtre2" id="filtre2" required>
                <option value="" disabled selected>Nom du filtre</option>
                <option value="filtre2-1">Filtre 1</option>
                <option value="filtre2-2">Filtre 2</option>
                <option value="filtre2-3">Filtre 3</option>
            </select>
        </div>

        <div class="form-group col-md-2 mb-2"> <!-- Filtre 3 -->
            <select class="form-select" name="filtre3" id="filtre3" required>
                <option value="" disabled selected>Nom du filtre</option>
                <option value="filtre3-1">Filtre 1</option>
                <option value="filtre3-2">Filtre 2</option>
                <option value="filtre3-3">Filtre 3</option>
            </select>
        </div>

        <div class="col-3 col-md-5"> <!-- Bouton Réinitialisé -->
            <button class="btn-ajouter rounded-2">
                <span class="fa-mountain-sun"></span> Réinitialiser filtres
            </button>
        </div>
    </div>

    <div>
        <table class="table table-striped">
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prenom</th>
                <th>NumeroTel</th>
                <th></th>
            </tr>
            <tr>
                <td>1</td>
                <td>Mark</td>
                <td>Otto</td>
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
                <td class="btn-colonne">
                    <button class="btn-suppr rounded-2"><span class="fa-solid fa-trash"></span></button>
                    <button class="btn-modifier rounded-2"><span class="fa-regular fa-pen-to-square"></span></button>
                </td>
            </tr>
            <tr>
                <td>3</td>
                <td>Larry</td>
                <td>the Bird</td>
                <td>@twitter</td>
                <td class="btn-colonne">
                    <button class="btn-suppr rounded-2"><span class="fa-solid fa-trash"></span></button>
                    <button class="btn-modifier rounded-2"><span class="fa-regular fa-pen-to-square"></span></button>
                </td>
            </tr>
        </table>
        <br><br><br><br><br><br><br><br><br><br><br><br>
    </div>
    <?php include '../fonction/footer.php'; ?>
</div>
</body>
<!-- Bootstrap JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</html>
