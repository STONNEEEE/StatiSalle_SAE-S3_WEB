<?php
$startTime = microtime(true);
require("../fonction/connexion.php");
session_start();
verif_session();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>StatiSalle - Aides Réservations</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- CSS -->
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <!-- Icon du site -->
    <link rel="icon" href=" ../img/logo.ico">
</head>
<body>
<div class="container-fluid">
    <!-- Header de la page -->
    <?php include '../include/header.php'; ?>

    <div class="full-screen padding-header">
        <div class="row text-center">
            <h1>StatiSalle</h1>
        </div>

        <div class="row d-flex justify-content-center align-items-start w-100 mb-5">
            <div class="acc-container p-4 w-50">
                <table class="table table-striped">
                    <p>
                        Pour commencer il y a le tableau central qui contient la liste de toutes les réservations. En plus de l’affichage il y a les boutons de modification et de suppression seulement pour l'administrateur comme sur cette page (si vous êtes utilisateur normal, vous ne verrez pas ces boutons). Lorsque vous cliquez sur le bouton de modification un page s’ouvre, pour plus d’aide n’hésitez pas à aller sur la page de la modification des réservations. Il y a également un bouton pour effectuer la suppression d'une réservation. Avant d'effectuer la suppression une confirmation vous sera demandé pour faire en sorte que vous ne supprimiez pas une réservation par inadvertence. Pour plus d’information sur une réservation, vous pouvez passer votre souris sur le i<span class="fa-solid fa-circle-info info-icon"></span>.
                    </p>
                    <tr>
                        <th>ID</th>
                        <th>Salle</th>
                        <th>Employé</th>
                        <th>Activité</th>
                        <th>Date</th>
                        <th>heure début</th>
                        <th>heure fin</th>
                        <th></th>
                    </tr>
                    <tr>
                        <td>R000019</td>
                        <td>A7</td>
                        <td>user user</td>
                        <td>réunion<span class="fa-solid fa-circle-info info-icon"></span></td>
                        <td>21-11-2025</td>
                        <td>07:00:00</td>
                        <td>10:00:00</td>
                        <?php
                            if($_SESSION['typeUtilisateur'] === 1){
                                echo '<td>';
                                echo '<button type="submit" class="btn-suppr rounded-2">';
                                echo '<span class="fa-solid fa-trash"></span>';
                                echo '</button>';
                                echo '<button type="submit" class="btn-modifier rounded-2">';
                                echo '<span class="fa-regular fa-pen-to-square"></span>';
                                echo '</button>';
                                echo '</td>';
                            }
                        ?>
                    </tr>
                </table>
                <p>
                    Il y a des filtres qui permettent de faciliter la recherche d’une réservation avec le nom de la salle si aucune réservation n'est trouvée alors, il a un message disant : "Aucune réservation n'est trouvée".
                </p>
                <!-- Salle -->
                <div class="col-12 col-md-2 mb-1 col-reduit-salle ">
                    <select class="form-select select-nom" id="salle">
                        <option value=""  selected>Salle</option>
                    </select>
                </div>
                <p>
                    Il y a également un filtre un tri par activité type d’activité.
                </p>
                <!-- Activité -->
                <div class="col-3">
                    <select class="form-select select-nom" id="activite">
                        <option value="" selected>Activité</option>
                    </select>
                </div>
                <p>
                    Il existe des filtres permettant de sélectionner une plage de dates afin d’identifier les réservations comprises entre une date A et une date B. Par exemple, pour afficher toutes les réservations effectuées en janvier, il suffit de définir la date de début au 1er janvier et la date de fin au 31 janvier. Si vous souhaitez consulter les réservations effectuées sur une seule journée, il suffit d’indiquer cette date dans le filtre "date de début" ou "date de fin".
                </p>
                <!-- Date -->
                <div class="col-3">
                    <select class="form-select select-nom" id="dateDebut">
                        <option value="" selected>Date Debut</option>
                    </select>
                </div>
                <div class="col-3">
                    <select class="form-select" id="date_fin">
                        <option selected>Date Fin</option>
                    </select>
                </div>
                <p>
                    Pour le fonctionnement des filtres heure début et heure fin, c'est le même principe que pour les filtres de date.
                </p>
                <!-- Heure début -->
                <div class="col-grand-reservation col-12 col-md-1 mb-1">
                    <select class="form-select" id="heure_debut">
                        <option selected>Heure début</option>
                    </select>
                </div>
                <!-- Heure fin -->
                <div class="col-grand-reservation col-12 col-md-1 mb-1">
                    <select class="form-select" id="heure_fin">
                        <option selected>Heure fin</option>
                    </select>
                </div>
                <p>
                    Ensuite, le bouton réserver sert à effectuer une nouvelle réservation. Une fois le bouton cliqué, vous serez automatiquement redirigé vers une nouvelle page contenant un formulaire à remplir pour réserver une nouvelle salle.
                </p>
                <!-- bouton "Réserver" -->
                <div class=" mb-3 ">
                    <div class="col-12 ">
                        <button class="btn-bleu rounded-2"">
                        <i class="fa fa-calendar"></i>
                        Réserver
                        </button>
                    </div>
                </div>
                <p>
                    Pour rendre l’utilisation des filtres plus simples, nous pouvons réinitialiser tous les filtres, c'est-à-dire les remettre à leur valeur de départ.
                </p>
                <div class="col-4">
                    <button class="btn-reset rounded-1 w-100" type="submit">Réinitialiser filtres</button>
                </div>
                <p>
                    Il y a aussi un moyen de naviguer entre différentes pages de réservation avec les flèches situées en bas à droite.
                </p>
                <div>
                    <button class="btn-pagination rounded rows-per-page"><<</button>
                    <button class="btn-pagination rounded rows-per-page"><</button>
                    <button class="btn-pagination rounded rows-per-page">1</button>
                    <button class="btn-pagination rounded rows-per-page">2</button>
                    <button class="btn-pagination rounded rows-per-page">></button>
                    <button class="btn-pagination rounded rows-per-page">>></button>

                </div>
                <p>
                    Mais aussi, il y a un moyen d’afficher plus de réservation sur la page courante en appuyant sur le nombre de lignes en bas à gauche. Ce nombre de lignes correspond au nombre de lignes affichées sur la page actuelle.
                </p>
                <button class="btn-pagination rounded rows-per-page" data-rows="10">5 lignes</button>
                <button class="btn-pagination rounded rows-per-page" data-rows="20">10 lignes</button>
                <button class="btn-pagination rounded rows-per-page" data-rows="30">15 lignes</button>
            </div>
        </div>
    </div>

    <!-- Footer de la page -->
    <?php include '../include/footer.php'; ?>
</div>
</body>
</html>
