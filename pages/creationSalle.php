<?php

    // session_start();

    // Vérification des variables issues du formulaire
    $nomSalle =         isset($_POST['nomSalle']) ? $_POST['nomSalle'] : null;
    $capacite =         isset($_POST['capacite']) ? $_POST['capacite'] : null;
    $videoProjecteur =  isset($_POST['videoProjecteur']) ? $_POST['videoProjecteur'] : null;
    $ordinateurXXL =    isset($_POST['ordinateurXXL']) ? $_POST['ordinateurXXL'] : null;
    $nbrOrdi =          isset($_POST['nbrOrdi']) ? $_POST['nbrOrdi'] : null;
    $typeMateriel =     isset($_POST['typeMateriel']) ? $_POST['typeMateriel'] : null;
    $logiciel =         isset($_POST['logiciel']) ? $_POST['logiciel'] : null;
    $imprimante =       isset($_POST['imprimante']) ? $_POST['imprimante'] : null;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>StatiSalle - Création Salle</title>
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

    <!-- Contenu de la page -->
    <div class="row text-center padding-header">
        <br><br>
        <h1>Création d'une salle</h1>
    </div>
    <br>
    <form method="post" action="creationSalle.php">
    <div class="row"> <!-- Grande row -->
        <div class="form-group offset-md-2 col-md-4"> <!-- first colonne -->
            <!-- TODO Mettre le nom des champs obligatoires en rouge -->
            <br>
            <div class="row"> <!-- Nom de la salle -->
                <div class="form-group col-12">
                    <label for="nomSalle" class="<?= isset($tabErreurs['nomSalle']) ? 'enRouge' : '' ?>"><a title="Champ Obligatoire">Nom de la salle : *</a></label>
                    <input type="text" class="form-control" name="nomSalle" id="nomSalle" value="<?php echo htmlentities($nomSalle, ENT_QUOTES); ?>" placeholder="Exemple : Picasso" required>
                </div>
            </div>
            <br>
            <div class="row"> <!-- Capacité -->
                <div class="form-group col-12">
                    <label for="capacite" class="<?= isset($tabErreurs['capacite']) ? 'enRouge' : '' ?>"><a title="Champ Obligatoire">Capacité de la salle : *</a></label>
                    <input type="number" class="form-control" name="capacite" id="capacite" value="<?php echo htmlentities($capacite, ENT_QUOTES); ?>" min="0" >
                </div>
            </div>
            <br>
            <br>
            <div class="row"> <!-- Vidéo projecteur -->
                <div class="form-group col-12">
                    <label for="videoProjecteur" class="<?= isset($tabErreurs['videoProjecteur']) ? 'enRouge' : '' ?>"><a title="Champ Obligatoire">Vidéo projecteur : *</a></label>
                    <input type="radio" class="form-check-input" id="OUI" name="videoProjecteur" value="OUI" <?= $videoProjecteur == 'OUI' ? 'checked' : '' ?> >
                    <label class="form-check-label" for="OUI">Oui</label>
                    <input type="radio" class="form-check-input" id="NON" name="videoProjecteur" value="NON" <?= $videoProjecteur == 'NON' ? 'checked' : '' ?> >
                    <label class="form-check-label" for="NON">Non</label>
                </div>
            </div>
            <br>
            <br>
            <div class="row"> <!-- Ordinateur XXL -->
                <div class="form-group col-md-12">
                    <label for="ordinateurXXL" class="<?= isset($tabErreurs['ordinateurXXL']) ? 'enRouge' : '' ?>"><a title="Champ Obligatoire">Ordinateur XXL : *</a></label>
                    <input type="radio" class="form-check-input" id="OUI" name="ordinateurXXL" value="OUI" <?= $ordinateurXXL == 'OUI' ? 'checked' : '' ?> >
                    <label class="form-check-label" for="OUI">Oui</label>
                    <input type="radio" class="form-check-input" id="NON" name="ordinateurXXL" value="NON" <?= $ordinateurXXL == 'NON' ? 'checked' : '' ?> >
                    <label class="form-check-label" for="NON">Non</label>
                </div>
            </div>
        </div>
        <div class="form-group col-md-4"> <!-- Informations supplémentaires -->
            <br>
            <div class="row"> <!-- Nombre d'ordinateurs -->
                <div class="form-group col-12">
                    <label for="nbrOrdi" class="<?php //echo $classnoTel; ?>">Nombre d'ordinateur : </label>
                    <input type="number" class="form-control" name="nbrOrdi" id="nbrOrdi" min="0" >
                </div>
            </div>
            <br>
            <div class="row"> <!-- Type matériel -->
                <div class="form-group col-12">
                    <label for="typeMateriel" class="<?php //echo $classnoTel; ?>">Type de matériel :</label>
                    <input type="text" class="form-control" name="typeMateriel" id="typeMateriel">
                </div>
            </div>
            <br>
            <div class="row"> <!-- Logiciels installés  -->
                <div class="form-group col-md-12">
                    <label for="logiciel" class="<?php //echo $classnoTel; ?>">Logiciels installés :</label>
                    <input type="text" class="form-control" name="logiciel" id="logiciel" placeholder="Exemple à suivre : bureautique, java, intellij, photoshop">
                </div>
            </div>
            <br>
            <div class="row"> <!-- Imprimante -->
                <div class="form-group col-md-12">
                    <label for="imprimante" class="<?php //echo $classnoTel; ?>">Imprimante : </label>
                    <input type="radio" class="form-check-input" id="OUI" name="imprimante" value="OUI">
                    <label class="form-check-label" for="OUI">Oui</label>
                    <input type="radio" class="form-check-input" id="NON" name="imprimante" value="NON">
                    <label class="form-check-label" for="NON">Non</label>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <!-- TODO Faire en sorte que le bouton soit cliquable quand les infos obligatoires sont rentrées -->
        <div class="col-3 text-center w-100 ">
            <button type="submit" class="btn-ajouter rounded" id="submit">
                Créer la salle
            </button>
            <br><br><br><br><br><br><br><br>
        </div>
    </div>
    </form>
    <!-- Footer de la page -->
    <?php include '../fonction/footer.php'; ?>
</div>
</body>
<!-- Bootstrap JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</html>
