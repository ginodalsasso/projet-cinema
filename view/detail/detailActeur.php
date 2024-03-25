<!-- On commence et on termine la vue par "ob_start()" et "ob_get_clean()" -->
<?php ob_start(); ?>

<?php 
// Récupération des données de l'acteur et de ses films
$acteur = $requeteActeur->fetch();
$filmActeur = $requeteFilmActeur->fetchAll();?>

<div>
    <img src="<?= $acteur['photo']?>" alt="photo de l'acteur">
    <p>Date de naissance: <?= $acteur["dateNaissance"]?></p>
    <p>Sexe: <?= $acteur["sexe"]?></p>
</div>

<!-- tableau affichant les détails de l'acteur -->
<table>sgfb
    <thead>
        <tr>
            <th>titre</th>
            <th>parution</th>
            <th>role</th>
            <th>id film</th>
            <th>id role</th>
            <th>photo</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($filmActeur as $film) { ?>
                <tr>
                    <td><?= $film["titre"] ?></td>
                    <td><?= $film["parution"] ?></td>
                    <td><?= $film["role_personnage"] ?></td>
                    <td><?= $film["id_film"] ?></td>
                    <td><?= $film["id_role"] ?></td>
                    <td>
                        <a href="index.php?action=detailFilm&id=<?= $film["id_film"] ?>">
                        <img src="<?= $film['affiche']?>" alt="affiche du film"></a>
                    </td>
                </tr>
            <?php } ?>
    </tbody>
</table>

<?php

// Définition des titres pour la vue
$titre = "Détail acteurs";
$titre_secondaire = $acteur["nomActeur"]; //titre variable en fonction de l'acteur

$contenu = ob_get_clean();

//injecter le contenu dans le template > template.php
require "view/template.php"; 
