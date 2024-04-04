<?php 
    if(isset($_SESSION["message"]) || !empty($_SESSION["message"])) {
        echo $_SESSION["message"]; //affiche le message
        unset($_SESSION["message"]); //supprime le message une fois affiché
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/f3340c3342.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="public/css/style.css">
    <!-- DANS CHAQUE VUE, il faudra toujours donner une valeur à $titre, $contenu et $titre_secondaire -->
    <title>
        <?= $titre ?> 
    </title> 
</head>
<body>
<!--==================== HEADER ====================-->
    <header class="header" id="header">
        <nav class="nav_container">
            <ul class="nav_list">
                <li class="logo"><a href="index.php?action=home" class="nav_logo">TWATCH</a></li>
                <input type="checkbox" id="check">
                <span class="menu">
                    <li class="nav_item">
                        <a href="index.php?action=listFilms" class="nav_link">Films</a>
                    </li>
                    <li class="nav_item">
                        <a href="index.php?action=listRealisateurs" class="nav_link">Réalisateurs</a>
                    </li>
                    <li class="nav_item">
                        <a href="index.php?action=listActeurs" class="nav_link">Acteurs</a>
                    </li>
                    <li class="nav_item">
                        <a href="index.php?action=listGenres" class="nav_link">Genres</a>
                    </li>
                    <li class="nav_item">
                        <a href="index.php?action=listRoles" class="nav_link">Rôles</a>
                    </li>
                    <label for="check" class="close-menu"><i class="fa fa-times"></i></label>
                </span>
                <label for="check" class="open-menu"><i class="fas fa-bars"></i></label>
            </ul>
        </nav>
    </header>
<!--==================== BODY ====================-->
    <main>
        <div id="contenu">
            <h1>PDO Cinema</h1>
            <h2><?= $titre_secondaire ?></h2>
            <?= $contenu ?>
        </div>
    </main>
</body>

<footer>
    <ul class="footer_list">
        <li class="footer_item">
            <a href="#" class="footer_link">Mentions Légales</a>
        </li>
        <li class="footer_item">
            <a href="#" class="footer_link">Contact</a>
        </li>
        <li>
            <a class="footer_social" href="#"><i class="fa-brands fa-x-twitter"></i></a>
            <a class="footer_social" href="#"><i class="fa-brands fa-facebook"></i></a>
            <a class="footer_social" href="#"><i class="fa-brands fa-instagram"></i></a>
        </li>
    </ul>
</footer>
</html>