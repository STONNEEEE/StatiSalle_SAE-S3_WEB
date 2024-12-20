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
                ON type_utilisateur.id_type = login.id_type
                ORDER BY nom, prenom";
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

function verifLogin($login) {
    global $pdo;

    $sql = "SELECT COUNT(*) 
            FROM login 
            WHERE login = :login";
    $stmtVerif = $pdo->prepare($sql);
    $stmtVerif->bindParam(':login', $login);
    $stmtVerif->execute();
    $result = $stmtVerif->fetchColumn();

    return $result > 0;  // Si le nombre est supérieur à 0, le login existe déjà
}

function ajouterEmploye($nom, $prenom, $login, $telephone, $mdp, $id_type) {
    global $pdo;

    try {
        // Démarrer une transaction
        $pdo->beginTransaction();

        // Récupérer le dernier ID employé au format 'E00000X'
        $requeteId = "SELECT id_employe 
                      FROM employe 
                      WHERE id_employe LIKE 'E%' 
                      ORDER BY id_employe DESC 
                      LIMIT 1";
        $dernierId = $pdo->query($requeteId)->fetchColumn();

        // Générer le nouvel ID
        $numero = $dernierId ? (int)substr($dernierId, 1) + 1 : 1;
        $id = 'E' . str_pad($numero, 6, '0', STR_PAD_LEFT);

        // Insérer dans la table employe
        $requeteEmploye = "INSERT INTO employe (id_employe, nom, prenom, telephone) VALUES (:id, :nom, :prenom, :telephone)";
        $stmtEmploye = $pdo->prepare($requeteEmploye);
        $stmtEmploye->execute([
            ':id' => $id,
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':telephone' => $telephone
        ]);

        // Vérifier si le type d'utilisateur existe
        if (!verifIdType($id_type)) {
            throw new Exception('Le type d\'utilisateur n\'existe pas dans la table type_utilisateur.');
        }

        // Hashage du mot de passe
        //$mdpHash = password_hash($mdp, PASSWORD_DEFAULT);

        // Insérer dans la table login
        $requeteLogin = "INSERT INTO login (login, mdp, id_type, id_employe) 
                         VALUES (:login, :mdp, :id_type, :id_employe)";
        $stmtLogin = $pdo->prepare($requeteLogin);
        $stmtLogin->execute([
            ':login' => $login,
            ':mdp' => $mdp, //$mdpHash
            ':id_type' => $id_type,
            ':id_employe' => $id
        ]);

        // Valider la transaction
        $pdo->commit();

    } catch (Exception $e) {
        // Annuler la transaction en cas d'erreur
        $pdo->rollBack();
        throw $e; // Propager l'exception pour gestion par l'appelant
    }
}


function modifierEmploye() {

}

function verifIdType($id_type) {
    global $pdo;

    $requeteVerifType = "SELECT COUNT(id_type) FROM type_utilisateur WHERE id_type = :id_type";
    $stmtVerif = $pdo->prepare($requeteVerifType);
    $stmtVerif->execute(['id_type' => $id_type]);
    return $stmtVerif->fetchColumn(); // Retourne le nombre d'occurrences de id_type
}
?>