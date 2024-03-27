<?php

//On se connecte
namespace Controller;
use Model\Connect; //"use" pour accéder à la classe Connect

class RolesController{

    
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



}