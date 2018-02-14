# ResoSocial

Ce projet a été réalisé pour le module PHP de l'ENSSAT, section IMR promo 2020.

## Préambule

Ce fichier contient, dans un premier temps les étapes d'installation du projet.
Puis il détaillera la liste des FrameWork utilisés.

### Pré-requis

Vous aurez besoin de télécharger :
 * xampp (7.2.1.0) / lampp ()
 * MongoDb (3.6.2)
Suivit de, une fois xamp/lamp installé :
 * Composer 
 * NodeJs (8.9.4)

### Installation

#### Pour Windows et Linux

1. Installer dans l'ordre sur la machine : XAMPP/LAMPP, MongoDB, Composer, NodeJs.
2. Télécherger le projet git sur votre machine, et le placer dans "_Cheminxamp_/htdocs/"
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
5.
## Running the tests

Explain how to run the automated tests for this system

### Break down into end to end tests

Explain what these tests test and why

```
Give an example
```

### And coding style tests

Explain what these tests test and why

```
Give an example
```

## Deployment

Add additional notes about how to deploy this on a live system

## Built With

* [Dropwizard](http://www.dropwizard.io/1.0.2/docs/) - The web framework used
* [Maven](https://maven.apache.org/) - Dependency Management
* [ROME](https://rometools.github.io/rome/) - Used to generate RSS Feeds

## Contributing

Please read [CONTRIBUTING.md](https://gist.github.com/PurpleBooth/b24679402957c63ec426) for details on our code of conduct, and the process for submitting pull requests to us.

## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see the [tags on this repository](https://github.com/your/project/tags). 

## Authors

* **Billie Thompson** - *Initial work* - [PurpleBooth](https://github.com/PurpleBooth)

See also the list of [contributors](https://github.com/your/project/contributors) who participated in this project.

## License

Ce projet est destiné l'ENSSAT, pour les élèves de l'ENSSAT.

## Acknowledgments

* Hat tip to anyone who's code was used
* Inspiration
* etc
