# ResoSocial

Ce projet a été réalisé pour le module PHP de l'ENSSAT, section IMR promo 2020.

## Préambule

Ce fichier contient, dans un premier temps les étapes d'installation du projet.
Puis il détaillera la liste des FrameWork utilisés.

## Installation
### Pré-requis

Vous aurez besoin de télécharger :
 * xampp (7.2.1.0) / lampp ()
 * MongoDb (3.6.2)
Suivit de, une fois xamp/lamp installé :
 * Composer 
 * NodeJs (8.9.4)

### Installation
#### Pour Windows

1. Installer dans l'ordre sur la machine : XAMPP, MongoDB, Composer, NodeJs.
2. Télécherger le projet git sur votre machine, et le placer dans "_Cheminxamp_/htdocs/"

#### Pour Linux

1. Installer dans l'ordre sur la machine : LAMPP, MongoDB, Composer, NodeJs.
2. Télécherger le projet git sur votre machine, 

#### Pour Windows et Linux

3. Créer dans ce dossier du projet un fichier .env :
```
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:R2Qpwae34Cw5zEepxtBg6dgVjYpL1U6T9jjHnzA6EYM=
APP_DEBUG=true
APP_LOG_LEVEL=debug
APP_URL=http://localhost/


DB_CONNECTION=mongodb
DB_HOST=localhost
DB_PORT=27017
DB_DATABASE=reseau_social
DB_USERNAME=
DB_PASSWORD=  

BROADCAST_DRIVER=log
CACHE_DRIVER=file
SESSION_DRIVER=file
SESSION_LIFETIME=120
QUEUE_DRIVER=sync
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=mt1
```
4. Completer les lignes en remplacent par vos identifiants, qui seront créés par la suite.
```
DB_USERNAME=baptiste
DB_PASSWORD=root
```
5. Exécuter la console MongoDB, et entrer la commande suivante :
```
use admin
db.createUser(
{
user: "baptiste",
pwd: "root",
roles: [ { role: "userAdminAnyDatabase", db: "admin" } ]
}
)
```
6. Aller à la racine du projet, et exécuter la commande pour générer une clé de chiffrement :
```
php php artisan key:generate
```
7. Dans le fichier database.php situé dans ./config/ et modifier la ligne
```
'username' => 'baptiste',
'password' => 'root',
```
8. Maintenant, nous pouvons exécuter les commandes suivantes, dans la racine du projet :
  1. cette commande permet la mise à jour de tous les framworks utilisés listés dans le point suivant :
```
composer install
```
  2. On se met dans le dossier public, et on exécute les commandes qui permettent d'installer les paquets JS :
```
npm install
npm run dev
```

## Frameworks utilisés

* [Dropwizard](http://www.dropwizard.io/1.0.2/docs/) - The web framework used
* [Maven](https://maven.apache.org/) - Dependency Management
* [ROME](https://rometools.github.io/rome/) - Used to generate RSS Feeds

## Auteurs

* **Billie Thompson** - *Initial work* - [PurpleBooth](https://github.com/PurpleBooth)

## License

Ce projet est licencié ENSSAT, est destiné l'ENSSAT, pour les élèves de l'ENSSAT.
