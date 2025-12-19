<?php

namespace Mini\Models;

use Mini\Core\Database;
use PDO;

/**
 * Model Categorie - Gère les catégories de produits
 */
class Categorie
{
    private $id;
    private $nom;
    private $description;

    // =====================
    // Getters / Setters
    // =====================

    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }

    public function getNom() { return $this->nom; }
    public function setNom($nom) { $this->nom = $nom; }

    public function getDescription() { return $this->description; }
    public function setDescription($description) { $this->description = $description; }

    // =====================
    // Méthodes CRUD
    // =====================

    /**
     * Récupère toutes les catégories
     */
    public static function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM categorie ORDER BY nom';
        $statement = $pdo->query($sql);
        return $statement->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    /**
     * Trouve une catégorie par ID
     */
    public static function find($id)
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM categorie WHERE id = :id';
        $statement = $pdo->prepare($sql);
        $statement->execute(['id' => $id]);
        $statement->setFetchMode(PDO::FETCH_CLASS, self::class);
        return $statement->fetch();
    }
}
