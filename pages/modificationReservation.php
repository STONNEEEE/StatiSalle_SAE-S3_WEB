<?php
    require '../fonction/connexion.php';
    require '../fonction/reservation.php';

    session_start();
    verif_session();

    // Vérification des variables issues du formulaire
    $idResa =         isset($_POST['idReservation']) ? $_POST['idReservation'] : null;
    $nomSalle =       isset($_POST['nomSalle']) ? $_POST['nomSalle'] : '';
    $nomActivite =    isset($_POST['nomActivite']) ? $_POST['nomActivite'] : '';
    $date =           isset($_POST['date']) ? $_POST['date'] : '';
    $heureDebut =     isset($_POST['heureDebut']) ? $_POST['heureDebut'] : '';
    $heureFin =       isset($_POST['heureFin']) ? $_POST['heureFin'] : '';
    $valeurChamp1 =   isset($_POST['objet']) ? $_POST['objet'] : '';
    $valeurChamp2 =   isset($_POST['nom']) ? $_POST['nom'] : '';
    $valeurChamp3 =   isset($_POST['prenom']) ? $_POST['prenom'] : '';
    $valeurChamp4 =   isset($_POST['numTel']) ? $_POST['numTel'] : '';
    $precisActivite = isset($_POST['precisActivite']) ? $_POST['precisActivite'] : '';
    $nomActivitePrecedent = '';
    $mettreAJour =    isset($_POST['mettreAJour']) ?? $_POST['mettreAJour'];

    $idLogin = $_SESSION['id'];

    // Contenu pour les listes déroulantes
    $tabSalles = listeDesSalles();
    $tabActivites = listeDesActivites();

    $detailsResa = recupAttributReservation($idResa);
    if ($detailsResa && $mettreAJour != 1) {
        // Préremplir les champs avec les données existantes
        $nomSalle = $detailsResa['nomSalle'];
        $nomActivite = $detailsResa['nomActivite'];
        $nomActivitePrecedent = $detailsResa['nomActivite'];
        $date = $detailsResa['date_reservation'];
        $heureDebut = date("H:i", strtotime($detailsResa['heure_debut']));
        $heureFin = date("H:i", strtotime($detailsResa['heure_fin']));
        if (isset($detailsResa['details'])) {
            $details = $detailsResa['details'];

            switch ($nomActivite) {
                case "Réunion":
                    $valeurChamp1 = $details['objet'] ?? "";
                    break;
                case "Formation":
                    $valeurChamp1 = $details['sujet'] ?? "";
                    $valeurChamp2 = $details['nom_formateur'] ?? "";
                    $valeurChamp3 = $details['prenom_formateur']?? "";
                    $valeurChamp4 = $details['num_tel_formateur'] ?? "";
                    break;
                case "Entretien de la salle":
                    $valeurChamp1 = $details['nature'] ?? "";
                    break;
                case "Prêt" || "Location":
                    $valeurChamp1 = $details['nom_organisme'] ?? "";
                    $valeurChamp2 = $details['nom_interlocuteur'] ?? "";
                    $valeurChamp3 = $details['prenom_interlocuteur'] ?? "";
                    $valeurChamp4 = $details['num_tel_interlocuteur'] ?? "";
                    $precisActivite = $details['type_activite'] ?? '';
                    break;
                case "Autre":
                    $valeurChamp1 = $details['description'] ?? "";
                    break;
            }
        }
    } else {
        $messageErreur = "Impossible de charger les détails de la réservation.";
    }

    // Variables des erreurs
    $messageSucces = "";
    $messageErreur = "";
    $erreurs = [];

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

    // Vérification que l'heure de fin est après l'heure de début
    if (strtotime($heureDebut) >= strtotime($heureFin)) {
        $erreurs['heureFin'] = "L'heure de fin doit être après l'heure de début.";
    }

    // Si aucun champ n'a d'erreur, on tente l'insertion
    if (empty($erreurs) && $messageErreur == "" && $mettreAJour == 1) {
        try {
            modifReservation($idResa, $nomSalle, $nomActivite, $date, $heureDebut, $heureFin, $valeurChamp1, $valeurChamp2, $valeurChamp3, $valeurChamp4, $precisActivite, $idLogin, $nomActivitePrecedent);
            $messageSucces = "Modification effectuée avec succès!";
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
            <h1>Modifiez votre réservation</h1>
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
        <form method="post" action="modificationReservation.php">
            <div class="row"> <!-- Grande row -->
                <div class="form-group offset-md-2 col-md-4"> <!-- first colonne -->
                    <br>
                    <div class="row"> <!-- Salle -->
                        <div class="form-group col-md-12">
                            <input name="mettreAJour" type="hidden" value="1">
                            <label for="salle" class="<?= isset($erreurs['nomSalle']) ? 'erreur' : '' ;?>"><a title="Champ Obligatoire">Nom de la salle : *</a></label>
                            <select class="form-select" name="nomSalle" id="salle" required>
                                <option value="<?php echo htmlentities($nomSalle, ENT_QUOTES); ?>" disabled selected>Choisir la salle</option>
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
                                    <label for="heureDebut" class="petite-taille <?= isset($erreurs['heureDebut']) ? 'erreur' : '' ;?>"><a title="Champ Obligatoire">Heure début : *</a></label>
                                    <select id="heureDebut" name="heureDebut" class="form-select" required>
                                        <?php
                                        $heureDebutPossible = 7;
                                        $heureFinPossible = 20;

                                        for ($heure = $heureDebutPossible; $heure < $heureFinPossible; $heure++) {
                                            for ($minute = 0; $minute < 60; $minute += 10) {
                                                $heureFormatee = str_pad($heure, 2, '0', STR_PAD_LEFT);
                                                $minuteFormatee = str_pad($minute, 2, '0', STR_PAD_LEFT);
                                                $heureComplete = "$heureFormatee:$minuteFormatee";
                                                // Comparaison et ajout de l'attribut 'selected' si l'heure correspond
                                                $selected = ($heureComplete === $heureDebut) ? 'selected' : '';
                                                echo "<option value=\"$heureComplete\" $selected>$heureComplete</option>\n";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <br>
                        </div>
                        <div class="form-group col-md-3">
                            <div class="row">
                                <div class="form-group col-12">
                                    <label for="heureFin" class="petite-taille <?= isset($erreurs['heureFin']) ? 'erreur' : '' ;?>"><a title="Champ Obligatoire">Heure de fin : *</a></label>
                                    <select id="heureFin" name="heureFin" class="form-select" required>
                                        <?php
                                        for ($heure = $heureDebutPossible; $heure < $heureFinPossible; $heure++) {
                                            for ($minute = 0; $minute < 60; $minute += 10) {
                                                $heureFormatee = str_pad($heure, 2, '0', STR_PAD_LEFT);
                                                $minuteFormatee = str_pad($minute, 2, '0', STR_PAD_LEFT);
                                                $heureComplete = "$heureFormatee:$minuteFormatee";
                                                // Comparaison et ajout de l'attribut 'selected' si l'heure correspond
                                                $selected = ($heureComplete === $heureFin) ? 'selected' : '';
                                                echo "<option value=\"$heureComplete\" $selected>$heureComplete</option>\n";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- premier champ -->
                <div class="form-group col-md-4"> <!-- Informations supplémentaires -->
                    <br>
                    <div class="row" id="champ1"> <!-- Objet de l'activité sélectionné -->
                        <div class="form-group col-md-6" >
                            <input name="idReservation" type="hidden" value="<?php echo $idResa; ?>">
                            <label for="objet" id="titreObjet" class="">Objet :</label>
                            <input type="text" class="form-control" name="objet" id="objet" value="<?php echo htmlentities($valeurChamp1, ENT_QUOTES) ?>">
                        </div>
                    </div>
                    <br>
                    <div class="row"> <!-- Nom formateur ou interlocuteur -->
                        <div class="col-md-6">
                            <div class="row" id="champ2">
                                <div class="form-group col-12">
                                    <label for="nom" id="titreNom" class="">Nom :</label>
                                    <input type="text" id="nom" name="nom" class="form-control" value="<?php echo htmlentities($valeurChamp2, ENT_QUOTES) ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6"> <!-- Prénom formateur ou interlocuteur -->
                            <div class="row" id="champ3">
                                <div class="form-group col-12">
                                    <label for="prenom" id="titrePrenom" class="">Prénom :</label>
                                    <input type="text" class="form-control" name="prenom" id="prenom" value="<?php echo htmlentities($valeurChamp3, ENT_QUOTES) ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row" > <!-- Numéro de téléphone formateur ou interlocuteur -->
                        <div class="form-group col-md-6">
                            <div class="row">
                                <div class="form-group col-12" id="champ4">
                                    <label for="numTel" class="">Numéro de téléphone :</label>
                                    <input type="tel" class="form-control" name="numTel" id="numTel" value="<?php echo htmlentities($valeurChamp4, ENT_QUOTES) ?>">
                                </div>
                            </div>
                            <br>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="row"> <!-- Précision sur l'activité -->
                                <div class="form-group col-12" id="champ5">
                                    <label for="precisActivite">Précision :</label>
                                    <input type="text" class="form-control"  placeholder="Précisez votre activité" name="precisActivite" id="precisActivite" value="<?php echo htmlentities($precisActivite, ENT_QUOTES) ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-3 text-center w-100">
                    <button type="submit" class="btn-bleu rounded-2" id="submit" name="submit">
                        Mise à jour de la réservation
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
    // Récupération des éléments
    const activiteSelect = document.getElementById('activite');

    // Champs à afficher ou masquer selon l'activité
    const champ1Input = document.getElementById('champ1');
    const champ2Input = document.getElementById('champ2');
    const champ3Input = document.getElementById('champ3');
    const champ4Input = document.getElementById('champ4');
    const champ5Input = document.getElementById('champ5');

    const champ1Label = document.getElementById('titreObjet');
    const champ2Label = document.getElementById('titreNom');
    const champ3Label = document.getElementById('titrePrenom');

    // Fonction pour masquer tous les champs
    function masquerTousLesChamps() {
        champ1Input.style.display = 'none';
        champ2Input.style.display = 'none';
        champ3Input.style.display = 'none';
        champ4Input.style.display = 'none';
        champ5Input.style.display = 'none';

    }

    // Fonction pour afficher les champs nécessaires selon l'activité sélectionnée
    function afficherChampsSupplementaires() {
        // Masquer tous les champs avant d'en afficher certains
        masquerTousLesChamps();

        // Récupérer l'activité sélectionnée
        const activite = activiteSelect.value;

        // Afficher les champs correspondant à l'activité choisie
        if (activite === 'Réunion') {
            champ1Input.style.display = 'block';
            champ1Label.textContent = 'Objet de la réunion :';

        } else if (activite === 'Formation') {
            champ1Input.style.display = 'block';
            champ2Input.style.display = 'block';
            champ3Input.style.display = 'block';
            champ4Input.style.display = 'block';
            champ1Label.textContent = 'Sujet de la formation :';
            champ2Label.textContent = 'Nom du formateur :';
            champ3Label.textContent = 'Prénom du formateur :';

        } else if (activite === 'Entretien de la salle') {
            champ1Input.style.display = 'block';
            champ1Label.textContent = 'Nature de l\'entretien :';

        } else if (activite === 'Prêt' || activite === 'Location') {
            champ1Input.style.display = 'block';
            champ2Input.style.display = 'block';
            champ3Input.style.display = 'block';
            champ4Input.style.display = 'block';
            champ5Input.style.display = 'block';
            champ1Label.textContent = 'Nom de votre organisme :';
            champ2Label.textContent = 'Nom de l\'interlocuteur :';
            champ3Label.textContent = 'Prénom de l\'interlocuteur :';

        } else if (activite === 'Autre') {
            champ1Input.style.display = 'block';
            champ1Label.textContent = 'Description de votre activité :';
        }
    }

    // Initialisation au chargement de la page
    document.addEventListener('DOMContentLoaded', () => {
        afficherChampsSupplementaires(); // Met à jour l'affichage dès le début
    });

    // Mise à jour lors du changement d'activité
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
