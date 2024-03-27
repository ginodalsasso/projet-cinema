<?php

//On se connecte
namespace Controller;
use Model\Connect; //"use" pour accéder à la classe Connect

class CastingsController{
    
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
            $titreFilm = filter_input(INPUT_POST, "id_film", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $acteurFilm = filter_input(INPUT_POST, "id_acteur", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $roleFilm = filter_input(INPUT_POST, "id_role", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if($titreFilm && $acteurFilm && $roleFilm){ 
                //exécute la requête d'ajout d'un casting
                $addRole = $pdo->prepare("
                    INSERT INTO casting (id_film, id_acteur, id_role) 
                    VALUES (:id_film, :id_acteur, :id_role)
                ");
                $addRole->execute(["id_film" => $titreFilm,
                                    "id_acteur" => $acteurFilm,
                                    "id_role" => $roleFilm,
                                ]);

                // message lors de l'ajout d'un casting
                $_SESSION['message'] = "<p>Le rôle $roleFilm vient d'être ajouté à l'acteur $acteurFilm !</p>";
                
                // redirection vers la page liste 
                header("Location: index.php?action=listRoles"); 
                exit;
            } 
            else { // sinon message de prévention et redirection
                $_SESSION['message'] = "<p>Le rôle n'a pas été enregistré !</p>";
                header("Location: index.php?action=addCasting");
                exit;
            }
        }
        

        require "view/forms/addCasting.php";
    }

}