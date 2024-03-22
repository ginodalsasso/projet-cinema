<!-- On commence et on termine la vue par "ob_start()" et "ob_get_clean()" -->
<?php ob_start(); ?>

<p>Il y a <?= $requeteActeurs->rowCount() ?> acteurs</p> 

<table>
    <thead>
        <tr>
            <th>id</th>
            <th>Acteurs</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($requeteActeurs->fetchAll() as $acteur) { ?>
                <tr>
                    <td><?= $acteur["id_acteur"] ?></td>
                    <td><?= $acteur["nomActeur"] ?></td>
                </tr>
            <?php } ?>
    </tbody>
</table>

<?php

$titre = "Liste des acteurs";
$titre_secondaire = "Liste des acteurs";

$contenu = ob_get_clean();
require "view/template.php"; //injecter le contenu dans le template > template.php
