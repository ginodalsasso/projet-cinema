<!-- On commence et on termine la vue par "ob_start()" et "ob_get_clean()" -->
<?php ob_start(); ?>

<p>Il y a <?= $requeteGenres->rowCount() ?> Genres</p> 

<table>
    <thead>
        <tr>
            <th>titre</th>
            <th>Genre</th>
            <th>Afficher</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($requeteGenres->fetchAll() as $genre) { ?>
                <tr>
                    <td><?= $genre["titre"] ?></td>
                    <td><?= $genre["nom_genre"] ?></td>
                    <td><img src="<?= $genre['affiche']?>" alt="affiche du film"></td>
                </tr>
            <?php } ?>
    </tbody>
</table>

<?php

$titre = "Liste des genres";
$titre_secondaire = "Liste des genres";

$contenu = ob_get_clean();
require "view/template.php"; //injecter le contenu dans le template > template.php
