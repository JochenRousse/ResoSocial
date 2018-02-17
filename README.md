# ResoSocial

Ce projet a été réalisé pour le module PHP de l'ENSSAT, section IMR promo 2020.

## Préambule

Ce fichier contient, dans un premier temps les étapes d'installation du projet.
Puis il détaillera la liste des frameworks utilisés.

## Installation
### Pré-requis

Vous aurez besoin de télécharger :
 * Un serveur web (par ex: Xampp ou Lamp)
 * MongoDb (3.6.2)  
 
Vous aurez ensuite besoin de :
 * Composer 
 * NodeJs (8.9.4)

### Installation
#### Pour Windows

1. Installez dans l'ordre sur la machine : XAMPP, MongoDB, Composer, NodeJs.
2. Suivez les instructions d'installation pour [MongoDB](https://docs.mongodb.com/manual/administration/install-community/).
3. Clonez le projet git sur votre machine, dans "_Cheminxampp_/htdocs/".

#### Pour Linux

1. Installez dans l'ordre sur la machine : LAMP, MongoDB, Composer, NodeJs.
2. Suivez les instructions d'installation pour [MongoDB](https://docs.mongodb.com/manual/administration/install-community/).
3. Téléchargez le projet git sur votre machine, et mettez-le dans la racine du serveur web.

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
4. Exécutez la console MongoDB, et entrez les commandes suivantes :
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
5. Complétez ces lignes en ajoutant les identifiants que vous venez de créer :
```
DB_USERNAME=_VotreNom_
DB_PASSWORD=_VotrePwd_
```
6. Allez à la racine du projet, et exécutez la commande pour générer une clé de chiffrement :
```
php artisan key:generate
```
7. Dans le fichier database.php situé dans ./config/ et modifiez la ligne pour qu'elle corresponde à vos identifiants :
```
'username' => '_VotreNom_',
'password' => '_VotrePwd_',
```
8. Maintenant, dans la racine du projet, exécutez la commande :  
```
composer install
```
9. Puis exécutez les commandes :
```
npm install
npm run dev
```

## Frameworks utilisés

* [laravel](https://laravel.com/) - Et ses packages, permettant la gestion du projet
* [MongoDB](https://www.mongodb.com/) - Base de donnée

## Dépendances principales

* [Composer](https://getcomposer.org/) - Gestionnaire de paquets PHP
* [NodeJS](https://nodejs.org/en/)
* [npm](https://www.npmjs.com/) - Gestionnaire de paquets JavaScript
* [Pusher](https://pusher.com/docs/) - Recevoir des notifications en temps réel
* [Laravel MongoDB](https://github.com/jenssegers/laravel-mongodb) - Dépendance de Laravel pour l'utilisation de MongoDB

## Auteurs

**Jochen Rousse** - **Johann Carfantan** - **Sylvan Le Deunff** - **Baptiste Prieur**

## License

Ce projet est licencié, est destiné à l'ENSSAT, pour les élèves de l'ENSSAT.
