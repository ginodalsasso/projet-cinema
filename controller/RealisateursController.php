<?php

//On se connecte
namespace Controller;
use Model\Connect; //"use" pour accéder à la classe Connect

class RealisateursController{
    
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

}