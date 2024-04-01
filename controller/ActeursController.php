<?php

//On se connecte
namespace Controller;
use Model\Connect; //"use" pour accéder à la classe Connect

class ActeursController{


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


///////////////////////////////////////////////////////EDITION D'UN ACTEUR

    public function editActeur($id){ //$id de l'acteur à éditer
        $pdo = Connect::seConnecter();
        
        //exécute la requête détail d'un acteur pour préremplir les champs du formulaires ($id)
        $choixActeur = $pdo->prepare("
            SELECT p.prenom, p.nom, DATE_FORMAT(dateNaissance, '%d/%m/%Y') AS dateNaissance, p.sexe, a.id_personne, a.id_acteur, p.photo
            FROM personne p
            INNER JOIN acteur a ON p.id_personne = a.id_personne
            WHERE a.id_personne = :id 
        ");

        $choixActeur->execute(["id" => $id]);

        if(isset($_POST['submit'])){
            // filtre la valeur insérée dans le formulaire
            $nomActeur = filter_input(INPUT_POST, "nom", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $prenomActeur = filter_input(INPUT_POST, "prenom", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $sexeActeur = filter_input(INPUT_POST, "sexe", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $dateActeur = filter_input(INPUT_POST, "dateNaissance", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            /////GESTION DE L'UPLOAD D'IMAGE
            if(isset($_FILES['file'])){

                // Requête pour récupérer le chemin de la photo actuelle de l'acteur
                $getPhoto = $pdo->prepare("
                    SELECT photo 
                    FROM personne 
                    WHERE id_personne = :id_personne
                    ");

                $getPhoto->execute(["id_personne" => $id]);
                
                // Récupère le chemin de la photo actuelle
                $unsetPhoto = $getPhoto->fetch();
                
                //unlink — Supprime un fichier (ici supprime la photo éditée)
                unlink($unsetPhoto[0]);
                
                //Requête pour supprimer le lien de la photo actuelle dans la base de données
                $deletePhoto = $pdo->prepare("
                    UPDATE personne 
                    SET photo = null 
                    WHERE id_personne = :id_personne
                    ");

                $deletePhoto->execute(["id_personne" => $id]);

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

                    // exécute la requête d'édition d'un acteur dans personne
                    $addActeur = $pdo->prepare("
                        UPDATE personne 
                        SET nom = :nom, 
                            prenom = :prenom,
                            sexe = :sexe, 
                            dateNaissance = :dateNaissance,
                            photo = :photo
                        WHERE id_personne = :id_personne
                            ");

                    $addActeur->execute([
                        "nom" => $nomActeur,
                        "prenom" => $prenomActeur,
                        "sexe" => $sexeActeur,
                        "dateNaissance" => $dateActeur,
                        "id_personne" => $id,
                        "photo" => $uploadBDD . $file
                    ]);
                
                    // message lors de l'ajout d'un acteur
                    $_SESSION['message'] = "<p>L'acteur' $nomActeur vient d'être modifié !</p>";
                    
                    // redirection vers la page liste acteurs
                    header("Location: index.php?action=listActeurs"); 
                    exit;
                } 
                else { // sinon message de prévention et redirection
                    $_SESSION['message'] = "<p>L'acteur n'a pas été enregistré !</p>";
                    header("Location: index.php?action=editActeur");
                    exit;
                }
            }
        }
        require "view/forms/editActeur.php";
    }


///////////////////////////////////////////////////////SUPPRESSION DUN ACTEUR
    public function delActeur(){
        $pdo = Connect::seConnecter();
    
        // Vérifie si l'existence des paramètres 'personneId' et 'acteurId' est dans l'URL
        if ($_GET['personneId'] && $_GET['acteurId']) {

            $personneId = $_GET['personneId'];
            $acteurId = $_GET['acteurId'];
    
            // Suppression dans la table 'casting' où 'id_acteur' correspond à '$acteurId'
            $deleteCasting = $pdo->prepare("
                DELETE FROM casting 
                WHERE id_acteur = :id_acteur
            ");
            $deleteCasting->execute([
                "id_acteur" => $acteurId
            ]);
    
            // Suppression de l'acteur de la table 'acteur' où 'id_personne' correspond à '$personneId'
            $deleteActeur = $pdo->prepare("
                DELETE FROM acteur 
                WHERE id_personne = :id_personne
            ");
            $deleteActeur->execute([
                "id_personne" => $personneId
            ]);
    
            // Suppression de l'entrée correspondante dans la table 'personne' où 'id_personne' correspond à '$personneId'
            $deletePersonne = $pdo->prepare("
                DELETE FROM personne 
                WHERE id_personne = :id_personne
            ");
            $deletePersonne->execute([
                "id_personne" => $personneId
            ]);
    
            header("Location:index.php?action=listActeurs");
        }
    }

}