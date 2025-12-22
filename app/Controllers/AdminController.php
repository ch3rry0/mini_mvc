<?php
namespace Mini\Controllers;

use Mini\Core\Controller;
use Mini\Core\AdminMiddleware;
use Mini\Models\Commande;

class AdminController extends Controller
{
    /**
     * Dashboard admin - Liste des commandes
     */
    public function dashboard()
    {
        AdminMiddleware::checkAdmin();
        
        $commandes = Commande::findAll();
        
        $this->render('admin/dashboard', [
            'commandes' => $commandes
        ]);
    }
    
    /**
     * Mettre à jour le statut d'une commande
     */
    public function updateStatus()
    {
        AdminMiddleware::checkAdmin();
        
        $id = isset($_POST['commande_id']) ? (int)$_POST['commande_id'] : 0;
        $statut = $_POST['statut'] ?? '';
        
        $statuts_valides = ['en attente', 'en cours de validation', 'en cours de livraison', 'validee', 'livree', 'annulee'];
        
        if ($id > 0 && in_array($statut, $statuts_valides)) {
            $commande = Commande::find($id);
            if ($commande) {
                $commande->updateStatut($statut);
            }
        }
        
        header('Location: ' . BASE_URL . '/admin/dashboard');
        exit;
    }
}