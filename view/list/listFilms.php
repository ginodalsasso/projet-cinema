<!-- On commence et on termine la vue par "ob_start()" et "ob_get_clean()" -->
<?php ob_start(); ?>

<!-- Affichage du nombre de films -->
<p class="count_list">Il y a <?= $requeteFilms->rowCount() ?> films</p> 

        <div class="cards_list">
            <?php

                foreach($requeteFilms->fetchAll() as $film) { ?>
                        <div class="card_item">
                            <figure class="fade_card"><img src="<?= $film['affiche']?>" alt="affiche du film"></figure>
                            <p><?= $film["note"] ?></p>
                            <p><?= $film["titre"] ?></p>
                            <p><?= $film["parution"] ?></p>
                        </div>

                <?php } ?>
        </div>

<?php

// Définition des titres pour la vue
$titre = "Liste des films";
$titre_secondaire = "Liste des films";
$contenu = ob_get_clean();

//injecter le contenu dans le template > template.php
require "view/template.php"; 
