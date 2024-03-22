<?php

use Controller\CinemaController; //"use" le controller Cinema


spl_autoload_register(function ($class_name) { //n autocharge les classes du projet
    include $class_name . '.php';
});

$ctrlCinema = new CinemaController(); //instance le controller Cinema

$id = (isset($_GET["id"])) ? $_GET["id"] : null;
// $type = (isset($_GET["type"])) ? $_GET["type"] : null;


if(isset($_GET["action"])){ //En fonction de l'action détectée dans l'URL via la propriété "action" on interagit avec la bonne méthode du controller
    switch ($_GET["action"]){

        case "home" : $ctrlCinema->home(); break;
        //list
        case "listActeurs" : $ctrlCinema->listActeurs(); break;
        case "listFilms" : $ctrlCinema->listFilms(); break;
        case "listGenres" : $ctrlCinema->listGenres(); break;
        case "listRealisateurs" : $ctrlCinema->listRealisateurs(); break;
        case "listRoles" : $ctrlCinema->listRoles(); break;
        //detail
        case "detailActeur" : $ctrlCinema->detailActeur($id); break;
        case "detailFilm" : $ctrlCinema->detailFilm($id); break;
        case "detailGenre" : $ctrlCinema->detailGenre($id); break;
        case "detailRealisateur" : $ctrlCinema->detailRealisateur($id); break;
        case "edition" : $ctrlCinema->edition($id); break; 
        case "addRemove" : $ctrlCinema->addRemove(); break; //pour une suppression, penser à l'id
    }
};

// index sert uniquement à accueillir l'action transmise par l'URL et ne sera pas ma "home page"