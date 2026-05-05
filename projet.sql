-- ============================================================================
-- projet.sql — Suivi des Lauréats ENSIASDT
-- Filière MGSI — Groupe N°46 — Chliyah Youssef & El Ghajdaoui Achraf
-- Export structure + données de test (compatible phpMyAdmin / MySQL 5.7+)
-- ============================================================================

CREATE DATABASE IF NOT EXISTS suivi_laureats_ensiasdt
    DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE suivi_laureats_ensiasdt;

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS connexions;
DROP TABLE IF EXISTS messages_contact;
DROP TABLE IF EXISTS laureats;
DROP TABLE IF EXISTS utilisateurs;
SET FOREIGN_KEY_CHECKS = 1;

-- ----------------------------------------------------------------------------
-- Table : utilisateurs (comptes d'authentification)
-- ----------------------------------------------------------------------------
CREATE TABLE utilisateurs (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    login           VARCHAR(50)  NOT NULL UNIQUE,
    email           VARCHAR(150) NOT NULL UNIQUE,
    mot_de_passe    VARCHAR(255) NOT NULL,
    nom             VARCHAR(80)  NOT NULL,
    prenom          VARCHAR(80)  NOT NULL,
    role            ENUM('admin','laureat') NOT NULL DEFAULT 'laureat',
    actif           TINYINT(1)   NOT NULL DEFAULT 1,
    created_at      TIMESTAMP    DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------------------------------------------------------
-- Table : laureats (fiche professionnelle)
-- ----------------------------------------------------------------------------
CREATE TABLE laureats (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id  INT NULL,
    nom             VARCHAR(80)  NOT NULL,
    prenom          VARCHAR(80)  NOT NULL,
    email           VARCHAR(150) NOT NULL,
    telephone       VARCHAR(30)  DEFAULT '',
    promotion       INT          NOT NULL,
    poste_actuel    VARCHAR(150) DEFAULT '',
    entreprise      VARCHAR(150) DEFAULT '',
    secteur         VARCHAR(100) DEFAULT '',
    ville           VARCHAR(80)  DEFAULT '',
    pays            VARCHAR(80)  DEFAULT 'Maroc',
    linkedin        VARCHAR(255) DEFAULT '',
    biographie      TEXT,
    created_at      TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_promotion (promotion),
    INDEX idx_secteur (secteur),
    CONSTRAINT fk_laureat_user FOREIGN KEY (utilisateur_id)
        REFERENCES utilisateurs(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------------------------------------------------------
-- Table : connexions (réseau d'anciens — relation many-to-many)
-- ----------------------------------------------------------------------------
CREATE TABLE connexions (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    laureat1    INT NOT NULL,
    laureat2    INT NOT NULL,
    statut      ENUM('en_attente','acceptee','refusee') NOT NULL DEFAULT 'acceptee',
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_cnx_l1 FOREIGN KEY (laureat1) REFERENCES laureats(id) ON DELETE CASCADE,
    CONSTRAINT fk_cnx_l2 FOREIGN KEY (laureat2) REFERENCES laureats(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------------------------------------------------------
-- Table : messages_contact (formulaire de la landing page)
-- ----------------------------------------------------------------------------
CREATE TABLE messages_contact (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    nom         VARCHAR(120) NOT NULL,
    email       VARCHAR(150) NOT NULL,
    sujet       VARCHAR(200) NOT NULL,
    message     TEXT NOT NULL,
    lu          TINYINT(1) DEFAULT 0,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================================
-- DONNÉES DE TEST
-- ============================================================================

-- Compte admin obligatoire : ENSIASD / ENSIASD2026
-- Hash bcrypt vérifié pour le mot de passe ENSIASD2026
INSERT INTO utilisateurs (login, email, mot_de_passe, nom, prenom, role) VALUES
('ENSIASD', 'admin@ensiasdt.ma', '$2b$12$2fgy22uk9Y7JlUXxBBtAXe4XaZy2WzFROjlfo3wEGKcCa9BaOfiSC', 'Administrateur', 'ENSIASDT', 'admin'),
('ychliyah', 'youssef.chliyah@ensiasdt.ma', '$2b$12$0ZgD2vA6pAnYb/HJDI9Mr.A1t9SFWBqRMnKRgUqgM.OABr0ssCyFG', 'Chliyah', 'Youssef', 'laureat'),
('aelghajdaoui', 'achraf.elghajdaoui@ensiasdt.ma', '$2b$12$0ZgD2vA6pAnYb/HJDI9Mr.A1t9SFWBqRMnKRgUqgM.OABr0ssCyFG', 'El Ghajdaoui', 'Achraf', 'laureat'),
('samrani', 'sara.amrani@gmail.com', '$2b$12$0ZgD2vA6pAnYb/HJDI9Mr.A1t9SFWBqRMnKRgUqgM.OABr0ssCyFG', 'Amrani', 'Sara', 'laureat'),
('ymansouri', 'youssef.mansouri@gmail.com', '$2b$12$0ZgD2vA6pAnYb/HJDI9Mr.A1t9SFWBqRMnKRgUqgM.OABr0ssCyFG', 'Mansouri', 'Youssef', 'laureat');

INSERT INTO laureats (utilisateur_id, nom, prenom, email, telephone, promotion, poste_actuel, entreprise, secteur, ville, pays, linkedin, biographie) VALUES
(2,'Chliyah','Youssef','youssef.chliyah@ensiasdt.ma','+212600000001',2026,'Étudiant ingénieur','ENSIASDT','Éducation','Tanger','Maroc','https://linkedin.com/in/youssef','Étudiant en MGSI, passionné de développement web.'),
(3,'El Ghajdaoui','Achraf','achraf.elghajdaoui@ensiasdt.ma','+212600000002',2026,'Étudiant ingénieur','ENSIASDT','Éducation','Tanger','Maroc','https://linkedin.com/in/achraf','Étudiant en MGSI, intéressé par la data science.'),
(4,'Amrani','Sara','sara.amrani@gmail.com','+212611111111',2023,'Data Engineer','OCP Group','Industrie','Casablanca','Maroc','https://linkedin.com/in/sara-amrani','Spécialisée big data et pipelines de données.'),
(5,'Mansouri','Youssef','youssef.mansouri@gmail.com','+212622222222',2021,'Consultant SI','Capgemini','Conseil','Rabat','Maroc','https://linkedin.com/in/youssef-mansouri','Consultant en transformation digitale.'),
(NULL,'Bennis','Imane','imane.bennis@bmce.ma','+212633333333',2022,'Analyste financier','BMCE Bank','Banque','Casablanca','Maroc','https://linkedin.com/in/imane-bennis','Analyste crédit en banque de détail.'),
(NULL,'Tazi','Mehdi','mehdi.tazi@orange.ma','+212644444444',2020,'Ingénieur réseau','Orange Maroc','Télécoms','Rabat','Maroc','','Ingénieur réseau & sécurité.'),
(NULL,'Lahlou','Khadija','khadija.lahlou@google.com','+212655555555',2019,'Software Engineer','Google','Informatique','Paris','France','https://linkedin.com/in/khadija','Travaille sur les services cloud GCP.'),
(NULL,'Berrada','Omar','omar.berrada@deloitte.ma','+212666666666',2024,'Auditeur Junior','Deloitte','Conseil','Casablanca','Maroc','','Audit financier et SI.'),
(NULL,'El Fassi','Nadia','nadia.elfassi@inwi.ma','+212677777777',2023,'Chef de projet IT','Inwi','Télécoms','Casablanca','Maroc','https://linkedin.com/in/nadia','Chef de projet IT, certifiée PMP.'),
(NULL,'Idrissi','Karim','karim.idrissi@managem.ma','+212688888888',2021,'Ingénieur process','Managem','Industrie','Marrakech','Maroc','','Ingénieur en industrie minière.'),
(NULL,'Saidi','Fatima','fatima.saidi@microsoft.com','+212699999999',2022,'Cloud Architect','Microsoft','Informatique','Dubaï','EAU','https://linkedin.com/in/fatima','Architecte solutions Azure.'),
(NULL,'Hassani','Rachid','rachid.hassani@cnss.ma','+212610101010',2020,'Développeur full-stack','CNSS','Informatique','Rabat','Maroc','','Développeur Java/Angular.');

-- Quelques connexions du réseau
INSERT INTO connexions (laureat1, laureat2, statut) VALUES
(1,2,'acceptee'),
(1,3,'acceptee'),
(2,4,'acceptee'),
(3,5,'acceptee'),
(4,7,'acceptee'),
(5,9,'acceptee');

-- Messages de contact (exemples)
INSERT INTO messages_contact (nom, email, sujet, message) VALUES
('Said El Amri','said@example.com','Demande d''information','Bonjour, je suis intéressé par le réseau alumni.'),
('Nora Benali','nora@example.com','Partenariat','Notre entreprise souhaite recruter parmi vos lauréats.'),
('Hamza Idrissi','hamza@example.com','Question technique','Comment mettre à jour mon profil ?');

-- ============================================================================
-- FIN
-- ============================================================================
