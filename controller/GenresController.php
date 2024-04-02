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
            SELECT titre, nom_genre, affiche, f.id_film, g.id_genre
            FROM  genre_film gf
            INNER JOIN genre g ON gf.id_genre = g.id_genre
            INNER JOIN film f ON gf.id_film = f.id_film
            ORDER BY nom_genre ASC
        ");

        require "view/list/listGenres.php"; 
    }
    

///////////////////////////////////////////////////////DETAILS GENRE
    public function detailGenre($id){
        $pdo = Connect::seConnecter();
        // exécute la requête détail d'un genre
        $requeteDetailGenre = $pdo->prepare("   
            SELECT id_genre
            FROM genre 
            WHERE id_genre = :id
            ");
        $requeteDetailGenre->execute(["id" => $id]);

        $requeteGenre = $pdo->prepare("
            SELECT f.titre, DATE_FORMAT(parution, '%Y') AS parution, gf.id_genre, g.nom_genre, f.id_film, f.affiche, g.nom_genre
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


///////////////////////////////////////////////////////MODIFICATION DU GENRE
    public function editGenre($id){
        $pdo = Connect::seConnecter();

        $choixGenre = $pdo->prepare("
            SELECT * 
            FROM genre 
            WHERE id_genre = :id
        ");

        $choixGenre->execute(["id" => $id]);


        if(isset($_POST['submit'])){
            // filtre la valeur insérée dans le formulaire
            $nomGenre = filter_input(INPUT_POST, "nom_genre", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            
            if($nomGenre){
                //exécute la requête d'édition d'un genre
                $updateGenre = $pdo->prepare("
                    UPDATE genre
                    SET nom_genre = :nom_genre
                    WHERE id_genre = :id_genre
                ");

                $updateGenre->execute([
                    "nom_genre" => $nomGenre,
                    "id_genre" => $id
                ]);
    

                // message lors de l'ajout d'un genre
                $_SESSION['message'] = "<p>Le Genre $nomGenre vient d'être ajouté !</p>";
                
                // redirection vers la page du nouveau genre
                header("Location: index.php?action=listGenres"); 
                exit;
            } 
            else { // sinon message de prévention et redirection à l'accueil
                $_SESSION['message'] = "<p>Le genre n'a pas été modifié !</p>";
                header("Location: index.php?action=listGenres");
                exit;
            }
        }
        require "view/forms/editGenre.php";
    }


///////////////////////////////////////////////////////SUPPRESSION DU GENRE
    public function delGenre($id){
        $pdo = Connect::seConnecter();

        $deleteGenreFilm = $pdo->prepare("
            DELETE FROM genre_film 
            WHERE id_genre = :id_genre
        ");
        $deleteGenreFilm->execute([
            "id_genre" => $id
        ]);

        $deleteGenre = $pdo->prepare("
            DELETE FROM genre 
            WHERE id_genre = :id_genre
        ");

        $deleteGenre->execute([
            "id_genre" => $id
        ]);

        header("Location: index.php?action=listGenres");
    }

}