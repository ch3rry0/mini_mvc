<?php

namespace Mini\Controllers;

use Mini\Core\Controller;
use Mini\Models\Product;

/**
 * CartController - Gère le panier d'achat (session)
 */
class CartController extends Controller
{
    /**
     * Initialise la session si nécessaire
     */
    private function initSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    /**
     * Affiche le panier
     */
    public function index()
    {
        $this->initSession();
        
        $cartItems = [];
        $total = 0;

        // Récupérer les détails de chaque produit dans le panier
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

        $this->render('cart/index', [
            'cartItems' => $cartItems,
            'total' => $total
        ]);
    }

    /**
     * Ajoute un produit au panier
     */
    public function add()
    {
        $this->initSession();
        
        $product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
        $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

        if ($product_id > 0 && $quantity > 0) {
            // Vérifier que le produit existe
            $product = Product::find($product_id);
            
            if ($product && $product->getStock() >= $quantity) {
                // Ajouter ou mettre à jour la quantité
                if (isset($_SESSION['cart'][$product_id])) {
                    $_SESSION['cart'][$product_id] += $quantity;
                } else {
                    $_SESSION['cart'][$product_id] = $quantity;
                }
                
                // Vérifier que la quantité totale ne dépasse pas le stock
                if ($_SESSION['cart'][$product_id] > $product->getStock()) {
                    $_SESSION['cart'][$product_id] = $product->getStock();
                }
            }
        }

        header('Location: /cart');
        exit;
    }

    /**
     * Met à jour la quantité d'un produit dans le panier
     */
    public function update()
    {
        $this->initSession();
        
        $product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
        $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 0;

        if ($product_id > 0) {
            if ($quantity > 0) {
                // Vérifier le stock
                $product = Product::find($product_id);
                if ($product && $quantity <= $product->getStock()) {
                    $_SESSION['cart'][$product_id] = $quantity;
                }
            } else {
                // Supprimer l'article si quantité = 0
                unset($_SESSION['cart'][$product_id]);
            }
        }

        header('Location: /cart');
        exit;
    }

    /**
     * Supprime un produit du panier
     */
    public function remove()
    {
        $this->initSession();
        
        $product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        if ($product_id > 0 && isset($_SESSION['cart'][$product_id])) {
            unset($_SESSION['cart'][$product_id]);
        }

        header('Location: /cart');
        exit;
    }

    /**
     * Vide complètement le panier
     */
    public function clear()
    {
        $this->initSession();
        $_SESSION['cart'] = [];
        
        header('Location: /cart');
        exit;
    }
}
