<!-- On commence et on termine la vue par "ob_start()" et "ob_get_clean()" -->
<?php ob_start(); ?>

        <!---------------------------- FILMS --------------------------------->
        <div class="cards_list">
            <?php

                foreach($requeteFilmsHome->fetchAll() as $film) { ?>
                        <div class="card_item">
                            <a href="index.php?action=detailFilm&id=<?= $film["id_film"] ?>">
                                <figure class="fade_card"><img src="<?= $film['affiche']?>" alt="affiche du film"></figure>
                            </a>
                            <p><?= $film["note"] ?></p>
                            <p><?= $film["titre"] ?></p>
                            <p><?= $film["parution"] ?></p>
                        </div>
                <?php } ?>
        </div>
        
        <div class="btn_display">
                <button class="more_btn" type="button">
                        <a href="index.php?action=listFilms">En savoir plus</a>
                </button>
        </div>

        <!---------------------------- ACTEURS --------------------------------->
        <div class="cards_list">
                <?php
                foreach($requeteActeursHome->fetchAll() as $acteur) { ?>
                        <div class="card_item">
                                <a href="index.php?action=detailActeur&id=<?= $acteur["id_acteur"] ?>">
                                        <figure class="fade_card"><img src="<?= $acteur['photo']?>" alt="photo de l'acteur"></figure>
                                </a>
                                <p><?= $acteur["nomActeur"] ?></p>
                        </div>       
                <?php } ?>
        </div>
        
        <div class="btn_display">
                <button class="more_btn" type="button">
                        <a href="index.php?action=listFilms">En savoir plus</a>
                </button>
        </div>
        <!---------------------------- REALISATEURS --------------------------------->

        <div class="cards_list">
                <?php
                foreach($requeteRealisateursHome->fetchAll() as $realisateur) { ?>
                        <div class="card_item">
                                <a href="index.php?action=detailRealisateur&id=<?= $realisateur["id_realisateur"] ?>">
                                        <figure class="fade_card"><img src="<?= $realisateur['photo']?>" alt="photo du réalisateur"></figure>
                                </a>
                                <p><?= $realisateur["nomRealisateur"] ?></p>
                        </div>       
                <?php } ?>
        </div>
        
        <div class="btn_display">
                <button class="more_btn" type="button">
                        <a href="index.php?action=listFilms">En savoir plus</a>
                </button>
        </div>

        <!---------------------------- GENRES --------------------------------->

        <div class="cards_list">
                <?php
                foreach($requeteGenresHome->fetchAll() as $genre) { ?>
                        <div class="card_item">
                                <a href="index.php?action=detailFilm&id=<?= $genre["id_film"] ?>">
                                        <figure class="fade_card"><img src="<?= $genre['affiche']?>" alt="affiche du film"></figure>
                                </a>
                                <p><?= $genre["titre"] ?></p>
                                <p><?= $genre["nom_genre"] ?></p>
                        </div>       
                <?php } ?>
        </div>

        <div class="btn_display">
                <button class="more_btn" type="button">
                        <a href="index.php?action=listFilms">En savoir plus</a>
                </button>
        </div>
        <!---------------------------- ROLES --------------------------------->

        <div class="cards_list">
                <?php
                foreach($requeteRolesHome->fetchAll() as $role) { ?>
                        <div class="card_item">
                                <a href="index.php?action=detailActeur&id=<?= $role["id_acteur"] ?>">
                                        <figure class="fade_card"><img src="<?= $role['photo']?>" alt="photo de l'acteur"></figure>
                                </a>
                                <p><?= $role["acteurs"] ?></p>
                                <p><?= "(Rôle: " . $role["role_personnage"] . ")" ?></p>
                                <p><?= $role["titre"] ?></p>
                        </div>       
                <?php } ?>
        </div>

        <div class="btn_display">
                <button class="more_btn" type="button">
                        <a href="index.php?action=listFilms">En savoir plus</a>
                </button>
        </div>
<?php

// Définition des titres pour la vue
$titre = "Home";
$titre_secondaire = "Home";
$contenu = ob_get_clean();

//injecter le contenu dans le template > template.php
require "view/template.php"; 
