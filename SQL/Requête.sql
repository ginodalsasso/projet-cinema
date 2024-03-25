            SELECT titre, GROUP_CONCAT(g.nom_genre SEPARATOR ', ') AS nom_genre, affiche, f.id_film
            FROM  genre_film gf
            INNER JOIN genre g ON gf.id_genre = g.id_genre
            INNER JOIN film f ON gf.id_film = f.id_film
            GROUP BY f.id_film
            ORDER BY nom_genre ASC