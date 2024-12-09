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
            <h1>Liste des Salles</h1>
        </div>
        <div class="col-12 d-flex justify-content-between align-items-center mb-3">
            <!-- Filtres alignés à gauche -->
            <div class="d-flex">
                <label>
                    <select class="select-filtre me-2">
                        <option>Filtre 1</option>
                        <option>Filtre 2</option>
                        <option>Filtre 3</option>
                    </select>
                </label>
                <label>
                    <select class="select-filtre me-2">
                        <option>Filtre 1</option>
                        <option>Filtre 2</option>
                        <option>Filtre 3</option>
                    </select>
                </label>
                <label>
                    <select class="select-filtre me-2">
                        <option>Filtre 1</option>
                        <option>Filtre 2</option>
                        <option>Filtre 3</option>
                    </select>
                </label>
            </div>
            <!-- Bouton aligné à droite -->
            <button class="btn-filtrer rounded-2"><span class="fa-plus"></span>Ajouter</button>
        </div>
        <div>
            <table class="table table-striped">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">First</th>
                    <th scope="col">Last</th>
                    <th scope="col">Handle</th>
                </tr>
                <tr>
                    <th scope="row">1</th>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>Jacob</td>
                    <td>Thornton</td>
                    <td>@fat</td>
                </tr>
                <tr>
                    <th scope="row">3</th>
                    <td>Larry</td>
                    <td>the Bird</td>
                    <td>@twitter</td>
                </tr>
            </table>
            <br><br><br><br><br><br><br><br><br><br><br><br>
        </div>
        <?php include '../fonction/footer.php'; ?>
    </div>
</body>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</html>
