<!-- On commence et on termine la vue par "ob_start()" et "ob_get_clean()" -->
<?php ob_start(); ?>

<?php 
// Récupération des données du réalisateur et des films réalisés
$realisateur = $requeteRealisateur->fetch();
$filmRealisateur = $requeteFilmRealisateur->fetchAll();?>

<!-- Affichage des informations sur le réalisateur -->
<div>
    <img src="<?= $realisateur['photo']?>" alt="photo du réalisateur">
    <p>Date de naissance: <?= $realisateur["dateNaissance"]?></p>
    <p>Sexe: <?= $realisateur["sexe"]?></p>
</div>

<!-- tableau affichant les films réalisés par ce réalisateur -->
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
                    <td>
                        <a href="http://localhost/projet-cinema/index.php?action=detailFilm&id=<?= $film["id_film"] ?>">
                        <img src="<?= $film['affiche']?>" alt="affiche du film"></a>
                    </td>
                </tr>
            <?php } ?>
    </tbody>
</table>

<?php

// Définition des titres pour la vue
$titre = "Détail acteurs";
$titre_secondaire = $realisateur["nomRealisateur"]; //titre variable en fonction de l'acteur

$contenu = ob_get_clean();

//injecter le contenu dans le template > template.php
require "view/template.php"; 
