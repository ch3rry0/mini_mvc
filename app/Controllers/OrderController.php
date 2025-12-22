<?php

namespace Mini\Controllers;

use Mini\Core\Controller;
use Mini\Models\Commande;
use Mini\Models\OrderItem;
use Mini\Models\Product;

/**
 * OrderController - Gère les commandes
 */
class OrderController extends Controller
{
    /**
     * Vérifie que l'utilisateur est connecté
     */
    private function checkAuth()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
    }

    /**
     * Page de passage de commande
     */
    public function checkout()
    {
        $this->checkAuth();
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Vérifier que le panier n'est pas vide
        if (empty($_SESSION['cart'])) {
            header('Location: ' . BASE_URL . '/cart');
            exit;
        }

        // Calculer le total
        $total = 0;
        $cartItems = [];
        
        foreach ($_SESSION['cart'] as $product_id => $quantity) {
            $product = Product::find($product_id);
            if ($product) {
                $subtotal = $product->getPrix() * $quantity;
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'subtotal' => $subtotal
                ];
                $total += $subtotal;
            }
        }

        $this->render('order/checkout', [
            'cartItems' => $cartItems,
            'total' => $total
        ]);
    }

    /**
     * Valide et crée la commande
     */
    public function process()
    {
        $this->checkAuth();
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Vérifier que le panier n'est pas vide
        if (empty($_SESSION['cart'])) {
            header('Location: ' . BASE_URL . '/cart');
            exit;
        }

        // Calculer le total et vérifier les stocks
        $total = 0;
        $errors = [];
        
        foreach ($_SESSION['cart'] as $product_id => $quantity) {
            $product = Product::find($product_id);
            if (!$product) {
                $errors[] = "Produit #{$product_id} introuvable";
                continue;
            }
            
            if ($product->getStock() < $quantity) {
                $errors[] = "Stock insuffisant pour {$product->getNom()}";
            }
            
            $total += $product->getPrix() * $quantity;
        }

        if (!empty($errors)) {
            $this->render('order/checkout', ['errors' => $errors]);
            return;
        }

        // Créer la commande
        $commande = new Commande();
        $commande->setDate(date('Y-m-d H:i:s'));
        $commande->setStatut('en attente');
        $commande->setTotal($total);
        $commande->setUtilisateurId($_SESSION['user_id']);
        $commande_id = $commande->insert();

        // Créer les items de commande et mettre à jour les stocks
        foreach ($_SESSION['cart'] as $product_id => $quantity) {
            $product = Product::find($product_id);
            
            // Créer l'item
            $orderItem = new OrderItem();
            $orderItem->setQuantite($quantity);
            $orderItem->setPrixUnitaire($product->getPrix());
            $orderItem->setCommandeId($commande_id);
            $orderItem->setProduitId($product_id);
            $orderItem->insert();
            
            // Mettre à jour le stock
            $product->updateStock($quantity);
        }

        // Vider le panier
        $_SESSION['cart'] = [];

        // Rediriger vers la page de confirmation
        header("Location: " . BASE_URL . "/order/confirmation?id={$commande_id}");
        exit;
    }

    /**
     * Page de confirmation de commande
     */
    public function confirmation()
    {
        $this->checkAuth();
        
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $commande = Commande::find($id);

        if (!$commande) {
            header('Location: ' . BASE_URL . '/');
            exit;
        }

        // Récupérer les items
        $items = $commande->getItems();

        $this->render('order/confirmation', [
            'commande' => $commande,
            'items' => $items
        ]);
    }

    /**
     * Historique des commandes (espace client)
     */
    public function history()
    {
        $this->checkAuth();
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $commandes = Commande::findByUtilisateur($_SESSION['user_id']);

        $this->render('order/history', [
            'commandes' => $commandes
        ]);
    }

    /**
     * Détail d'une commande
     */
    public function detail()
    {
        $this->checkAuth();
        
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $commande = Commande::find($id);

        if (!$commande) {
            header('Location: ' . BASE_URL . '/order/history');
            exit;
        }

        // Vérifier que la commande appartient bien à l'utilisateur connecté
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if ($commande->getUtilisateurId() != $_SESSION['user_id']) {
            header('Location: ' . BASE_URL . '/order/history');
            exit;
        }

        // Récupérer les items
        $items = $commande->getItems();

        $this->render('order/detail', [
            'commande' => $commande,
            'items' => $items
        ]);
    }
}
