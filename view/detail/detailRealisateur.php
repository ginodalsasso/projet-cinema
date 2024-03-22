<!-- On commence et on termine la vue par "ob_start()" et "ob_get_clean()" -->
<?php ob_start(); ?>

<?php 
$realisateur = $requeteRealisateur->fetch();
$filmRealisateur = $requeteFilmRealisateur->fetchAll();?>

<div>
    <img src="<?= $realisateur['photo']?>" alt="photo du réalisateur">
    <p>Date de naissance: <?= $realisateur["dateNaissance"]?></p>
    <p>Sexe: <?= $realisateur["sexe"]?></p>
</div>


<table>
    <thead>
        <tr>
            <th>titre</th>
            <th>parution</th>
            <th>id film</th>
            <th>photo</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($filmRealisateur as $film) { ?>
                <tr>
                    <td><?= $film["titre"] ?></td>
                    <td><?= $film["parution"] ?></td>
                    <td><?= $film["id_film"] ?></td>
                    <td><img src="<?= $film['affiche']?>" alt="affiche du film"></td>
                </tr>
            <?php } ?>
    </tbody>
</table>

<?php

$titre = "Détail acteurs";
$titre_secondaire = $realisateur["nomRealisateur"]; //titre variable en fonction de l'acteur

$contenu = ob_get_clean();
require "view/template.php"; //injecter le contenu dans le template > template.php
