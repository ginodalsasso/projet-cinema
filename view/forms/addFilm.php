<!-- On commence et on termine la vue par "ob_start()" et "ob_get_clean()" -->
<?php ob_start(); ?>

<?php $realisateurs = $choixRealisateur->fetchAll();
      $genres = $choixGenre->fetchAll();
?>

<!-- formulaire d'ajout d'un acteur -->
<section class="form">
    <form action="index.php?action=addFilm" method="post" enctype="multipart/form-data">
        <p><label>Titre du film :</label></p>
            <input type="text" class="form_item" name="titre" placeholder="Titre" required>
        <p><label>Parution :</label></p>
            <input type="date" class="form_item" name="parution" required>
        <p><label>Durée :</label></p>
            <input type="number" class="form_item" name="duree" placeholder="Durée (en min)" required>
        <p><label>Note sur 5 :</label></p>
            <input type="number" class="form_item" name="note" placeholder="Note" required>
        <p><label>Synopsis</label></p>
            <textarea name="synopsis" rows="5" placeholder="Synopsis"></textarea>

        <p><label>Réalisateur :</label></p>
        <select name="id_realisateur" id="realisateur-select">
            <!-- select des realisateurs -->
            <?php 
            foreach($realisateurs as $real){ ?>
                    <option value="<?=$real["id_realisateur"]?>"><?=$real["realisateurs"]?></option>
            <?php } ?>
        </select>

        <p><label>Choisissez un genre :</label></p> 
        <!-- checkbox des genres  -->
        <?php foreach($genres as $genre){ ?>
            <p><input type="checkbox" id="<?=$genre["nom"]?>" name="genres[]" value="<?=$genre["id_genre"]?>"/>
            <label for="<?=$genre["nom"]?>"><?=$genre["nom"]?></label> </p>  
                <?php } ?> 
                
        <p><label for="file">Ajouter une affiche</label></p>
            <input type="file" name="file" class="add_photo" accept="image/png, image/jpeg">
        
        <p><button type="submit" name="submit" class="add_btn">Ajouter le film</button></p>
    </form>
</section>

<?php

// Définition des titres pour la vue
$titre = "Ajouter un film";
$titre_secondaire = "Ajout d'un film";
$contenu = ob_get_clean();

//injecter le contenu dans le template > template.php
require "view/template.php"; 
