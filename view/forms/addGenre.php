<!-- On commence et on termine la vue par "ob_start()" et "ob_get_clean()" -->
<?php ob_start(); ?>

<!-- formulaire d'ajout d'un genre -->
<section class="form">
    <!-- action redirigeant vers la méthode du controller -->
    <form action="index.php?action=addGenre" method="post">
        <p><label>Titre du genre :</label></p>
            <input type="text" class="form_item" name="titre" placeholder="Titre" required>
        
        <p><button type="submit" name="submit" class="add_btn">Ajouter le genre</button></p>
    </form>
</section>

<?php

// Définition des titres pour la vue
$titre = "Ajouter un genre";
$titre_secondaire = "Ajout d'un genre";
$contenu = ob_get_clean();

//injecter le contenu dans le template > template.php
require "view/template.php"; 
