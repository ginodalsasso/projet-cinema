<!-- On commence et on termine la vue par "ob_start()" et "ob_get_clean()" -->
<?php ob_start(); ?>

<?php 
$films = $choixFilm->fetchAll();
$acteurs = $choixActeur->fetchAll();
$roles = $choixRole->fetchAll();
// var_dump($_POST['submit']);
?>

<!-- formulaire d'ajout d'un casting -->
<section class="form">
    <form action="index.php?action=addCasting" method="post" enctype="multipart/form-data">

        <p><label>Selection du film :</label></p>
        <!-- select des films -->
        <select name="id_film" id="film-select">
            <?php 
            foreach($films as $film){ ?>
                    <option value="<?=$film["id_film"]?>"><?=$film["titre"]?></option>
            <?php } ?>
        </select>

        <p><label>Acteurs :</label></p>
        <!-- select des acteurs -->
        <select name="id_acteur" id="acteur-select">
            <?php 
            foreach($acteurs as $acteur){ ?>
                    <option value="<?=$acteur["id_acteur"]?>"><?=$acteur["nomActeur"]?></option>
            <?php } ?>
        </select>

        <p><label>Rôles :</label></p>
        <!-- select des rôles -->
        <select name="id_role" id="role-select">
            <?php 
            foreach($roles as $role){ ?>
                    <option value="<?=$role["id_role"]?>"><?=$role["role_personnage"]?></option>
            <?php } ?>
        </select>
        
        <p><button type="submit" name="submit" class="add_btn">Ajouter le casting</button></p>
    </form>
</section>

<?php

// Définition des titres pour la vue
$titre = "Ajouter un casting";
$titre_secondaire = "Ajout d'un casting";
$contenu = ob_get_clean();

//injecter le contenu dans le template > template.php
require "view/template.php"; 
