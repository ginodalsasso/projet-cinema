<!-- On commence et on termine la vue par "ob_start()" et "ob_get_clean()" -->
<?php ob_start(); ?>

<p>Il y a <?= $requete->rowCount() ?> Rôles</p> 

<table>
    <thead>
        <tr>
            <th>id_personnes</th>
            <th>id_acteurs</th>
            <th>acteurs</th>
            <th>rôles</th>
            <th>films</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($requete->fetchAll() as $role) { ?>
                <tr>
                    <td><?= $role["id_acteur"] ?></td>
                    <td><?= $role["id_personne"] ?></td>
                    <td><?= $role["acteurs"] ?></td>
                    <td><?= $role["role_personnage"] ?></td>
                    <td><?= $role["titre"] ?></td>
                </tr>
            <?php } ?>
    </tbody>
</table>

<?php

$titre = "Liste des rôles";
$titre_secondaire = "Liste des rôles";

$contenu = ob_get_clean();
require "view/template.php"; //injecter le contenu dans le template > template.php
