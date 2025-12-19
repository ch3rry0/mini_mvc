# 📚 STRUCTURE DU PROJET E-COMMERCE MVC

## 🎯 Vue d'ensemble

Ce projet est une **application e-commerce complète** développée en **PHP pur** (sans framework) suivant le **pattern architectural MVC (Model-View-Controller)**. L'application permet aux utilisateurs d'acheter des produits en ligne avec un système complet de gestion de panier, d'authentification et de commandes.

---

## 🏗️ Architecture MVC - Explication

Le pattern **MVC** sépare l'application en 3 couches distinctes :

### 1. **MODEL (Modèle)** 
- **Rôle** : Gère les données et la logique métier
- **Responsabilités** : 
  - Communication avec la base de données
  - Opérations CRUD (Create, Read, Update, Delete)
  - Validation des données métier
- **Dans ce projet** : `app/Models/`

### 2. **VIEW (Vue)**
- **Rôle** : Gère l'affichage et l'interface utilisateur
- **Responsabilités** :
  - Présentation des données (HTML)
  - Interface utilisateur
  - Aucune logique métier
- **Dans ce projet** : `app/Views/`

### 3. **CONTROLLER (Contrôleur)**
- **Rôle** : Fait le lien entre Model et View
- **Responsabilités** :
  - Reçoit les requêtes HTTP
  - Appelle les Models pour récupérer/modifier les données
  - Choisit la View à afficher
  - Transmet les données à la View
- **Dans ce projet** : `app/Controllers/`

### 🔄 Flux de données MVC

```
Utilisateur → Router → Controller → Model → Base de données
                           ↓
                         View → HTML → Utilisateur
```

---

## 📂 Structure détaillée du projet

```
mini_mvc/
│
├── app/                          # Cœur de l'application
│   ├── config.ini               # Configuration base de données
│   │
│   ├── Core/                    # Classes du noyau MVC
│   │   ├── Controller.php       # Classe mère de tous les contrôleurs
│   │   ├── Database.php         # Connexion à la base de données (Singleton)
│   │   ├── Model.php            # Classe mère de tous les modèles
│   │   └── Router.php           # Système de routage HTTP
│   │
│   ├── Controllers/             # CONTRÔLEURS (logique applicative)
│   │   ├── AuthController.php   # Authentification (login/register/logout)
│   │   ├── CartController.php   # Gestion du panier
│   │   ├── OrderController.php  # Gestion des commandes
│   │   └── ProductController.php # Affichage des produits
│   │
│   ├── Models/                  # MODÈLES (accès aux données)
│   │   ├── Utilisateur.php      # Gestion des utilisateurs
│   │   ├── Product.php          # Gestion des produits
│   │   ├── Categorie.php        # Gestion des catégories
│   │   ├── Commande.php         # Gestion des commandes
│   │   └── OrderItem.php        # Gestion des articles de commande
│   │
│   └── Views/                   # VUES (interface utilisateur)
│       ├── layout.php           # Template principal (header/footer)
│       ├── auth/                # Vues d'authentification
│       │   ├── login.php
│       │   └── register.php
│       ├── cart/                # Vues du panier
│       │   └── index.php
│       ├── order/               # Vues des commandes
│       │   ├── checkout.php
│       │   ├── confirmation.php
│       │   ├── detail.php
│       │   └── history.php
│       └── product/             # Vues des produits
│           ├── index.php        # Liste des produits
│           └── show.php         # Détail d'un produit
│
├── public/                      # Dossier accessible au public
│   ├── .htaccess               # Configuration Apache (URL rewriting)
│   ├── index.php               # Point d'entrée de l'application
│   └── css/
│       └── style.css           # Feuille de style responsive
│
├── vendor/                      # Dépendances Composer (autoload)
│
├── composer.json               # Configuration Composer
├── composer.lock               # Versions exactes des dépendances
├── ecommerce_mvc.sql          # Script de création de la base de données
├── README_ECOMMERCE.md        # Documentation complète du projet
└── README.md                  # Documentation de base

```

---

## 🔍 Explication détaillée de chaque composant

### 📁 **app/Core/** - Le noyau MVC

#### 1. `Database.php` - Connexion à la base de données
```php
// Pattern Singleton : une seule instance de connexion
Database::getPDO() → retourne l'objet PDO
```
- **Design Pattern** : Singleton
- **Rôle** : Établit et maintient la connexion à MySQL
- **Utilisation** : Tous les Models l'utilisent pour accéder à la BDD

