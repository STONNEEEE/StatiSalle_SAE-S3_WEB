<?php
include '../fonction/employe.php';
require("../fonction/connexion.php");
//session_start();
//verif_session();


// Initialisation des variables et messages d'erreur
$nom = $prenom = $numTel = $login = $mdp = $cmdp = "";
$erreurs = [];
$messageSucces = "";

//vérifie si la modification est souhaitée
$modifie = $_POST['modifie'] ?? false;
$id = $_POST['id_employe'] ?? null;

//Récupération des attributs de l'employé en fonction de l'id de l'employé
$tabAttributEmploye = recupAttributEmploye($id);

//Récupération des attributs du login en fonction de l'id de l'employé
$tabAttributLogin = recupAttributLogin($id);

$nom = $_POST['nom'] ?? '';
$prenom = $_POST['prenom'] ?? '';
$numTel = $_POST['numTel'] ?? '';
$login = $_POST['login'] ?? '';
$mdp = $_POST['mdp'] ?? '';
$cmdp = $_POST['cmdp'] ?? '';
$admin = $_POST['admin'] ?? '0'; // Par défaut non admin

if(isset($_POST['modifier'])){
    // Récupération de la valeur de la case admin
    $admin = $_POST['admin'] ?? false; // Par défaut, pas d'admin
    $id_type = $admin ? 1 : 2;  // Si admin est coché, id_type = 1 (admin), sinon 2 (employé)

    //Fonction pour effectuer la modification
    modifierEmploye($id, $nom, $prenom, $login, $numTel, $mdp, $id_type);
    // Vérification des champs requis
    if (!isset($nom) || $nom === '') $erreurs['nom'] = "Le nom est requis.";
    if (!isset($prenom) || $prenom === '') $erreurs['prenom'] = "Le prénom est requis.";
    if (!isset($numTel) || $numTel === '') $erreurs['numTel'] = "Le numéro de téléphone est requis.";
    if (!isset($login) || $login === '') $erreurs['id'] = "Le login est requis.";
    if (!isset($mdp) || $mdp === '') $erreurs['mdp'] = "Le mot de passe est requis.";
    if (!isset($cmdp) || $cmdp === '') $erreurs['cmdp'] = "La confirmation du mot de passe est requise.";
    if (!isset($admin) || $admin === '') $erreurs['admin'] = "La selection du type de compte est requise";

    // Vérification des longueurs des champs
    if (strlen($numTel) < 4 || strlen($numTel) > 10) {
        $erreurs['numTel'] = "Le numéro de téléphone doit contenir entre 4 et 10 caractères.";
    }
    if (strlen($nom) < 1 || strlen($nom) > 50) {
        $erreurs['nom'] = "Le nom doit contenir entre 1 et 50 caractères.";
    }
    if (strlen($prenom) < 1 || strlen($prenom) > 50) {
        $erreurs['prenom'] = "Le prénom doit contenir entre 1 et 50 caractères.";
    }

// Vérification que le numéro de téléphone contient uniquement des chiffres
    if (!ctype_digit($numTel)) {
        $erreurs['numTel'] = "Le numéro de téléphone doit contenir uniquement des chiffres.";
    }

// Vérification que le mot de passe et sa confirmation sont identiques
    if ($mdp !== $cmdp) {
        $erreurs['cmdp'] = "Les mots de passe ne correspondent pas.";
    }
// Vérification format du mot de passe
    if (!verifMdp($mdp)) {
        $erreurs['mdp'] = "Le mot de passe doit faire plus de 8 caractères et contenir un caractère spécial, par exemple : @, #, $, %, & ou *.";
    }

// Vérification de l'unicité du login pour un employé
    if (verifLogin($login) > 0) {
        $erreurs['login'] = "Le login est déjà utilisé.";
    }

// Si aucune erreur, on appelle de la fonction pour ajouter l'employé dans la base de données
    if (empty($erreurs)) {
        try {
            $messageSucces = "Employé modifié avec succès !";
        } catch (Exception $e) {
            $erreurs[] = "Impossible de modifier l'employé dans la base de donnée : " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>StatiSalle - Modifications Employés</title>
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
        <!-- Titre de la page -->
        <div class="padding-header row">
            <div class="text-center">
                <br>
                <h1>Modifications d'un employé</h1>
            </div>
        </div>

        <!-- Affichage des erreurs globales seulement après soumission -->
        <?php if (!empty($erreurs)): ?>
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="alert alert-danger">
                        <ul>
                            <?php foreach ($erreurs as $erreur): ?>
                                <li><?= $erreur ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Affichage du message de succès -->
        <?php if ($messageSucces): ?>
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="alert alert-success">
                        <?= $messageSucces ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Contenu de la page -->
        <div class="container">
            <form method="POST" action="modificationEmploye.php">
                <!-- Nom et prénom -->
                <div class="row">
                    <div class="col-md-3 offset-md-3">
                        <label for="nom"></label><input class="form-text form-control" type="text" placeholder="Nom" id="nom" name="nom" value="<?= $tabAttributEmploye['nom'] ?>" required>
                        <?php if (isset($erreurs['nom'])): ?>
                            <small class="text-danger"><?= $erreurs['nom'] ?></small>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-3">
                        <label for="prenom"></label><input class="form-text form-control" type="text" placeholder="Prénom" id="prenom" name="prenom" value="<?= $tabAttributEmploye['prenom'] ?>" required>
                        <?php if (isset($erreurs['prenom'])): ?>
                            <small class="text-danger"><?= $erreurs['prenom'] ?></small>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Numéro de tel -->
                <div class="row">
                    <div class="col-md-6 offset-md-3">
                        <label for="numTel"></label><input class="form-text form-control" type="text" placeholder="Numéro de téléphone" id="numTel" name="numTel" value="<?= $tabAttributEmploye['telephone'] ?>" required>
                        <?php if (isset($erreurs['numTel'])): ?>
                            <small class="text-danger"><?= $erreurs['numTel'] ?></small>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- login -->
                <div class="row">
                    <div class="col-md-6 offset-md-3">
                        <label for="login"></label><input class="form-text form-control" type="text" placeholder="Compte utilisateur" id="login" name="login" value="<?= $tabAttributLogin['login'] ?>" required>
                        <?php if (isset($erreurs['login'])): ?>
                            <small class="text-danger"><?= $erreurs['login'] ?></small>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Mdp -->
                <div class="row">
                    <div class="col-md-6 offset-md-3">
                        <label for="mdp"></label><input class="form-text form-control" type="password" placeholder="Mot de passe" id="mdp" name="mdp" value="<?= $tabAttributLogin['mdp'] ?>" required>
                        <?php if (isset($erreurs['mdp'])): ?>
                            <small class="text-danger"><?= $erreurs['mdp'] ?></small>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Confirmation mot de passe -->
                <div class="row">
                    <div class="col-md-6 offset-md-3">
                        <label for="cmdp"></label><input class="form-text form-control" type="password" placeholder="Confirmez le mot de passe" id="cmdp" name="cmdp" value="<?= $tabAttributLogin['mdp'] ?>" required>
                        <?php if (isset($erreurs['cmdp'])): ?>
                            <small class="text-danger"><?= $erreurs['cmdp'] ?></small>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Case à cocher pour les permissions administratives -->
                <div class="row mt-3">
                    <div class="col-md-6 offset-md-3">
                        <label for="admin">Permissions administratives</label>
                        <?php $checked = ($tabAttributLogin['id_type'] == 1) ? 'checked' : ''; ?>
                        <input type="checkbox" id="admin" name="admin" value="<?= $tabAttributLogin['id_type'] ?>" <?= $checked?>>
                        <small class="text-muted">Cochez cette case si l'employé a des permissions administratives.</small>
                    </div>
                </div>

                <!-- Boutton envoyer le formulaire -->
                <div class="row mt-4">
                    <div class="col-md-6 offset-md-3">
                        <input type="hidden" id="modifier" name="modifier" value="true">
                        <input type="hidden" id="id_employe" name="id_employe" value="<?= $id ?>">
                        <button type="submit" class="btn-bleu rounded w-100">Modifier le compte</button>
                    </div>
                </div>
            </form>
            <div class ="row offset-md-2">
                <div>
                    <button class="btn-suppr rounded-2" type="button"
                            onclick="window.location.href='affichageEmploye.php'">
                        Retour
                    </button>
                </div>
            </div>
        </div>
        <br><br>
    </div>

    <?php include '../include/footer.php'; ?>
</div>
</body>
</html>
