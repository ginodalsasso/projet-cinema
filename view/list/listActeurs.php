<!-- On commence et on termine la vue par "ob_start()" et "ob_get_clean()" -->
<?php ob_start(); ?>
<!-- Affichage du nombre d'Acteurs -->
<p>Il y a <?= $requeteActeurs->rowCount() ?> acteurs</p> 

<table>
    <thead>
        <tr>
            <th>id</th>
            <th>Acteurs</th>
            <th>Photos</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($requeteActeurs->fetchAll() as $acteur) { ?>
                <tr>
                    <td><?= $acteur["id_acteur"] ?></td>
                    <td><?= $acteur["nomActeur"] ?></td>
                    <td><img src="<?= $acteur['photo']?>" alt="photo de l'acteur"></td>
                </tr>
            <?php } ?>
    </tbody>
</table>

<?php

// Définition des titres pour la vue
$titre = "Liste des acteurs";
$titre_secondaire = "Liste des acteurs";

$contenu = ob_get_clean();
 //injecter le contenu dans le template > template.php
require "view/template.php";
