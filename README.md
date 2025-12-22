# 🛒 E-Commerce MVC - Projet PHP

Application e-commerce complète développée avec une architecture MVC personnalisée en PHP.

## 📋 Fonctionnalités

- ✅ Authentification (inscription/connexion)
- ✅ Catalogue de produits avec filtres par catégorie
- ✅ Panier d'achat en session
- ✅ Gestion des commandes
- ✅ Historique des commandes utilisateur
- ✅ Interface responsive (mobile, tablette, desktop)
- ✅ Architecture MVC avec Active Record

## 🚀 Installation

### Prérequis

- PHP 7.4 ou supérieur
- MySQL/MariaDB
- XAMPP (ou tout serveur Apache/PHP/MySQL)
- Composer

### 1️⃣ Cloner le projet

```bash
# Si vous utilisez XAMPP, placez le projet dans htdocs
cd /Applications/XAMPP/xamppfiles/htdocs/
# Ou clonez votre repository
git clone <votre-repo> mini_mvc
cd mini_mvc
```

### 2️⃣ Installer les dépendances

```bash
composer install
```

### 3️⃣ Configuration de la base de données

#### Créer la base de données

1. Ouvrez phpMyAdmin : `http://localhost/phpmyadmin`
2. Créez une nouvelle base de données nommée `ecommerce_mvc`
3. Importez le fichier SQL :
   ```sql
   -- Importez le fichier : ecommerce_mvc.sql
   ```

Ou en ligne de commande :
```bash
mysql -u root -p
CREATE DATABASE ecommerce_mvc;
exit;

mysql -u root -p ecommerce_mvc < ecommerce_mvc.sql
```

#### Configurer la connexion

Modifiez le fichier `app/config.ini` avec vos paramètres :
```ini
DB_NAME = "ecommerce_mvc"
DB_HOST = "127.0.0.1"
DB_USERNAME = "root"
DB_PASSWORD = ""
```

### 4️⃣ Lancer le projet

#### Avec XAMPP

1. Démarrez Apache et MySQL depuis le panneau de contrôle XAMPP
2. Accédez à l'application : `http://localhost/mini_mvc/public/`

#### Avec le serveur PHP intégré

```bash
cd /Applications/XAMPP/xamppfiles/htdocs/mini_mvc/public
php -S localhost:8000
```
Puis accédez à : `http://localhost:8000`

## 👤 Identifiants de test

### Compte Client

- **Email :** `jean.dupont@email.com`
- **Mot de passe :** `password123`

### Compte Admin

- **Email :** `admin@ecommerce.com`
- **Mot de passe :** `admin123`

> 💡 Le compte admin permet d'accéder à la gestion des commandes via le lien "📊 Admin" dans la navigation.

## 📁 Structure du projet

```
mini_mvc/
├── app/
│   ├── Controllers/     # Contrôleurs (logique métier)
│   ├── Core/           # Classes du noyau MVC
│   ├── Models/         # Modèles (Active Record)
│   ├── Views/          # Vues (templates PHP)
│   └── config.ini      # Configuration DB
├── public/
│   ├── css/           # Styles CSS
│   ├── index.php      # Point d'entrée
├── vendor/            # Dépendances Composer
├── docs/              # Documentation
├── database/          # Migrations SQL
├── composer.json
└── README.md
```

## 🎯 Utilisation

### Parcourir les produits
- Accédez à la page d'accueil
- Filtrez par catégorie
- Cliquez sur "Voir détails" pour plus d'informations

### Passer une commande
1. Ajoutez des produits au panier 🛒
2. Cliquez sur l'icône panier
3. Modifiez les quantités si nécessaire
4. Cliquez sur "Passer la commande"
5. Confirmez votre commande

### Gérer les commandes (Admin)
1. Connectez-vous avec un compte admin
2. Accédez à "📊 Admin" dans le menu
3. Modifiez les statuts des commandes via le menu déroulant

## 🛠️ Technologies utilisées

- **Backend :** PHP 7.4+
- **Base de données :** MySQL/MariaDB
- **Architecture :** MVC personnalisé avec Active Record
- **Frontend :** HTML5, CSS3 (Responsive)
- **Autoloading :** Composer PSR-4

## 📚 Documentation supplémentaire

- [Installation détaillée](./docs/README_START.md)
- [Active Record Pattern](./docs/active-record.md)
- [Guide Panier](./docs/GUIDE_PANIER.md)
- [CRUD Produits](./docs/PRODUCT_CRUD.md)

## 👨‍💻 Auteur

Sloan, Développé dans le cadre d'un projet d'apprentissage MVC en PHP.