<?php
    function connecteBD(){
        $host = 'www.statisalle.fr';
        $db = 'StatsalleBD';
        $user = 'admin';
        $pass = 'admin';
        $charset = 'utf8mb4';

        // Constitution variable DSN
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

        // Réglage des options
        $options=[
            PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES=>false];

        try{	// Bloc try bd injoignable ou si erreur SQL
            $pdo = new PDO($dsn,$user,$pass,$options);
            return $pdo;
        }catch(PDOException $e){
            //Il y a eu une erreur
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }
?>