<!-- On commence et on termine la vue par "ob_start()" et "ob_get_clean()" -->
<?php ob_start(); ?>

<!-- Affichage du nombre de films -->
<p>Il y a <?= $requeteFilms->rowCount() ?> films</p> 

<table>
    <thead>
        <tr>
            <th>TITRE</th>
            <th>ANNEE SORTIE</th>
            <th>AFFICHE</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($requeteFilms->fetchAll() as $film) { ?>
                <tr>
                    <td><?= $film["titre"] ?></td>
                    <td><?= $film["parution"] ?></td>
                    <td><img src="<?= $film['affiche']?>" alt="affiche du film"></td>
                </tr>
            <?php } ?>
    </tbody>
</table>

<?php

// Définition des titres pour la vue
$titre = "Liste des films";
$titre_secondaire = "Liste des films";
$contenu = ob_get_clean();

//injecter le contenu dans le template > template.php
require "view/template.php"; 
