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

function affichageTypeReservation($idReservation){
    global $pdo;
    $requete = "SELECT reservation_entretien.*, 
                       reservation_formation.*, 
                       reservation_pret_louer.*, 
                       reservation_autre.*, 
                       reservation_reunion.*
                FROM reservation
                LEFT JOIN reservation_entretien
                ON reservation.id_reservation = reservation_entretien.id_reservation
                LEFT JOIN reservation_formation
                ON reservation.id_reservation = reservation_formation.id_reservation
                LEFT JOIN reservation_pret_louer
                ON reservation.id_reservation = reservation_pret_louer.id_reservation
                LEFT JOIN reservation_autre
                ON reservation.id_reservation = reservation_autre.id_reservation
                LEFT JOIN reservation_reunion
                ON reservation.id_reservation = reservation_reunion.id_reservation
                WHERE reservation.id_reservation = :id_reservation";
    $requete = $pdo->prepare($requete);

    // On lie le paramètre :id_reservation une seule fois
    $requete->bindParam(':id_reservation', $idReservation, PDO::PARAM_STR);

    // On exécute la requête après avoir lié le paramètre
    $requete->execute();

    // On récupère le résultat
    $resultat = $requete->fetch(PDO::FETCH_ASSOC);
    return $resultat;
}
