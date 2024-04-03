<!-- On commence et on termine la vue par "ob_start()" et "ob_get_clean()" -->
<?php ob_start(); ?>

<?php
//requête pour récupérer les infos d'un genre
$genre = $choixGenre->fetch();
?>
<!-- formulaire d'édition d'un genre -->
<section class="wrapper">
    <!-- action redirigeant vers la méthode du controller -->
    <form class="form" action="index.php?action=editGenre&id=<?= $_GET["id"] ?>" method="POST" enctype="multipart/form-data">
        <p><label>Titre du genre :</label></p>
            <input value="<?=$genre["nom_genre"] ?>" type="text" class="form_item" name="nom_genre" placeholder="Titre" required>
        
            <p><button type="submit" name="submit" class="more_btn">Editer le genre</button></p>
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
$titre = "Editer un genre";
$titre_secondaire = "Edition d'un genre";
$contenu = ob_get_clean();

//injecter le contenu dans le template > template.php
require "view/template.php"; 
