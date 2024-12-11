<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>StatiSalle - Réservation</title>
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
        <h1 style="color:red">Réserver votre salle</h1>
    </div>

    <!-- Choix de la salle et objet de la réunion ou bien sujet de la formation ou bien nature des travaux ou bien nom organisme ou bien description activité (seul en textarea)-->
    <div class="row mt-4">
        <div class="form-group offset-2 col-4">
            <!--TODO Faire une liste déroulante avec une fonction php qui récupère les salles correspondantes -->
            <label for="salle-select" class="<?php //echo $classnoTel; ?>">Nom de la salle :</label>
            <select class="form-select" name="nomSalle" id="salle-select"
                    required>
                <option value="" disabled selected>Choisir la salle</option>
                <option value="salle1">salle1</option>
                <option value="salle2">salle2</option>
                <option value="salle3">salle3</option>
                <option value="salle4">salle4</option>
                <option value="salle5">salle5</option>
                <option value="salle6">salle6</option>
            </select>
        </div>
        <div class="form-group col-2">
            <!-- TODO Faire en sorte que ça s'affiche lorsque réunion est sélectionné pour l'activité -->
            <!-- objet de la réunion-->
            <!-- ou bien sujet de la formation-->
            <!-- ou bien nature des travaux-->
            <!-- ou bien nom organisme-->
            <!-- ou bien description activité (seul en textarea)-->
            <label for="objet" class="<?php //echo $classnoTel; ?>">Objet de
                votre réunion :</label>
            <input type="text" class="form-control" name="objet" id="objet"
                   required>
            <?php
            //                            if() {
            //                                Faire le textarea
            //                            } else {
            //                                Faire le input
            //                            }
            ?>
        </div>
    </div>
    <br>
    <!-- Activité, nom et prénom de l'interlocuteur ou du formateur -->
    <div class="row">
        <div class="form-group offset-2 col-4">
            <!--TODO Faire une liste déroulante avec une fonction php qui récupère les activités correspondantes -->
            <label for="activite-select" class="<?php //echo $classnoTel; ?>">Activité :</label>
            <select class="form-select" name="nomActivite" id="activite-select"
                    required>
                <option value="" disabled selected>Choisir l'activité</option>
                <option value="activité1">activité1</option>
                <option value="activité2">activité2</option>
                <option value="activité3">activité3</option>
                <option value="activité4">activité4</option>
                <option value="activité5">activité5</option>
                <option value="activité6">activité6</option>
            </select>
        </div>
        <div class="col-2">
            <!--TODO Faire en sorte que ça s'affiche lorsque formation ou pret/louée est sélectionné pour l'activité -->
            <label for="autre" class="<?php //echo $classnoTel; ?>">Nom
                formateur :</label>
            <input id="autre" name="autre" class="form-control"
                   placeholder="Décrivez votre activité">
        </div>
        <div class="col-2">
            <!--TODO Faire en sorte que ça s'affiche lorsque formation ou pret/louée est sélectionné pour l'activité -->
            <label for="travaux" class="<?php //echo $classnoTel; ?>">Prénom
                formateur :</label>
            <input type="text" class="form-control" name="travaux" id="travaux" required>
        </div>
    </div>
    <br>
    <?php
    //                // Date et heure du jour
    //                $dt = new DateTime();
    ?>
    <!-- Date, numéro de téléphone et précision sur l'activité -->
    <div class="row">
        <div class="form-group offset-2 col-2">
            <!--TODO Faire un calendrier avec impossibilité de sélectionné des jours avent aujourd'hui -->
            <!--     Impossible de réserver une salle le dimanche et seulement entre 7h et 20h -->
            <label for="date">Date :</label>
            <input type="date" id="date" name="date"
                   placeholder="Choisir la date de votre réservation"
                   class="form-control" value="" min="" required>
        </div>
        <div class="form-group col-1">
            <!-- TODO Faire en sorte que les horaires soit compris entre 7h et 20h maximum -->
            <label for="heureDebut">Heure début :</label>
            <input type="time" id="heureDebut" name="heureDebut"
                   class="form-control" min="07:00" max="20:00" required>
        </div>
        <div class="form-group col-1">
            <!-- TODO Faire en sorte que les horaires soit compris entre 7h et 20h maximum -->
            <label for="heureFin">Heure fin :</label>
            <input type="time" id="heureFin" name="heureFin"
                   class="form-control" min="07:00" max="20:00" required>
        </div>
        <div class="form-group col-2">
            <!--TODO Faire en sorte que ça s'affiche lorsque réunion est sélectionné pour l'activité -->
            <label for="sujetFormation" class="<?php //echo $classnoTel; ?>">Numéro
                de téléphone :</label>
            <input type="text" class="form-control" name="sujetFormation"
                   id="sujetFormation" required>
        </div>
        <div class="form-group col-2">
            <!--TODO Faire en sorte que ça s'affiche lorsque travaux/entretien est sélectionné pour l'activité -->
            <label for="precisActivite" class="<?php //echo $classnoTel; ?>">Précision sur activité :</label>
            <input type="text" class="form-control" placeholder=""
                   name="precisActivite" id="precisActivite" required>
        </div>
    </div>
    <br>
    <!-- TODO Faire en sorte que le bouton soit cliquable quand les infos obligatoires sont rentrées -->
    <div class="col-3 offset-9 mb-5">
        <button type="submit" class="btn btn-primary btn-block" id="submit">
            Réserver
        </button>
        <br><br><br><br><br><br><br><br>
    </div>
    <!-- Footer de la page -->
    <?php include '../fonction/footer.php'; ?>
</div>
</body>
<!-- Bootstrap JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</html>
