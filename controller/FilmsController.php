<?php

//On se connecte
namespace Controller;
use Model\Connect; //"use" pour accéder à la classe Connect

class FilmsController {


///////////////////////////////////////////////////////LIST FILMS
    public function listFilms(){
        $pdo = Connect::seConnecter();
        //exécute la requête de notre choix
        $requeteFilms = $pdo->query("
            SELECT titre, DATE_FORMAT(parution, '%Y') AS parution, affiche, note, id_film
            FROM film
        ");

        require "view/list/listFilms.php"; //relie par un "require" la vue qui nous intéresse (située dans le dossier "view")
    }


///////////////////////////////////////////////////////DETAILS FILM
    public function detailFilm($id){
        $pdo = Connect::seConnecter();
        //exécute la requête détail d'un film
        $requeteFilm = $pdo->prepare("
            SELECT f.affiche, f.titre, DATE_FORMAT(parution, '%d %m %Y') AS parution, f.duree, f.note, CONCAT(prenom, ' ', nom) AS nom_realisateur, synopsis,r.id_realisateur, f.id_film
            FROM film f
            INNER JOIN realisateur r ON f.id_realisateur = r.id_realisateur
            INNER JOIN personne p ON r.id_personne = p.id_personne
            WHERE f.id_film = :id
        ");
        $requeteFilm->execute(["id" => $id]);

        //exécute la requête genre d'un film
        $requeteGenre = $pdo->prepare("
            SELECT GROUP_CONCAT(g.nom_genre SEPARATOR ', ') AS nom_genre
            FROM  genre_film gf
            INNER JOIN genre g ON gf.id_genre = g.id_genre
            INNER JOIN film f ON gf.id_film = f.id_film
            WHERE f.id_film = :id
        ");
        $requeteGenre->execute(["id" => $id]);

        //exécute la requête pour le casting d'un film
        $requeteCasting = $pdo->prepare("
            SELECT CONCAT(prenom, ' ', nom) AS nomActeur, role_personnage, p.photo, a.id_acteur, r.id_role           FROM film f
            INNER JOIN casting c ON f.id_film = c.id_film
            INNER JOIN acteur a ON c.id_acteur = a.id_acteur
            INNER JOIN personne p ON a.id_personne = p.id_personne
            INNER JOIN role r ON c.id_role = r.id_role
            WHERE f.id_film = :id
        ");
        $requeteCasting->execute(["id" => $id]);
        require "view/detail/detailFilm.php"; 
    }


    
///////////////////////////////////////////////////////AJOUT D'UN FILM
public function addFilm(){
    $pdo = Connect::seConnecter();

     // choix du réalisateur
     $choixRealisateur = $pdo->prepare("
        SELECT CONCAT(p.prenom, ' ', p.nom) AS nomRealisateur, r.id_realisateur
        FROM realisateur r
        INNER JOIN personne p ON r.id_personne = p.id_personne
        ORDER BY p.nom");
    $choixRealisateur->execute();
 
    // choix du genre
    $choixGenre = $pdo->prepare("
        SELECT * FROM genre ORDER BY nom_genre");
    $choixGenre->execute();
    
    // si le formulaire est envoyé 
    if(isset($_POST['submit'])){
        // filtre la valeur insérée dans le formulaire
        $titreFilm = filter_input(INPUT_POST, "titre", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $parutionFilm = filter_input(INPUT_POST, "parution", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $dureeFilm = filter_input(INPUT_POST, "duree",  FILTER_VALIDATE_INT);
        $noteFilm = filter_input(INPUT_POST, "note", FILTER_VALIDATE_INT);
        $synopsisFilm = filter_input(INPUT_POST, "synopsis", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $realisateurFilm = filter_input(INPUT_POST, "id_realisateur", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        ///////GESTION DE L'UPLOAD D'IMAGE
        if(isset($_FILES['file'])){
            // infos image
            $tmpName = $_FILES['file']['tmp_name'];
            $name = $_FILES['file']['name'];
            $size = $_FILES['file']['size'];
            $error = $_FILES['file']['error'];

            //dossier de destination
            $uploadBDD = 'public/img/affiches/';

            $tabExtension = explode('.', $name); //découpe le nom et l'extension de l'image en plusiseurs morceaux (à chaque point)
            $extension = strtolower(end($tabExtension)); //récupère le dernier élément de la découpe du nom de l'image (donc l'extension)
            $extensions = ['jpg', 'png', 'jpeg', 'webp']; //extensions autorisées
            $maxSize = 40000000; 

            // si l'extension est dans le tableau des extensions autorisées que la taille est ok alors il éxécute la fonction et s'il n'y à pas d'erreur
            if(in_array($extension, $extensions) && $size <= $maxSize && $error == 0){
                //pour ne pas écraser deux images ayant le même nom
                $uniqueName = uniqid('', true);
                //uniqid génère quelque chose comme ca : 5f586bf96dcd38.73540086
                $file = $uniqueName.".".$extension;
                //$file = 5f586bf96dcd38.73540086.jpg
                move_uploaded_file($tmpName, $uploadBDD . $file);
            }
            else{
                echo "Mauvaise extension ou taille de l'image trop lourde !";
                // exit;
            }
        } 

    
        if($titreFilm && $parutionFilm && $dureeFilm && $noteFilm && $synopsisFilm  && $realisateurFilm){ //&& $genreFilm

            //exécute la requête d'ajout d'un film
            $addFilm = $pdo->prepare("
                INSERT INTO film(titre, parution, duree, synopsis, note, affiche, id_realisateur) 
                VALUES(:titre, :parution, :duree, :synopsis, :note, :affiche, :id_realisateur)
            ");
            $addFilm->execute(["titre" => $titreFilm,
                                "parution" => $parutionFilm,
                                "duree" => $dureeFilm,
                                "synopsis" => $synopsisFilm,
                                "note" => $noteFilm,
                                "affiche" => $uploadBDD . $file,
                                "id_realisateur" => $realisateurFilm
                            ]);

            //Retourne l'identifiant de la dernière ligne insérée pour récuperer l'id dans film
            $idFilm = $pdo->lastInsertId();
                
            // boucle pour ajouter les genres sélectionnés en bdd
            foreach ($_POST['genres'] as $genreFilm) {

                $genreFilm = filter_var($genreFilm, FILTER_VALIDATE_INT);

                if ($genreFilm) {
                    $requeteAddGenre = $pdo->prepare("
                        INSERT INTO genre_film (id_film, id_genre)
                        VALUES (:id_film, :id_genre)
                    ");

                    $requeteAddGenre->execute(["id_film" => $idFilm,
                                                "id_genre" => $genreFilm]);
                }
            }
        
            // message lors de l'ajout d'un film
            $_SESSION['message'] = "<p>Le film $titreFilm vient d'être ajouté !</p>";
            
            // redirection vers la page liste realisateur
            header("Location: index.php?action=listFilms"); 
            exit;
        } 
        else { // sinon message de prévention et redirection
            $_SESSION['message'] = "<p>Le film n'a pas été enregistré !</p>";
            header("Location: index.php?action=addFilm");
            exit;
        }
       
    }
    require "view/forms/addFilm.php";
}


///////////////////////////////////////////////////////EDITION D'UN FILM

public function editFilm($id){ //$id du film à éditer
    $pdo = Connect::seConnecter();

    //exécute la requête détail d'un film pour préremplir les champs du formulaires ($id)
    $choixFilm = $pdo->prepare("
        SELECT titre, parution, duree, affiche, note, synopsis, id_film, id_realisateur
        FROM film
        WHERE id_film = :id
        ");

    $choixFilm->execute(["id" => $id]);

    // // choix du réalisateur formulaire
    $choixRealisateur = $pdo->prepare("
        SELECT CONCAT(p.prenom, ' ', p.nom) AS nomRealisateur, r.id_realisateur
        FROM realisateur r
        INNER JOIN personne p ON r.id_personne = p.id_personne
        ");

    $choixRealisateur->execute();

    // choix du genre formulaire
    $choixGenre = $pdo->prepare("
        SELECT * 
        FROM genre 
        ");

    $choixGenre->execute();

    $prevListGenres = $pdo->prepare("
        SELECT id_genre 
        FROM genre_film 
        WHERE id_film = :id
        ");
        
    $prevListGenres->execute(["id" => $id]);
    
    $idGenre = [];
        foreach ($prevListGenres->fetchAll() as $genre) {
            $idGenre[] = $genre["id_genre"];
        }


    if(isset($_POST ['submit'])){
        // var_dump($_POST);
        // filtre la valeur insérée dans le formulaire
        $titreFilm = filter_input(INPUT_POST, "titre", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $parutionFilm = filter_input(INPUT_POST, "parution", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $dureeFilm = filter_input(INPUT_POST, "duree",  FILTER_VALIDATE_INT);
        $noteFilm = filter_input(INPUT_POST, "note", FILTER_VALIDATE_INT);
        $synopsisFilm = filter_input(INPUT_POST, "synopsis", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $realisateurFilm = filter_input(INPUT_POST, "id_realisateur",  FILTER_VALIDATE_INT);
        $id_genres = filter_input(INPUT_POST, "genres", FILTER_VALIDATE_INT, FILTER_REQUIRE_ARRAY);

        ///GESTION DE L'UPLOAD D'IMAGE
        if(isset($_FILES['file'])){

            // Requête pour récupérer le chemin de la photo actuelle du film
            $getPhoto = $pdo->prepare("
                SELECT affiche 
                FROM film 
                WHERE id_film = :id_film
            ");

            $getPhoto->execute(["id_film" => $id]);

            // Récupère le chemin de la photo actuelle
            $unsetPhoto = $getPhoto->fetch();
            
            // unlink — Supprime un fichier (ici supprime la photo éditée)
            unlink($unsetPhoto[0]);

            // Requête pour supprimer le lien de la photo actuelle dans la base de données
            $deletePhoto = $pdo->prepare("
                UPDATE film 
                SET affiche = null 
                WHERE id_film = :id_film
            ");

            $deletePhoto->execute(["id_film" => $id]);

            // infos image
            $tmpName = $_FILES['file']['tmp_name'];
            $name = $_FILES['file']['name'];
            $size = $_FILES['file']['size'];
            $error = $_FILES['file']['error'];
        
            //dossier de destination
            $uploadBDD = 'public/img/affiches/';

            $tabExtension = explode('.', $name); //découpe le nom et l'extension de l'image en plusiseurs morceaux (à chaque point)
            $extension = strtolower(end($tabExtension)); //récupère le dernier élément de la découpe du nom de l'image (donc l'extension)
            $extensions = ['jpg', 'png', 'jpeg', 'webp']; //extensions autorisées
            $maxSize = 40000000; 

            // si l'extension est dans le tableau des extensions autorisées que la taille est ok alors il éxécute la fonction et s'il n'y à pas d'erreur
            if(in_array($extension, $extensions) && $size <= $maxSize && $error == 0){
                
                //pour ne pas écraser deux images ayant le même nom
                $uniqueName = uniqid('', true);
                //uniqid génère quelque chose comme ca : 5f586bf96dcd38.73540086
                $file = $uniqueName.".".$extension;
                //$file = 5f586bf96dcd38.73540086.jpg
                move_uploaded_file($tmpName, $uploadBDD . $file);   
            }
            else{
                echo "Mauvaise extension ou taille de l'image trop lourde !";
                exit;
            }
        }    
           
        if($titreFilm && $parutionFilm && $dureeFilm && $synopsisFilm && $noteFilm && $id_genres && $realisateurFilm){

                //-----------------update des infos du film
                // exécute la requête d'édition d'un film
                $addFilm = $pdo->prepare("
                    UPDATE film
                    SET titre = :titre,
                        parution = :parution, 
                        duree = :duree, 
                        synopsis = :synopsis, 
                        note = :note, 
                        affiche = :affiche,
                        id_realisateur = :id_realisateur
                    WHERE id_film = :id_film
                    ");

                $addFilm->execute([
                    "titre" => $titreFilm,
                    "parution" => $parutionFilm,
                    "duree" => $dureeFilm,
                    "synopsis" => $synopsisFilm,
                    "note" => $noteFilm,
                    "affiche" => $uploadBDD . $file,
                    "id_realisateur" => $realisateurFilm,
                    "id_film" => $id
                ]);
                

                //-----------------update du genre du film
                //suprime le genre dans genre_film
                $deleteGenre = $pdo->prepare("
                    DELETE FROM genre_film
                    WHERE id_film = :id_film
                ");
                $deleteGenre->execute([
                    "id_film" => $id
                ]);

                foreach ($id_genres as $id_genre) {
                    $addGenre = $pdo->prepare("
                        INSERT INTO genre_film (id_film, id_genre) 
                        VALUES (:id_film, :id_genre)
                    ");

                    $addGenre->execute([
                        "id_film" => $id,
                        "id_genre" => $id_genre
                    ]);
                }
                

                // message lors de l'ajout d'un film
                $_SESSION['message'] = "<p>Le film' $titreFilm vient d'être modifié !</p>";
                
                // redirection vers la page liste de films
                header("Location: index.php?action=listFilms"); 
                exit;
            } 
            else { // sinon message de prévention et redirection
                $_SESSION['message'] = "<p>L'acteur n'a pas été enregistré !</p>";
                header("Location: index.php?action=listFilms");
                exit;
            }
        }
    require "view/forms/editFilm.php";
}



///////////////////////////////////////////////////////SUPPRESSION D'UN FILM

public function delFilm($id){
    $pdo = Connect::seConnecter();

    
    $deleteGenreFilm = $pdo->prepare("
    DELETE FROM genre_film 
    WHERE id_film = :id_film
    ");
    $deleteGenreFilm->execute([
        "id_film" => $id
    ]);
    
    $deleteCasting = $pdo->prepare("
    DELETE FROM casting 
    WHERE id_film = :id_film
    ");
    $deleteCasting->execute([
        "id_film" => $id
    ]);
    
    $deleteFilm = $pdo->prepare("
        DELETE FROM film 
        WHERE id_film = :id_film
    ");
    $deleteFilm->execute([
        "id_film" => $id
    ]);

    header("Location: index.php?action=listFilms");

}

}
