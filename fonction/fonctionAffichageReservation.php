<?php
require 'liaisonBD.php';
$pdo = connecteBD();
function affichageReservation()
{
    global $pdo;
    $requete = "SELECT reservation.id_reservation as id_reservation, salle.nom as nom_salle, employe.nom as nom_employe,
                employe.prenom as prenom_employe, activite.nom_activite as nom_activite, reservation.date_reservation 
                as date, reservation.heure_debut as heure_debut, reservation.heure_fin as heure_fin
                FROM reservation
                JOIN salle
                ON reservation.id_salle = salle.id_salle
                JOIN employe
                ON reservation.id_employe = employe.id_employe
                JOIN activite
                ON reservation.id_activite = activite.id_activite";
    $requete = $pdo->prepare($requete);
    $requete->execute();
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
    return $resultat;
}