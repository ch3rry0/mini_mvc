<?php
namespace Mini\Core;

class AdminMiddleware
{
    public static function checkAdmin(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
        
        // Vérifier si l'utilisateur est admin
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            // Rediriger vers l'accueil avec un message d'erreur
            header('Location: ' . BASE_URL . '/');
            exit;
        }
    }
}