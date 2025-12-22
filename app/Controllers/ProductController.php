<?php

namespace Mini\Controllers;

use Mini\Core\Controller;
use Mini\Models\Product;
use Mini\Models\Categorie;

/**
 * ProductController - Gère l'affichage des produits
 */
class ProductController extends Controller
{
    /**
     * Page d'accueil - Liste tous les produits
     */
    public function index()
    {
        // Récupérer le filtre catégorie s'il existe
        $categorie_id = isset($_GET['categorie']) ? (int)$_GET['categorie'] : null;
        
        // Récupérer les produits (filtrés ou tous)
        if ($categorie_id) {
            $products = Product::findByCategorie($categorie_id);
        } else {
            $products = Product::findAll();
        }
        
        // Récupérer toutes les catégories pour le filtre
        $categories = Categorie::findAll();
        
        // Afficher la vue
        $this->render('product/index', [
            'products' => $products,
            'categories' => $categories,
            'categorie_id' => $categorie_id
        ]);
    }

    /**
     * Page détail d'un produit
     */
    public function show()
    {
        // Récupérer l'ID du produit
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
        // Récupérer le produit
        $product = Product::find($id);
        
        if (!$product) {
            header('Location: ' . BASE_URL . '/');
            exit;
        }
        
        // Afficher la vue
        $this->render('product/show', [
            'product' => $product
        ]);
    }
}
