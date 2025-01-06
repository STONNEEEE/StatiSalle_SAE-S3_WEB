<?php
    require ('../fonction/connexion.php');
    session_start();

    $message = '';
    verif_session();
    include '../fonction/fonctionAffichageReservation.php';

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
                        <select class="form-select" id="employes">
                            <option selected>Employé</option>
                            <?php
                            for ($i = 0; $i < count($tabEmployeNom); $i++) {
                                $nom = $tabEmployeNom[$i];      // Nom de l'employé à l'indice $i
                                $prenom = $tabEmployePrenom[$i]; // Prénom de l'employé à l'indice $i

                                echo "<option value='" . $nom . " " . $prenom . "'>" . $nom . " " . $prenom . "</option>";
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
        <script>
            // ---------------- PAGINATION ----------------
            document.addEventListener("DOMContentLoaded", function () {
                const rows = Array.from(document.querySelectorAll("table.table-striped tbody tr"));
                const paginationContainer = document.querySelector("#pagination");
                const rowsPerPageOptions = document.querySelectorAll(".rows-per-page");
                let rowsPerPage = 10; // Par défaut, 10 lignes par page
                let currentPage = 1;

                function generatePageLinks(totalPages, currentPage) {
                    const pages = [];

                    // Ajouter la première page
                    pages.push(1);

                    // Ajouter une ellipse si la page actuelle est éloignée du début
                    if (currentPage > 3) {
                        pages.push('...');
                    }

                    // Ajouter les pages proches de la page actuelle
                    for (let i = Math.max(2, currentPage - 2); i <= Math.min(totalPages - 1, currentPage + 2); i++) {
                        pages.push(i);
                    }

                    // Ajouter une ellipse si la page actuelle est éloignée de la fin
                    if (currentPage < totalPages - 2) {
                        pages.push('...');
                    }

                    // Ajouter la dernière page si elle n'est pas déjà dans la liste
                    if (totalPages > 1) {
                        pages.push(totalPages);
                    }

                    return pages;
                }

                function renderTable() {
                    const totalRows = rows.length;
                    const totalPages = Math.ceil(totalRows / rowsPerPage);

                    // Calculer les limites de lignes visibles
                    const startRow = (currentPage - 1) * rowsPerPage;
                    const endRow = startRow + rowsPerPage;

                    // Afficher ou masquer les lignes selon la pagination
                    rows.forEach((row, index) => {
                        row.style.display = index >= startRow && index < endRow ? "" : "none";
                    });

                    // Générer les boutons de pagination
                    paginationContainer.innerHTML = "";

                    // Générer les liens de pages à afficher
                    const pageLinks = generatePageLinks(totalPages, currentPage);

                    // Bouton "Aller au début"
                    const firstButton = document.createElement("button");
                    firstButton.textContent = "<<";
                    firstButton.className = currentPage === 1
                        ? "btn-pagination-disabled rounded"
                        : "btn-pagination rounded";
                    if (currentPage !== 1) {
                        firstButton.addEventListener("click", () => {
                            currentPage = 1;
                            renderTable();
                        });
                    }
                    paginationContainer.appendChild(firstButton);

                    // Bouton "Page précédente"
                    const prevButton = document.createElement("button");
                    prevButton.textContent = "<";
                    prevButton.className = currentPage === 1
                        ? "btn-pagination-disabled rounded"
                        : "btn-pagination rounded";
                    if (currentPage !== 1) {
                        prevButton.addEventListener("click", () => {
                            currentPage -= 1;
                            renderTable();
                        });
                    }
                    paginationContainer.appendChild(prevButton);

                    // Boutons pour chaque page
                    pageLinks.forEach(link => {
                        const button = document.createElement("button");
                        button.textContent = link;
                        if (link === "...") {
                            button.className = "btn-pagination btn-points disabled rounded"; // Style pour les ellipses
                        } else {
                            button.className = `btn-pagination rounded ${link === currentPage ? "active" : ""}`;
                            button.addEventListener("click", () => {
                                currentPage = link;
                                renderTable();
                            });
                        }
                        paginationContainer.appendChild(button);
                    });

                    // Bouton "Page suivante"
                    const nextButton = document.createElement("button");
                    nextButton.textContent = ">";
                    nextButton.className = currentPage === totalPages
                        ? "btn-pagination-disabled rounded"
                        : "btn-pagination rounded";
                    if (currentPage !== totalPages) {
                        nextButton.addEventListener("click", () => {
                            currentPage += 1;
                            renderTable();
                        });
                    }
                    paginationContainer.appendChild(nextButton);

                    // Bouton "Aller à la fin"
                    const lastButton = document.createElement("button");
                    lastButton.textContent = ">>";
                    lastButton.className = currentPage === totalPages
                        ? "btn-pagination-disabled rounded"
                        : "btn-pagination rounded";
                    if (currentPage !== totalPages) {
                        lastButton.addEventListener("click", () => {
                            currentPage = totalPages;
                            renderTable();
                        });
                    }
                    paginationContainer.appendChild(lastButton);
                }

                // Mise à jour des lignes par page
                rowsPerPageOptions.forEach(option => {
                    option.addEventListener("click", function () {
                        rowsPerPage = parseInt(this.dataset.rows, 10);
                        currentPage = 1; // Revenir à la première page
                        renderTable();
                    });
                });

                renderTable(); // Initialiser le tableau
            });

            // ---------------- FILTRE ----------------
            // TODO
        </script>
    </body>
</html>
