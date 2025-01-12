<?php
    $startTime = microtime(true); // temps de chargement de la page
    require '../fonction/employe.php';
    require '../fonction/connexion.php';

    session_start();
    verif_session();

    $messageSucces = $messageErreur ='';

    if (isset($_POST['id_employe']) && $_POST['supprimer'] == "true") {
        $id_employe = $_POST['id_employe'];

        // Appeler la fonction de suppression
        try {
            supprimerEmploye($id_employe);
            $messageSucces = 'Employé supprimé avec succès !';
        } catch (Exception $e) {
            if ($e->getCode() == '23000') { // Code SQLSTATE pour contrainte de clé étrangère
                $messageErreur = '<span class="fa-solid fa-arrow-right erreur"></span>
                                        <span class="erreur">Impossible de supprimer cet employé : 
                                        veuillez supprimer la réservation qui lui est attribuée.</span>
                                        <a href="affichageReservation.php" title="Page réservation">Cliquez ici</a>';
            } else {
                $messageErreur = 'Erreur lors de la suppression de l\'employé : ' . $e->getMessage();
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
        <!-- Icon du site -->
        <link rel="icon" href=" ../img/logo.ico">
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

                <!-- Affichage du message d'erreur -->
                <?php if ($messageErreur): ?>
                    <div class="row">
                        <div class="col-md-6 offset-md-3">
                            <div class="alert alert-danger">
                                <?= $messageErreur ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Affichage du message de succès -->
                <?php if ($messageSucces): ?>
                    <div class="row">
                        <div class="col-md-6 offset-md-3">
                            <div class="alert alert-success">
                                <?= $messageSucces ?>
                            </div>
                        </div>
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

                    <!-- Compteur -->
                    <?php
                    try {
                        $listeEmploye = renvoyerEmployes(); // récupération des employés dans la base de données
                    } catch (PDOException $e) {
                        echo '<div class="text-center text-danger fw-bold">Impossible de charger les employés en raison d’un problème technique...</div>';
                    }

                    $nombreEmploye = count($listeEmploye ?? []); // Nombre d'employés
                    ?>
                    <div class="col-12 text-center mb-3">
                        <p class="fw-bold compteur-employe">
                            Nombre de comptes employé trouvé(s) : <?= $nombreEmploye ?>
                        </p>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped text-center">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Identifiant compte</th>
                                    <th>Numéro de téléphone</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    // Afficher les employés
                                    foreach ($listeEmploye as $employe) {
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
                                        if ($employe->type_utilisateur != 'admin') {
                                            echo '<form method="POST" onsubmit="return confirm(\'Êtes-vous sûr de vouloir supprimer cet employé ?\');">';
                                            echo '    <input type="hidden" name="id_employe" value="' . $employe->id_employe . '">';
                                            echo '    <input type="hidden" name="supprimer" value="true">';
                                            echo '    <button type="submit" class="btn-suppr rounded-2">';
                                            echo '        <span class="fa-solid fa-trash"></span>';
                                            echo '    </button>';
                                            echo '</form>';
                                            echo '<form method="POST" action="modificationEmploye.php">
                                                      <input name="id_employe" type="hidden" value="' . $employe->id_employe . '">
                                                      <button type="submit" class="btn-modifier rounded-2">
                                                          <span class="fa-regular fa-pen-to-square"></span>
                                                      </button>
                                                  </form>';
                                        }
                                        echo '</div>';
                                        echo '</td>';
                                        echo '</tr>';
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Footer de la page -->
            <?php include '../include/footer.php'; ?>
        </div>
        <!-- JavaScript pour les filtres -->
        <script defer src="../fonction/filtreEmploye.js"></script>
    </body>
</html>
