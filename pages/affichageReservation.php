<?php
    require ('../fonction/connexion.php');
    require '../fonction/connexion.php';
    session_start();
    verif_session();

    $message = '';
    verif_session();
    include '../fonction/fonctionAffichageReservation.php';

    $tabEmployeNom    = listeEmployesNom();
    $tabEmployePrenom = listeEmployesPrenom();
    $tabSalle         = listeSalles();
    $tabActivite      = listeActivites();
    $tabDate          = listeDate();
    $heureDebut       = listeHeureDebut();
    $heureFin         = listeHeureFin();

    if (isset($_POST['id_reservation']) && $_POST['supprimer'] == "true") {
        $id_reservation = $_POST['id_reservation'];

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
        <title>StatiSalle - Réservation</title>
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
                        <h1 class="text-center">Liste des Réservations</h1>
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

                <div class="row g-1 justify-content-start">
                    <!-- Nom des employés -->
                    <div class="col-12 col-md-2 mb-1 col-reduit-reservation">
                        <input type="text" class="form-control" id="nom" name="nom" placeholder="Nom de l'employé">
                    </div>
                    <!-- Nom des salles -->
                    <div class="col-12 col-md-2 mb-1 col-reduit-reservation">
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
                    <div class="col-12 col-md-1 mb-1 col-grand-reservation">
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
                    <?php
                    try {
                        $listeReservation = affichageReservation();
                    } catch (PDOException $e) {
                        echo '<div class="text-center text-danger fw-bold">Impossible de charger les réservations en raison d’un problème technique.</div>';
                    }

                    $nombreReservations = count($listeReservation ?? []);
                    ?>

                    <div class="col-12 text-center mb-3">
                        <p class="fw-bold result-count">
                            Nombre de réservation trouvée(s) : <?= $nombreReservations ?>
                        </p>
                    </div>

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
                                    $listeReservation = affichageReservation();
                                } catch (PDOException $e) {
                                    echo '<tr><td colspan="5" class="text-center text-danger fw-bold">Impossible de charger la liste des employés en raison d’un problème technique...</td></tr>';
                                }

                                if (empty($listeReservation)) {
                                    echo '<tr><td colspan=8" class="text-center fw-bold">Aucune reservation n’est enregistrée ici !</td></tr>';
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
                                                  <form  method="post" action="modificationResa.php">';
                                                        //Vérifier que cette ligne prend bien l'id de la reservation
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
                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center my-3">
                        <div>
                            <button class="btn-pagination rounded rows-per-page" data-rows="10">5 lignes</button>
                            <button class="btn-pagination rounded rows-per-page" data-rows="20">10 lignes</button>
                            <button class="btn-pagination rounded rows-per-page" data-rows="30">15 lignes</button>
                        </div>
                        <div id="pagination" class="pagination-container"></div>
                    </div>
                </div>
            </div>
            <?php include '../include/footer.php'; ?>
        </div>
        <script defer>
            // ---------------- FILTRE ----------------
            document.addEventListener("DOMContentLoaded", function () {

                // Récupération des éléments <select> et <input> pour les filtres
                const filters = {
                    nom: document.getElementById("nom"), // Filtre sur le nom
                    salles: document.getElementById("salles"), // Filtre sur la salle
                    activites: document.getElementById("activites"), // Filtre sur les activités
                    date_debut: document.getElementById("date_debut"), // Filtre date début
                    date_fin: document.getElementById("date_fin"), // Filtre date fin
                    heure_debut: document.getElementById("heure_debut"), // Filtre heure début
                    heure_fin: document.getElementById("heure_fin"), // Filtre heure fin
                };

                // Récupération de toutes les lignes du tableau
                const rows = document.querySelectorAll("table.table-striped tbody tr");

                // Fonction pour vérifier si tous les filtres sont vides
                function areFiltersEmpty() {
                    return Object.values(filters).every(filter => {
                        // Si c'est un champ SELECT, vérifier si la première option est sélectionnée
                        if (filter.tagName === "SELECT") {
                            return filter.selectedIndex === 0;
                        }
                        // Si c'est un champ INPUT, vérifier si la valeur est vide
                        return filter.value.trim() === "";
                    });
                }

                // Fonction de filtrage
                function filterTable() {
                    let visibleRowCount = 0; // Compteur pour les lignes visibles
                    let noResultsFound = true; // Variable pour vérifier si des résultats sont trouvés

                    // Si tous les filtres sont vides, on ne fait rien et on affiche toutes les lignes
                    if (areFiltersEmpty()) {
                        rows.forEach(row => {
                            row.style.display = ""; // Affiche toutes les lignes
                        });

                        // Met à jour le compteur avec le nombre total de lignes
                        const resultCountElement = document.querySelector(".result-count");
                        if (resultCountElement) {
                            resultCountElement.textContent = `Nombre de réservation trouvée(s) : ${rows.length/2}`;
                        }

                        // Retirer la ligne "Aucune réservation trouvée" si elle existe
                        removeNoResultsRow();
                        return; // On arrête la fonction ici, aucun filtrage n'est appliqué
                    }

                    rows.forEach(row => {
                        const columns = row.querySelectorAll("td.tab-trier");

                        // Extraction des valeurs nécessaires des colonnes correspondantes
                        const values = {
                            salles: columns[1]?.innerText.trim().toLowerCase(), // Utiliser innerText pour récupérer tout le texte visible
                            nom: columns[2]?.innerText.trim().toLowerCase(), // Utiliser innerText pour récupérer tout le texte visible
                            activites: columns[3]?.childNodes[0]?.textContent.trim().toLowerCase(), // Colonne "Activité"
                            date: columns[4]?.textContent.trim(), // Colonne "Date"
                            heure_debut: columns[5]?.textContent.trim(), // Colonne "Heure début"
                            heure_fin: columns[6]?.textContent.trim(), // Colonne "Heure fin"
                        };

                        // Vérification des filtres
                        const isDateInRange = (() => {
                            const filterStart = filters.date_debut.value.trim(); // Valeur du filtre date début
                            const filterEnd = filters.date_fin.value.trim(); // Valeur du filtre date fin

                            if (!filterStart && !filterEnd) return true; // Pas de filtre

                            const rowDate = new Date(values.date); // Date de la ligne
                            const startDate = filterStart ? new Date(filterStart) : null;
                            const endDate = filterEnd ? new Date(filterEnd) : null;

                            return (!startDate || rowDate >= startDate) && (!endDate || rowDate <= endDate);
                        })();

                        // Convertit une chaîne d'heure (HH:mm:ss) en minutes totales
                        function timeToMinutes(time) {
                            const [hours, minutes, seconds] = time.split(":").map(Number);
                            return hours * 60 + minutes + (seconds || 0) / 60;
                        }

                        const isTimeInRange = (() => {
                            const filterStartTime = filters.heure_debut.value.trim();
                            const filterEndTime = filters.heure_fin.value.trim();

                            // Si aucun filtre n'est défini, tout est accepté
                            if (!filterStartTime && !filterEndTime) return true;

                            const rowStartTime = values.heure_debut;
                            const rowEndTime = values.heure_fin;

                            // Si une des heures de la ligne est manquante, la ligne est exclue
                            if (!rowStartTime || !rowEndTime) return false;

                            // Convertir les heures en minutes totales pour la comparaison
                            const filterStartMinutes = filterStartTime ? timeToMinutes(filterStartTime) : null;
                            const filterEndMinutes = filterEndTime ? timeToMinutes(filterEndTime) : null;
                            const rowStartMinutes = timeToMinutes(rowStartTime);
                            const rowEndMinutes = timeToMinutes(rowEndTime);

                            // Vérification stricte : la réservation doit commencer et se terminer dans la plage
                            const isStartInRange = filterStartMinutes === null || rowStartMinutes >= filterStartMinutes;
                            const isEndInRange = filterEndMinutes === null || rowEndMinutes <= filterEndMinutes;

                            return isStartInRange && isEndInRange;
                        })();

                        const matchesFilters = Object.keys(filters).every(key => {
                            if (key === "date_debut" || key === "date_fin" || key === "heure_debut" || key === "heure_fin") {
                                return true;
                            }

                            const filterValue = filters[key]?.value.trim().toLowerCase();

                            // Si la valeur du filtre est vide ou égale à la valeur par défaut (première option), on passe
                            if (!filterValue || (filters[key]?.tagName === "SELECT" && filterValue === filters[key]?.options[0]?.value.trim())) {
                                return true;
                            }

                            if (key === "salles") {
                                return values.salles === filterValue; // Vérifie l'égalité exacte, sans modification
                            }

                            // Vérification pour les autres champs (on garde la logique de recherche partielle)
                            return values[key]?.includes(filterValue) ?? false;
                        });

                        // Afficher ou masquer la ligne en fonction des conditions
                        const isVisible = matchesFilters && isDateInRange && isTimeInRange;
                        row.style.display = isVisible ? "" : "none";

                        if (isVisible) {
                            visibleRowCount++; // Incrémente si la ligne est visible
                            noResultsFound = false; // Il y a des résultats visibles
                        }
                    });

                    // Met à jour le nombre de résultats trouvés
                    const resultCountElement = document.querySelector(".result-count");
                    if (resultCountElement) {
                        resultCountElement.textContent = `Nombre de réservation trouvée(s) : ${visibleRowCount}`;
                    }

                    // Si aucune ligne n'est visible, afficher une ligne "Aucune réservation trouvée"
                    if (noResultsFound) {
                        addNoResultsRow();
                    } else {
                        removeNoResultsRow();
                    }
                }

                // Fonction pour ajouter la ligne "Aucune réservation trouvée"
                function addNoResultsRow() {
                    const tbody = document.querySelector("table.table-striped tbody");
                    if (!document.querySelector(".no-results-row")) {
                        const row = document.createElement("tr");
                        row.classList.add("no-results-row");
                        row.innerHTML = `<td colspan="8" class="text-center text-danger fw-bold">Aucune réservation trouvée</td>`;
                        tbody.appendChild(row);
                    }
                }

                // Fonction pour retirer la ligne "Aucune réservation trouvée"
                function removeNoResultsRow() {
                    const noResultsRow = document.querySelector(".no-results-row");
                    if (noResultsRow) {
                        noResultsRow.remove();
                    }
                }

                // Ajout des écouteurs d'événements pour chaque filtre
                Object.values(filters).forEach(filter => {
                    const eventType = filter.tagName === "SELECT" ? "change" : "input";
                    filter.addEventListener(eventType, filterTable);
                });

                // Bouton de réinitialisation des filtres
                const resetButton = document.querySelector('.btn-reset');
                if (resetButton) {
                    resetButton.addEventListener('click', function () {
                        Object.values(filters).forEach(filter => {
                            // Réinitialise chaque filtre à sa valeur par défaut
                            if (filter.tagName === "SELECT") {
                                filter.selectedIndex = 0; // Remet le premier élément sélectionné
                            } else {
                                filter.value = ""; // Vide les champs texte
                            }
                        });
                        filterTable(); // Applique les filtres réinitialisés
                    });
                }
            });
        </script>
    </body>
</html>