<!-- On commence et on termine la vue par "ob_start()" et "ob_get_clean()" -->
<?php ob_start(); ?>

<!-- Affichage du nombre de rôles -->
<span id="add_btn_position">
    <a href="index.php?action=addRole" class="add_btn">Ajouter un rôle </a> 
</span>

<div class="cards_list">
    <?php
        foreach($requeteRoles->fetchAll() as $role) { ?>
            <div class="card_item">
                <a href="index.php?action=detailActeur&id=<?= $role["id_acteur"] ?>">
                    <figure class="fade_card">
                        <img src="<?= $role['photo']?>" alt="photo de l'acteur">
                    </figure>
                </a>
                <p><?= $role["acteurs"] ?></p>
                <p><?= "(Rôle: " . $role["role_personnage"] . ")"?></p>
                <p><?= $role["titre"] ?></p>
            </div>  
        <?php } ?>
        
</div> 
<p class="count_list">Il y a <?= $requeteRoles->rowCount() ?> Rôles</p> 
<?php

// Définition des titres pour la vue
$titre = "Liste des rôles";
$titre_secondaire = "Liste des rôles";

$contenu = ob_get_clean();

//injecter le contenu dans le template > template.php
require "view/template.php"; 
