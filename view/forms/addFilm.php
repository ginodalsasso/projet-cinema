<!-- On commence et on termine la vue par "ob_start()" et "ob_get_clean()" -->
<?php ob_start(); ?>

<!-- formulaire d'ajout d'un acteur -->
<section class="form">
    <form action="">
        <p><label>Titre du film :</label></p>
            <input type="text" class="form_item" name="titre" placeholder="Titre" required>
        <p><label>Parution :</label></p>
            <input type="date" class="form_item" name="parution" required>
        <p><label>Durée :</label></p>
            <input type="number" class="form_item" name="durée" placeholder="Durée" required>
        <p><label>Note sur 5 :</label></p>
            <input type="number" class="form_item" name="note" placeholder="Note" required>
        <p><label>Synopsis</label></p>
            <textarea name="synopsis" rows="5" placeholder="Synopsis"></textarea>
            
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
