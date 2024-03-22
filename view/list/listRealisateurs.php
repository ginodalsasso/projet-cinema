<!-- On commence et on termine la vue par "ob_start()" et "ob_get_clean()" -->
<?php ob_start(); ?>

<p>Il y a <?= $requeteRealisateurs->rowCount() ?> réalisateurs</p> 

<table>
    <thead>
        <tr>
            <th>id</th>
            <th>Réalisateurs</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($requeteRealisateurs->fetchAll() as $realisateur) { ?>
                <tr>
                    <td><?= $realisateur["id_realisateur"] ?></td>
                    <td><?= $realisateur["nomRealisateur"] ?></td>
                </tr>
            <?php } ?>
    </tbody>
</table>

<?php

$titre = "Liste des réalisateurs";
$titre_secondaire = "Liste des réalisateurs";

$contenu = ob_get_clean();
require "view/template.php"; //injecter le contenu dans le template > template.php
