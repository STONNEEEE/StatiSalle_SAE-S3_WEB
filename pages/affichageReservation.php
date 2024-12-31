<?php
    require("../fonction/connexion.php");
    //session_start();
    //verif_session();

?>
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
    <?php include '../include/header.php'; ?>

    <div class="full-screen">
        <!-- Titre de la page -->
        <div class="padding-header row">
            <div class="col-12">
                <h1 class="text-center">Liste des Réservations</h1>
            </div>
            <br><br><br>
        </div>

        <!-- 1ère ligne avec le bouton "Réserver" -->
        <div class="row mb-3 ">
            <div class="col-12 text-center text-md-end">
                <button class="btn-bleu rounded-2" onclick="window.location.href='reservation.php';">
                    <i class="fa fa-calendar"></i>
                    Réserver
                </button>
            </div>
        </div>

        <div class="row g-1 justify-content-start">
            <!-- Nom des employés -->
            <div class="col-12 col-md-2 mb-1 col-reduit-reservation">
                <select class="form-select">
                    <option selected>Employé</option>
                    <option>Legrand Jean-Pierre</option>
                    <option>Filtre 2</option>
                    <option>Filtre 3</option>
                </select>
            </div>
            <!-- Nom des salles -->
            <div class="col-12 col-md-2 mb-1 col-reduit-reservation">
                <select class="form-select">
                    <option selected>Salle</option>
                    <option>Filtre 1</option>
                    <option>Filtre 2</option>
                    <option>Filtre 3</option>
                </select>
            </div>
            <!-- Nom des activités -->
            <div class="col-12 col-md-1 mb-1 col-grand-reservation">
                <select class="form-select">
                    <option selected>Activités</option>
                    <option>Formation</option>
                    <option>Filtre 2</option>
                    <option>Filtre 3</option>
                </select>
            </div>

            <!-- Date début -->
            <div class=" col-grand-reservation col-12 col-md-1 mb-1">
                <select class="form-select">
                    <option selected>Date Début</option>
                    <option>Filtre 1</option>
                    <option>Filtre 2</option>
                    <option>Filtre 3</option>
                </select>
            </div>
            <!-- Date fin -->
            <div class="col-grand-reservation col-12 col-md-1 mb-1">
                <select class="form-select">
                    <option selected>Date Fin</option>
                    <option>Filtre 1</option>
                    <option>Filtre 2</option>
                    <option>Filtre 3</option>
                </select>
            </div>
            <!-- Heure début -->
            <div class="col-grand-reservation col-12 col-md-1 mb-1">
                <select class="form-select">
                    <option selected>Heure début</option>
                    <option>Filtre 1</option>
                    <option>Filtre 2</option>
                    <option>Filtre 3</option>
                </select>
            </div>
            <!-- Date début -->
            <div class="col-grand-reservation col-12 col-md-1 mb-1">
                <select class="form-select">
                    <option selected>Heure fin</option>
                    <option>Filtre 1</option>
                    <option>Filtre 2</option>
                    <option>Filtre 3</option>
                </select>
            </div>
            <!-- Bouton de réinitialisation des filtres -->
            <div class="col-6 col-sm-6 col-md-1 mb-1">
                <button class="btn-reset rounded-1 col-md-12">
                    Réinitialiser filtres
                </button>
            </div>
        </div>
        <!-- Tableau des données -->
        <div class="row mt-3">
            <div class="table-responsive">
                <table class="table table-striped text-center">
                    <tr>
                        <th>ID</th>
                        <th>Salle</th>
                        <th>Employe</th>
                        <th>Activite</th>
                        <th>Date</th>
                        <th>Heure debut</th>
                        <th>Heure fin</th>
                    </tr>
                    <?php
                        include '../fonction/fonctionAffichageReservation.php';
                        try {
                            $listeReservation = affichageReservation();
                        } catch (PDOException $e) {
                            echo '<tr><td colspan="5" class="text-center text-danger fw-bold">Impossible de charger la liste des employés en raison d’un problème technique...</td></tr>';
                        }

                        if (empty($listeReservation)) {
                            echo '<tr><td colspan="5" class="text-center fw-bold">Aucune reservation n’est enregistrée ici !</td></tr>';
                        } else {
                            foreach ($listeReservation as $ligne) {
                                echo '<tr>';
                                    echo '<td>' . $ligne['id_reservation'] . '</td>';
                                    echo '<td>' . $ligne['nom_salle'] . '</td>';
                                    echo '<td>' . $ligne['nom_employe'] . ' ' .  $ligne['prenom_employe'] . '</td>';
                                    echo '<td>' . $ligne['nom_activite'] . '</td>';
                                    echo '<td>' . $ligne['date'] . '</td>';
                                    echo '<td>' . $ligne['heure_debut'] . '</td>';
                                    echo '<td>' . $ligne['heure_fin'] . '</td>';
                                echo '</tr>';
                            }
                        }
                    ?>
                </table>
            </div>
        </div>
    </div>
    <?php include '../include/footer.php'; ?>
</div>
</body>
</html>
