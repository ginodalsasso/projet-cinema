<!-- On commence et on termine la vue par "ob_start()" et "ob_get_clean()" -->
<?php ob_start(); ?>

<!-- Affichage du nombre d'Acteurs -->
<p class="count_list">Il y a <?= $requeteActeurs->rowCount() ?> acteurs</p> 
<a href="index.php?action=addActeur" class="add_btn">Ajouter un acteur </a> 

    <div class="cards_list">
        <?php
            foreach($requeteActeurs->fetchAll() as $acteur) { ?>
                    <div class="card_item">
                        <a href="index.php?action=detailActeur&id=<?= $acteur["id_acteur"] ?>">
                            <figure class="fade_card">
                                <img src="<?= $acteur['photo']?>" alt="photo de l'acteur">
                            </figure>
                        </a>
                        <p><?= $acteur["nomActeur"] ?></p>
                    </div>

            <?php } ?>
    </div>

<?php

// Définition des titres pour la vue
$titre = "Liste des acteurs";
$titre_secondaire = "Liste des acteurs";

$contenu = ob_get_clean();
 //injecter le contenu dans le template > template.php
require "view/template.php";