#### 2. `Router.php` - Système de routage
```php
// Associe une URL à un contrôleur et une action
['GET', '/product', [ProductController::class, 'show']]
```
- **Rôle** : Analyse l'URL et appelle le bon contrôleur
- **Fonctionnement** :
  1. Reçoit la requête HTTP (méthode + URI)
  2. Compare avec la table des routes
  3. Instancie le contrôleur correspondant
  4. Appelle la méthode (action) appropriée

#### 3. `Controller.php` - Contrôleur de base
```php
render(string $view, array $params)
```
- **Rôle** : Classe abstraite dont héritent tous les contrôleurs
- **Méthode principale** : `render()` pour afficher une vue avec des données

#### 4. `Model.php` - Modèle de base
- **Rôle** : Classe de base pour les modèles (peu utilisée ici)
- **Contient** : Propriétés communes (id, created_at, updated_at)

---

### 📁 **app/Controllers/** - Les contrôleurs

#### 1. `ProductController.php` - Gestion des produits
**Méthodes** :
- `index()` : Affiche la liste des produits (avec filtre catégorie)
- `show()` : Affiche le détail d'un produit

**Flux** :
```
Requête GET / 
  → index() 
  → Product::findAll() (récupère produits)
  → render('product/index') avec les données
```

#### 2. `AuthController.php` - Authentification
**Méthodes** :
- `login()` : Affiche le formulaire de connexion
- `loginPost()` : Traite la connexion
- `register()` : Affiche le formulaire d'inscription
- `registerPost()` : Traite l'inscription
- `logout()` : Déconnexion

**Fonctionnement connexion** :
```
1. Utilisateur soumet email + password
2. Recherche dans BDD (Utilisateur::findByEmail)
3. Vérification mot de passe (password_verify)
4. Création de session ($_SESSION['user_id'])
5. Redirection vers page d'accueil
```

#### 3. `CartController.php` - Gestion du panier
**Méthodes** :
- `index()` : Affiche le panier
- `add()` : Ajoute un produit au panier
- `update()` : Modifie la quantité d'un produit
- `remove()` : Supprime un produit du panier
- `clear()` : Vide complètement le panier

**Stockage** : Le panier est stocké en **session PHP**
```php
$_SESSION['cart'] = [
    'product_id' => quantity,
    1 => 2,  // Produit #1, quantité 2
    5 => 1,  // Produit #5, quantité 1
]
```

#### 4. `OrderController.php` - Gestion des commandes
**Méthodes** :
- `checkout()` : Page de confirmation avant commande
- `process()` : Crée la commande en BDD
- `confirmation()` : Page de confirmation après commande
- `history()` : Historique des commandes de l'utilisateur
- `detail()` : Détail d'une commande spécifique

**Flux de commande** :
```
1. Utilisateur clique "Passer commande"
2. checkout() → affiche récapitulatif
3. process() → 
   - Crée la commande (table commande)
   - Crée les items (table order_item)
   - Met à jour les stocks
   - Vide le panier
4. Redirection vers confirmation()
```

---

### 📁 **app/Models/** - Les modèles (accès aux données)

#### 1. `Utilisateur.php` - Gestion des utilisateurs
**Propriétés** :
- id, nom, email, mot_de_passe, adresse, role

**Méthodes principales** :
- `findByEmail($email)` : Recherche un utilisateur par email
- `find($id)` : Recherche un utilisateur par ID
- `insert()` : Crée un nouvel utilisateur
- `update()` : Met à jour un utilisateur

#### 2. `Product.php` - Gestion des produits
**Propriétés** :
- id, nom, description, prix, stock, categorie_id

**Méthodes principales** :
- `findAll()` : Tous les produits (avec catégorie via JOIN)
- `findByCategorie($id)` : Produits d'une catégorie
- `find($id)` : Un produit spécifique
- `updateStock($quantity)` : Décrémenter le stock

#### 3. `Categorie.php` - Gestion des catégories
**Méthodes** :
- `findAll()` : Toutes les catégories
- `find($id)` : Une catégorie

#### 4. `Commande.php` - Gestion des commandes
**Propriétés** :
- id, date, statut, total, utilisateur_id

**Méthodes** :
- `insert()` : Crée une nouvelle commande
- `findByUtilisateur($id)` : Commandes d'un utilisateur
- `find($id)` : Une commande spécifique
- `getItems()` : Récupère les articles d'une commande

#### 5. `OrderItem.php` - Articles de commande
**Propriétés** :
- id, quantite, prix_unitaire, commande_id, produit_id

