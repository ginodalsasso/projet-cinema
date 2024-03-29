<!-- On commence et on termine la vue par "ob_start()" et "ob_get_clean()" -->
<?php ob_start(); ?>

<?php 
// Récupération de tous les genres de films
$detailGenre = $requeteDetailGenre->fetch();
$genres = $requeteGenre->fetchAll();?>

<!--tableau affichant les genres de films -->
        <?php
            foreach($genres as $genre) { ?>
                <tr>
                    <td>
                        <a href="index.php?action=detailFilm&id=<?= $genre["id_film"] ?>">
                        <img src="<?= $genre['affiche']?>" alt="affiche du film"></a>
                    </td>
                    <td><?= $genre["titre"] ?></td>
                    <td><?= $genre["parution"] ?></td>
                </tr>
            <?php } ?>

<?php

// Définition des titres pour la vue
$titre = "Détail Genre";
$titre_secondaire = "Détail Genre"; //titre variable en fonction de l'acteur

//injecter le contenu dans le template > template.php
$contenu = ob_get_clean();
require "view/template.php"; //injecter le contenu dans le template > template.php