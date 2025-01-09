<?php
    require("../fonction/connexion.php");
    require("../fonction/fonctionSalle.php");

    session_start();
    verif_session();

    require("../fonction/fonction_insert_update_Salle.php");

    $idSalle = $_POST['idSalle'] ?? null;
    $mettreAJour = isset($_POST['mettreAJour']) ?? $_POST['mettreAJour'];;
    $tabAttribut = recupAttributSalle($idSalle);

    // Tableau de correspondance entre les noms des champs de formulaire et les colonnes de la base de données
    $mapChamps = [
        'nomSalle' => 'nom',
        'capacite' => 'capacite',
        'videoProjecteur' => 'videoproj',
        'ordinateurXXL' => 'ecran_xxl',
        'nbrOrdi' => 'ordinateur',
        'typeMateriel' => 'type',
        'logiciel' => 'logiciels',
        'imprimante' => 'imprimante'
    ];

    // Initialisation des variables
    foreach ($mapChamps as $champFormulaire => $champBD) {
        $$champFormulaire = isset($_POST[$champFormulaire]) ? $_POST[$champFormulaire] : (isset($tabAttribut[$champBD]) ? $tabAttribut[$champBD] : '');
    }

    // Tableau pour stocker les erreurs
    $erreurs = [];
    $messageSucces = "";
    $messageErreur = "";

    // Vérification des champs obligatoires
    if (!isset($nomSalle) || $nomSalle === '') {
        $erreurs['nomSalle'] = "Le nom de la salle est obligatoire.";
    }
    if (!isset($capacite) || $capacite === '') {
        $erreurs['capacite'] = "La capacité est obligatoire.";
    }
    if (!isset($videoProjecteur)) {
        $erreurs['videoProjecteur'] = "Le choix pour le vidéo projecteur est obligatoire.";
    }
    if (!isset($ordinateurXXL)) {
        $erreurs['ordinateurXXL'] = "Le choix pour l'ordinateur XXL est obligatoire.";
    }

    // Vérification que l'id est bien unique dans la base de données
    if ($mettreAJour == 1 && verifNomSalle($nomSalle, $idSalle)) {
        $messageErreur = "Erreur : Ce nom de salle existe déjà. Veuillez en choisir un autre.";
        $nomSalle = '';
    }

    if (empty($erreurs) && $messageErreur == "" && $mettreAJour == 1) {
        try {
            mettreAJourSalle(intval($idSalle), $nomSalle, intval($capacite), $videoProjecteur, $ordinateurXXL, intval($nbrOrdi), $typeMateriel, $logiciel, $imprimante);
            $messageSucces = "Salle mise à jour avec succès !";
        } catch (PDOException $e) {
            $messageErreur = "Une erreur est survenue lors de l'accès à la base de données. Veuillez réessayer plus tard ou contacter l'administrateur si le problème persiste.";
        }
    }
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>StatiSalle - Modification Salle</title>
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

            <div class="full-screen">
                <!-- Contenu de la page -->
                <div class="row text-center padding-header">
                    <h1>Modification d'une salle</h1>
                </div>
                <br>
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
                <br>
                <form method="post" action="modificationSalle.php">
                    <div class="row"> <!-- Grande row -->
                        <div class="form-group offset-md-2 col-md-4"> <!-- first colonne -->
                            <br>
                            <div class="row"> <!-- Nom de la salle -->
                                <div class="form-group col-12">
                                    <!-- Passage de l'id de la salle en paramètre caché -->
                                    <input name="idSalle" type="hidden" value="<?php echo $idSalle; ?>">
                                    <input name="mettreAJour" type="hidden" value="1">
                                    <label for="nomSalle"><a title="Champ Obligatoire">Nom de la salle : *</a></label>
                                    <input type="text" class="form-control" name="nomSalle" id="nomSalle" value="<?php echo htmlentities($nomSalle, ENT_QUOTES); ?>" placeholder="Exemple : Salle Picasso" required>
                                </div>
                            </div>
                            <br>
                            <div class="row"> <!-- Capacité -->
                                <div class="form-group col-12">
                                    <label for="capacite"><a title="Champ Obligatoire">Capacité de la salle : *</a></label>
                                    <input type="number" class="form-control" name="capacite" id="capacite" value="<?php echo htmlentities($capacite, ENT_QUOTES); ?>" min="0" required>
                                </div>
                            </div>
                            <br>
                            <br>
                            <div class="row"> <!-- Vidéo projecteur -->
                                <div class="form-group col-12">
                                    <label for="videoProjecteur"><a title="Champ Obligatoire">Vidéo projecteur : *</a></label>
                                    <input type="radio" class="form-check-input" id="OUI" name="videoProjecteur" value="1" <?= $videoProjecteur == '1' ? 'checked' : '' ?> required>
                                    <label class="form-check-label" for="OUI">Oui</label>
                                    <input type="radio" class="form-check-input" id="NON" name="videoProjecteur" value="0" <?= $videoProjecteur == '0' ? 'checked' : '' ?> required>
                                    <label class="form-check-label" for="NON">Non</label>
                                </div>
                            </div>
                            <br>
                            <br>
                            <div class="row"> <!-- Ordinateur XXL -->
                                <div class="form-group col-md-12">
                                    <label for="ordinateurXXL" ><a title="Champ Obligatoire">Ordinateur XXL : *</a></label>
                                    <input type="radio" class="form-check-input" id="OUI" name="ordinateurXXL" value="1" <?= $ordinateurXXL == '1' ? 'checked' : '' ?> required>
                                    <label class="form-check-label" for="OUI">Oui</label>
                                    <input type="radio" class="form-check-input" id="NON" name="ordinateurXXL" value="0" <?= $ordinateurXXL == '0' ? 'checked' : '' ?> required >
                                    <label class="form-check-label" for="NON">Non</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-4"> <!-- Informations supplémentaires -->
                            <br>
                            <div class="row"> <!-- Nombre d'ordinateurs -->
                                <div class="form-group col-12">
                                    <label for="nbrOrdi">Nombre d'ordinateur : </label>
                                    <input type="number" class="form-control" name="nbrOrdi" id="nbrOrdi" min="0" value="<?php echo htmlentities($nbrOrdi, ENT_QUOTES); ?>" >
                                </div>
                            </div>
                            <br>
                            <div class="row"> <!-- Type matériel -->
                                <div class="form-group col-12">
                                    <label for="typeMateriel">Type de matériel :</label>
                                    <input type="text" class="form-control" name="typeMateriel" id="typeMateriel" value="<?php echo htmlentities($typeMateriel, ENT_QUOTES); ?>">
                                </div>
                            </div>
                            <br>
                            <div class="row"> <!-- Logiciels installés  -->
                                <div class="form-group col-md-12">
                                    <label for="logiciel">Logiciels installés :</label>
                                    <input type="text" class="form-control" name="logiciel" id="logiciel" placeholder="Exemple à suivre : bureautique, java, intellij, photoshop" value="<?php echo htmlentities($logiciel, ENT_QUOTES); ?>">
                                </div>
                            </div>
                            <br>
                            <div class="row"> <!-- Imprimante -->
                                <div class="form-group col-md-12">
                                    <label for="imprimante">Imprimante : </label>
                                    <input type="radio" class="form-check-input" id="OUI" name="imprimante" value="1" <?= $imprimante == '1' ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="OUI">Oui</label>
                                    <input type="radio" class="form-check-input" id="NON" name="imprimante" value="0" <?= $imprimante == '0' || $imprimante == NULL ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="NON">Non</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-3 text-center w-100 ">
                            <button type="submit" class="btn-bleu rounded" id="submit">
                                Mise à jour de la salle
                            </button>
                            <br><br>
                        </div>
                    </div>
                </form>
                <div class ="row offset-md-2">
                    <div>
                        <button class="btn-suppr rounded-2" type="button"
                                onclick="window.location.href='affichageSalle.php'">
                            Retour
                        </button>
                    </div>
                </div>
            </div>

            <!-- Footer de la page -->
            <?php include '../include/footer.php'; ?>
        </div>
    </body>
</html>
