
INSERT INTO film (titre, parution, duree, synopsis, note, affiche)
VALUES ("Django", "2013-01-16", 165, "Un esclave noir est affranchi par un chasseur de primes. Le moment est venu de sauver son épouse d'un riche propriétaire de plantation du Mississipi.", 4.5,"https://media.senscritique.com/media/000013924487/0/django_unchained.jp")

INSERT INTO personne (prenom, nom, sexe, dateNaissance)
VALUES ("Quentin", "Tarantino", "Homme", "1963-03-27")

-- a. Informations d’un film (id_film) : titre, année, durée (au format HH:MM) et
-- réalisateur 

SELECT titre, DATE_FORMAT(parution, "%D %b %Y") AS parution, duree, nom, prenom
FROM filM f
INNER JOIN realisateur r ON f.id_realisateur = r.id_realisateur
INNER JOIN personne p ON r.id_personne = p.id_personne
WHERE id_film = 1

-- b. Liste des films dont la durée excède 2h15 classés par durée (du + long au + court)

SELECT titre, duree
FROM filM f
WHERE duree > 135
ORDER BY duree DESC

-- c. Liste des films d’un réalisateur (en précisant l’année de sortie)

SELECT titre, DATE_FORMAT(parution, "%Y") AS parution, prenom, nom
FROM  film f
INNER JOIN realisateur r ON f.id_realisateur = r.id_realisateur
INNER JOIN personne p ON r.id_personne = p.id_personne
WHERE r.id_realisateur = 1

-- d. Nombre de films par genre (classés dans l’ordre décroissant)

SELECT COUNT(titre) AS nb_films, nom_genre
FROM  film f
INNER JOIN genre_film gf ON f.id_film = gf.id_film
INNER JOIN genre g ON gf.id_genre = g.id_genre
GROUP BY g.id_genre
ORDER BY nb_films DESC

--e. Nombre de films par réalisateur (classés dans l’ordre décroissant)

SELECT COUNT(titre) AS nb_films, prenom, nom
FROM  film f
INNER JOIN realisateur r ON f.id_realisateur = r.id_realisateur
INNER JOIN personne p ON r.id_personne = p.id_personne
GROUP BY r.id_realisateur
ORDER BY nb_films DESC

--f. Casting d’un film en particulier (id_film) : nom, prénom des acteurs + sexe

SELECT titre, CONCAT(prenom," ", nom), sexe
FROM  film f 
INNER JOIN casting c ON f.id_film = c.id_film
INNER JOIN acteur a ON c.id_acteur = a.id_acteur
INNER JOIN personne p ON a.id_personne = p.id_personne
INNER JOIN role r ON c.id_role = r.id_role
WHERE c.id_film = 2

--g. Films tournés par un acteur en particulier (id_acteur) avec leur rôle et l’année de
-- sortie (du film le plus récent au plus ancien)

SELECT titre, CONCAT(nom, " ", prenom) AS acteurs, role_personnage, DATE_FORMAT(parution, "%Y") AS parution 
FROM film f
INNER JOIN casting c ON f.id_film = c.id_film
INNER JOIN acteur a ON c.id_acteur = a.id_acteur
INNER JOIN personne p ON a.id_personne = p.id_personne
INNER JOIN role r ON c.id_role = r.id_role
WHERE a.id_acteur = 7

--h. Liste des personnes qui sont à la fois acteurs et réalisateurs

SELECT CONCAT(prenom, nom)
FROM personne p
INNER JOIN acteur a ON p.id_personne = a.id_personne
INNER JOIN realisateur r ON p.id_personne = r.id_personne

--i. Liste des films qui ont moins de 5 ans (classés du plus récent au plus ancien)

SELECT titre, DATE_FORMAT(f.parution, "%Y") AS parution
FROM film f
WHERE DATE_FORMAT(f.parution, "%Y") > YEAR(CURRENT_DATE) - 5
ORDER BY f.parution DESC

--j. Nombre d’hommes et de femmes parmi les acteurs

SELECT COUNT(sexe) AS s
FROM personne p
INNER JOIN acteur a ON p.id_personne = a.id_personne
GROUP BY sexe

--k. Liste des acteurs ayant plus de 50 ans (âge révolu et non révolu)

SELECT CONCAT(prenom, " ", nom), DATE_FORMAT(dateNaissance, "%Y")
FROM acteur a 
INNER JOIN personne p ON a.id_personne = p.id_personne
WHERE DATE_FORMAT(dateNaissance, "%Y") <= YEAR(CURRENT_DATE) -50

--l. Acteurs ayant joué dans 3 films ou plus

SELECT CONCAT(prenom, " ", nom) AS acteurs, COUNT(titre) AS nb_films
FROM film f 
INNER JOIN casting c ON f.id_film = c.id_film
INNER JOIN acteur a ON c.id_acteur = a.id_acteur
INNER JOIN personne p ON a.id_personne = p.id_personne
GROUP BY acteurs
HAVING nb_films >= 3;


--Requêtes accueil:

-- lister les films avec l'année de parution
SELECT titre, DATE_FORMAT(parution, "%Y") AS parution
FROM film

-- lister acteurs 
SELECT CONCAT(prenom, nom)
FROM personne p
INNER JOIN acteur a ON p.id_personne = a.id_personne
LIMIT 6

-- lister les réalisateurs
SELECT CONCAT(prenom, nom)
FROM personne p
INNER JOIN realisateur r ON p.id_personne = r.id_personne
LIMIT 3


-- lister les films avec leurs genre concaténé
SELECT titre, GROUP_CONCAT(g.nom_genre SEPARATOR ', ')
FROM  genre_film gf
INNER JOIN genre g ON gf.id_genre = g.id_genre
INNER JOIN film f ON gf.id_film = f.id_film
GROUP BY f.id_film

-- lister roles joués par acteurs par film
SELECT CONCAT(nom, " ", prenom) AS acteurs, role_personnage, titre
FROM film f
INNER JOIN casting c ON f.id_film = c.id_film
INNER JOIN acteur a ON c.id_acteur = a.id_acteur
INNER JOIN personne p ON a.id_personne = p.id_personne
INNER JOIN role r ON c.id_role = r.id_role
LIMIT 3


--Requêtes Détail Film:

-- liste tout les détails du films
SELECT *
FROM film f

-- lise le casting avec les roles joués
SELECT CONCAT(nom, " ", prenom) AS acteurs, role_personnage, titre
FROM film f
INNER JOIN casting c ON f.id_film = c.id_film
INNER JOIN acteur a ON c.id_acteur = a.id_acteur
INNER JOIN personne p ON a.id_personne = p.id_personne
INNER JOIN role r ON c.id_role = r.id_role
WHERE f.id_film = 3


--Requêtes liste Films:

SELECT titre, DATE_FORMAT(parution, "%Y") AS parution
FROM film

--Requêtes page personne

--liste les infos de l'acteur
SELECT CONCAT(prenom, nom), DATE_FORMAT(dateNaissance, "%D %b %Y"), sexe
FROM personne p
INNER JOIN acteur a ON p.id_personne = a.id_personne
WHERE id_acteur = 1

--liste les films d'un réalisateur
SELECT titre
FROM  film f
INNER JOIN realisateur r ON f.id_realisateur = r.id_realisateur
INNER JOIN personne p ON r.id_personne = p.id_personne
WHERE r.id_realisateur = 1