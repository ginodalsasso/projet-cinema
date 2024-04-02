<!-- On commence et on termine la vue par "ob_start()" et "ob_get_clean()" -->
<?php ob_start(); ?>

<?php 
// Récupération de tous les genres de films
$detailGenre = $requeteDetailGenre->fetch();
$genres = $requeteGenre->fetchAll();?>


<span id="add_btn_position">
    <a class="add_btn" href="index.php?action=editGenre&id=<?= $detailGenre["id_genre"] ?>">Editer le genre</a>
</span>

<span id="add_btn_position">
    <a class="add_btn" href="index.php?action=delGenre&id=<?= $detailGenre["id_genre"] ?>">Supprimer le genre</a>
</span>

<!--tableau affichant les genres de films -->
    
<div class="cards_list">
    <?php
        foreach($genres as $genre) { ?>
            <div class="card_item">
                <a href="index.php?action=detailFilm&id=<?= $genre["id_film"] ?>">
                    <figure class="fade_card">
                        <img src="<?= $genre['affiche']?>" alt="affiche du film">
                    </figure>
                </a>        
                <p><?= $genre["titre"] ?></p>
                <p><?= $genre["parution"] ?></p>
                <p><?= $genre["nom_genre"] ?></p>
            </div>
        <?php } ?>
</div>   

<?php

// Définition des titres pour la vue
$titre = "Détail Genre";
$titre_secondaire = "Détail Genre"; //titre variable en fonction du genre

//injecter le contenu dans le template > template.php
$contenu = ob_get_clean();
require "view/template.php"; //injecter le contenu dans le template > template.php