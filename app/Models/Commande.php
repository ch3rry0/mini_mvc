<?php

namespace Mini\Models;

use Mini\Core\Database;
use PDO;

/**
 * Model Commande - Gère les commandes
 */
class Commande
{
    private $id;
    private $date;
    private $statut;
    private $total;
    private $utilisateur_id;

    // =====================
    // Getters / Setters
    // =====================

    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }

    public function getDate() { return $this->date; }
    public function setDate($date) { $this->date = $date; }

    public function getStatut() { return $this->statut; }
    public function setStatut($statut) { $this->statut = $statut; }

    public function getTotal() { return $this->total; }
    public function setTotal($total) { $this->total = $total; }

    public function getUtilisateurId() { return $this->utilisateur_id; }
    public function setUtilisateurId($utilisateur_id) { $this->utilisateur_id = $utilisateur_id; }

    // =====================
    // Méthodes CRUD
    // =====================

    /**
     * Crée une nouvelle commande
     */
    public function insert()
    {
        $pdo = Database::getPDO();
        $sql = 'INSERT INTO commande (date, statut, total, utilisateur_id) 
                VALUES (:date, :statut, :total, :utilisateur_id)';
        $statement = $pdo->prepare($sql);
        $statement->execute([
            'date' => $this->date,
            'statut' => $this->statut,
            'total' => $this->total,
            'utilisateur_id' => $this->utilisateur_id
        ]);
        $this->id = $pdo->lastInsertId();
        return $this->id;
    }
    // Récupérer toutes les commandes (admin)
    public static function findAll(): array
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT c.*, u.nom as utilisateur_nom, u.email as utilisateur_email 
                FROM commande c 
                JOIN utilisateur u ON c.utilisateur_id = u.id 
                ORDER BY c.date DESC';
        $statement = $pdo->prepare($sql);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_CLASS, self::class);
        return $statement->fetchAll();
    }
    /**
     * Récupère les commandes d'un utilisateur
     */
    public static function findByUtilisateur($utilisateur_id)
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM commande 
                WHERE utilisateur_id = :utilisateur_id 
                ORDER BY date DESC';
        $statement = $pdo->prepare($sql);
        $statement->execute(['utilisateur_id' => $utilisateur_id]);
        return $statement->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    /**
     * Trouve une commande par ID
     */
    public static function find($id)
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM commande WHERE id = :id';
        $statement = $pdo->prepare($sql);
        $statement->execute(['id' => $id]);
        $statement->setFetchMode(PDO::FETCH_CLASS, self::class);
        return $statement->fetch();
    }

    /**
     * Récupère les items d'une commande avec les détails produits
     */
    public function getItems()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT oi.*, p.nom as produit_nom 
                FROM order_item oi
                JOIN produit p ON oi.produit_id = p.id
                WHERE oi.commande_id = :commande_id';
        $statement = $pdo->prepare($sql);
        $statement->execute(['commande_id' => $this->id]);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    // Mettre à jour le statut d'une commande
    public function updateStatut(string $statut): void {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("UPDATE commande SET statut = :statut WHERE id = :id");
        $stmt->execute([':statut' => $statut, ':id' => $this->id]);
        $this->statut = $statut;
    }
}
