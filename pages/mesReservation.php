<?php
    require '../fonction/connexion.php';
    require '../fonction/reservation.php';

    session_start();
    verif_session();

    $message = '';
    $tabEmployeNom = listeEmployesNom();
    $tabEmployePrenom = listeEmployesPrenom();
    $tabSalle = listeSalles();
    $tabActivite = listeActivites();
    $tabDate = listeDate();
    $heureDebut = listeHeureDebut();
    $heureFin = listeHeureFin();

    if (isset($_POST['id_reservation']) && $_POST['supprimer'] == "true") {
        $id_reservation = $_POST['id_reservation'];

        // Appeler la fonction de suppression
        try {
            supprimerResa($id_reservation);
            $_SESSION['message'] = 'Reservation supprimée avec succès !';
        } catch (Exception $e) {
            $_SESSION['message'] = "La réservation n'a pas pu être effectuée, 
                                        un problème est survenu.";
        }
    }
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>StatiSalle - Mes réservation</title>
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
            <?php include '../include/header.php'; ?>

            <div class="full-screen">
                <!-- Titre de la page -->
                <div class="padding-header row">
                    <div class="col-12">
                        <h1 class="text-center">Mes Réservations</h1>
                    </div>
                    <br><br><br>
                </div>

                <?php if (isset($_SESSION['message'])): ?>
                    <div class="alert alert-info text-center" role="alert">
                        <?php
                        echo $_SESSION['message'];
                        unset($_SESSION['message']); // Effacer le message après l'affichage
                        ?>
                    </div>
                <?php endif; ?>

                <!-- 1ère ligne avec le bouton "Réserver" -->
                <div class="row mb-3 ">
                    <div class="col-12 text-center text-md-end">
                        <button class="btn-bleu rounded-2" onclick="window.location.href='creationReservation.php';">
                            <i class="fa fa-calendar"></i>
                            Réserver
                        </button>
                    </div>
                </div>

                <!-- Ligne des filtres -->
                <div class="row g-1 justify-content-start">
                    <!-- Nom des employés -->
                    <div class="col-12 col-md-2 mb-1 col-reduit-reservation">
                        <input type="text" class="form-control" id="nom" name="nom" placeholder="Nom de l'employé">
                    </div>
                    <!-- Nom des salles -->
                    <div class="col-12 col-md-2 mb-1 col-grand-reservation">
                        <select class="form-select select-nom" id="salles">
                            <option value=""  selected>Salle</option>
                            <?php
                            foreach ($tabSalle as $salle) {
                                echo '<option value="' . $salle . '">' . $salle . "</option>";
                            } // On boucle sur les noms des salles contenues dans le tableau
                            ?>
                        </select>
                    </div>
                    <!-- Nom des activités -->
                    <div class="col-12 col-md-1 mb-1 col-reduit-reservation">
                        <select class="form-select select-nom" id="activites">
                            <option value=""  selected>Activités</option>
                            <?php
                            foreach ($tabActivite as $activite){ // On boucle sur les différentes activités contenues dans le tableau
                                echo '<option value="' . $activite . '">' . $activite . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <!-- Date début -->
                    <div class=" col-grand-reservation col-12 col-md-1 mb-1">
                        <select class="form-select select-nom" id="date_debut">
                            <option value=""  selected>Date Début</option>
                            <?php
                            foreach ($tabDate as $date){ // On boucle sur les différentes dates contenues dans le tableau
                                echo '<option value="' . $date . '">' . $date . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <!-- Date fin -->
                    <div class="col-grand-reservation col-12 col-md-1 mb-1">
                        <select class="form-select select-nom" id="date_fin">
                            <option value=""  selected>Date Fin</option>
                            <?php
                            foreach ($tabDate as $date){ // On boucle sur les différentes dates contenues dans le tableau
                                echo '<option value="' . $date . '">' . $date . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <!-- Heure début -->
                    <div class="col-grand-reservation col-12 col-md-1 mb-1">
                        <select class="form-select select-nom" id="heure_debut">
                            <option value=""  selected>Heure début</option>
                            <?php
                            foreach ($heureDebut as $heure){ // On boucle sur les différentes dates contenues dans le tableau
                                echo '<option value="' . $heure . '">' . $heure . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <!-- Heure fin -->
                    <div class="col-grand-reservation col-12 col-md-1 mb-1">
                        <select class="form-select select-nom" id="heure_fin">
                            <option value=""  selected>Heure fin</option>
                            <?php
                            foreach ($heureFin as $heure){ // On boucle sur les différentes dates contenues dans le tableau
                                echo '<option value="' . $heure . '">' . $heure . "</option>";
                            }
                            ?>
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
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Salle</th>
                                    <th>Employe</th>
                                    <th>Activite</th>
                                    <th>Date</th>
                                    <th>Heure debut</th>
                                    <th>Heure fin</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                try {
                                    $listeReservation = affichageMesReservations($_SESSION['id_employe']);
                                } catch (PDOException $e) {
                                }

                                if (empty($listeReservation)) {
                                    echo '<tr><td colspan="8" class="text-center fw-bold">Aucune reservation n’est enregistrée ici !</td></tr>';
                                } else {
                                    foreach ($listeReservation as $ligne) {
                                        echo '<tr>';
                                        echo '<td class="tab-trier">' . $ligne['id_reservation'] . '</td>';
                                        echo '<td class="tab-trier">' . $ligne['nom_salle'] . '</td>';
                                        echo '<td class="tab-trier">' . $ligne['nom_employe'] . ' ' .  $ligne['prenom_employe'] . '</td>';
                                        echo '<td class="tab-trier">';
                                        echo $ligne['nom_activite'];
                                        echo '<span class="fa-solid fa-circle-info info-icon">';
                                        echo '<span class="tooltip">';
                                        echo '<table class="table table-striped">';
                                        try {
                                            $listeType = affichageTypeReservation($ligne['id_reservation']);
                                        } catch (PDOException $e) {
                                            echo '<tr><td colspan="5" class="text-center text-danger fw-bold">Impossible de charger les informations sur le type de reservation</td></tr>';
                                        }

                                        if (!empty($listeType)) {
                                            // Filtrer les valeurs non vides
                                            $listeSansVide = array_filter($listeType, function($valeur) {
                                                return !empty($valeur);
                                            });

                                            if (!empty($listeSansVide)) {
                                                echo "<tr>";
                                                foreach ($listeSansVide as $key => $valeur) {
                                                    echo "<td>" . $valeur . "</td>";
                                                }
                                                echo "</tr>";
                                            } else {
                                                echo "<tr><td colspan='3'>Aucune donnée trouvée pour cette réservation</td></tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='3'>Aucune donnée trouvée pour cette réservation</td></tr>";
                                        }
                                        echo ' </table>';
                                        echo '</span>';
                                        echo '</span>';
                                        echo '</td>';
                                        echo '<td class="tab-trier">' . $ligne['date'] . '</td>';
                                        echo '<td class="tab-trier">' . $ligne['heure_debut'] . '</td>';
                                        echo '<td class="tab-trier">' . $ligne['heure_fin'] . '</td>';

                                        echo '<td class="btn-colonne">';
                                        echo '<div class="d-flex justify-content-center gap-1">';
                                        echo '<form method="POST" onsubmit="return confirm(\'Êtes-vous sûr de vouloir supprimer cette réservation ?\')">';
                                        echo '    <input type="hidden" name="id_reservation" value="' . htmlspecialchars($ligne['id_reservation']) . '">';
                                        echo '    <input type="hidden" name="supprimer" value="true">';
                                        echo '    <button type="submit" class="btn-suppr rounded-2">';
                                        echo '        <span class="fa-solid fa-trash"></span>';
                                        echo '    </button>';
                                        echo '</form>';

                                        echo '<!-- Paramètre envoyé pour modifier la salle -->
                                                      <form  method="post" action="modificationReservation.php">';
                                        // Vérifier que cette ligne prend bien l'id de la reservation
                                        echo'       <input name="idReservation" type="hidden" value="' . htmlentities($ligne['id_reservation'], ENT_QUOTES) . '">
                                                            <button type="submit" class="btn-modifier rounded-2"><span class="fa-regular fa-pen-to-square"></span></button>
                                                      </form>
                                                      ';
                                        echo '</button>';
                                        echo '</div>';
                                        echo '</td>';
                                        echo '</tr>';
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php include '../include/footer.php'; ?>
        </div>
        <script defer src="../fonction/filtreReservation.js"></script>
    </body>
</html>
