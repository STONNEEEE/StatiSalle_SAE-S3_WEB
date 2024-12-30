<?php
    session_start();

    require('fonction/liaisonBD.php');
    require('fonction/connexion.php');

    try {
        $pdo = connecteBD();
    } catch (Exception $e) {
        header('Location: erreurBD.php');
        exit();
    }

    $erreur = false;

    // Si l'utilisateur est déjà connecté, redirige vers accueil.php
    if (isset($_SESSION['id'])) {
        header('Location: pages/accueil.php');
        exit;
    }

    $identifiant = isset($_POST['identifiant']) ? $_POST['identifiant'] : '';
    print(password_hash('admin', PASSWORD_BCRYPT)); echo "<br>";
    print(password_hash($_POST['mdp'], PASSWORD_BCRYPT)); echo "<br>";
    print($_POST['mdp']);
    $mdp = isset($_POST['mdp']) ? password_hash($_POST['mdp'], PASSWORD_BCRYPT) : '';


    // vérification de l'éxistence de l'identifiant de l'utilisateur
    $utilisateurOk = verif_utilisateur($pdo, $identifiant);
    // vérification de l'éxistence du mot de passe de l'utilisateur
    $mdpOk = verif_mdp($pdo, $mdp);

    $typeUtilisateur = type_utilisateur($pdo, $identifiant, $mdp);

    if ($typeUtilisateur != null) {
        $_SESSION['typeUtilisateur'] = $typeUtilisateur->id_type;
    }

    if ($identifiant != "" && $mdp != "") {
        if ($utilisateurOk && $mdpOk) {
            $_SESSION['id'] = $utilisateurOk->id_login;
            $_SESSION['login'] = $utilisateurOk->login;
            $_SESSION['mdp'] = $utilisateurOk->mdp;
            header('Location: pages/accueil.php');
            exit;
        } else {
            $erreur = true;
        }
    }
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>StatiSalle - Connexion</title>
        <!-- CSS -->
        <link rel="stylesheet" href="css/style.css">
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
                    <a href="#" class="text-decoration-none text-white" title="Page d'accueil">
                        <h1 class="m-0">StatiSalle</h1>
                    </a>
                </div>
            </header>

            <div class="row d-flex justify-content-center align-items-center w-100 auth-row">
                <div class="auth-container text-center p-4 w-50">
                    <h3 class="mb-4">
                        <?php
                            if ($erreur) {
                                if (!$utilisateurOk) {
                                    echo "<span class='erreur'>Erreur : Veuillez entrer un identifiant valide.</span>";
                                }
                                if (!$mdpOk) {
                                    echo "<span class='erreur'>Erreur : Veuillez entrer un mot de passe valide.</span>";
                                }
                            } else {
                                echo "Authentification";
                            }
                        ?>
                        <a href="#" target="_blank" class="ms-2" title="Page d'aide">
                            <i class="fa fa-question-circle fs-5 text-black"></i>
                        </a>
                    </h3>
                    <form action="" method="post">
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
                            <input type="text" class="form-control mt-2 mt-sm-0" name="identifiant" id="identifiant" placeholder="Entrez votre identifiant">
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
                            <input type="password" class="form-control mt-2 mt-sm-0" name="mdp" id="mdp" placeholder="Entrez votre mot de passe">
                        </div>
                        <button type="submit" class="btn btn-info w-100">Se connecter</button>
                    </form>
                </div>
            </div>

            <?php include 'include/footer.php'; ?>
        </div>
    </body>
</html>
