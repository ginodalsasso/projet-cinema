<!-- On commence et on termine la vue par "ob_start()" et "ob_get_clean()" -->
<?php ob_start(); ?>

<?php 
$film = $requeteFilm->fetch();
$castings = $requeteCasting->fetchAll();?>

<div>
    <img src="<?= $film['affiche']?>" alt="photo du film">
    <p>Parution: <?= $film["parution"]?></p>
    <p>Durée: <?= $film["duree"]?>min</p>
    <p>Note: <?= $film["note"]?></p>
    <p>De <?= $film["nom_realisateur"]?></p>

</div>

<h3>Casting</h3>
<table>
    <thead>
        <tr>
            <th>Acteurs</th>
            <th>Id acteurs</th>
            <th>Rôle</th>
            <th>Id role</th>
            <th>photo</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($castings as $casting) { ?>
                <tr>
                    <td><?= $casting["nomActeur"] ?></td>
                    <td><?= $casting["id_acteur"] ?></td>
                    <td><?= $casting["role_personnage"] ?></td>
                    <td><?= $casting["id_role"] ?></td>
                    <td><img src="<?= $casting['photo']?>" alt="affiche de l'acteur"></td>
                </tr>
            <?php } ?>
    </tbody>
</table>

<?php

$titre = "Détail Film";
$titre_secondaire = $film["titre"]; //titre variable en fonction de l'acteur

$contenu = ob_get_clean();
require "view/template.php"; //injecter le contenu dans le template > template.php