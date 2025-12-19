CREATE TABLE utilisateur (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    adresse VARCHAR(255),
    role VARCHAR(50) NOT NULL
);

CREATE TABLE categorie (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(150) NOT NULL,
    description TEXT
);

CREATE TABLE produit (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(150) NOT NULL,
    description TEXT,
    prix DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL,
    categorie_id INT NOT NULL,

    CONSTRAINT fk_produit_categorie
        FOREIGN KEY (categorie_id)
        REFERENCES categorie(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE INDEX idx_produit_categorie ON produit(categorie_id);

CREATE TABLE commande (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date DATETIME NOT NULL,
    statut VARCHAR(50) NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    utilisateur_id INT NOT NULL,

    CONSTRAINT fk_commande_utilisateur
        FOREIGN KEY (utilisateur_id)
        REFERENCES utilisateur(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE INDEX idx_commande_utilisateur ON commande(utilisateur_id);

CREATE TABLE order_item (
    id INT AUTO_INCREMENT PRIMARY KEY,
    quantite INT NOT NULL,
    prix_unitaire DECIMAL(10,2) NOT NULL,
    commande_id INT NOT NULL,
    produit_id INT NOT NULL,

    CONSTRAINT fk_orderitem_commande
        FOREIGN KEY (commande_id)
        REFERENCES commande(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    CONSTRAINT fk_orderitem_produit
        FOREIGN KEY (produit_id)
        REFERENCES produit(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE INDEX idx_orderitem_commande ON order_item(commande_id);
CREATE INDEX idx_orderitem_produit ON order_item(produit_id);

-- Insertion de données de test

-- Insertion des catégories
INSERT INTO categorie (nom, description) VALUES
('Électronique', 'Appareils électroniques et accessoires'),
('Mode', 'Vêtements et accessoires de mode'),
('Maison & Jardin', 'Articles pour la maison et le jardin'),
('Sport & Loisirs', 'Équipements sportifs et loisirs'),
('Livres', 'Livres et magazines');

-- Insertion des utilisateurs (mot de passe: "password123" hashé)
INSERT INTO utilisateur (nom, email, mot_de_passe, adresse, role) VALUES
('Jean Dupont', 'jean.dupont@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '123 Rue de Paris, 75001 Paris', 'client'),
('Marie Martin', 'marie.martin@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '456 Avenue des Champs, 69000 Lyon', 'client'),
('Admin User', 'admin@ecommerce.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '1 Place de la République, 75011 Paris', 'admin');

-- Insertion des produits
INSERT INTO produit (nom, description, prix, stock, categorie_id) VALUES
-- Électronique
('Smartphone XR Pro', 'Smartphone dernière génération avec écran OLED 6.5 pouces, appareil photo 48MP et batterie longue durée.', 699.99, 25, 1),
('Ordinateur Portable Ultra', 'PC portable 15 pouces, processeur Intel i7, 16GB RAM, SSD 512GB. Parfait pour le travail et les loisirs.', 1299.99, 15, 1),
('Écouteurs Sans Fil Premium', 'Écouteurs Bluetooth avec réduction de bruit active, autonomie 30h, qualité audio exceptionnelle.', 149.99, 50, 1),
('Montre Connectée Sport', 'Montre intelligente avec suivi fitness, GPS, résistante à l\'eau, notifications smartphone.', 249.99, 30, 1),
('Tablette Graphique Pro', 'Tablette 10 pouces, 128GB, stylet inclus, parfaite pour le dessin et la créativité.', 449.99, 20, 1),

-- Mode
('T-shirt Coton Bio', 'T-shirt 100% coton biologique, coupe confortable, disponible en plusieurs couleurs.', 29.99, 100, 2),
('Jean Slim Stretch', 'Jean stretch confortable, coupe moderne, denim de qualité supérieure.', 79.99, 60, 2),
('Baskets Running Pro', 'Chaussures de running légères avec amorti optimal, design moderne et respirant.', 119.99, 40, 2),
('Sac à Dos Urbain', 'Sac à dos élégant avec compartiment ordinateur, imperméable, idéal pour le quotidien.', 59.99, 35, 2),
('Veste d\'hiver Premium', 'Veste chaude et imperméable, coupe-vent, parfaite pour l\'hiver.', 189.99, 25, 2),

-- Maison & Jardin
('Cafetière Automatique', 'Cafetière programmable, carafe en verre, arrêt automatique, capacité 12 tasses.', 89.99, 30, 3),
('Aspirateur Robot Intelligent', 'Robot aspirateur avec navigation intelligente, application mobile, nettoyage automatique.', 399.99, 15, 3),
('Lampe LED Design', 'Lampe de bureau LED avec variateur d\'intensité, design moderne, économie d\'énergie.', 45.99, 45, 3),
('Set Casseroles Inox', 'Set de 5 casseroles en inox de qualité professionnelle, tous feux dont induction.', 159.99, 20, 3),
('Plantes d\'intérieur Pack', 'Assortiment de 3 plantes d\'intérieur faciles d\'entretien avec cache-pots.', 34.99, 50, 3),

-- Sport & Loisirs
('Tapis de Yoga Premium', 'Tapis de yoga antidérapant, 6mm d\'épaisseur, écologique, avec sac de transport.', 39.99, 40, 4),
('Vélo d\'appartement Pro', 'Vélo d\'intérieur avec écran LCD, résistance réglable, pédalier silencieux.', 299.99, 10, 4),
('Ballon de Football Officiel', 'Ballon de football taille officielle, qualité match, coutures renforcées.', 24.99, 60, 4),
('Raquette de Tennis Expert', 'Raquette de tennis professionnelle, manche antidérapant, poids équilibré.', 149.99, 18, 4),
('Kit Camping Complet', 'Kit camping avec tente 4 personnes, sacs de couchage, matelas gonflables.', 279.99, 12, 4),

-- Livres
('Le Guide du Développeur Web', 'Guide complet pour apprendre le développement web moderne: HTML, CSS, JavaScript, PHP.', 49.99, 35, 5),
('Romans Bestseller Pack', 'Collection de 3 romans best-sellers du moment, couvertures souples.', 39.99, 50, 5),
('Manuel de Cuisine Française', 'Livre de recettes traditionnelles françaises, 200 recettes illustrées.', 34.99, 30, 5),
('Encyclopédie du Jardinage', 'Guide complet du jardinage: plantes, techniques, calendrier, photos couleur.', 44.99, 25, 5),
('Livre Audio - Développement Personnel', 'Livre audio format MP3, 10h d\'écoute, techniques de motivation et réussite.', 19.99, 100, 5);

-- Insertion de quelques commandes de test
INSERT INTO commande (date, statut, total, utilisateur_id) VALUES
('2025-12-01 10:30:00', 'livree', 729.98, 1),
('2025-12-05 14:15:00', 'en attente', 279.98, 1),
('2025-12-08 09:45:00', 'validee', 549.97, 2);

-- Insertion des items de commande
INSERT INTO order_item (quantite, prix_unitaire, commande_id, produit_id) VALUES
-- Commande 1
(1, 699.99, 1, 1),
(1, 29.99, 1, 6),

-- Commande 2
(1, 249.99, 2, 4),
(1, 29.99, 2, 6),

-- Commande 3
(1, 399.99, 3, 12),
(1, 149.99, 3, 3);
 
 