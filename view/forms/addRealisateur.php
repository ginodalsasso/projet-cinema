    <!-- On commence et on termine la vue par "ob_start()" et "ob_get_clean()" -->
    <?php ob_start(); ?>


<!-- formulaire d'ajout d'un réalisateur -->
<section class="wrapper">
    <!-- action redirigeant vers la méthode du controller -->
    <form class="form" action="index.php?action=addRealisateur" method="post" enctype="multipart/form-data">
        <p><label>Nom :</label></p>
            <input type="text" class="form_item" name="nom" placeholder="Nom" required>
        <p><label>Prenom :</label></p>
            <input type="text" class="form_item" name="prenom" placeholder="Prénom" required>
        <p><label>Sexe :</label></p>
            <input type="text" class="form_item" name="sexe" placeholder="sexe" required>
        <p><label>Date de naissance :</label></p>
            <input type="date" class="form_item" name="dateNaissance" required>
        <p><label for="file">Ajouter une photo</label></p>
            <input type="file" name="file" class="add_photo" accept="image/jpg, image/png, image/jpeg, image/webp">
        
        <p><button type="submit" name="submit" class="more_btn">Ajouter le réalisateur</button></p>
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
$titre = "Ajouter un réalisateur";
$titre_secondaire = "Ajout d'un réalisateur";
$contenu = ob_get_clean();

//injecter le contenu dans le template > template.php
require "view/template.php"; 
