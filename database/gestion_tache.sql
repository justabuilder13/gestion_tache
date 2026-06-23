-- ============================================================
--  Base de données : gestion_taches
-- ============================================================

CREATE DATABASE IF NOT EXISTS gestion_taches
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE gestion_taches;

-- ------------------------------------------------------------
--  Utilisateurs
-- ------------------------------------------------------------
CREATE TABLE utilisateurs (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    nom         VARCHAR(100)        NOT NULL,
    email       VARCHAR(150)        NOT NULL UNIQUE,
    created_at  TIMESTAMP           DEFAULT CURRENT_TIMESTAMP
);

-- ------------------------------------------------------------
--  Catégories de tâches
-- ------------------------------------------------------------
CREATE TABLE categories (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    nom         VARCHAR(100)        NOT NULL
);

-- ------------------------------------------------------------
--  Tâches
-- ------------------------------------------------------------
CREATE TABLE taches (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    titre           VARCHAR(255)        NOT NULL,
    description     TEXT,
    termine         BOOLEAN             DEFAULT FALSE,
    priorite        ENUM('basse','moyenne','haute') DEFAULT 'moyenne',
    utilisateur_id  INT,
    categorie_id    INT,
    created_at      TIMESTAMP           DEFAULT CURRENT_TIMESTAMP,
    updated_at      TIMESTAMP           DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE SET NULL,
    FOREIGN KEY (categorie_id)   REFERENCES categories(id)   ON DELETE SET NULL
);

-- ============================================================
--  Données de test
-- ============================================================

INSERT INTO utilisateurs (nom, email) VALUES
    ('Justin Lachapelle',   'justin@example.com'),
    ('Sophie Tremblay','sophie@example.com');

INSERT INTO categories (nom) VALUES
    ('École'),
    ('Personnel'),
    ('Travail');

INSERT INTO taches (titre, description, termine, priorite, utilisateur_id, categorie_id) VALUES
    ('Remettre le devoir PHP',  'Faire fonctionner l\'app dans WSL avec NGINX', FALSE, 'haute',   1, 1),
    ('Réviser pour l\'exam SQL','Revoir les JOIN et les clés étrangères',        FALSE, 'haute',   1, 1),
    ('Acheter épicerie',        NULL,                                             FALSE, 'basse',   1, 2),
    ('Lire chapitre 4',         'Manuel de bases de données',                    TRUE,  'moyenne', 2, 1);

-- ============================================================
--  Utilisateur MySQL pour l'app
-- ============================================================

CREATE USER IF NOT EXISTS 'app_user'@'localhost' IDENTIFIED BY 'motdepasse123';
GRANT ALL PRIVILEGES ON gestion_taches.* TO 'app_user'@'localhost';
FLUSH PRIVILEGES;