**Méthodes** :
- `insert()` : Crée un nouvel item

---

### 📁 **app/Views/** - Les vues (interface)

#### Structure d'une vue
Toutes les vues utilisent le même pattern :

```php
<!-- Contenu de la vue (HTML + PHP) -->
<h1>Titre</h1>
<p><?= $variable ?></p>
```

Le contrôleur appelle :
```php
$this->render('dossier/fichier', ['variable' => $valeur]);
```

#### `layout.php` - Template principal
- Header avec navigation
- Zone de contenu dynamique (`<?= $content ?>`)
- Footer
- Gestion du panier dans la navigation

#### Organisation des vues
```
auth/        → Connexion, inscription
cart/        → Panier
order/       → Commandes (checkout, historique, détails)
product/     → Produits (liste, détail)
```

---

### 📁 **public/** - Point d'entrée

#### `index.php` - Bootstrap de l'application
```php
1. Charge l'autoloader Composer
2. Importe les contrôleurs
3. Démarre la session
4. Définit les routes
5. Instancie le Router
6. Dispatch la requête
```

#### `.htaccess` - URL rewriting
Redirige toutes les requêtes vers `index.php` :
```apache
RewriteRule ^ index.php [QSA,L]
```

Permet d'avoir des URLs propres :
- `/product?id=5` au lieu de `/index.php?controller=product&action=show&id=5`

---

## 🗄️ Base de données

### Structure (5 tables)

#### 1. `utilisateur`
```sql
- id (PK)
- nom
- email (UNIQUE)
- mot_de_passe (hashé avec password_hash)
- adresse
- role (client, admin)
```

#### 2. `categorie`
```sql
- id (PK)
- nom
- description
```

#### 3. `produit`
```sql
- id (PK)
- nom
- description
- prix (DECIMAL)
- stock (INT)
- categorie_id (FK → categorie)
```

#### 4. `commande`
```sql
- id (PK)
- date (DATETIME)
- statut (en attente, validée, livrée)
- total (DECIMAL)
- utilisateur_id (FK → utilisateur)
```

#### 5. `order_item`
```sql
- id (PK)
- quantite (INT)
- prix_unitaire (DECIMAL)
- commande_id (FK → commande)
- produit_id (FK → produit)
```

### Relations
```
utilisateur 1→N commande
commande 1→N order_item
produit 1→N order_item
categorie 1→N produit
```

---

## 🔄 Flux de données complet - Exemple

### Exemple : Achat d'un produit

#### 1. **Utilisateur accède à la page d'accueil**
```
Navigateur : GET /mini_mvc/public/
    ↓
.htaccess : Redirige vers index.php
    ↓
index.php : Démarre l'application
    ↓
Router : Analyse l'URL → Route '/' → ProductController::index()
    ↓
ProductController::index() :
    - Appelle Product::findAll()
    - Appelle Categorie::findAll()
    ↓
Product::findAll() :
    - Database::getPDO() pour la connexion
    - Exécute requête SQL JOIN avec categorie
    - Retourne tableau d'objets Product
    ↓
ProductController::index() :
    - Appelle render('product/index', $data)
    ↓
Controller::render() :
    - Charge la vue product/index.php
    - Injecte les données
    - Charge layout.php qui contient la vue
    ↓
Vue product/index.php :
    - Affiche les produits en HTML
    - Formulaire "Ajouter au panier"
    ↓
Navigateur : Affiche la page HTML
```

#### 2. **Utilisateur ajoute au panier**
```
Navigateur : POST /mini_mvc/public/cart/add
    ↓
Router → CartController::add()
    ↓
CartController::add() :
    - Récupère product_id et quantity du POST
    - Vérifie le stock avec Product::find($id)
    - Ajoute/met à jour $_SESSION['cart']
    - Redirection vers /cart
```

#### 3. **Utilisateur passe commande**
```
Navigateur : POST /mini_mvc/public/order/process
    ↓
Router → OrderController::process()
    ↓
OrderController::process() :
    - Vérifie utilisateur connecté
    - Vérifie le panier non vide
    - Vérifie les stocks pour chaque produit
    - Crée Commande et insert()
    - Pour chaque article du panier :
        * Crée OrderItem et insert()
        * Met à jour le stock (Product::updateStock())
    - Vide $_SESSION['cart']
    - Redirection vers confirmation
```

---

## 🔐 Sécurité implémentée

### 1. **Mots de passe**
```php
// Inscription
password_hash($password, PASSWORD_DEFAULT) // Bcrypt

// Connexion
password_verify($password, $hash)
```

