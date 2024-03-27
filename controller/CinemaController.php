<?php

//On se connecte
namespace Controller;
use Model\Connect; //"use" pour accéder à la classe Connect

class CinemaController {



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

///////////////////////////////////////////////////////LIST ACTEURS
    public function listActeurs(){
        $pdo = Connect::seConnecter();
        //exécute la requête de notre choix
        $requeteActeurs = $pdo->query("
            SELECT CONCAT(prenom,' ',nom) AS nomActeur, id_acteur, photo
            FROM personne p
            INNER JOIN acteur a ON p.id_personne = a.id_personne
            ORDER BY nom
        ");

        require "view/list/listActeurs.php"; 
    }

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

///////////////////////////////////////////////////////LIST REALISATEURS
    public function listRealisateurs(){
        $pdo = Connect::seConnecter();
        //exécute la requête de notre choix
        $requeteRealisateurs = $pdo->query("
            SELECT CONCAT(prenom,' ',nom) AS nomRealisateur, id_realisateur, photo
            FROM personne p
            INNER JOIN realisateur r ON p.id_personne = r.id_personne
            ORDER BY nom
        ");

        require "view/list/listRealisateurs.php"; 
    }

///////////////////////////////////////////////////////LIST ROLES
    public function listRoles(){
        $pdo = Connect::seConnecter();
        //exécute la requête de notre choix
        $requeteRoles = $pdo->query("
            SELECT p.id_personne, a.id_acteur, CONCAT(prenom,' ', nom) AS acteurs, role_personnage, titre, photo
            FROM film f
            INNER JOIN casting c ON f.id_film = c.id_film
            INNER JOIN acteur a ON c.id_acteur = a.id_acteur
            INNER JOIN personne p ON a.id_personne = p.id_personne
            INNER JOIN role r ON c.id_role = r.id_role        
        ");

        require "view/list/listRoles.php"; 
    }


///////////////////////////////////////////////////////DETAILS ACTEUR
    public function detailActeur($id){
        $pdo = Connect::seConnecter();
        //exécute la requête détail d'un acteur
        $requeteActeur = $pdo->prepare("
            SELECT CONCAT(p.prenom, ' ', p.nom) AS nomActeur, DATE_FORMAT(dateNaissance, '%d/%m/%Y') AS dateNaissance, p.sexe, a.id_personne, a.id_acteur, p.photo
            FROM acteur a
            INNER JOIN personne p ON a.id_personne = p.id_personne
            WHERE a.id_acteur = :id
        ");
        $requeteActeur->execute(["id" => $id]);

        //exécute la requête liste film d'un acteur
        $requeteFilmActeur = $pdo->prepare("
            SELECT f.titre, DATE_FORMAT(f.parution, '%Y') AS parution, r.role_personnage, c.id_film, r.id_role, f.affiche
            FROM casting c
            INNER JOIN film f ON c.id_film = f.id_film
            INNER JOIN role r ON c.id_role = r.id_role
            WHERE c.id_acteur= :id
            ORDER BY f.parution DESC
        ");
        $requeteFilmActeur->execute(["id" => $id]);
        require "view/detail/detailActeur.php"; 
    }

///////////////////////////////////////////////////////DETAILS REALISATEUR
    public function detailRealisateur($id){
        $pdo = Connect::seConnecter();
        //exécute la requête détail d'un réalisateur
        $requeteRealisateur = $pdo->prepare("
            SELECT CONCAT(p.prenom, ' ', p.nom) AS nomRealisateur, DATE_FORMAT(dateNaissance, '%d/%m/%Y') AS dateNaissance, p.sexe, r.id_personne, r.id_realisateur, p.photo
            FROM realisateur r
            INNER JOIN personne p ON r.id_personne = p.id_personne
            WHERE r.id_realisateur = :id
        ");
        $requeteRealisateur->execute(["id" => $id]);

        //exécute la requête liste film d'un réalisateur
        $requeteFilmRealisateur = $pdo->prepare("
            SELECT f.titre, DATE_FORMAT(f.parution, '%Y') AS parution, f.id_film, f.affiche
            FROM  film f
            INNER JOIN realisateur r ON f.id_realisateur = r.id_realisateur
            INNER JOIN personne p ON r.id_personne = p.id_personne
            WHERE r.id_realisateur= :id
            ORDER BY f.parution DESC
        ");
        $requeteFilmRealisateur->execute(["id" => $id]);
        require "view/detail/detailRealisateur.php"; 
    }

///////////////////////////////////////////////////////DETAILS FILM
    public function detailFilm($id){
        $pdo = Connect::seConnecter();
        //exécute la requête détail d'un film
        $requeteFilm = $pdo->prepare("
            SELECT f.affiche, f.titre, DATE_FORMAT(parution, '%d %m %Y') AS parution, f.duree, f.note, CONCAT(prenom, ' ', nom) AS nom_realisateur
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


///////////////////////////////////////////////////////AJOUT DU ROLE
    public function addRole(){
        $pdo = Connect::seConnecter();
        
        if(isset($_POST['submit'])){
            // filtre la valeur insérée dans le formulaire
            $nomRole = filter_input(INPUT_POST, "role_personnage", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            
            if($nomRole){
                //exécute la requête d'ajout d'un genre
                $addRole = $pdo->prepare("
                    INSERT INTO role(role_personnage) VALUES(:role_personnage)
                ");
                $addRole->execute(["role_personnage" => $nomRole]);
    
                // message lors de l'ajout d'un genre
                $_SESSION['message'] = "<p>Le rôle de $nomRole vient d'être ajouté !</p>";
                
                // redirection vers la page du nouveau genre
                header("Location: index.php?action=addRole"); 
                exit;
            } 
            else { // sinon message de prévention et redirection à l'accueil
                $_SESSION['message'] = "<p>Le rôle n'a pas été enregistré !</p>";
                header("Location: index.php?action=addRole");
                exit;
            }
        }
        require "view/forms/addRole.php";
    }


///////////////////////////////////////////////////////AJOUT D'UN ACTEUR
    public function addActeur(){
        $pdo = Connect::seConnecter();
        
        if(isset($_POST['submit'])){
            // filtre la valeur insérée dans le formulaire
            $nomActeur = filter_input(INPUT_POST, "nom", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $prenomActeur = filter_input(INPUT_POST, "prenom", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $sexeActeur = filter_input(INPUT_POST, "sexe", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $dateActeur = filter_input(INPUT_POST, "dateNaissance", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            ///////GESTION DE L'UPLOAD D'IMAGE
            if(isset($_FILES['file'])){
                // infos image
                $tmpName = $_FILES['file']['tmp_name'];
                $name = $_FILES['file']['name'];
                $size = $_FILES['file']['size'];
                $error = $_FILES['file']['error'];

                //dossier de destination
                $uploadBDD = 'public/img/personnes/';

                $tabExtension = explode('.', $name); //découpe le nom et l'extension de l'image en plusiseurs morceaux (à chaque point)
                $extension = strtolower(end($tabExtension)); //récupère le dernier élément de la découpe du nom de l'image (donc l'extension)
                $extensions = ['jpg', 'png', 'jpeg', 'webp']; //extensions autorisées
                $maxSize = 40000000; 

                if($nomActeur && $prenomActeur && $sexeActeur && $dateActeur){
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
                    //exécute la requête d'ajout d'un acteur dans personne
                    $addActeur = $pdo->prepare("
                        INSERT INTO personne(nom, prenom, sexe, dateNaissance, photo) 
                        VALUES(:nom, :prenom, :sexe, :dateNaissance, :photo)
                    ");
                    $addActeur->execute(["nom" => $nomActeur,
                                        "prenom" => $prenomActeur,
                                        "sexe" => $sexeActeur,
                                        "dateNaissance" => $dateActeur,
                                        "photo" => $uploadBDD . $file]);

                    //Retourne l'identifiant de la dernière ligne insérée pour récuperer l'id dans personne
                    $idPersonne=$pdo->lastInsertId();

                    //exécute la requête d'ajout d'un acteur
                    $addIdActeur = $pdo->prepare("
                        INSERT INTO acteur (id_personne) 
                        VALUES (:id_personne)
                    ");
                    $addIdActeur->execute(["id_personne" => $idPersonne]);
                
                    // message lors de l'ajout d'un acteur
                    $_SESSION['message'] = "<p>L'acteur' $nomActeur vient d'être ajouté !</p>";
                    
                    // redirection vers la page liste acteurs
                    header("Location: index.php?action=listActeurs"); 
                    exit;
                } 
                else { // sinon message de prévention et redirection
                    $_SESSION['message'] = "<p>L'acteur n'a pas été enregistré !</p>";
                    header("Location: index.php?action=addActeur");
                    exit;
                }
            }
        }
        require "view/forms/addActeur.php";
    }

///////////////////////////////////////////////////////AJOUT D'UN REALISATEUR
    public function addRealisateur(){
        $pdo = Connect::seConnecter();
        
        if(isset($_POST['submit'])){
            // filtre la valeur insérée dans le formulaire
            $nomRealisateur = filter_input(INPUT_POST, "nom", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $prenomRealisateur = filter_input(INPUT_POST, "prenom", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $sexeRealisateur = filter_input(INPUT_POST, "sexe", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $dateRealisateur = filter_input(INPUT_POST, "dateNaissance", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            ///////GESTION DE L'UPLOAD D'IMAGE
            if(isset($_FILES['file'])){
                // infos image
                $tmpName = $_FILES['file']['tmp_name'];
                $name = $_FILES['file']['name'];
                $size = $_FILES['file']['size'];
                $error = $_FILES['file']['error'];

                //dossier de destination
                $uploadBDD = 'public/img/personnes/';

                $tabExtension = explode('.', $name); //découpe le nom et l'extension de l'image en plusiseurs morceaux (à chaque point)
                $extension = strtolower(end($tabExtension)); //récupère le dernier élément de la découpe du nom de l'image (donc l'extension)
                $extensions = ['jpg', 'png', 'jpeg', 'webp']; //extensions autorisées
                $maxSize = 40000000; 

                if($nomRealisateur && $prenomRealisateur && $sexeRealisateur && $dateRealisateur){
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
                    //exécute la requête d'ajout d'un acteur dans personne
                    $addRealisateur = $pdo->prepare("
                        INSERT INTO personne(nom, prenom, sexe, dateNaissance, photo) 
                        VALUES(:nom, :prenom, :sexe, :dateNaissance, :photo)
                    ");
                    $addRealisateur->execute(["nom" => $nomRealisateur,
                                        "prenom" => $prenomRealisateur,
                                        "sexe" => $sexeRealisateur,
                                        "dateNaissance" => $dateRealisateur,
                                        "photo" => $uploadBDD . $file]);

                    //Retourne l'identifiant de la dernière ligne insérée pour récuperer l'id dans personne
                    $idPersonne=$pdo->lastInsertId();

                    //exécute la requête d'ajout d'un acteur
                    $addIdRealisateur = $pdo->prepare("
                        INSERT INTO realisateur (id_personne) 
                        VALUES (:id_personne)
                    ");
                    $addIdRealisateur->execute(["id_personne" => $idPersonne]);
                
                    // message lors de l'ajout d'un acteur
                    $_SESSION['message'] = "<p>Le réalisateur $nomRealisateur vient d'être ajouté !</p>";
                    
                    // redirection vers la page liste acteurs
                    header("Location: index.php?action=listRealisateurs"); 
                    exit;
                } 
                else { // sinon message de prévention et redirection
                    $_SESSION['message'] = "<p>Le réalisateur n'a pas été enregistré !</p>";
                    header("Location: index.php?action=addRealisateur");
                    exit;
                }
            }
        }
        require "view/forms/addRealisateur.php";
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
                $uploadBDD = 'public/img/personnes/';

                $tabExtension = explode('.', $name); //découpe le nom et l'extension de l'image en plusiseurs morceaux (à chaque point)
                $extension = strtolower(end($tabExtension)); //récupère le dernier élément de la découpe du nom de l'image (donc l'extension)
                $extensions = ['jpg', 'png', 'jpeg', 'webp']; //extensions autorisées
                $maxSize = 40000000; 

                if($titreFilm && $parutionFilm && $dureeFilm && $noteFilm && $synopsisFilm  && $realisateurFilm){ //&& $genreFilm

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
        }
        require "view/forms/addFilm.php";
    }


///////////////////////////////////////////////////////AJOUT D'UN CASTING
    public function addCasting(){
        $pdo = Connect::seConnecter();
        ////////////////////requètes pour les select de la vue addCasting
        // choix du film
        $choixFilm = $pdo->prepare("
            SELECT titre, id_film
            FROM film 
            ORDER BY titre"
        );
        $choixFilm->execute();

         // choix du réalisateur
         $choixActeur = $pdo->prepare("
            SELECT CONCAT(p.prenom, ' ', p.nom) AS nomActeur, a.id_acteur
            FROM acteur a
            INNER JOIN personne p ON a.id_personne = p.id_personne
            ORDER BY p.nom"
        );
        $choixActeur->execute();

         // choix du rôle
         $choixRole = $pdo->prepare("
            SELECT role_personnage, id_role
            FROM  role r
            ORDER BY r.role_personnage"
        );
        $choixRole->execute();

         // si le formulaire est envoyé 
         if(isset($_POST['submit'])){
            // filtre la valeur insérée dans le formulaire
            $realisateurFilm = filter_input(INPUT_POST, "id_realisateur", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            
     

        require "view/forms/addCasting.php";
    }

    // public function addImg(){
    //     ///////GESTION DE L'UPLOAD D'IMAGE
    //     if(isset($_FILES['file'])){
    //         // infos image
    //         $tmpName = $_FILES['file']['tmp_name'];
    //         $name = $_FILES['file']['name'];
    //         $size = $_FILES['file']['size'];
    //         $error = $_FILES['file']['error'];

    //         $tabExtension = explode('.', $name); //découpe le nom et l'extension de l'image en plusiseurs morceaux (à chaque point)
    //         $extension = strtolower(end($tabExtension)); //récupère le dernier élément de la découpe du nom de l'image (donc l'extension)
    //         $extensions = ['jpg', 'png', 'jpeg', 'webp']; //extensions autorisées
    //         $maxSize = 400000; 
    //         }

    //     // si l'extension est dans le tableau des extensions autorisées que la taille est ok alors il éxécute la fonction et s'il n'y à pas d'erreur
    //     if(in_array($extension, $extensions) && $size <= $maxSize && $error == 0){
    //         //pour ne pas écraser deux images ayant le même nom
    //         $uniqueName = uniqid('', true);
    //         //uniqid génère quelque chose comme ca : 5f586bf96dcd38.73540086
    //         $file = $uniqueName.".".$extension;
    //         //$file = 5f586bf96dcd38.73540086.jpg
    //         move_uploaded_file($tmpName, $uploadBDD . $file);
    //     }
    //     else{
    //         echo "Mauvaise extension ou taille de l'image trop lourde !";
    //         exit;
    //     }
}

