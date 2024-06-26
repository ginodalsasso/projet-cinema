<!-- On commence et on termine la vue par "ob_start()" et "ob_get_clean()" -->
<?php ob_start(); ?>

<?php 
// Récupération des données de l'acteur et de ses films
$acteur = $requeteActeur->fetch();
$filmActeur = $requeteFilmActeur->fetchAll();

if (isset($_SESSION['message'])){
    echo $_SESSION['message'] ;
    unset($_SESSION['message']);
}
?>

<span id="add_btn_position">
    <a class="add_btn" href="index.php?action=editActeur&id=<?= $acteur["id_personne"] ?>">Editer l'acteur</a>
</span>

<span id="add_btn_position">
<!-- paramètres 'personneId' et 'acteurId' dans l'URL -->
    <a class="add_btn" href="index.php?action=delActeur&acteurId=<?= $acteur["id_acteur"] ?>&personneId=<?= $acteur['id_personne'] ?>">Supprimer l'acteur</a>
</span>

<!-- Affichage des informations sur l'acteur -->
<div class="wrapper">
    <div class="detail">
        <div class="detail_display_img">
            <figure class="fade_card">
                <img src="<?= $acteur['photo']?>" alt="photo de l'acteur">
            </figure>
        </div>
        <div class="detail_display_txt">
            <p>Date de naissance: <?= $acteur["dateNaissance"]?></p>
            <p>Sexe: <?= $acteur["sexe"]?></p>
        </div>
    </div>


    <!-- liste des films joués par l'acteur -->
        <h3>Films joués:</h3>
        <div class="cards_list">
            <?php
                foreach($filmActeur as $film) { ?>
                    <div class="card_item">
                        <a href="index.php?action=detailFilm&id=<?= $film["id_film"] ?>">
                            <figure class="fade_card">
                                <img src="<?= $film['affiche']?>" alt="affiche du film">    
                            </figure>
                        </a>
                        <p><?= $film["titre"] ?></p>
                        <p><?= $film["parution"] ?></p>
                        <p><?= $film["role_personnage"] ?></p>
                    </div>

            <?php } ?>
        </div>
    </div>

<?php

// Définition des titres pour la vue
$titre = "Détail acteurs";
$titre_secondaire = $acteur["nomActeur"]; //titre variable en fonction de l'acteur

$contenu = ob_get_clean();

//injecter le contenu dans le template > template.php
require "view/template.php"; 
