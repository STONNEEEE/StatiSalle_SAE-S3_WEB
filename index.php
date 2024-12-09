<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>StatiSalle - Connexion</title>
        <!-- CSS -->
        <link rel="stylesheet" href="css/commun.css">
        <link rel="stylesheet" href="css/index.css">
        <link rel="stylesheet" href="css/header.css">
        <link rel="stylesheet" href="css/footer.css">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
        <!-- FontAwesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    </head>
    <body>
        <div class="container-fluid">
            <!-- l'index (page de connexion) est la seule page avec un header custom-->
            <header class="header row align-items-center">
                <div class="header-gauche d-flex align-items-center gap-2">
                    <a href="#" title="Page d'accueil">
                        <img src="img/LogoStatisalle.jpg" alt="Logo de StatiSalle" class="img-fluid">
                    </a>
                    <a href="#" class="text-decoration-none" title="Page d'accueil">
                        <h1 class="m-0">StatiSalle</h1>
                    </a>
                </div>
            </header>

            <div class="row d-flex justify-content-center align-items-center w-100 auth-row">
                <div class="auth-container text-center p-4 w-50">
                    <h3 class="mb-4">
                        Authentification
                        <a href="#" target="_blank" class="ms-2" title="Page d'aide">
                            <i class="fa fa-question-circle fs-5 text-black"></i>
                        </a>
                    </h3>

                    <!-- Champ Identifiant -->
                    <div class="mb-3">
                        <div class="d-flex flex-column flex-sm-row justify-content-between">
                            <label for="identifiant" class="form-label mb-1 mb-sm-0">Identifiant</label>
                            <small class="form-text text-sm-start text-md-end">
                                <a href="#" target="_blank" class="text-danger text-decoration-none" title="Identifiant oublié">
                                    Identifiant oublié ?
                                </a>
                            </small>
                        </div>
                        <input type="text" class="form-control mt-2 mt-sm-0" id="identifiant" placeholder="Entrez votre identifiant">
                    </div>

                    <!-- Champ Mot de passe -->
                    <div class="mb-3">
                        <!-- Container pour label et small -->
                        <div class="d-flex flex-column flex-sm-row justify-content-between">
                            <label for="mdp" class="form-label mb-1 mb-sm-0">Mot de passe</label>
                            <small class="form-text text-sm-start text-md-end">
                                <a href="#" target="_blank" class="text-danger text-decoration-none" title="Mot de passe oublié">
                                    Mot de passe oublié ?
                                </a>
                            </small>
                        </div>
                        <input type="password" class="form-control mt-2 mt-sm-0" id="mdp" placeholder="Entrez votre mot de passe">
                    </div>

                    <!-- Bouton -->
                    <button type="submit" class="btn btn-info w-100">Se connecter</button>
                </div>
            </div>

            <?php include 'fonction/footer.php'; ?>
        </div>
    </body>
    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</html>
