## Configuration initiale

1. **Cloner le projet** :
   git clone url_du_repository
   cd repertoire_du_projet

2. **Installer les dépendances** :
   composer install

3. **Configurer l'environnement** :
   Dupliquez le fichier `.env.example` en `.env` et configurez vos variables d'environnement, notamment pour la base de données.
   Ensuite, modifiez le fichier `.env` avec les informations de connexion à votre base de données.

4. **Démarrer le serveur local** :
   Pour démarrer le serveur de développement local, exécutez :
   symfony server:start

5. **Créer la base de données** :
   Si la base de données n'existe pas encore, créez-la avec la commande suivante :
   php bin/console doctrine:migrations:migrate

6. **Charger les données de test** :
   Pour charger des données de test dans la base de données, exécutez les fixtures avec la commande suivante :
   php bin/console doctrine:fixtures:load
