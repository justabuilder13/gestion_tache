# TP4 — Déploiement d’une application PHP/MySQL sur N0C

**Étudiant :** Justin Lachapelle-Lévesque
**Code étudiant :** #2596219  

---

## 1. Nom du projet
Application de Gestion de Tâches Minimaliste

## 2. Description de l’application
Cette application est un système de gestion de tâches qui permet de lire, ajouter, modifier ou supprimer des tâches simple ou complex de votre vie quotidienne. Dans l'interface en temps réel, l'application se concentre sur la gestion et l'affichage des tâches selon leur niveau de priorité (basse, moyenne, haute).

## 3. Lien GitHub
https://github.com/justabuilder13/gestion_tache

## 4. Lien N0C
https://edw2-h26-tp4.e2596219.webdevmaisonneuve.ca/

## 5. Structure du projet

- `public/`: Le dossier racine accessible par le serveur web, contenant `index.php`
- `app/`: Dossier interne hébergeant le script de connexion sécurisé `db.php`
- `database/`: Dossier contenant le fichier d'exportation de la base de données `export.sql`
- `.env`: Fichier local contenant les variables d'environnement confidentielles (exclu de Git)
- `.env.example`: Modèle de configuration partagé publiquement pour documenter les variables

## 6. Base de données
La base de données en production contient trois tables interconnectées par des clés étrangères :
- `utilisateurs`: Stocke les informations des usagers (comme Jacob Martin)
- `taches`: Table principale gérant l'identifiant, le titre, la description, la priorité (enum basse, moyenne, haute) et les états d'avancement des tâches.

## 7. Variables d’environnement
L'application utilise également une meilleure gestion dynamique basée sur un fichier `.env` lu à l'aide d'un parseur
- Le dépôt GitHub n'expose aucun mot de passe ou informations discrète grâce au fichier `.gitignore`
- Un fichier `.env.example` a été poussé pour documenter l'environnement sans compromettre la sécurité

## 8. Configuration du sous-domaine N0C
- **Lien N0C utilisé** : `https://edw2-h26-tp4.e2596219.webdevmaisonneuve.ca/`
- **Sous-domaine configuré**: `edw2-h26-tp4.e2596219.webdevmaisonneuve.ca`
- **Document Root configuré**: `gestion_tache/public`
- **Dossier du projet sur N0C**: Cloné dans `~/gestion_tache`
- **Raison du pointage vers public/**: Pointer le Document Root directement vers `public/` garantit que seuls les scripts d'affichage (comme `index.php`) sont accessibles aux visiteurs. Les données et configurations critiques situées dans `app/db.php` ou `.env` restent totalement inaccessibles depuis le navigateur internet, prévenant ainsi les failles de sécurité.

## 9. Étapes de déploiement réalisées

### 9.1 Préparation locale dans WSL
Développement de l'application dans l'environnement WSL (`/var/www/gestion_tache`), validation des requêtes CRUD locales et configuration du fichier `.gitignore` initial

### 9.2 Mise sur GitHub
Création du dépôt Git distant, validation de l'exclusion du fichier `.env`, et téléversement du code sur GitHub via la commande `git push origin main`

### 9.3 Préparation de la base sur N0C
Création de la base de données et de l'utilisateur associé dans l'interface N0C de PlanetHoster. Exportation du schéma de données depuis WSL (`mysqldump`) suivi de son importation réussie dans l'outil phpMyAdmin de production

### 9.4 Connexion SSH
Utilisation du protocole SSH dans le terminal WSL pour se connecter de manière sécurisée au serveur distant PlanetHoster via le port d'accès spécifique configuré sur N0C

### 9.5 Récupération du projet sur N0C
Clonage du code source de l'application directement depuis GitHub vers l'espace d'hébergement en utilisant la commande `git clone`

### 9.6 Configuration du `.env` sur N0C
Création manuelle d'un fichier `.env` de production avec l'éditeur `nano` à la racine du serveur. Ce fichier stocke l'hôte local (`127.0.0.1`), le nom exact de la base de données de production et les accès générés par N0C

### 9.7 Configuration du sous-domaine
Ajustement du Document Root dans l'onglet "Domain Management" de N0C pour s'assurer que le trafic du sous-domaine pointe exclusivement vers le sous-dossier `public/`

### 9.8 Tests finaux
Ouverture du site web en ligne, validation de la disparition de l'erreur HTTP 500, affichage correct des tâches et contrôle de la persistance en base de données

## 10. Problèmes rencontrés et solutions
1. **HTTP ERROR 500 & Échec de connexion (1045)**: Le code d'origine utilisait `localhost` et des identifiants d'environnement de développement local. Sur le serveur N0C, l'hôte a dû être remplacé de force par `127.0.0.1` et le script de traitement du fichier `.env` a été réécrit pour lire les variables de PlanetHoster de manière fluide et sécurisée
2. **SQLSTATE[42S02] Table not found (1146)**: Une mauvaise base de données de messagerie avait été assignée au départ par mégarde. La base de données en production a été vidée et nettoyée dans phpMyAdmin, puis le script SQL officiel contenant l'arbre relationnel complet de la gestion des tâches (`taches`, `categories`, `utilisateurs`) a été exécuté avec succès

## 11. Validation finale
L'application en ligne est entièrement fonctionnelle. Le lien N0C affiche l'interface utilisateur sans bavure. L'application extrait les données en temps réel depuis la base N0C (comme l'utilisateur Jacob Martin et les catégories de tâches) et gère les écritures SQL sans lever d'erreur. Les données modifiées se répercutent de façon transparente dans phpMyAdmin