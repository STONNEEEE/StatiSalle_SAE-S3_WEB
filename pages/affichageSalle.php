<?php
require '../fonction/fonctionAffichageSalle.php';

// On démarre la session
session_start();

$message = '';

$supprimer = isset($_POST['supprimer']) ? $_POST['supprimer'] : 'false';
$id_salle = $_POST['idSalle'] ?? null;

if ($supprimer == "true" && $id_salle) {
    try {
        // Vérifier si la salle a des réservations
        $reservations = verifierReservations($id_salle);

        if (count($reservations) > 0) {
            // Si des réservations existent, afficher un message d'erreur
            $_SESSION['message'] = '<span class="fa-solid fa-arrow-right erreur"></span>
                                        <span class="erreur">Impossible de supprimer cette salle. 
                                        Des réservations y sont associées.</span>
                                        <a href="affichageReservation.php" title="Page réservation">Cliquez ici</a>';
        } else {
            // Si pas de réservations, supprimer la salle
            supprimerSalle($id_salle);
            $_SESSION['message'] = 'Salle supprimée avec succès !';
        }
    } catch (Exception $e) {
        $_SESSION['message'] = '<span class="fa-solid fa-arrow-right erreur"></span>
                                    <span class="erreur">Une erreur est survenue : ' . htmlspecialchars($e->getMessage()) . '</span>';
    }
}

