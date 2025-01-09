<?php
    require("../fonction/connexion.php");
    require("../fonction/fonction_insert_Reservation.php");

    session_start();
    verif_session();

    $idLogin = $_SESSION['id'];

    $tabSalles = listeDesSalles();
    $tabActivites = listeDesActivites();

    // Vérification des variables du formulaire
    $nomSalle =         isset($_POST['nomSalle']) ? $_POST['nomSalle'] : '';
    $nomActivite =      isset($_POST['nomActivite']) ? $_POST['nomActivite'] : '';
    $date =             isset($_POST['date']) ? $_POST['date'] : '';
    $heureDebut =       isset($_POST['heureDebut']) ? $_POST['heureDebut'] : '';
    $heureFin =         isset($_POST['heureFin']) ? $_POST['heureFin'] : '';
    $objet =            isset($_POST['objet']) ? $_POST['objet'] : '';
    $nom =              isset($_POST['nom']) ? $_POST['nom'] : '';
    $prenom =           isset($_POST['prenom']) ? $_POST['prenom'] : '';
    $numTel =           isset($_POST['numTel']) ? $_POST['numTel'] : '';
    $precisActivite =   isset($_POST['precisActivite']) ? $_POST['precisActivite'] : '';

    // Tableau pour stocker les erreurs
    $erreurs = [];
    $messageSucces = $messageErreur = "";

    // Validation des champs
    if ($nomSalle == '') {
        $erreurs['nomSalle'] = "Le nom de la salle est obligatoire.";
    }
    if ($nomActivite == '') {
        $erreurs['nomActivite'] = "L'activité est obligatoire.";
    }
    if ($date == '') {
        $erreurs['date'] = "La date est obligatoire.";
    }
    if ($heureDebut == '') {
        $erreurs['heureDebut'] = "L'heure de début est obligatoire.";
    }
    if ($heureFin == '') {
        $erreurs['heureFin'] = "L'heure de fin est obligatoire.";
    }

    // Si aucun champ n'a d'erreur, on tente l'insertion
    if (empty($erreurs)) {
        try {
            // Appel à la fonction pour insérer la réservation
            insertionReservation($nomSalle, $nomActivite, $date, $heureDebut, $heureFin, $objet, $nom, $prenom, $numTel, $precisActivite, $idLogin);
            $messageSucces = "Réservation effectuée avec succès!";
        } catch (PDOException $e) {
            $messageErreur = "Une erreur est survenue lors de la réservation.";
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
</head>
<body>
<div class="container-fluid">
    <!-- Header de la page -->
    <?php include '../include/header.php'; ?>

    <div class="full-screen">
        <!-- Contenu de la page -->
        <div class="row text-center padding-header">
            <h1>Réservez votre salle</h1>
        </div>
        <br>

        <!-- Affichage des erreurs -->
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
        <form method="post" action="creationReservation.php">
            <div class="row"> <!-- Grande row -->
                <div class="form-group offset-md-2 col-md-4"> <!-- first colonne -->
                    <br>
                    <div class="row"> <!-- Salle -->
                        <div class="form-group col-md-12">
                            <label for="salle" class="<?= isset($erreurs['nomSalle']) ? 'erreur' : '' ;?>"><a title="Champ Obligatoire">Nom de la salle : *</a></label>
                            <select class="form-select" name="nomSalle" id="salle" required>
                                <option value="" disabled selected>Choisir la salle</option>
                                <?php
                                foreach ($tabSalles as $salle) { ?>
                                    <option value="<?= $salle ?>" <?= $salle == $nomSalle ? 'selected' : '' ?>><?= $salle ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row"> <!-- Activité -->
                        <div class="form-group col-md-12">
                            <label for="activite" class="<?= isset($erreurs['nomActivite']) ? 'erreur' : '' ;?>"><a title="Champ Obligatoire">Activité : *</a></label>
                            <select class="form-select" name="nomActivite" id="activite" required>
                                <option value="" disabled selected>Choisir l'activité</option>
                                <?php
                                foreach ($tabActivites as $activite) { ?>
                                    <option value="<?= $activite ?>" <?= $activite == $nomActivite ? 'selected' : '' ?>><?= $activite ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row"> <!-- Date, Heure Début, Heure Fin -->
                        <div class="form-group col-md-6">
                            <div class="row">
                                <div class="form-group col-12">
                                    <label for="date" class="<?= isset($erreurs['date']) ? 'erreur' : '' ;?>"><a title="Champ Obligatoire">Date : *</a></label>
                                    <input type="date" id="date" name="date" class="form-control" min="<?= date('Y-m-d'); ?>" required
                                           oninput="var day = new Date(this.value).getUTCDay(); if(day == 0){ this.value=''; alert('Réservation impossible le dimanche.'); }"
                                           value="<?php echo htmlentities($date, ENT_QUOTES); ?>">
                                </div>
                            </div>
                            <br>
                        </div>
                        <div class="form-group col-md-3">
                            <div class="row">
                                <div class="form-group col-12">
                                    <label for="heureDebut" class="petite-taille <?= isset($erreurs['heureDebut']) ? 'erreur' : '' ;?>">
                                        <a title="Champ Obligatoire">Heure début : *</a>
                                    </label>
                                    <select id="heureDebut" name="heureDebut" class="form-select" required>
                                        <!-- Option initiale vide -->
                                        <option value="" disabled selected>00:00</option>
                                        <?php
                                        $heureDebutPossible = 7;
                                        $heureFinPossible = 20;

                                        for ($heure = $heureDebutPossible; $heure < $heureFinPossible; $heure++) {
                                            for ($minute = 0; $minute < 60; $minute += 10) {
                                                $heureFormatee = str_pad($heure, 2, '0', STR_PAD_LEFT);
                                                $minuteFormatee = str_pad($minute, 2, '0', STR_PAD_LEFT);
                                                echo "<option value=\"$heureFormatee:$minuteFormatee\">$heureFormatee:$minuteFormatee</option>\n";
                                            }
                                        }
                                        echo "<option value=\"20:00\">20:00</option>\n";
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <br>
                        </div>
                        <div class="form-group col-md-3">
                            <div class="row">
                                <div class="form-group col-12">
                                    <label for="heureFin" class="petite-taille <?= isset($erreurs['heureFin']) ? 'erreur' : '' ;?>">
                                        <a title="Champ Obligatoire">Heure début : *</a>
                                    </label>
                                    <select id="heureFin" name="heureFin" class="form-select" required>
                                        <!-- Option initiale vide -->
                                        <option value="" disabled selected>00:00</option>
                                        <?php
                                        $heureDebutPossible = 7;
                                        $heureFinPossible = 20;

                                        for ($heure = $heureDebutPossible; $heure < $heureFinPossible; $heure++) {
                                            for ($minute = 0; $minute < 60; $minute += 10) {
                                                $heureFormatee = str_pad($heure, 2, '0', STR_PAD_LEFT);
                                                $minuteFormatee = str_pad($minute, 2, '0', STR_PAD_LEFT);
                                                echo "<option value=\"$heureFormatee:$minuteFormatee\">$heureFormatee:$minuteFormatee</option>\n";
                                            }
                                        }
                                        echo "<option value=\"20:00\">20:00</option>\n";
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-4"> <!-- Informations supplémentaires -->
                    <br>
                    <div class="row" id="ligneObjet"> <!-- Objet de l'activité sélectionné -->
                        <div class="form-group col-md-6" >
                            <label for="objet" id="titreObjet" class="">Objet :</label>
                            <input type="text" class="form-control" name="objet" id="objet">
                        </div>
                    </div>
                    <br>
                    <div class="row"> <!-- Nom formateur ou interlocuteur -->
                        <div class="col-md-6">
                            <div class="row" id="ligneNom">
                                <div class="form-group col-12">
                                    <label for="nom" id="titreNom" class="">Nom :</label>
                                    <input type="text" id="nom" name="nom" class="form-control" >
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6"> <!-- Prénom formateur ou interlocuteur -->
                            <div class="row" id="lignePrenom">
                                <div class="form-group col-12">
                                    <label for="prenom" id="titrePrenom" class="">Prénom :</label>
                                    <input type="text" class="form-control" name="prenom" id="prenom">
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row" > <!-- Numéro de téléphone formateur ou interlocuteur -->
                        <div class="form-group col-md-6">
                            <div class="row">
                                <div class="form-group col-12" id="ligneNum">
                                    <label for="numTel" class="">Numéro de téléphone :</label>
                                    <input type="tel" class="form-control" name="numTel" id="numTel">
                                </div>
                            </div>
                            <br>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="row"> <!-- Précision sur l'activité -->
                                <div class="form-group col-12" id="lignePrecision">
                                    <label for="precisActivite">Précision :</label>
                                    <input type="text" class="form-control"  placeholder="Précisez votre activité" name="precisActivite" id="precisActivite">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-3 text-center w-100">
                    <button type="submit" class="btn-bleu rounded-2" id="submit">
                        Réserver
                    </button>
                </div>
            </div>
        </form>
        <div class ="row offset-md-2">
            <div>
                <button class="btn-suppr rounded-2" type="button"
                        onclick="window.location.href='affichageReservation.php'">
                    Retour
                </button>
            </div>
        </div>
    </div>

    <!-- Footer de la page -->
    <?php include '../include/footer.php'; ?>
</div>
<script>
    // Récupération des de l'ID des champs pour y faire des modifications
    const activiteSelect =      document.getElementById('activite');
    const objetInput =          document.getElementById('ligneObjet');
    const nomInput =            document.getElementById('ligneNom');
    const prenomInput =         document.getElementById('lignePrenom');
    const numInput =            document.getElementById('ligneNum');
    const precisionInput =      document.getElementById('lignePrecision');

    const objetLabel =          document.getElementById('titreObjet');
    const nomLabel =            document.getElementById('titreNom');
    const prenomLabel =         document.getElementById('titrePrenom');

    // Initialisation de l'affichage
    objetInput.style.display =      'none';
    nomInput.style.display =        'none';
    prenomInput.style.display =     'none';
    numInput.style.display =        'none';
    precisionInput.style.display =  'none';

    // Apparition de certain champ à remplir selon l'activité sélectionné
    function afficherChampsSupplementaires() {
        const activite = activiteSelect.value;

        // Initialisation de l'affichage
        objetInput.style.display =      'none';
        nomInput.style.display =        'none';
        prenomInput.style.display =     'none';
        numInput.style.display =        'none';
        precisionInput.style.display =  'none';

        if (activite === 'Réunion') {
            objetInput.style.display = 'block';
            objetLabel.textContent = 'Objet de la réunion :';

        } else if (activite === 'Formation') {
            objetInput.style.display = 'block';
            nomInput.style.display = 'block';
            prenomInput.style.display = 'block';
            numInput.style.display = 'block';
            objetLabel.textContent = 'Sujet de la formation :';
            nomLabel.textContent = 'Nom du formateur :';
            prenomLabel.textContent = 'Prénom du formateur :';

        } else if (activite === 'Entretien de la salle') {
            objetInput.style.display = 'block';
            objetLabel.textContent = 'Nature de l\'entretien :';

        } else if (activite === 'Prêt' || activite === 'Location') {
            objetInput.style.display = 'block';
            nomInput.style.display = 'block';
            prenomInput.style.display = 'block';
            numInput.style.display = 'block';
            precisionInput.style.display = 'block';
            objetLabel.textContent = 'Nom de votre organisme :';
            nomLabel.textContent = 'Nom de l\'interlocuteur :';
            prenomLabel.textContent = 'Prénom de l\'interlocuteur :';

        } else if (activite === 'Autre') {
            objetInput.style.display = 'block';
            objetLabel.textContent = 'Description de votre activité :';
        }
    }

    activiteSelect.addEventListener('change', afficherChampsSupplementaires);

    // Vérification que l'heure de fin plus tard que l'heure de début
    const heureDebut = document.getElementById('heureDebut');
    const heureFin = document.getElementById('heureFin');

    function verifierHeures() {
        const debut = heureDebut.value;
        const fin = heureFin.value;

        if (debut && fin) {
            if (debut >= fin) {
                heureFin.setCustomValidity("L'heure de fin doit être strictement après l'heure de début.");
            } else {
                heureFin.setCustomValidity('');
            }
        }
    }

    heureDebut.addEventListener('change', verifierHeures);
    heureFin.addEventListener('change', verifierHeures);
</script>
</body>
</html>
