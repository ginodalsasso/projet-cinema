<?php

//On se connecte
namespace Controller;
use Model\Connect; //"use" pour accéder à la classe Connect

class HomeController {



///////////////////////////////////////////////////////HOME
    public function listHome(){
        $pdo = Connect::seConnecter();
        //exécute la requête de notre choix
        $requeteFilmsHome = $pdo->query("
            SELECT titre, DATE_FORMAT(parution, '%Y') AS parution, affiche, note, id_film
            FROM film
            LIMIT 3
        ");

        $requeteActeursHome = $pdo->query("
            SELECT CONCAT(prenom,' ',nom) AS nomActeur, id_acteur, photo
            FROM personne p
            INNER JOIN acteur a ON p.id_personne = a.id_personne
            ORDER BY nom
            LIMIT 6
    ");
        $requeteRealisateursHome = $pdo->query("
            SELECT CONCAT(prenom,' ',nom) AS nomRealisateur, id_realisateur, photo
            FROM personne p
            INNER JOIN realisateur r ON p.id_personne = r.id_personne
            ORDER BY nom
            LIMIT 6
    ");
        $requeteGenresHome = $pdo->query("
            SELECT titre, GROUP_CONCAT(g.nom_genre SEPARATOR ', ') AS nom_genre, affiche, f.id_film
            FROM  genre_film gf
            INNER JOIN genre g ON gf.id_genre = g.id_genre
            INNER JOIN film f ON gf.id_film = f.id_film
            GROUP BY f.id_film
            ORDER BY nom_genre ASC
            LIMIT 3
    ");
        $requeteRolesHome = $pdo->query("
            SELECT p.id_personne, a.id_acteur, CONCAT(prenom,' ', nom) AS acteurs, role_personnage, titre, photo
            FROM film f
            INNER JOIN casting c ON f.id_film = c.id_film
            INNER JOIN acteur a ON c.id_acteur = a.id_acteur
            INNER JOIN personne p ON a.id_personne = p.id_personne
            INNER JOIN role r ON c.id_role = r.id_role  
            LIMIT 3
    ");

        require "view/home.php"; //relie par un "require" la vue qui nous intéresse (située dans le dossier "view")
    }
}