### 2. **Sessions**
```php
session_start();
$_SESSION['user_id'] = $user->getId();
```

### 3. **Protection XSS**
```php
htmlspecialchars($variable) // Dans les vues
```

### 4. **Requêtes préparées** (Protection SQL Injection)
```php
$statement = $pdo->prepare('SELECT * FROM produit WHERE id = :id');
$statement->execute(['id' => $id]);
```

### 5. **Vérification d'authentification**
```php
private function checkAuth() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: /login');
        exit;
    }
}
```

---

## 🎨 Design et Responsive

### CSS
- **Flexbox et Grid** pour la mise en page
- **Media queries** pour le responsive
- **Mobile-first** : adapté mobile, tablette, desktop

### Points de rupture
```css
@media (max-width: 768px)  /* Tablette */
@media (max-width: 480px)  /* Mobile */
```

---

## 📊 Composer et Autoloading

### `composer.json`
```json
{
    "autoload": {
        "psr-4": {
            "Mini\\": "app/"
        }
    }
}
```

### Autoloading PSR-4
Permet de charger automatiquement les classes :
```php
use Mini\Controllers\ProductController;
// Composer charge automatiquement app/Controllers/ProductController.php
```

---

## 🚀 Fonctionnalités complètes

### ✅ Fonctionnalités principales
1. **Catalogue produits** : Liste, détail, filtre par catégorie
2. **Authentification** : Inscription, connexion, déconnexion
3. **Panier** : Ajout, modification, suppression
4. **Commandes** : Passage, confirmation, historique
5. **Gestion stock** : Vérification automatique
6. **Interface responsive** : Mobile, tablette, desktop

### 🎁 Fonctionnalités bonus
- Filtre par catégorie
- Décompte panier dans la navigation
- Historique des commandes
- Détail de chaque commande
- Interface moderne et intuitive

---

## 🎓 Points clés à expliquer au professeur

### 1. **Architecture MVC stricte**
"J'ai séparé clairement la logique métier (Models), le traitement des requêtes (Controllers) et l'affichage (Views). Aucune logique métier dans les vues, aucun HTML dans les contrôleurs."

### 2. **Pattern Singleton pour la BDD**
"J'utilise le pattern Singleton pour la connexion à la base de données afin d'avoir une seule instance partagée par toute l'application, ce qui optimise les performances."

### 3. **Système de routage personnalisé**
"J'ai créé un système de routage qui associe des URLs à des contrôleurs et des actions, permettant des URLs propres et une organisation claire du code."

### 4. **Sécurité**
"J'ai implémenté plusieurs mesures de sécurité : hashage des mots de passe avec bcrypt, protection contre les injections SQL avec des requêtes préparées, protection XSS avec htmlspecialchars, et gestion sécurisée des sessions."

### 5. **Gestion des sessions**
"Le panier est stocké en session PHP, ce qui permet de maintenir l'état entre les pages sans base de données. Lors de la commande, je transfère les données vers la BDD."

### 6. **Autoloading PSR-4**
"J'utilise Composer avec l'autoloading PSR-4 pour charger automatiquement les classes sans avoir besoin de require/include manuels, ce qui rend le code plus propre et maintenable."

### 7. **Responsive Design**
"L'interface est entièrement responsive avec CSS Grid et Flexbox, s'adaptant automatiquement aux mobiles, tablettes et ordinateurs."

### 8. **Organisation du code**
"J'ai organisé le code de manière logique avec des dossiers séparés pour chaque type de composant, ce qui facilite la maintenance et l'évolution du projet."

---

## 📈 Améliorations possibles (si demandé)

1. **Panel d'administration** : Gestion des produits, utilisateurs, commandes
2. **Recherche** : Barre de recherche de produits
3. **Pagination** : Pour la liste des produits
4. **Upload d'images** : Pour les produits
5. **Système d'avis** : Notation et commentaires
6. **Paiement en ligne** : Intégration Stripe/PayPal
7. **Email** : Confirmation de commande par email
8. **API REST** : Pour une application mobile

---

## 📝 Conclusion

Ce projet démontre une **maîtrise complète** :
- Du **pattern MVC**
- De la **POO en PHP**
- De la **gestion de base de données**
- De la **sécurité web**
- Du **design responsive**
- Des **bonnes pratiques de développement**

C'est un projet e-commerce fonctionnel, sécurisé et évolutif, développé entièrement en PHP pur sans framework. 🎉
