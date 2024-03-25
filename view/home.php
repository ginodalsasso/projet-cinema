<!-- On commence et on termine la vue par "ob_start()" et "ob_get_clean()" -->
<?php ob_start(); ?>


<?php

// Définition des titres pour la vue
$titre = "Liste des films";
$titre_secondaire = "Liste des films";
$contenu = ob_get_clean();

//injecter le contenu dans le template > template.php
require "view/template.php"; 
