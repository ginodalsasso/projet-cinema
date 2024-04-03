<?php

use Controller\HomeController; //"use" le controller Home
use Controller\ActeursController; //"use" le controller acteurs
use Controller\CastingsController; //"use" le controller castings
use Controller\FilmsController; //"use" le controller films
use Controller\GenresController; //"use" le controller genres
use Controller\RealisateursController; //"use" le controller realisateurs
use Controller\RolesController; //"use" le controller Roles


spl_autoload_register(function ($class_name) { //n autocharge les classes du projet
    require str_replace("\\", DIRECTORY_SEPARATOR, $class_name) . '.php'; 
    // include $class_name . '.php';
});

$ctrlHome = new HomeController(); 
$ctrlActeurs = new ActeursController(); 
$ctrlCastings = new CastingsController(); 
$ctrlFilms = new FilmsController(); 
$ctrlGenres = new GenresController(); 
$ctrlRealisateurs = new RealisateursController(); 
$ctrlRoles = new RolesController(); 

//En fonction de l'action détectée dans l'URL via la propriété "action" on interagit avec la bonne méthode du controller
$id= (isset($_GET["id"])) ? $_GET["id"] : null;


if(isset($_GET["action"])){ //En fonction de l'action détectée dans l'URL via la propriété "action" on interagit avec la bonne méthode du controller
    $action = filter_var($_GET['action'], FILTER_SANITIZE_SPECIAL_CHARS, FILTER_VALIDATE_INT);

    switch ($_GET["action"]){

        case "home" : $ctrlHome->listHome(); break;
        //list
        case "listActeurs" : $ctrlActeurs->listActeurs(); break;
        case "listFilms" : $ctrlFilms->listFilms(); break;
        case "listGenres" : $ctrlGenres->listGenres(); break;
        case "listRealisateurs" : $ctrlRealisateurs->listRealisateurs(); break;
        case "listRoles" : $ctrlRoles->listRoles(); break;
        //detail
        case "detailActeur" : $ctrlActeurs->detailActeur($id); break;
        case "detailFilm" : $ctrlFilms->detailFilm($id); break;
        case "detailGenre" : $ctrlGenres->detailGenre($id); break;
        case "detailRealisateur" : $ctrlRealisateurs->detailRealisateur($id); break;
        //forms ajout
        case "addActeur" : $ctrlActeurs->addActeur(); break; 
        case "addRealisateur" : $ctrlRealisateurs->addRealisateur(); break; 
        case "addFilm" : $ctrlFilms->addFilm(); break;
        case "addGenre" : $ctrlGenres->addGenre(); break;
        case "addRole" : $ctrlRoles->addRole(); break;
        case "addCasting" : $ctrlCastings->addCasting(); break;
        //forms edit
        case "editActeur" : $ctrlActeurs->editActeur($id); break;
        case "editFilm" : $ctrlFilms->editFilm($id); break;
        case "editRealisateur" : $ctrlRealisateurs->editRealisateur($id); break;
        case "editGenre" : $ctrlGenres->editGenre($id); break;
        //forms delete
        case "delActeur" : $ctrlActeurs->delActeur($id); break;
        case "delRealisateur" : $ctrlRealisateurs->delRealisateur($id); break;
        case "delFilm" : $ctrlFilms->delFilm($id); break;
        case "delGenre" : $ctrlGenres->delGenre($id); break;


        
    }
};

// index sert uniquement à accueillir l'action transmise par l'URL et ne sera pas ma "home page"