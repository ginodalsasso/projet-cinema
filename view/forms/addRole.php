<!-- On commence et on termine la vue par "ob_start()" et "ob_get_clean()" -->
<?php ob_start(); ?>


<!-- formulaire d'ajout d'un rôle -->
<section class="form">
    <!-- action redirigeant vers la méthode du controller -->
    <form action="index.php?action=addRole" method="post">
        <p><label>Nom du rôle :</label></p>
            <input type="text" class="form_item" name="role_personnage" placeholder="nom du rôle" required>
        
        <p><button type="submit" name="submit" class="more_btn">Ajouter le rôle</button></p>
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
$titre = "Ajouter un rôle";
$titre_secondaire = "Ajout d'un rôle";
$contenu = ob_get_clean();

//injecter le contenu dans le template > template.php
require "view/template.php"; 
