<!-- On commence et on termine la vue par "ob_start()" et "ob_get_clean()" -->
<?php ob_start(); ?>

<!-- Affichage du nombre de genres -->
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
                    <td>
                        <a href="http://localhost/projet-cinema/index.php?action=detailFilm&id=<?= $genre["id_film"] ?>">
                        <img src="<?= $genre['affiche']?>" alt="affiche du film"></a>
                    </td>
                </tr>
            <?php } ?>
    </tbody>
</table>

<?php

// Définition des titres pour la vue
$titre = "Liste des genres";
$titre_secondaire = "Liste des genres";

$contenu = ob_get_clean();

 //injecter le contenu dans le template > template.php
require "view/template.php";
