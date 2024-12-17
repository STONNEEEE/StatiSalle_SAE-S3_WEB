<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>StatiSalle - Modification Employés</title>
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

    <!-- Titre de la page -->
    <div class="padding-header row">
        <div class="text-center">
            <h1>Modification d'un employé</h1>
        </div>
    </div>
    <div class="container">
        <form>
            <div class="row">
                <div class="col-md-3 offset-md-3">
                    <label for="nom"></label>
                    <input class="form-text form-control" type="text" placeholder="nom" id="nom" name="nom" required>
                </div>
                <div class="col-md-3">
                    <label for="prenom"></label>
                    <input class="form-text form-control" type="text" placeholder="prenom" id="prenom" name="prenom" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <label for="numTel"></label>
                    <input class="form-text form-control" type="text" placeholder="numTel" id="numTel" name="numTel" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <label for="id"></label>
                    <input class="form-text form-control" type="text" placeholder="identifiant" id="id" name="id" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <label for="mdp"></label>
                    <input class="form-text form-control" type="text" placeholder="Mot de passe" id="mdp" name="mdp" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <label for="cmdp"></label>
                    <input class="form-text form-control" type="text" placeholder="Confirmez le mot de passe" id="cmdp" name="cmdp" required>
                </div>
            </div>
            <br>
            <div class="row full-screen">
                <div class="col-md-6 offset-md-3">
                    <button type="submit" class="btn-ajouter rounded w-100">Appliquer les modifications</button>
                </div>
            </div>
        </form>
        <br>
    </div>
    <?php include '../fonction/footer.php'; ?>
</div>
</body>
<!-- Bootstrap JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</html>
