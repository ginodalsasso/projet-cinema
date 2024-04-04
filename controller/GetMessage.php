<?php
namespace GetMessage;

class GetMessage{

    public function getMessage(){ 
        if(isset($_SESSION["message"]) || !empty($_SESSION["message"])) {
            echo $_SESSION["message"]; //affiche le message
            unset($_SESSION["message"]); //supprime le message une fois affiché
        }
    }
}
