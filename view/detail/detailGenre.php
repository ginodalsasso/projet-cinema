<!-- On commence et on termine la vue par "ob_start()" et "ob_get_clean()" -->
<?php ob_start(); ?>

<?php 
// Récupération de tous les genres de films
$genres = $requeteGenre->fetchAll();?>

<!--tableau affichant les genres de films -->
<table>
    <thead>
        <tr>
            <th>Affiche</th>
            <th>Titre</th>
            <th>Parution</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($genres as $genre) { ?>
                <tr>
                    <td><img src="<?= $genre['affiche']?>" alt="affiche du film"></td>
                    <td><?= $genre["titre"] ?></td>
                    <td><?= $genre["parution"] ?></td>
                </tr>
            <?php } ?>
    </tbody>
</table>

<?php

// Définition des titres pour la vue
$titre = "Détail Genre";
$titre_secondaire = $genre["nom_genre"]; //titre variable en fonction de l'acteur

//injecter le contenu dans le template > template.php
$contenu = ob_get_clean();
require "view/template.php"; //injecter le contenu dans le template > template.php