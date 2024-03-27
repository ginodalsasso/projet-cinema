<?php

//On se connecte
namespace Controller;
use Model\Connect; //"use" pour accéder à la classe Connect

class GenresController{

///////////////////////////////////////////////////////LIST GENRES
    public function listGenres(){
        $pdo = Connect::seConnecter();
        //exécute la requête de notre choix
        $requeteGenres = $pdo->query("
            SELECT titre, GROUP_CONCAT(g.nom_genre SEPARATOR ', ') AS nom_genre, affiche, f.id_film
            FROM  genre_film gf
            INNER JOIN genre g ON gf.id_genre = g.id_genre
            INNER JOIN film f ON gf.id_film = f.id_film
            GROUP BY f.id_film
            ORDER BY nom_genre ASC
        ");

        require "view/list/listGenres.php"; 
    }
    

///////////////////////////////////////////////////////DETAILS GENRE
    public function detailGenre($id){
        $pdo = Connect::seConnecter();
        //exécute la requête détail d'un genre
        $requeteDetailGenre = $pdo->prepare("   
            SELECT  g.id_genre, g.nom_genre
            FROM genre g
            WHERE g.id_genre = :id
            ");
        $requeteDetailGenre->execute(["id" => $id]);

        $requeteGenre = $pdo->prepare("
            SELECT f.titre, DATE_FORMAT(parution, '%Y') AS parution, gf.id_genre, g.nom_genre, f.id_film, f.affiche
            FROM genre_film gf
            INNER JOIN film f ON gf.id_film = f.id_film
            INNER JOIN genre g ON gf.id_genre = g.id_genre
            WHERE gf.id_genre = :id
        ");
        $requeteGenre->execute(["id" => $id]);
        require "view/detail/detailGenre.php"; 
    }



///////////////////////////////////////////////////////AJOUT DU GENRE
    public function addGenre(){
        $pdo = Connect::seConnecter();
        
        if(isset($_POST['submit'])){
            // filtre la valeur insérée dans le formulaire
            $nomGenre = filter_input(INPUT_POST, "nom_genre", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            
            if($nomGenre){
                //exécute la requête d'ajout d'un genre
                $addGenre = $pdo->prepare("
                    INSERT INTO genre(nom_genre) VALUES(:nom_genre)
                ");
                $addGenre->execute(["nom_genre" => $nomGenre]);
    
                // message lors de l'ajout d'un genre
                $_SESSION['message'] = "<p>Le Genre $nomGenre vient d'être ajouté !</p>";
                
                // redirection vers la page du nouveau genre
                header("Location: index.php?action=addGenre"); 
                exit;
            } 
            else { // sinon message de prévention et redirection à l'accueil
                $_SESSION['message'] = "<p>Le genre n'a pas été enregistré !</p>";
                header("Location: index.php?action=addGenre");
                exit;
            }
        }
        require "view/forms/addGenre.php";
    }

}