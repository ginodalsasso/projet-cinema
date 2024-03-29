<!-- On commence et on termine la vue par "ob_start()" et "ob_get_clean()" -->
<?php ob_start(); ?>

<?php 
//requête pour récupérer les infos d'un acteur
$acteur = $choixActeur->fetch();
?>

<!-- formulaire d'édition d'un acteur -->
<section class="wrapper">
    <!-- action redirigeant vers la méthode du controller -->
    <form class="form" action="index.php?action=editActeur&id=<?= $_GET["id"] ?>" method="post" enctype="multipart/form-data">
        <p><label>Selection de l'acteur :</label></p>
           

        <p><label>Nom :</label></p>
            <input value="<?= $acteur["nom"] ?>" type="text" class="form_item" name="nom" required>
        <p><label>Prenom :</label></p>
            <input value="<?= $acteur["prenom"] ?>" type="text" class="form_item" name="prenom" required>
        <p><label>Sexe :</label></p>
            <input value="<?= $acteur["sexe"] ?>" type="text" class="form_item" name="sexe" required>
        <p><label>Date de naissance :</label></p>
            <input value="<?= $acteur["dateNaissance"] ?>" type="date" class="form_item" name="dateNaissance" required>
        <p><label for="file">Ajouter une photo</label></p>
            <input type="file" name="file" class="add_photo" accept="image/jpg, image/png, image/jpeg, image/webp">
        
        <p><button type="submit" name="submit" class="more_btn">Editer l'acteur</button></p>
    </form>
</section>

<?php

// Définition des titres pour la vue
$titre = "Modifier un acteur";
$titre_secondaire = "Edition d'un acteur";
$contenu = ob_get_clean();

//injecter le contenu dans le template > template.php
require "view/template.php"; 
