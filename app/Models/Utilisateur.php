<?php

namespace Mini\Models;

use Mini\Core\Database;
use PDO;

/**
 * Model Utilisateur - Gère les utilisateurs du système
 */
class Utilisateur
{
    private $id;
    private $nom;
    private $email;
    private $mot_de_passe;
    private $adresse;
    private $role;

    // =====================
    // Getters / Setters
    // =====================

    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }

    public function getNom() { return $this->nom; }
    public function setNom($nom) { $this->nom = $nom; }

    public function getEmail() { return $this->email; }
    public function setEmail($email) { $this->email = $email; }

    public function getMotDePasse() { return $this->mot_de_passe; }
    public function setMotDePasse($mot_de_passe) { $this->mot_de_passe = $mot_de_passe; }

    public function getAdresse() { return $this->adresse; }
    public function setAdresse($adresse) { $this->adresse = $adresse; }

    public function getRole() { return $this->role; }
    public function setRole($role) { $this->role = $role; }

    // =====================
    // Méthodes CRUD
    // =====================
    public static function getAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM utilisateur ORDER BY nom';
        $statement = $pdo->query($sql);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    /**
     * Trouve un utilisateur par email
     */
    public static function findByEmail($email)
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM utilisateur WHERE email = :email';
        $statement = $pdo->prepare($sql);
        $statement->execute(['email' => $email]);
        $statement->setFetchMode(PDO::FETCH_CLASS, self::class);
        return $statement->fetch();
    }

    /**
     * Trouve un utilisateur par ID
     */
    public static function find($id)
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM utilisateur WHERE id = :id';
        $statement = $pdo->prepare($sql);
        $statement->execute(['id' => $id]);
        $statement->setFetchMode(PDO::FETCH_CLASS, self::class);
        return $statement->fetch();
    }

    /**
     * Crée un nouvel utilisateur
     */
    public function insert()
    {
        $pdo = Database::getPDO();
        $sql = 'INSERT INTO utilisateur (nom, email, mot_de_passe, adresse, role) 
                VALUES (:nom, :email, :mot_de_passe, :adresse, :role)';
        $statement = $pdo->prepare($sql);
        $statement->execute([
            'nom' => $this->nom,
            'email' => $this->email,
            'mot_de_passe' => $this->mot_de_passe,
            'adresse' => $this->adresse,
            'role' => $this->role
        ]);
        $this->id = $pdo->lastInsertId();
    }

    /**
     * Met à jour un utilisateur
     */
    public function update()
    {
        $pdo = Database::getPDO();
        $sql = 'UPDATE utilisateur 
                SET nom = :nom, email = :email, adresse = :adresse, role = :role
                WHERE id = :id';
        $statement = $pdo->prepare($sql);
        return $statement->execute([
            'id' => $this->id,
            'nom' => $this->nom,
            'email' => $this->email,
            'adresse' => $this->adresse,
            'role' => $this->role
        ]);
    }
}
