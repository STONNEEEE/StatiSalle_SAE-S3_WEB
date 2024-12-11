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
    <div class="padding-header">
        <h1 class="text-center">Liste des Employés</h1>
    </div>
    <div class="col-12 d-flex justify-content-between align-items-center mb-3">
        <!-- Filtres alignés à gauche -->
        <div class="d-flex">
            <select class="select-filtre me-2">
                <option selected>Nom du filtre</option>
                <option>Filtre 1</option>
                <option>Filtre 2</option>
                <option>Filtre 3</option>
            </select>
            <select class="select-filtre me-2">
                <option selected>Nom du filtre</option>
                <option>Filtre 1</option>
                <option>Filtre 2</option>
                <option>Filtre 3</option>
            </select>
            <select class="select-filtre me-2">
                <option selected>Nom du filtre</option>
                <option>Filtre 1</option>
                <option>Filtre 2</option>
                <option>Filtre 3</option>
            </select>
        </div>
        <!-- Bouton aligné à droite -->
        <button class="btn-ajouter rounded-2"><span class="fa-plus">Ajouter</button>
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
