<?php

//On se connecte
namespace Controller;
use Model\Connect; //"use" pour accéder à la classe Connect

class CinemaController {

/////////LIST FILMS
    public function listFilms(){
        $pdo = Connect::seConnecter();
        //exécute la requête de notre choix
        $requeteFilms = $pdo->query("
            SELECT titre, DATE_FORMAT(parution, '%Y') AS parution
            FROM film
        ");

        require "view/list/listFilms.php"; //relie par un "require" la vue qui nous intéresse (située dans le dossier "view")
    }

/////////LIST ACTEURS
    public function listActeurs(){
        $pdo = Connect::seConnecter();
        //exécute la requête de notre choix
        $requeteActeurs = $pdo->query("
            SELECT CONCAT(prenom,' ',nom) AS nomActeur, id_acteur
            FROM personne p
            INNER JOIN acteur a ON p.id_personne = a.id_personne
            ORDER BY nom
        ");

        require "view/list/listActeurs.php"; 
    }

/////////LIST GENRES
    public function listGenres(){
        $pdo = Connect::seConnecter();
        //exécute la requête de notre choix
        $requeteGenres = $pdo->query("
            SELECT nom_genre, id_genre
            FROM genre
            ORDER BY nom_genre ASC
        ");

        require "view/list/listGenres.php"; 
    }

/////////LIST REALISATEURS
    public function listRealisateurs(){
        $pdo = Connect::seConnecter();
        //exécute la requête de notre choix
        $requeteRealisateurs = $pdo->query("
            SELECT CONCAT(prenom,' ',nom) AS nomRealisateur, id_realisateur
            FROM personne p
            INNER JOIN realisateur r ON p.id_personne = r.id_personne
            ORDER BY nom
        ");

        require "view/list/listRealisateurs.php"; 
    }

/////////LIST ROLES
    public function listRoles(){
        $pdo = Connect::seConnecter();
        //exécute la requête de notre choix
        $requeteRoles = $pdo->query("
            SELECT p.id_personne, a.id_acteur, CONCAT(prenom,' ', nom) AS acteurs, role_personnage, titre
            FROM film f
            INNER JOIN casting c ON f.id_film = c.id_film
            INNER JOIN acteur a ON c.id_acteur = a.id_acteur
            INNER JOIN personne p ON a.id_personne = p.id_personne
            INNER JOIN role r ON c.id_role = r.id_role        
        ");

        require "view/list/listRoles.php"; 
    }


/////////DETAILS ACTEUR
    public function detailActeur($id){
        $pdo = Connect::seConnecter();
        //exécute la requête détail d'un acteur
        $requeteActeur = $pdo->prepare("
            SELECT CONCAT(p.prenom, ' ', p.nom) AS nomActeur, DATE_FORMAT(dateNaissance, '%d/%m/%Y') AS dateNaissance, p.sexe, a.id_personne, a.id_acteur
            FROM acteur a
            INNER JOIN personne p ON a.id_personne = p.id_personne
            WHERE a.id_acteur = :id
        ");
        $requeteActeur->execute(["id" => $id]);

        //exécute la requête liste film d'un acteur
        $requeteFilmActeur = $pdo->prepare("
            SELECT f.titre, DATE_FORMAT(f.parution, '%Y') AS parution, r.role_personnage, c.id_film, r.id_role
            FROM casting c
            INNER JOIN film f ON c.id_film = f.id_film
            INNER JOIN role r ON c.id_role = r.id_role
            WHERE c.id_acteur= :id
            ORDER BY f.parution DESC
        ");
        $requeteFilmActeur->execute(["id" => $id]);
        require "view/detail/detailActeur.php"; 
    }


    



    // public function detActeur($id) {
    //     $pdo = Connect::seConnecter();
    //     //exécute la requête de notre choix
    //     $requete = $pdo->prepare("SELECT * FROM acteur WHERE id_acteur = :id"); //Quand on fait une requête dans laquelle on a un élément variable (comme ici l'id de l'acteur), il faut faire un "prepare"
    //     $requete->execute(["id" => $id]);  // dans le "execute" on fait passer un tableau associatif qui associe le nom de champ paramétré avec la valeur de l'id (celui passé dans la méthode : $id)
    //     require "view/acteur/detailActeur.php";
    // }
}

