<?php
include '../fonction/employe.php';
session_start();

$message = '';

if (isset($_POST['id_employe']) && $_POST['supprimer'] == "true") {
    $id_employe = $_POST['id_employe'];

    // Appeler la fonction de suppression
    try {
        supprimerEmploye($id_employe);
        $_SESSION['message'] = 'Employé supprimé avec succès !';
    } catch (Exception $e) {
        if ($e->getCode() == '23000') { // Code SQLSTATE pour contrainte de clé étrangère
            $_SESSION['message'] = '<span class="fa-solid fa-arrow-right erreur"></span>
                                    <span class="erreur">Impossible de supprimer cet employé : 
                                    veuillez supprimer la réservation qui lui est attribuée.</span>
                                    <a href="affichageReservation.php" title="Page réservation">Cliquez ici</a>';
        } else {
            $_SESSION['message'] = 'Erreur lors de la suppression de l\'employé : ' . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>StatiSalle - Employés</title>
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

    <!-- Contenu de la page -->
    <div class="full-screen padding-header">
        <!-- Titre de la page -->
        <div class="row">
            <div class="col-12">
                <h1 class="text-center">Liste des Employés</h1>
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

        <!-- Bouton aligné à droite -->
        <div class="row mb-3">
            <div class="col-12 text-center text-md-end">
                <button class="btn-bleu rounded-2" type="button" onclick="window.location.href='creationEmploye.php';">
                    <span class="fa-plus"></span> Ajouter
                </button>
            </div>
        </div>

        <!-- Champs de filtres -->
        <div class="row g-1 justify-content-start">
            <!-- Nom employé -->
            <div class="col-12 col-md-2 mb-1">
                <input type="text" class="form-control" id="nom" name="nom" placeholder="Nom">
            </div>
            <!-- Prénom employé -->
            <div class="col-12 col-md-2 mb-1">
                <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Prénom">
            </div>
            <!-- ID compte employé -->
            <div class="col-12 col-md-2 mb-1">
                <input type="text" class="form-control" id="compte" name="compte" placeholder="Compte employé">
            </div>
            <!-- Numéro de téléphone employé -->
            <div class="col-12 col-md-2 mb-1">
                <input type="text" class="form-control" id="telephone" name="telephone" placeholder="Numéro de téléphone">
            </div>
            <!-- Bouton de soumission -->
            <div class="col-12 col-md-2 mb-1">
                <button class="btn-reset rounded-1 w-100" type="submit">Réinitialiser filtres</button>
            </div>
        </div>

        <!-- Tableau des données -->
        <div class="row mt-3">
            <div class="table-responsive">
                <table class="table table-striped text-center">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Identifiant compte</th>
                            <th>Numéro de téléphone</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        try {
                            $employes = renvoyerEmployes();
                        } catch (Exception $e) {
                            echo '<tr><td colspan="5" class="text-center text-danger fw-bold">Impossible de charger la liste des employés en raison d’un problème technique...</td></tr>';
                        }

                        // Vérifier si le tableau est vide
                        if (empty($employes)) {
                            echo '<tr><td colspan="5" class="text-center fw-bold">Aucun compte employé n’est enregistré ici !</td></tr>';
                        } else {
                            // Afficher les employés
                            foreach ($employes as $employe) {
                                echo '<tr>';
                                echo '<td>' . $employe->nom . '</td>';
                                echo '<td>' . $employe->prenom . '</td>';
                                echo '<td>';
                                // Ajouter une icône si l'utilisateur est un admin
                                if ($employe->type_utilisateur === 'admin') {
                                    echo '<span class="fa-solid fa-shield-alt text-primary me-1" title="Compte administrateur"></span>';
                                }
                                echo $employe->id_compte. '</td>';
                                echo '<td>' . $employe->telephone . '</td>';
                                echo '<td class="btn-colonne">';
                                echo '<div class="d-flex justify-content-center gap-1">';
                                echo '<form method="POST">';
                                echo '    <input type="hidden" name="id_employe" value="' . $employe->id_employe . '">';
                                echo '    <input type="hidden" name="supprimer" value="true">';
                                echo '    <button type="submit" class="btn-suppr rounded-2">';
                                echo '        <span class="fa-solid fa-trash"></span>';
                                echo '    </button>';
                                echo '</form>';

                                echo '<button class="btn-modifier rounded-2">';
                                echo '    <span class="fa-regular fa-pen-to-square"></span>';
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
</body>
<!-- JavaScript pour les filtres -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Récupération des champs de filtre
        const filters = {
            nom: document.getElementById("nom"),
            prenom: document.getElementById("prenom"),
            compte: document.getElementById("compte"),
            telephone: document.getElementById("telephone")
        };

        // Récupération des lignes du tableau
        const rows = document.querySelectorAll("table.table-striped tbody tr");

        // Fonction de filtrage
        function filterTable() {
            rows.forEach(row => {
                const columns = row.getElementsByTagName("td");
                const values = {
                    nom: columns[0]?.textContent.toLowerCase() || "",
                    prenom: columns[1]?.textContent.toLowerCase() || "",
                    compte: columns[2]?.textContent.toLowerCase() || "",
                    telephone: columns[3]?.textContent.toLowerCase() || ""
                };

                // Vérifie si toutes les conditions de filtre sont remplies
                const visible = Object.keys(filters).every(key => {
                    const filterValue = filters[key].value.trim().toLowerCase();
                    return filterValue === "" || values[key].includes(filterValue);
                });

                row.style.display = visible ? "" : "none";
            });
        }

        // Ajout d'écouteurs d'événements pour chaque filtre
        Object.values(filters).forEach(filter => {
            filter.addEventListener("input", filterTable);
        });

        // Bouton de réinitialisation
        const resetButton = document.querySelector('.btn-reset');
        if (resetButton) {
            resetButton.addEventListener('click', function () {
                // Réinitialisation des champs de filtre
                Object.values(filters).forEach(filter => {
                    filter.value = "";
                });
                filterTable(); // Met à jour l'affichage du tableau
            });
        }
    });
</script>
</html>
