<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>StatiSalle - Modification Salle</title>
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
        <!-- Contenu de la page -->
        <div class="row text-center padding-header">
            <br><br>
            <h1>Modification de la salle</h1>
        </div>
        <br>
        <!-- Choix de la salle et objet de la réunion ou bien sujet de la formation ou bien nature des travaux ou bien nom organisme ou bien description activité (seul en textarea)-->
        <div class="row"> <!-- Grande row -->
            <div class="form-group offset-md-2 col-md-4"> <!-- first colonne -->
                <br>
                <div class="row"> <!-- Nom de la salle -->
                    <div class="form-group col-12">
                        <label for="nomSalle" class="<?php //echo $classnoTel; ?>"><a title="Champ Obligatoire">Nom de la salle : *</a></label>
                        <input type="text" class="form-control" name="nomSalle" id="nomSalle" placeholder="Indiquer le nom de la salle" required>
                    </div>
                </div>
                <br>
                <div class="row"> <!-- Capacité -->
                    <div class="form-group col-12">
                        <label for="capacité" class="<?php //echo $classnoTel; ?>"><a title="Champ Obligatoire">Capacité de la salle : *</a></label>
                        <input type="number" class="form-control" name="nomSalle" id="nomSalle" placeholder="" min="0" required>
                    </div>
                </div>
                <br>
                <div class="row"> <!-- Vidéo projecteur -->
                    <div class="form-group col-12">
                        <label for="videoProjecteur" class="<?php //echo $classnoTel; ?>"><a title="Champ Obligatoire">Vidéo projecteur : *</a></label>
                        <input type="radio" class="form-check-input" id="OUI" name="videoProjecteur" value="OUI">
                        <label class="form-check-label" for="OUI">Oui</label>
                        <input type="radio" class="form-check-input" id="NON" name="videoProjecteur" value="NON">
                        <label class="form-check-label" for="NON">Non</label>
                    </div>
                </div>
                <br>
                <div class="row"> <!-- Ordinateur XXL -->
                    <div class="form-group col-md-12">
                        <label for="ordinateurXXL" class="<?php //echo $classnoTel; ?>"><a title="Champ Obligatoire">Ordinateur XXL : *</a></label>
                        <input type="radio" class="form-check-input" id="OUI" name="ordinateurXXL" value="OUI">
                        <label class="form-check-label" for="OUI">Oui</label>
                        <input type="radio" class="form-check-input" id="NON" name="ordinateurXXL" value="NON">
                        <label class="form-check-label" for="NON">Non</label>
                    </div>
                </div>
            </div>
            <div class="form-group col-md-4"> <!-- Informations supplémentaires -->
                <br>
                <div class="row"> <!-- Nombre d'ordinateurs -->
                    <div class="form-group col-12">
                        <label for="nbrOrdi" class="<?php //echo $classnoTel; ?>"><a title="Champ Obligatoire">Nombre d'ordinateur : *</a></label>
                        <input type="number" class="form-control" name="nbrOrdi" id="nbrOrdi" placeholder="" min="0" required>
                    </div>
                </div>
                <br>
                <div class="row"> <!-- Type matériel -->
                    <div class="form-group col-12">
                        <label for="typeMateriel" class="<?php //echo $classnoTel; ?>"><a title="Champ Obligatoire">Type de matériel : *</a></label>
                        <input type="text" class="form-control" name="nomSalle" id="nomSalle" placeholder="" required>
                    </div>
                </div>
                <br>
                <div class="row"> <!-- Logiciels installés  -->
                    <div class="form-group col-md-12">
                        <label for="logiciel" class="<?php //echo $classnoTel; ?>">Logiciels installés :</label>
                        <input type="text" class="form-control" name="nomSalle" id="nomSalle" placeholder="" required>
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
            <div class="col-3 text-center w-100">
                <button type="submit" class="btn-bleu rounded" id="submit">
                    Appliquer les modifications
                </button>
                <br><br><br><br><br><br><br><br>
            </div>
        </div>
    </div>

    <!-- Footer de la page -->
    <?php include '../include/footer.php'; ?>
</div>
</body>
</html>
