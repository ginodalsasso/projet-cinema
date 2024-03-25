<!-- On commence et on termine la vue par "ob_start()" et "ob_get_clean()" -->
<?php ob_start(); ?>

<!-- Affichage du nombre de réalisateurs -->
<p>Il y a <?= $requeteRealisateurs->rowCount() ?> réalisateurs</p> 

<table>
    <thead>
        <tr>
            <th>id</th>
            <th>Réalisateurs</th>
            <th>Photo</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($requeteRealisateurs->fetchAll() as $realisateur) { ?>
                <tr>
                    <td><?= $realisateur["id_realisateur"] ?></td>
                    <td><?= $realisateur["nomRealisateur"] ?></td>
                    <td>
                        <a href="index.php?action=detailRealisateur&id=<?= $realisateur["id_realisateur"] ?>">
                        <img src="<?= $realisateur['photo']?>" alt="photo du réalisateur"></a>
                    </td>
                </tr>
            <?php } ?>
    </tbody>
</table>

<?php

// Définition des titres pour la vue
$titre = "Liste des réalisateurs";
$titre_secondaire = "Liste des réalisateurs";

$contenu = ob_get_clean();

//injecter le contenu dans le template > template.php
require "view/template.php"; 
