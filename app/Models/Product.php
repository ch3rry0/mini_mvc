<?php

namespace Mini\Models;

use Mini\Core\Database;
use PDO;

/**
 * Model Product - Gère les produits
 */
class Product
{
    private $id;
    private $nom;
    private $description;
    private $prix;
    private $stock;
    private $categorie_id;

    // Propriétés additionnelles pour les jointures
    private $categorie_nom;

    // =====================
    // Getters / Setters
    // =====================

    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }

    public function getNom() { return $this->nom; }
    public function setNom($nom) { $this->nom = $nom; }

    public function getDescription() { return $this->description; }
    public function setDescription($description) { $this->description = $description; }

    public function getPrix() { return $this->prix; }
    public function setPrix($prix) { $this->prix = $prix; }

    public function getStock() { return $this->stock; }
    public function setStock($stock) { $this->stock = $stock; }

    public function getCategorieId() { return $this->categorie_id; }
    public function setCategorieId($categorie_id) { $this->categorie_id = $categorie_id; }

    public function getCategorieNom() { return $this->categorie_nom; }
    public function setCategorieNom($categorie_nom) { $this->categorie_nom = $categorie_nom; }

    // =====================
    // Méthodes CRUD
    // =====================

    /**
     * Récupère tous les produits avec leur catégorie
     */
    public static function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT p.*, c.nom as categorie_nom 
                FROM produit p
                LEFT JOIN categorie c ON p.categorie_id = c.id
                ORDER BY p.id DESC';
        $statement = $pdo->query($sql);
        return $statement->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    /**
     * Récupère les produits par catégorie
     */
    public static function findByCategorie($categorie_id)
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT p.*, c.nom as categorie_nom 
                FROM produit p
                LEFT JOIN categorie c ON p.categorie_id = c.id
                WHERE p.categorie_id = :categorie_id
                ORDER BY p.id DESC';
        $statement = $pdo->prepare($sql);
        $statement->execute(['categorie_id' => $categorie_id]);
        return $statement->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    /**
     * Trouve un produit par ID
     */
    public static function find($id)
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT p.*, c.nom as categorie_nom 
                FROM produit p
                LEFT JOIN categorie c ON p.categorie_id = c.id
                WHERE p.id = :id';
        $statement = $pdo->prepare($sql);
        $statement->execute(['id' => $id]);
        $statement->setFetchMode(PDO::FETCH_CLASS, self::class);
        return $statement->fetch();
    }

    /**
     * Met à jour le stock d'un produit
     */
    public function updateStock($quantity)
    {
        $pdo = Database::getPDO();
        $sql = 'UPDATE produit SET stock = stock - :quantity WHERE id = :id';
        $statement = $pdo->prepare($sql);
        return $statement->execute([
            'id' => $this->id,
            'quantity' => $quantity
        ]);
    }
}
