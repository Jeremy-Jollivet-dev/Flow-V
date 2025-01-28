# Flow-V

Flow-V est une application web d'organisation de courses cyclistes.

## Prérequis

Avant d'installer Flow-V, assurez-vous d'avoir les éléments suivants installés sur votre système :

- PHP (>=7.4)

- Composer

- Un serveur web (Apache, Nginx, etc.)

- MySQL ou MariaDB

- Node.js et npm (pour la gestion des dépendances front-end)



## Installation

Cloner le dépôt

```bash
    git clone https://github.com/Jeremy-Jollivet-dev/Flow-V.git
    cd Flow-V
```

Installer les dépendances PHP

```bash
    composer install
```

Configurer la base de données

```bash
    CREATE DATABASE flow;

    mysql -u root -p flow < flow.sql
```

Configurer l'application

Copiez le fichier ".env.example" et renommez-le en ".env", puis modifiez les paramètres de connexion à la base de données :

```bash
    DB_HOST=127.0.0.1
    DB_DATABASE=flow
    DB_USERNAME=root
    DB_PASSWORD=yourpassword
```

Lancer le serveur local

```bash
    php -S localhost:8000 -t public/
```

## Développement
Si vous modifiez des fichiers front-end, installez les dépendances et générez les assets :

```bash
    npm install
    npm run build
```



