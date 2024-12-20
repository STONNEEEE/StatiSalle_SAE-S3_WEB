<?php
include 'liaisonBD.php';
$pdo = connecteBD();

function renvoyerEmployes(): array {
    global $pdo;

    $requete = "SELECT nom, prenom, login.login AS id_compte, 
                       telephone, type_utilisateur.nom_type AS type_utilisateur, 
                       employe.id_employe
                FROM employe
                JOIN login
                ON login.id_employe = employe.id_employe
                JOIN type_utilisateur
                ON type_utilisateur.id_type = login.id_type";
    $stmt = $pdo->query($requete);
    return $stmt->fetchAll();
}

function supprimerEmploye($id_employe): void {
    global $pdo;

    try {
        // Démarrage de la transaction
        $pdo->beginTransaction();

        // Requête SQL pour supprimer le login
        $requeteLogin = "DELETE FROM login WHERE id_employe = :id_employe";
        $stmtLogin = $pdo->prepare($requeteLogin);
        $stmtLogin->bindParam(':id_employe', $id_employe);
        $stmtLogin->execute();

        // Requête SQL pour supprimer l'employé
        $requeteEmploye = "DELETE FROM employe WHERE id_employe = :id_employe";
        $stmtEmployer = $pdo->prepare($requeteEmploye);
        $stmtEmployer->bindParam(':id_employe', $id_employe);
        $stmtEmployer->execute();

        // Validation de la transaction
        $pdo->commit();
    } catch (Exception $e) {
        // Annulation de la transaction en cas d'erreur
        $pdo->rollBack();
        throw new Exception($e->getMessage(), $e->getCode());
    }
}
function verifIdEmploye($id) {
    global $pdo;

    $sql = "SELECT COUNT(id_employe) FROM employe WHERE id_employe = :id";
    $stmtVerif = $pdo->prepare($sql);
    $stmtVerif->bindParam(':id', $id, PDO::PARAM_STR);
    $stmtVerif->execute();
    $result = $stmtVerif->fetchColumn();

    return $result > 0;  // Si le nombre est supérieur à 0, l'ID existe déjà
}

function ajouterEmploye($id, $nom, $prenom, $telephone, $mdp, $id_type) {
    global $pdo;

    // Insertion dans la table employe
    $requete = "INSERT INTO employe (id_employe, nom, prenom, telephone) VALUES (:id, :nom, :prenom, :telephone)";
    $stmt = $pdo->prepare($requete);
    $stmt->execute(['id' => $id, 'nom' => $nom, 'prenom' => $prenom, 'telephone' => $telephone]);

    // Nettoyer le prénom et le nom pour créer le login
    $login = nettoyerTexte($prenom . '.' . $nom);
    // Limiter la longueur à 20 caractères
    $login = substr($login, 0, 20);

    // Vérifier si le type d'utilisateur existe
    if (verifIdType($id_type) > 0) {
        // Hashage du mot de passe avant insertion
        $mdpHash = password_hash($mdp, PASSWORD_DEFAULT);

        // Insertion dans la table login
        $requeteCompte = "INSERT INTO login (login, mdp, id_type) VALUES (:login, :mdp, :id_type)";
        $stmt = $pdo->prepare($requeteCompte);
        $stmt->execute(['login' => $login, 'mdp' => $mdpHash, 'id_type' => $id_type]);
    } else {
        // Si le type d'utilisateur n'existe pas, lancer une exception
        throw new Exception('Le type d\'utilisateur n\'existe pas dans la table type_utilisateur.');
    }
}

function modifierEmploye(){

}

function verifIdType($id_type) {
    global $pdo;

    $requeteVerifType = "SELECT COUNT(id_type) FROM type_utilisateur WHERE id_type = :id_type";
    $stmtVerif = $pdo->prepare($requeteVerifType);
    $stmtVerif->execute(['id_type' => $id_type]);
    return $stmtVerif->fetchColumn(); // Retourne le nombre d'occurrences de id_type
}

// Fonction pour supprimer les accents et remplacer les espaces par des tirets
function nettoyerTexte($texte) {
    // Tableau de correspondance des caractères accentués vers les caractères sans accents
    $tabCaractere = [
        'á' => 'a', 'à' => 'a', 'â' => 'a', 'ä' => 'a', 'ã' => 'a', 'å' => 'a',
        'é' => 'e', 'è' => 'e', 'ê' => 'e', 'ë' => 'e',
        'í' => 'i', 'ì' => 'i', 'î' => 'i', 'ï' => 'i',
        'ó' => 'o', 'ò' => 'o', 'ô' => 'o', 'ö' => 'o', 'õ' => 'o',
        'ú' => 'u', 'ù' => 'u', 'û' => 'u', 'ü' => 'u',
        'ç' => 'c', 'ñ' => 'n', 'ý' => 'y', 'ÿ' => 'y',
        ' ' => '-'
    ];

    // Convertir en minuscules
    $texte = strtolower($texte);

    return strtr($texte, $tabCaractere);
}
?>