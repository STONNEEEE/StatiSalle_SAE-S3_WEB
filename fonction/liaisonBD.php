<?php
function connecteBD() {
    // Vérification si le script est appelé localement ou via le domaine
    if ($_SERVER['HTTP_HOST'] === 'statisalle.fr') {
        $host = 'localhost'; // Si appelé localement
    } else {
        $host = 'statisalle.fr';
    }
    $db = 'sc1vosi2297_StatisalleBD';
    $user = 'sc1vosi2297_application';
    $pass = '@ppl1cat1on123';
    $charset = 'utf8mb4';
    $port = 3306;

    // Constitution variable DSN
    $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";

    // Réglage des options
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,    // Active les exceptions en cas d'erreur
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, // Récupère les résultats sous forme d'objets
        PDO::ATTR_EMULATE_PREPARES => false             // Désactive l'émulation des requêtes préparées
    ];

    // Bloc pour gérer les erreurs
    try {
        return new PDO($dsn, $user, $pass, $options);
    } catch (PDOException $e) {
        // En cas d'erreur, on affiche des informations précises pour le débogage
        echo "Erreur de connexion : " . $e->getMessage() . "<br>";
        echo "Code d'erreur : " . $e->getCode() . "<br>";
        echo "Hôte : $host<br>";
        echo "Port : $port<br>";
        echo "Utilisateur : $user<br>";
        exit;
    }
}
?>