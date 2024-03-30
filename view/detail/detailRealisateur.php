<!-- On commence et on termine la vue par "ob_start()" et "ob_get_clean()" -->
<?php ob_start(); ?>

<?php 
// Récupération des données du réalisateur et des films réalisés
$realisateur = $requeteRealisateur->fetch();
$filmRealisateur = $requeteFilmRealisateur->fetchAll();?>


<span id="add_btn_position">
    <a class="add_btn" href="index.php?action=editRealisateur&id=<?= $realisateur["id_personne"] ?>">Editer realisateur</a>
</span>
<!-- Affichage des informations sur le réalisateur -->
<div class="wrapper">
    <div class="detail">
        <figure class="fade_card">
            <img src="<?= $realisateur['photo']?>" alt="photo du réalisateur">
        </figure>
        <p>Date de naissance: <?= $realisateur["dateNaissance"]?></p>
        <p>Sexe: <?= $realisateur["sexe"]?></p>
    </div>

    <!-- liste des films réalisés par le réalisateur -->
        <h3>Films réalisés:</h3>
        <div class="cards_list">
            <?php
                foreach($filmRealisateur as $film) { ?>
                    <div class="card_item">
                        <a href="index.php?action=detailFilm&id=<?= $film["id_film"] ?>">
                            <figure class="fade_card">
                                <img src="<?= $film['affiche']?>" alt="affiche du film">    
                            </figure>
                        </a>
                        <p><?= $film["titre"] ?></p>
                        <p><?= $film["parution"] ?></p>
                    </div>

                <?php } ?>
        </div>
    </div>
<?php

// Définition des titres pour la vue
$titre = "Détail réalisateur";
$titre_secondaire = $realisateur["nomRealisateur"]; //titre variable en fonction de l'acteur

$contenu = ob_get_clean();

//injecter le contenu dans le template > template.php
require "view/template.php"; 
