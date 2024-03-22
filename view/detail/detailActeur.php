<!-- On commence et on termine la vue par "ob_start()" et "ob_get_clean()" -->
<?php ob_start(); ?>

<?php 
$acteur = $requeteActeur->fetch();
$filmActeur = $requeteFilmActeur->fetchAll();?>

<div>
    <img src="<?= $acteur['photo']?>" alt="photo de l'acteur">
    <p>Date de naissance: <?= $acteur["dateNaissance"]?></p>
    <p>Sexe: <?= $acteur["sexe"]?></p>
</div>


<table>
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
                    <td><img src="<?= $film['affiche']?>" alt="affiche du film"></td>
                </tr>
            <?php } ?>
    </tbody>
</table>

<?php

$titre = "Détail acteurs";
$titre_secondaire = $acteur["nomActeur"]; //titre variable en fonction de l'acteur

$contenu = ob_get_clean();
require "view/template.php"; //injecter le contenu dans le template > template.php
