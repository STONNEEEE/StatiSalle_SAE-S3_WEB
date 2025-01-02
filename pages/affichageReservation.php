<?php
    require("../fonction/connexion.php");
    //session_start();
    //verif_session();
    include '../fonction/fonctionAffichageReservation.php';

    $tabEmployeNom = listeEmployesNom();
    $tabEmployePrenom = listeEmployesPrenom();
    $tabSalle = listeSalles();
    $tabActivite = listeActivites();
    $tabDate = listeDate();
    $heureDebut = listeHeureDebut();
    $heureFin = listeHeureFin();
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
                <select class="form-select" id="employes">
                    <option selected>Employé</option>
                    <?php
                    foreach ($tabEmployeNom as $nom) {
                        foreach ($tabEmployePrenom as $prenom){ // On boucle sur les noms et prénoms des employés contenus dans le tableau
                            echo "<option value=" . $nom . " " . $prenom . ">". $nom . " " . $prenom . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <!-- Nom des salles -->
            <div class="col-12 col-md-2 mb-1 col-reduit-reservation">
                <select class="form-select" id="salles">
                    <option selected>Salle</option>
                    <?php
                        foreach ($tabSalle as $salle){
                            echo "<option value=" . $salle . ">" . $salle . "</option>";
                        }// On boucle sur les noms des salles contenues dans le tableau
                    ?>
                </select>
            </div>
            <!-- Nom des activités -->
            <div class="col-12 col-md-1 mb-1 col-grand-reservation">
                <select class="form-select" id="activites">
                    <option selected>Activités</option>
                    <?php
                    foreach ($tabActivite as $activite){ // On boucle sur les différentes activités contenues dans le tableau
                        echo "<option value=" . $activite . ">" . $activite . "</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- Date début -->
            <div class=" col-grand-reservation col-12 col-md-1 mb-1">
                <select class="form-select" id="date_debut">
                    <option selected>Date Début</option>
                    <?php
                    foreach ($tabDate as $date){ // On boucle sur les différentes dates contenues dans le tableau
                        echo "<option value=" . $date . ">" . $date . "</option>";
                    }
                    ?>
                </select>
            </div>
            <!-- Date fin -->
            <div class="col-grand-reservation col-12 col-md-1 mb-1">
                <select class="form-select" id="date_fin">
                    <option selected>Date Fin</option>
                    <?php
                    foreach ($tabDate as $date){ // On boucle sur les différentes dates contenues dans le tableau
                        echo "<option value=" . $date . ">" . $date . "</option>";
                    }
                    ?>
                </select>
            </div>
            <!-- Heure début -->
            <div class="col-grand-reservation col-12 col-md-1 mb-1">
                <select class="form-select" id="heure_debut">
                    <option selected>Heure début</option>
                    <?php
                    foreach ($heureDebut as $heure){ // On boucle sur les différentes dates contenues dans le tableau
                        echo "<option value=" . $heure . ">" . $heure . "</option>";
                    }
                    ?>
                </select>
            </div>
            <!-- Heure fin -->
            <div class="col-grand-reservation col-12 col-md-1 mb-1">
                <select class="form-select" id="heure_fin">
                    <option selected>Heure fin</option>
                    <?php
                    foreach ($heureFin as $heure){ // On boucle sur les différentes dates contenues dans le tableau
                        echo "<option value=" . $heure . ">" . $heure . "</option>";
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
                    <?php
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
                                    echo '<td>';
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
                                    echo '<td>' . $ligne['date'] . '</td>';
                                    echo '<td>' . $ligne['heure_debut'] . '</td>';
                                    echo '<td>' . $ligne['heure_fin'] . '</td>';

                                    echo '<td class="btn-colonne">';
                                    echo '<div class="d-flex justify-content-center gap-1">';
                                    echo '<form method="POST">';
                                    echo '    <input type="hidden" name="supprimer" value="true">';
                                    echo '    <button type="submit" class="btn-suppr rounded-2">';
                                    echo '        <span class="fa-solid fa-trash"></span>';
                                    echo '    </button>';
                                    echo '</form>';
                                    echo '<form method="POST" action="#">
                                              <button type="submit" class="btn-modifier rounded-2">
                                                  <span class="fa-regular fa-pen-to-square"></span>
                                              </button>
                                          </form>
                                          '; //TODO à completer pour la suppression et la modification
                                    echo '</button>';
                                    echo '</div>';
                                    echo '</td>';
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
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Récupération des éléments <select>
        const filters = {
            employes: document.getElementById("employes"),
            salles: document.getElementById("salles"),
            activites: document.getElementById("activites"),
            date_debut: document.getElementById("date_debut"),
            date_fin: document.getElementById("date_fin"),
            heure_debut: document.getElementById("heure_debut"),
            heure_fin: document.getElementById("heure_fin"),
        };

        // Récupération de toutes les lignes du tableau
        const rows = document.querySelectorAll("table.table-striped tbody tr");

        // Fonction de filtrage
        function filterTable() {
            rows.forEach(row => {
                const columns = row.getElementsByTagName("td");

                const values = {
                    employes: columns[1].textContent.toLowerCase(),
                    salles: columns[2].textContent.trim(),
                    activites: columns[3].textContent.trim().toLowerCase(),
                    date_debut: columns[4].textContent.trim().toLowerCase(),
                    date_fin: columns[5].textContent.trim(),
                    heure_debut: columns[7].textContent.trim().toLowerCase(),
                    heure_fin: columns[8].textContent.trim().toLowerCase(),
                };

                const visible = Object.keys(filters).every(key => {
                    const filterValue = filters[key].value.trim().toLowerCase();

                    // Comparaison pour les autres champs
                    return filterValue === "" || values[key].includes(filterValue);
                });

                row.style.display = visible ? "" : "none";
            });
        }

        // Ajout des écouteurs d'événements
        Object.values(filters).forEach(filter => {
            filter.addEventListener("change", filterTable);
        });

        // Fonction pour réinitialiser les filtres
        const resetButton = document.querySelector('.btn-reset');
        if (resetButton) {
            resetButton.addEventListener('click', function () {
                // Réinitialisation des filtres
                Object.values(filters).forEach(filter => {
                    filter.value = ""; // Réinitialise les filtres à leur valeur par défaut
                });
                filterTable(); // Applique les filtres réinitialisés
            });
        }
    });
</script>
</body>
</html>
