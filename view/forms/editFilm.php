<!-- On commence et on termine la vue par "ob_start()" et "ob_get_clean()" -->
<?php ob_start(); ?>

<?php 
//requête pour récupérer les infos d'un film
$film = $choixFilm->fetch();
$realisateurs = $choixRealisateur->fetchAll();
$genres = $choixGenre->fetchAll();
$currentTime = new DateTime('now');
?>

<!-- formulaire d'édition d'un acteur -->
<section class="wrapper">
    <!-- action redirigeant vers la méthode du controller -->

    <form class="form" action="index.php?action=editFilm&id=<?= $_GET["id"] ?>" method="post" enctype="multipart/form-data">
        <p><label>Selection du film :</label></p>
           
        <p><label>Titre du film :</label></p>
            <input value="<?= $film["titre"] ?>" type="text" class="form_item" name="titre" required>
        <p><label>Parution :</label></p>
            <input value="<?= $film["parution"] ?>" type="date" max="2024-04-30" class="form_item" name="parution" required>
        <p><label>Durée :</label></p>
            <input value="<?= $film["duree"] ?>" type="number" min="0" max="999" class="form_item" name="duree" required>
        <p><label>Note sur 5 :</label></p>
            <input value="<?= $film["note"] ?>" type="number" min="0" max="5" class="form_item" name="note" required>
        <p><label>Synopsis</label></p>
            <textarea value="<?= $film["synopsis"] ?>" name="synopsis" rows="5" required></textarea>


        <p><label>Réalisateur :</label></p>
        <select name="id_realisateur" id="realisateur-select">
            <!-- select des realisateurs -->
            <?php 
            foreach($realisateurs as $real){
            // Vérifie si l'ID du réalisateur actuel correspond à l'ID du réalisateur associé au film en cours, Si oui, $selected est défini à 'selected', sinon il est défini comme vide
            $selected = ($real['id_realisateur'] == $film['id_realisateur']) ? 'selected' : '' ; ?>
                    <option value="<?=$real["id_realisateur"]?>" <?=$selected?> ><?=$real["nomRealisateur"]?></option>
            <?php } ?>
        </select>
        
        
        <p><label>Choisissez un genre :</label></p> 
        <!-- checkbox des genres  -->
        <?php foreach($genres as $genre){ 
            // Vérifie si l'ID du genre actuel est présent dans le tableau $idGenre, si oui, $checked est défini à 'checked', sinon il est défini comme vide, Si la condition est vraie ($real['id_realisateur'] est égal à $film['id_realisateur']), alors 'selected' est attribué à la variable $selected.
            $checked = (in_array($genre['id_genre'], $idGenre)) ? 'checked' : ''; ?>
            <p><input type="checkbox" id="<?=$genre["nom_genre"]?>" name="genres[]" value="<?=$genre["id_genre"]?>" <?= $checked ?>/>
            <label for="<?=$genre["nom_genre"]?>"><?=$genre["nom_genre"]?></label> </p>  
        <?php } ?> 

          
        <p><label for="file">Ajouter une affiche</label></p>
        <input type="file" name="file" class="add_photo" accept="image/png, image/jpeg, image/webp">


        <p><button type="submit" name="submit" class="add_btn">Editer le film</button></p>
    </form>
</section>

<?php

// Définition des titres pour la vue
$titre = "Modifier un film";
$titre_secondaire = "Edition d'un film";
$contenu = ob_get_clean();

//injecter le contenu dans le template > template.php
require "view/template.php"; 
