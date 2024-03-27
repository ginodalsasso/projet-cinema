<!-- On commence et on termine la vue par "ob_start()" et "ob_get_clean()" -->
<?php ob_start(); ?>

<?php 
// Récupération des données du film et de son casting
$film = $requeteFilm->fetch();
$castings = $requeteCasting->fetchAll();
$Genre = $requeteGenre->fetch()?>

<!-- Affichage des informations sur le film -->
<div>
    <img src="<?= $film['affiche']?>" alt="photo du film">
    <p>Parution: <?= $film["parution"]?></p>
    <p>Durée: <?= $film["duree"]?>min</p>
    <p>Note: <?= $film["note"]?></p>
    <p>De <a href="index.php?action=detailRealisateur&id=<?= $film["id_realisateur"] ?>"><?= $film["nom_realisateur"]?></p></a>
    <p>Genre: <?= $Genre["nom_genre"]?></p>

</div>

<!--tableau affichant le casting du film -->
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
                    <td><?= $casting["id_role"] ?></td>
                    <td>
                        <a href="index.php?action=detailActeur&id=<?= $casting["id_acteur"] ?>">
                        <img src="<?= $casting['photo']?>" alt="affiche de l'acteur"></a>
                    </td>
                </tr>
            <?php } ?>
    </tbody>
</table>


<a href="index.php?action=addCasting" class="add_btn">Ajouter un casting </a> 

<?php

// Définition des titres pour la vue
$titre = "Détail Film";
$titre_secondaire = $film["titre"]; //titre variable en fonction de l'acteur

//injecter le contenu dans le template > template.php
$contenu = ob_get_clean();
require "view/template.php"; //injecter le contenu dans le template > template.php