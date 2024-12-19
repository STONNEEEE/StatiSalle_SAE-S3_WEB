<?php
include '../fonction/employer.php';

$message = '';

if (isset($_POST['id_employe']) && $_POST['supprimer'] == "true") {
    $id_employe = $_POST['id_employe'];

    // Appeler la fonction de suppression
    try {
        supprimerEmploye($id_employe);
        $_SESSION['message'] = 'Employé supprimé avec succès !';
    } catch (Exception $e) {
        $_SESSION['message'] = 'Erreur lors de la suppression de l\'employé : ' . $e->getMessage();
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
                echo htmlspecialchars($_SESSION['message']);
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

        <div class="row g-1 justify-content-start">
            <!-- Nom employe -->
            <div class="col-12 col-md-2 mb-1">
                <select class="form-select">
                    <option selected>Nom</option>
                    <option>Filtre 1</option>
                    <option>Filtre 2</option>
                    <option>Filtre 3</option>
                </select>
            </div>
            <!-- Prénom employe -->
            <div class="col-12 col-md-2 mb-1">
                <select class="form-select">
                    <option selected>Prenom</option>
                    <option>Filtre 1</option>
                    <option>Filtre 2</option>
                    <option>Filtre 3</option>
                </select>
            </div>
            <!-- Numéro de téléphone employe -->
            <div class="col-12 col-md-2 mb-1">
                <select class="form-select">
                    <option selected>Numéro de téléphone</option>
                    <option>Filtre 1</option>
                    <option>Filtre 2</option>
                    <option>Filtre 3</option>
                </select>
            </div>
            <!-- Bouton de réinitialisation des filtres -->
            <div class="col-12 col-md-2 mb-1">
                <button class="btn-reset rounded-1 w-100">
                    Réinitialiser filtres
                </button>
            </div>
        </div>

        <!-- Tableau des données -->
        <div class="row mt-3">
            <div class="table-responsive">
                <table class="table table-striped text-center">

                    <tr>
                        <th>Nom</th>
                        <th>Prenom</th>
                        <th>Identifiant compte</th>
                        <th>Numéro de téléphone</th>
                        <th>Actions</th>
                    </tr>
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
                            echo $employe->id_compte . '</td>';
                            echo '<td>' . $employe->telephone . '</td>';
                            echo '<td class="btn-colonne">';
                            echo '<div class="d-flex justify-content-center gap-1">';
                            echo '    <form method="POST">';
                            echo '    <input type="hidden" name="id_employe" value="' . $employe->id_compte . '">';
                            echo '        <input type="hidden" name="supprimer" value="true">';
                            echo '        <button type="submit" class="btn-suppr rounded-2">';
                            echo '             <span class="fa-solid fa-trash"></span>';
                            echo '        </button>';
                            echo '    </form>';

                            echo '    <button class="btn-modifier rounded-2">';
                            echo '        <span class="fa-regular fa-pen-to-square"></span>';
                            echo '    </button>';
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
</body>
</html>
