<?php
namespace GetMessage;

class GetMessage{

    function getMessage() {  //me permet de récupérer un message suite à l'action d'un utilisateur et de le retourner
        if(isset($_SESSION["message"])) {
            $message = $_SESSION["message"];
        }
        return $message;
    }
    
}
