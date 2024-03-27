<!-- On commence et on termine la vue par "ob_start()" et "ob_get_clean()" -->
<?php ob_start(); ?>

<!-- Affichage du nombre de réalisateurs -->
<p class="count_list">Il y a <?= $requeteRealisateurs->rowCount() ?> réalisateurs</p> 
<a href="index.php?action=addRealisateur" class="add_btn">Ajouter un réalisateur </a> 

    <div class="cards_list">
        <?php
            foreach($requeteRealisateurs->fetchAll() as $realisateur) { ?>
                <div class="card_item">
                    <a href="index.php?action=detailRealisateur&id=<?= $realisateur["id_realisateur"] ?>">
                        <figure class="fade_card">
                            <img src="<?= $realisateur['photo']?>" alt="photo du réalisateur">
                        </figure>
                    </a>
                    <p><?= $realisateur["nomRealisateur"] ?></p>
                </div>

            <?php } ?>

<?php

// Définition des titres pour la vue
$titre = "Liste des réalisateurs";
$titre_secondaire = "Liste des réalisateurs";

$contenu = ob_get_clean();

//injecter le contenu dans le template > template.php
require "view/template.php"; 
