# Relevé consommation


# Créer la base de données, ainsi qu'un utilisateur

CREATE DATABASE releve_conso;


CREATE USER 'conso_dev'@'localhost' IDENTIFIED BY 'Tic98!Bx12';


GRANT SELECT, INSERT, UPDATE, DELETE ON releve_conso.* TO 'conso_dev'@'localhost';


FLUSH PRIVILEGES; 


# Installation / Configuration
Cloner le répertoire

Aller dans le répertoire qui contient le site

php artisan migrate 


# Mettre à jour le php.ini 
post_max_size = 20M

upload_max_filesize = 20M

Redémarrer apache


# Modifier dans le .env
QUEUE_CONNECTION=database


Avant d'uploader le fichier, lancer la commande suivante dans le répertoire de l'application :

php artisan queue:work --timeout=120 --queue=urgent (si besoin gérer le redémarrage automatiquement via le crontab)

