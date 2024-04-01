<!-- On commence et on termine la vue par "ob_start()" et "ob_get_clean()" -->
<?php ob_start(); ?>

<?php 
// Récupération des données du film et de son casting
$film = $requeteFilm->fetch();
$castings = $requeteCasting->fetchAll();
$Genre = $requeteGenre->fetch()?>

<span id="add_btn_position">
    <a class="add_btn" href="index.php?action=editFilm&id=<?= $film["id_film"] ?>">Editer le film</a>
</span>

<span id="add_btn_position">
    <a class="add_btn" href="index.php?action=delFilm&id=<?= $film["id_film"] ?>">Supprimer le film</a>
</span>

<!-- Affichage des informations sur le film -->
<div class="wrapper">
    <div class="detail">
        <figure class="fade_card">
            <img src="<?= $film['affiche']?>" alt="photo du film">
        </figure>   
        <p>Parution: <?= $film["parution"]?></p>
        <p>Durée: <?= $film["duree"]?>min</p>
        <p>Note: <?= $film["note"]?></p>
        <p>Réalisé par: <br> <a href="index.php?action=detailRealisateur&id=<?= $film["id_realisateur"] ?>"> <?= $film["nom_realisateur"]?></p></a>
        <p>Genre: <?= $Genre["nom_genre"]?></p>
    </div>


    <!--casting du film -->
    <h3>Casting</h3>
    <div class="cards_list">
        <?php
            foreach($castings as $casting) { ?>
                <div class="card_item">
                    <a href="index.php?action=detailActeur&id=<?= $casting["id_acteur"] ?>">
                        <figure class="fade_card">
                            <img src="<?= $casting['photo']?>" alt="affiche de l'acteur">    
                        </figure>
                    </a>
                    <p><?= $casting["nomActeur"] ?></p>
                    <p><?= $casting["role_personnage"] ?></p>
                </div>

        <?php } ?>
    </div>
</div>

<span id="add_btn_position">
    <a href="index.php?action=addCasting" class="add_btn">Ajouter un casting </a> 
</span>

<?php

// Définition des titres pour la vue
$titre = "Détail Film";
$titre_secondaire = $film["titre"]; //titre variable en fonction de l'acteur

//injecter le contenu dans le template > template.php
$contenu = ob_get_clean();
require "view/template.php"; //injecter le contenu dans le template > template.php