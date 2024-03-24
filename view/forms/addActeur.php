    <!-- On commence et on termine la vue par "ob_start()" et "ob_get_clean()" -->
<?php ob_start(); ?>

<!-- formulaire d'ajout d'un acteur -->
<section class="form">
    <form action="">
        <p><label>Nom :</label></p>
            <input type="text" class="form_item" name="nom" placeholder="Nom" required>
        <p><label>Prenom :</label></p>
            <input type="text" class="form_item" name="prenom" placeholder="Prénom" required>
        <p><label>Sexe :</label></p>
            <input type="text" class="form_item" name="sexe" placeholder="sexe" required>
        <p><label>Date de naissance :</label></p>
            <input type="date" class="form_item" name="anniversaire" required>
        <p><label for="file">Ajouter une photo</label></p>
            <input type="file" name="file" class="add_photo" accept="image/png, image/jpeg">
        
        <p><button type="submit" name="submit" class="add_btn">Ajouter l'acteur</button></p>
    </form>
</section>

<?php

// Définition des titres pour la vue
$titre = "Ajouter un acteur";
$titre_secondaire = "Ajout d'un acteur";
$contenu = ob_get_clean();

//injecter le contenu dans le template > template.php
require "view/template.php"; 
