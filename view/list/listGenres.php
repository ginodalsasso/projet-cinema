<!-- On commence et on termine la vue par "ob_start()" et "ob_get_clean()" -->
<?php ob_start(); ?>

<!-- Affichage du nombre de genres -->
<span id="add_btn_position">
    <a href="index.php?action=addGenre" class="add_btn">Ajouter un genre </a> 
</span>


<div class="cards_list">
    <?php
        foreach($requeteGenres->fetchAll() as $genre) { ?>
            <div class="card_item">
                <a href="index.php?action=detailGenre&id=<?= $genre["id_film"] ?>">
                    <figure class="fade_card">
                        <img src="<?= $genre['affiche']?>" alt="affiche du film">
                    </figure>
                </a>
                <p><?= $genre["titre"] ?></p>
                <p><?= $genre["nom_genre"] ?></p>
            </div>
        <?php } ?>

</div>
<p class="count_list">Il y a <?= $requeteGenres->rowCount() ?> Genres</p> 

<?php

// Définition des titres pour la vue
$titre = "Liste des genres";
$titre_secondaire = "Liste des genres";

$contenu = ob_get_clean();

 //injecter le contenu dans le template > template.php
require "view/template.php";
