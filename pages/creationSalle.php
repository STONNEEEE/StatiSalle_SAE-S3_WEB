<?php

    // session_start();
    // require(..\fonction\fonction.php);

    // Vérification des variables issues du formulaire
    $nomSalle =         isset($_POST['nomSalle']) ? $_POST['nomSalle'] : '';
    $capacite =         isset($_POST['capacite']) ? $_POST['capacite'] : '';
    $videoProjecteur =  isset($_POST['videoProjecteur']) ? $_POST['videoProjecteur'] : '';
    $ordinateurXXL =    isset($_POST['ordinateurXXL']) ? $_POST['ordinateurXXL'] : '';
    $nbrOrdi =          isset($_POST['nbrOrdi']) ? $_POST['nbrOrdi'] : '';
    $typeMateriel =     isset($_POST['typeMateriel']) ? $_POST['typeMateriel'] : '';
    $logiciel =         isset($_POST['logiciel']) ? $_POST['logiciel'] : '';
    $imprimante =       isset($_POST['imprimante']) ? $_POST['imprimante'] : '';

    // Tableau pour stocker les erreurs
    $erreurs = [];

    // Vérification des champs obligatoires
    if (empty($nomSalle)) {
        $erreurs['nomSalle'] = "Le nom de la salle est obligatoire.";
    }
    if (empty($capacite)) {
        $erreurs['capacite'] = "La capacité est obligatoire.";
    }
    if (empty($videoProjecteur)) {
        $erreurs['videoProjecteur'] = "Le choix pour le vidéo projecteur est obligatoire.";
    }
    if (empty($ordinateurXXL)) {
        $erreurs['ordinateurXXL'] = "Le choix pour l'ordinateur XXL est obligatoire.";
    }

    // TODO Insertion de la Salle avec tous les paramètres
    // Rajouter une condition de si les données sont bien rentré pour permettre l'insertion
    // Faire que $pdo soit une variable globale dans le fichier des fonctions
    // creationSalle($pdo, $nomSalle, $capacite, $videoProjecteur, $ordinateurXXL, $nbrOrdi, $typeMateriel, $logiciel, $imprimante);

//    if (!isset($erreurs['nomSalle']) && !isset($erreurs['capacite']) && !isset($erreurs['videoProjecteur']) && !isset($erreurs['ordinateurXXL'])){
//        creationSalle( $nomSalle, $capacite, $videoProjecteur, $ordinateurXXL, $nbrOrdi, $typeMateriel, $logiciel, $imprimante);
//    }
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
                    <label for="nomSalle" class="<?= isset($erreurs['nomSalle']) ? 'enRouge' : '' ;?>" ><a title="Champ Obligatoire">Nom de la salle : *</a></label>
                    <input type="text" class="form-control" name="nomSalle" id="nomSalle" value="<?php echo htmlentities($nomSalle, ENT_QUOTES); ?>" placeholder="Exemple : Picasso" required>
                </div>
            </div>
            <br>
            <div class="row"> <!-- Capacité -->
                <div class="form-group col-12">
                    <label for="capacite" class="<?= isset($erreurs['capacite']) ? 'enRouge' : ' ' ?>"><a title="Champ Obligatoire">Capacité de la salle : *</a></label>
                    <input type="number" class="form-control" name="capacite" id="capacite" value="<?php echo htmlentities($capacite, ENT_QUOTES); ?>" min="0" >
                </div>
            </div>
            <br>
            <br>
            <div class="row"> <!-- Vidéo projecteur -->
                <div class="form-group col-12">
                    <label for="videoProjecteur" class="<?= isset($erreurs['videoProjecteur']) ? 'enRouge' : ' ' ?>"><a title="Champ Obligatoire">Vidéo projecteur : *</a></label>
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
                    <label for="ordinateurXXL" class="<?= isset($erreurs['ordinateurXXL']) ? 'enRouge' : ' ' ?>"><a title="Champ Obligatoire">Ordinateur XXL : *</a></label>
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
                    <label for="nbrOrdi">Nombre d'ordinateur : </label>
                    <input type="number" class="form-control" name="nbrOrdi" id="nbrOrdi" min="0" >
                </div>
            </div>
            <br>
            <div class="row"> <!-- Type matériel -->
                <div class="form-group col-12">
                    <label for="typeMateriel">Type de matériel :</label>
                    <input type="text" class="form-control" name="typeMateriel" id="typeMateriel">
                </div>
            </div>
            <br>
            <div class="row"> <!-- Logiciels installés  -->
                <div class="form-group col-md-12">
                    <label for="logiciel">Logiciels installés :</label>
                    <input type="text" class="form-control" name="logiciel" id="logiciel" placeholder="Exemple à suivre : bureautique, java, intellij, photoshop">
                </div>
            </div>
            <br>
            <div class="row"> <!-- Imprimante -->
                <div class="form-group col-md-12">
                    <label for="imprimante">Imprimante : </label>
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
        <div class="col-3 text-center w-100 ">
            <button type="submit" class="btn-ajouter rounded" id="submit">
                Créer la salle
            </button>
            <br><br>
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
