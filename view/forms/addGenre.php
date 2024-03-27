<!-- On commence et on termine la vue par "ob_start()" et "ob_get_clean()" -->
<?php ob_start(); ?>


<!-- formulaire d'ajout d'un genre -->
<section class="form">
    <!-- action redirigeant vers la méthode du controller -->
    <form action="index.php?action=addGenre" method="post">
        <p><label>Titre du genre :</label></p>
            <input type="text" class="form_item" name="nom_genre" placeholder="Titre" required>
        
        <p><a type="submit" name="submit" class="more_btn">Ajouter le genre</a></p>
    </form>
</section>


<?php
    // Vérifie si un message est défini dans la session
    if (isset($_SESSION['message'] )){
        // Affiche le message
        echo $_SESSION['message'] ;
        // Efface le message de la session pour qu'il ne s'affiche pas à nouveau lors du prochain chargement de la page
        unset($_SESSION['message'] );
    }
?>

<?php

// Définition des titres pour la vue
$titre = "Ajouter un genre";
$titre_secondaire = "Ajout d'un genre";
$contenu = ob_get_clean();

//injecter le contenu dans le template > template.php
require "view/template.php"; 
