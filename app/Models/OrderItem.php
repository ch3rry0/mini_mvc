<?php

namespace Mini\Models;

use Mini\Core\Database;
use PDO;

/**
 * Model OrderItem - Gère les items de commande
 */
class OrderItem
{
    private $id;
    private $quantite;
    private $prix_unitaire;
    private $commande_id;
    private $produit_id;

    // =====================
    // Getters / Setters
    // =====================

    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }

    public function getQuantite() { return $this->quantite; }
    public function setQuantite($quantite) { $this->quantite = $quantite; }

    public function getPrixUnitaire() { return $this->prix_unitaire; }
    public function setPrixUnitaire($prix_unitaire) { $this->prix_unitaire = $prix_unitaire; }

    public function getCommandeId() { return $this->commande_id; }
    public function setCommandeId($commande_id) { $this->commande_id = $commande_id; }

    public function getProduitId() { return $this->produit_id; }
    public function setProduitId($produit_id) { $this->produit_id = $produit_id; }

    // =====================
    // Méthodes CRUD
    // =====================

    /**
     * Crée un nouvel item de commande
     */
    public function insert()
    {
        $pdo = Database::getPDO();
        $sql = 'INSERT INTO order_item (quantite, prix_unitaire, commande_id, produit_id) 
                VALUES (:quantite, :prix_unitaire, :commande_id, :produit_id)';
        $statement = $pdo->prepare($sql);
        $statement->execute([
            'quantite' => $this->quantite,
            'prix_unitaire' => $this->prix_unitaire,
            'commande_id' => $this->commande_id,
            'produit_id' => $this->produit_id
        ]);
        $this->id = $pdo->lastInsertId();
    }
}
