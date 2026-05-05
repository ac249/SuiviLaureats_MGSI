================================================================================
  PROJET : Suivi des Lauréats ENSIASDT
  Filière : MGSI    |    Groupe N°46
  Auteurs : Chliyah Youssef  &  El Ghajdaoui Achraf
================================================================================

1. PRÉSENTATION
---------------
Application web PHP/MySQL permettant de gérer la base de données des diplômés
de l'ENSIASDT, faciliter le réseautage entre anciens élèves et suivre
l'insertion professionnelle.

2. PRÉ-REQUIS
-------------
- Serveur Apache (XAMPP / WAMP / MAMP / LAMP)
- PHP 7.4 ou supérieur (extension PDO_MYSQL activée)
- MySQL 5.7+ ou MariaDB 10.3+
- Navigateur récent (Chrome, Firefox, Edge)

3. INSTALLATION (XAMPP)
-----------------------
a) Copier le dossier "SuiviLaureats_MGSI" dans :
       C:\xampp\htdocs\

b) Démarrer Apache et MySQL depuis le panneau XAMPP.

c) Importer la base :
   - Ouvrir http://localhost/phpmyadmin
   - Onglet "Importer" -> choisir "projet.sql"
   - Cliquer sur "Exécuter"
   La base "suivi_laureats_ensiasdt" est créée automatiquement avec les données.

d) Si nécessaire, vérifier la configuration dans config.php :
       DB_HOST = localhost
       DB_NAME = suivi_laureats_ensiasdt
       DB_USER = root
       DB_PASS = ''

e) Lancer l'application :
       http://localhost/SuiviLaureats_MGSI/

4. COMPTES DE TEST
------------------
   ┌─────────────────────────────────────────────────────────┐
   │ COMPTE ADMINISTRATEUR (accès complet) — OBLIGATOIRE     │
   │   Login    : ENSIASD                                    │
   │   Password : ENSIASD2026                                │
   └─────────────────────────────────────────────────────────┘

   Comptes lauréats supplémentaires (mot de passe : Test1234!) :
     - ychliyah        / Test1234!
     - aelghajdaoui    / Test1234!
     - samrani         / Test1234!
     - ymansouri       / Test1234!

5. STRUCTURE DU PROJET
----------------------
   SuiviLaureats_MGSI/
   ├── index.php               (landing page)
   ├── config.php              (connexion BDD + helpers)
   ├── projet.sql              (export complet de la BDD)
   ├── css/                    (styles personnalisés)
   ├── bootstrap/              (Bootstrap 5 en local)
   ├── js/                     (scripts JavaScript)
   ├── images/                 (images du site)
   ├── pages/                  (login, register, dashboard, laureats, etc.)
   ├── includes/               (header, footer, navbar, fonctions)
   └── doc/                    (documentation)
       ├── Fiche.pdf
       ├── captures.pdf        (rapport des captures)
       ├── README.txt
       ├── captures/           (PNG de chaque page)
       └── diagrammes/         (MCD + MLD)

6. FONCTIONNALITÉS
------------------
- Landing page responsive (Hero, services, statistiques, témoignages, contact)
- Authentification (inscription, connexion, déconnexion, sessions)
- Tableau de bord avec KPIs et graphiques (Chart.js)
- Annuaire des lauréats avec recherche & filtres (promotion, secteur)
- CRUD complet des fiches lauréats (admin)
- Mise à jour du profil par chaque lauréat
- Réseau d'anciens (connexions + suggestions)
- Gestion des utilisateurs (admin)
- Mentions légales & politique de confidentialité

7. SÉCURITÉ
-----------
- Mots de passe hachés (bcrypt via password_hash)
- Toutes les requêtes SQL utilisent PDO + requêtes préparées
- Échappement systématique des sorties HTML (fonction e())
- Sessions PHP pour l'authentification
- Contrôles d'accès par rôle (require_login / require_admin)

8. TECHNOLOGIES
---------------
HTML5 / CSS3 / JavaScript / Bootstrap 5 / PHP 7.4+ / MySQL / PDO / Chart.js