// Chargement des filtres
$tabNoms = listeDesNoms();
$tabCapacite = listeDesCapacites();
$tabOrdinateur = listeDesOrdinateurs();
$tabLogiciels = listeDesLogiciels();

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>StatiSalle - Salles</title>
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
                <h1 class="text-center">Liste des Salles</h1>
            </div>
            <br><br><br>
        </div>

        <!-- Message de confirmation ou d'erreur -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-info text-center" role="alert">
                <?php
                echo $_SESSION['message'];
                unset($_SESSION['message']); // Effacer le message après l'affichage
                ?>
            </div>
        <?php endif; ?>

        <!-- 1ère ligne avec le bouton "Ajouter" -->
        <div class="row mb-3">
            <div class="col-12 text-center text-md-end">
                <button class="btn-bleu rounded-2" onclick="window.location.href='creationSalle.php';">
                    <span class="fa-plus">
                     Ajouter
                    </span>
                </button>
            </div>
        </div>

        <div class="row g-1 justify-content-start"> <!-- Grande row des filtres avec espacement réduit -->
            <!-- Nom des salles -->
            <div class="col-12 col-md-2 mb-1 col-reduit-salle ">
                <select class="form-select select-nom" id="nom">
                    <option value=""  selected>Nom</option>
                    <?php
                    foreach ($tabNoms as $nom) { // On boucle sur les noms contenus dans le tableau
                        echo "<option value=".$nom.">".$nom."</option>";
                    }
                    ?>
                </select>
            </div>
            <!-- Capacité -->
            <div class="col-12 col-md-1 mb-1">
                <select class="form-select select-nom" id="capacite">
                    <option value="" selected>Capacité</option>
                    <?php
                    foreach ($tabCapacite as $capacite) { // On boucle sur la capacité contenus dans le tableau
                        echo "<option value=".$capacite.">".$capacite."</option>";
                    }
                    ?>
                </select>
            </div>
            <!-- Vidéo projecteur -->
            <div class="col-12 col-md-1 mb-1 col-grand-salle ">
                <select class="form-select select-nom" id="videoproj">
                    <option value="" selected>Vidéo projecteur</option>
                    <option value ="oui">Oui</option>
                    <option value ="non">Non</option>
                </select>
            </div>
            <!-- Grand écran -->
            <div class="col-12 col-md-1 mb-1 col-grand-salle ">
                <select class="form-select select-nom" id="grandEcran">
                    <option value="" selected>Écran XXL</option>
                    <option value ="oui">Oui</option>
                    <option value ="non">Non</option>
                </select>
            </div>
            <!-- Nombre ordinateur -->
            <div class="col-12 col-md-1 mb-1 col-grand-salle ">
                <select class="form-select select-nom" id="nbrOrdi">
                    <option value="" selected>Ordinateur</option>
                    <?php
                    foreach ($tabOrdinateur as $nbrOrdi) { // On boucle sur le nombre d'ordinateur contenus dans le tableau
                        echo "<option value=".$nbrOrdi.">".$nbrOrdi."</option>";
                    }
                    ?>
                </select>
            </div>
            <!-- Logiciel -->
            <div class="col-12 col-md-3 mb-1">
                <select class="form-select select-nom" id="logiciel">
                    <option value="" selected>Logiciel</option>
                    <?php
                    foreach ($tabLogiciels as $logiciel) { // On boucle sur les logiciels contenus dans le tableau
                        echo "<option value=".$logiciel.">".$logiciel."</option>";
                    }
                    ?>
                </select>
            </div>
            <!-- Imprimante -->
            <div class="col-12 col-md-1 mb-1 col-grand-salle ">
                <select class="form-select select-nom" id="imprimante">
                    <option value="" selected>Imprimante</option>
                    <option value ="oui">Oui</option>
                    <option value ="non">Non</option>
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
                        <th>Nom</th>
                        <th>Capacité</th>
                        <th>Vidéo Projecteur</th>
                        <th>Écran XXL</th>
                        <th>Nombre Ordinateurs</th>
                        <th>Type</th>
                        <th>Logiciels</th>
                        <th>Imprimante</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    // Chargement des données
                    try {
                        $listeSalles = listeDesSalles();
                    } catch (Exception $e) {
                        echo '<tr><td colspan="5" class="text-center text-danger fw-bold">Impossible de charger la liste des salles en raison d’un problème technique...</td></tr>';
                    }
                    // Vérifier si le tableau est vide
                    if (empty($listeSalles)) {
                        echo '<tr><td colspan="5" class="text-center fw-bold">Aucune salle n’est enregistré ici !</td></tr>';
                    } else {
                        // Affichage des salles
                        foreach ($listeSalles as $salle) {
                            echo "<tr>";
                            echo "<td>".$salle['id_salle']."</td>";
                            echo "<td>".$salle['nom']."</td>";
                            echo "<td>".$salle['capacite']."</td>";
                            // Videoproj : Condition pour afficher Oui/Non
                            echo "<td>".($salle['videoproj'] == 1 ? "Oui" : "Non")."</td>";
                            // Ecran XXL : Condition pour afficher Oui/Non
                            echo "<td>".($salle['ecran_xxl'] == 1 ? "Oui" : "Non")."</td>";
                            echo "<td>".$salle['ordinateur']."</td>";
                            echo "<td>".$salle['type']."</td>";
                            echo "<td>".$salle['logiciels']."</td>";
                            // Imprimante : Condition pour afficher Oui/Non
                            echo "<td>".($salle['imprimante'] == 1 ? "Oui" : "Non")."</td>";

                            // Mise en forme (boutons alignés verticalement
                            echo '<td class="btn-colonne">';
                            echo '<div class="d-flex justify-content-center gap-1">';
                            ?>
                            <!-- Paramètre envoyé pour supprimer la salle -->
                            <form method="post" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette salle ?')">
                                <input name="idSalle" type="hidden" value="<?php echo $salle['id_salle']; ?>">
                                <input name="supprimer" type="hidden" value="true">
                                <button type="submit" class="btn-suppr rounded-2"><span class="fa-solid fa-trash"></span></button>
                            </form>

                            <!-- Paramètre envoyé pour modifier la salle -->
                            <form  method="post" action="modificationSalle.php">
                                <input name="idSalle" type="hidden" value="<?php echo $salle['id_salle']; ?>">
                                <button type="submit" class="btn-modifier rounded-2"><span class="fa-regular fa-pen-to-square"></span></button>
                            </form>
                            <?php
                            echo '</div>';
                            echo "</td>";
                            echo "</tr>";
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
<!-- JavaScript pour les filtres -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Récupération des éléments <select>
        const filters = {
            nom: document.getElementById("nom"),
            capacite: document.getElementById("capacite"),
            videoproj: document.getElementById("videoproj"),
            grandEcran: document.getElementById("grandEcran"),
            ordinateur: document.getElementById("nbrOrdi"),
            logiciel: document.getElementById("logiciel"),
            imprimante: document.getElementById("imprimante"),
        };

        // Récupération de toutes les lignes du tableau
        const rows = document.querySelectorAll("table.table-striped tbody tr");

        // Fonction de filtrage
        function filterTable() {
            rows.forEach(row => {
                const columns = row.getElementsByTagName("td");

                const values = {
                    nom: columns[1].textContent.toLowerCase(),
                    capacite: columns[2].textContent.trim(),
                    videoproj: columns[3].textContent.trim().toLowerCase(),
                    grandEcran: columns[4].textContent.trim().toLowerCase(),
                    ordinateur: columns[5].textContent.trim(),
                    logiciel: columns[7].textContent.trim().toLowerCase(),
                    imprimante: columns[8].textContent.trim().toLowerCase(),
                };

                const visible = Object.keys(filters).every(key => {
                    const filterValue = filters[key].value.trim().toLowerCase();

                    // Comparaison stricte pour les nombres
                    if (key === "capacite" || key === "ordinateur") {
                        return filterValue === "" || parseInt(values[key]) === parseInt(filterValue);
                    }

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
