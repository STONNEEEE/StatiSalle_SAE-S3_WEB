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
    <?php include '../include/header.php'; ?>

    <div class="full-screen">
        <!-- Contenu de la page -->
        <div class="row text-center padding-header">
            <br><br>
            <h1>Réserver votre salle</h1>
        </div>
        <br>
        <!-- Choix de la salle et objet de la réunion ou bien sujet de la formation ou bien nature des travaux ou bien nom organisme ou bien description activité (seul en textarea)-->
        <div class="row"> <!-- Grande row -->
            <div class="form-group offset-md-2 col-md-4"> <!-- first colonne -->
                <br>
                <div class="row"> <!-- Salle -->
                    <div class="form-group col-md-12">
                        <!--TODO Faire une liste déroulante avec une fonction php qui récupère les salles correspondantes -->
                        <label for="salle-select" class="<?php //echo $classnoTel; // Pour mettre ne rouge?>"><a title="Champ Obligatoire">Nom de la salle : *</a></label>
                        <select class="form-select" name="nomSalle" id="salle-select" required>
                            <option value="" disabled selected>Choisir la salle</option>
                            <option value="salle1">salle1</option>
                            <option value="salle2">salle2</option>
                            <option value="salle3">salle3</option>
                            <option value="salle4">salle4</option>
                            <option value="salle5">salle5</option>
                            <option value="salle6">salle6</option>
                        </select>
                    </div>
                </div>
                <br>
                <div class="row"> <!-- Activité -->
                    <div class="form-group col-md-12">
                        <!--TODO Faire une liste déroulante avec une fonction php qui récupère les activités correspondantes -->
                        <label for="activite-select" class="<?php //echo $classnoTel; ?>"><a title="Champ Obligatoire">Activité : *</a></label>
                        <select class="form-select" name="nomActivite" id="activite-select" required>
                            <option value="" disabled selected>Choisir l'activité</option>
                            <option value="activité1">activité1</option>
                            <option value="activité2">activité2</option>
                            <option value="activité3">activité3</option>
                            <option value="activité4">activité4</option>
                            <option value="activité5">activité5</option>
                            <option value="activité6">activité6</option>
                        </select>
                    </div>
                </div>
                <br>
                <div class="row"> <!-- Date, Heure Début, Heure Fin -->
                    <div class="form-group col-md-6">
                        <div class="row">
                            <div class="form-group col-12">
                                <!-- TODO Faire un calendrier avec impossibilité de sélectionné des jours avent aujourd'hui -->
                                <!-- TODO A créer le css pour "petite-taille" -->
                                <!--      Impossible de réserver une salle le dimanche et seulement entre 7h et 20h -->
                                <label for="date" class="petite-taille"><a title="Champ Obligatoire">Date : *</a></label>
                                <input type="date" id="date" name="date" placeholder="Choisir la date de votre réservation" class="form-control" value="" min="" required>
                            </div>
                        </div>
                        <br>
                    </div>
                    <div class="form-group col-md-3">
                        <div class="row">
                            <div class="form-group col-12">
                                <!-- TODO Faire en sorte que les horaires soit compris entre 7h et 20h maximum -->
                                <label for="heureDebut" class="petite-taille"><a title="Champ Obligatoire">Heure début : *</a></label>
                                <input type="time" id="heureDebut" name="heureDebut" class="form-control" min="07:00" max="20:00" required>
                            </div>
                        </div>
                        <br>
                    </div>
                    <div class="form-group col-md-3">
                        <div class="row">
                            <div class="form-group col-12">
                                <!-- TODO Faire en sorte que les horaires soit compris entre 7h et 20h maximum -->
                                <label for="heureFin" class="petite-taille"><a title="Champ Obligatoire">Heure de fin : *</a></label>
                                <input type="time" id="heureFin" name="heureFin" class="form-control" min="07:00" max="20:00" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group col-md-4"> <!-- Informations supplémentaires -->
                <br>
                <div class="row"> <!-- Objet de l'activité sélectionné -->
                    <div class="form-group col-md-6">
                        <!-- TODO Faire en sorte que ça s'affiche lorsque réunion est sélectionné pour l'activité -->
                        <!-- objet de la réunion-->
                        <!-- ou bien sujet de la formation-->
                        <!-- ou bien nature des travaux-->
                        <!-- ou bien nom organisme-->
                        <!-- ou bien description activité (seul en textarea)-->
                        <label for="objet" class="<?php //echo $classnoTel; ?>">Objet de votre réunion :</label>
                        <input type="text" class="form-control" name="objet" id="objet" required>
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
                <div class="row"> <!-- Nom formateur ou interlocuteur -->
                    <div class="col-md-6">
                        <div class="row">
                            <div class="form-group col-12">
                                <!--TODO Faire en sorte que ça s'affiche lorsque formation ou prêt/louée est sélectionné pour l'activité -->
                                <label for="autre" class="<?php //echo $classnoTel; ?>">Nom formateur :</label>
                                <input id="autre" name="autre" class="form-control" placeholder="Décrivez votre activité">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6"> <!-- Prénom formateur ou interlocuteur -->
                        <div class="row">
                            <div class="form-group col-12">
                                <!--TODO Faire en sorte que ça s'affiche lorsque formation ou prêt/louée est sélectionné pour l'activité -->
                                <label for="travaux" class="<?php //echo $classnoTel; ?>">Prénom formateur :</label>
                                <input type="text" class="form-control" name="travaux" id="travaux" required>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row"> <!-- Numéro de téléphone formateur ou interlocuteur -->
                    <div class="form-group col-md-6">
                        <div class="row">
                            <div class="form-group col-12">
                                <!--TODO Faire en sorte que ça s'affiche lorsque réunion est sélectionné pour l'activité -->
                                <label for="sujetFormation" class="<?php //echo $classnoTel; ?>">Numéro de téléphone :</label>
                                <input type="text" class="form-control" name="sujetFormation" id="sujetFormation" required>
                            </div>
                        </div>
                        <br>
                    </div>
                    <div class="form-group col-md-6">
                        <div class="row"> <!-- Précision sur l'activité -->
                            <div class="form-group col-12">
                                <!--TODO Faire en sorte que ça s'affiche lorsque travaux/entretien est sélectionné pour l'activité -->
                                <label for="precisActivite" class="<?php //echo $classnoTel; ?>">Précision sur activité :</label>
                                <input type="text" class="form-control" placeholder="" name="precisActivite" id="precisActivite" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <!-- TODO Faire en sorte que le bouton soit cliquable quand les infos obligatoires sont rentrées -->
            <div class="col-3 offset-9 col-md-5">
                <button type="submit" class="btn btn-primary btn-block" id="submit">
                    Réserver
                </button>
            </div>
        </div>
    </div>

    <!-- Footer de la page -->
    <?php include '../include/footer.php'; ?>
</div>
</body>
</html>
