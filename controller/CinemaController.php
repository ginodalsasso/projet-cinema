<?php

//On se connecte
namespace Controller;
use Model\Connect; //"use" pour accéder à la classe Connect

class CinemaController {


    public function listFilms(){

        $pdo = Connect::seConnecter();
        //exécute la requête de notre choix
        $requete = $pdo->query("
            SELECT titre, DATE_FORMAT(parution, '%Y') AS parution
            FROM film
        ");

        require "view/listFilms.php"; //relie par un "require" la vue qui nous intéresse (située dans le dossier "view")
    }

    public function detActeur($id) {
        $pdo = Connect::seConnecter();
        //exécute la requête de notre choix
        $requete = $pdo->prepare("SELECT * FROM acteur WHERE id_acteur = :id"); //Quand on fait une requête dans laquelle on a un élément variable (comme ici l'id de l'acteur), il faut faire un "prepare"
        $requete->execute(["id" => $id]);  // dans le "execute" on fait passer un tableau associatif qui associe le nom de champ paramétré avec la valeur de l'id (celui passé dans la méthode : $id)
        require "view/acteur/detailActeur.php";
    }
}

