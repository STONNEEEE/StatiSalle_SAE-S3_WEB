<?php
    require '../fonction/fonctionAffichageSalle.php';

    $listeSalles = listeDesSalles();
    /*$tabNoms = listeDesNoms();*/
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
                        <option selected>Nom</option>
                        <?php
                        foreach ($tabNoms as $nom) { // On boucle sur les noms contenus dans le tableau
                            echo '<option value="'.$nom.'">'.$nom.'</option>';
                        }
                        ?>
                    </select>
                </div>
                <!-- Capacité -->
                <div class="col-12 col-md-1 mb-1">
                    <select class="form-select select-nom">
                        <option selected>Capacité</option>
                        <option>Filtre 1</option>
                        <option>Filtre 2</option>
                        <option>Filtre 3</option>
                    </select>
                </div>
                <!-- Vidéo projecteur -->
                <div class="col-12 col-md-1 mb-1 col-grand-salle ">
                    <select class="form-select select-nom">
                        <option selected>Vidéo proj</option>
                        <option>Filtre 1</option>
                        <option>Filtre 2</option>
                        <option>Filtre 3</option>
                    </select>
                </div>
                <!-- Grand écran -->
                <div class="col-12 col-md-1 mb-1 col-grand-salle ">
                    <select class="form-select select-time">
                        <option selected>Grand écran</option>
                        <option>Filtre 1</option>
                        <option>Filtre 2</option>
                        <option>Filtre 3</option>
                    </select>
                </div>
                <!-- Nombre ordinateur -->
                <div class="col-12 col-md-1 mb-1 col-grand-salle ">
                    <select class="form-select select-time">
                        <option selected>Nbr ordi</option>
                        <option>Filtre 1</option>
                        <option>Filtre 2</option>
                        <option>Filtre 3</option>
                    </select>
                </div>
                <!-- Logiciel -->
                <div class="col-12 col-md-3 mb-1">
                    <select class="form-select select-time">
                        <option selected>Logiciel</option>
                        <option>"bureautique,java,intellij,photoshop"</option>
                        <option>Filtre 2</option>
                        <option>Filtre 3</option>
                    </select>
                </div>
                <!-- Imprimante -->
                <div class="col-12 col-md-1 mb-1 col-grand-salle ">
                    <select class="form-select select-time">
                        <option selected>Imprimante</option>
                        <option>Indéfini</option>
                        <option>Oui</option>
                        <option>Non</option>
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
                        <?php
                        foreach ($listeSalles as $salle) {
                            echo "<tr>";
                            echo "<td>".$salle['id_salle']."</td>";
                            echo "<td>".$salle['nom']."</td>";
                            echo "<td>".$salle['capacite']."</td>";
                            echo "<td>".$salle['videoproj']."</td>";
                            echo "<td>".$salle['ecran_xxl']."</td>";
                            echo "<td>".$salle['ordinateur']."</td>";
                            echo "<td>".$salle['type']."</td>";
                            echo "<td>".$salle['logiciels']."</td>";
                            echo "<td>".$salle['imprimante']."</td>";
                            echo "<td>".'<button class="btn-suppr rounded-2"><span class="fa-solid fa-trash"></span></button>'
                                .'<button class="btn-modifier rounded-2"><span class="fa-regular fa-pen-to-square"></span></button>'."</td>";
                            /*<td class="btn-colonne">
                                <button class="btn-suppr rounded-2"><span class="fa-solid fa-trash"></span></button>
                                <button class="btn-modifier rounded-2"><span class="fa-regular fa-pen-to-square"></span></button>
                            </td>*/
                            echo "</tr>";
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
