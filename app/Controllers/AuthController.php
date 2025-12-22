<?php

namespace Mini\Controllers;

use Mini\Core\Controller;
use Mini\Models\Utilisateur;

/**
 * AuthController - Gère l'authentification (inscription/connexion/déconnexion)
 */
class AuthController extends Controller
{
    /**
     * Affiche le formulaire de connexion
     */
    public function login()
    {
        $this->render('auth/login');
    }

    /**
     * Traite la connexion
     */
    public function loginPost()
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $errors = [];

        // Validation
        if (empty($email) || empty($password)) {
            $errors[] = 'Tous les champs sont obligatoires';
        }

        if (empty($errors)) {
            // Chercher l'utilisateur
            $user = Utilisateur::findByEmail($email);
            
            if ($user && password_verify($password, $user->getMotDePasse())) {
                // Connexion réussie
                session_start();
                $_SESSION['user_id'] = $user->getId();
                $_SESSION['user_nom'] = $user->getNom();
                $_SESSION['user_role'] = $user->getRole();
                
                header('Location: ' . BASE_URL . '/');
                exit;
            } else {
                $errors[] = 'Email ou mot de passe incorrect';
            }
        }

        // Afficher le formulaire avec les erreurs
        $this->render('auth/login', ['errors' => $errors]);
    }

    /**
     * Affiche le formulaire d'inscription
     */
    public function register()
    {
        $this->render('auth/register');
    }

    /**
     * Traite l'inscription
     */
    public function registerPost()
    {
        $nom = $_POST['nom'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $password_confirm = $_POST['password_confirm'] ?? '';
        $adresse = $_POST['adresse'] ?? '';
        $errors = [];

        // Validation
        if (empty($nom) || empty($email) || empty($password)) {
            $errors[] = 'Tous les champs obligatoires doivent être remplis';
        }

        if ($password !== $password_confirm) {
            $errors[] = 'Les mots de passe ne correspondent pas';
        }

        if (strlen($password) < 6) {
            $errors[] = 'Le mot de passe doit contenir au moins 6 caractères';
        }

        // Vérifier si l'email existe déjà
        if (empty($errors) && Utilisateur::findByEmail($email)) {
            $errors[] = 'Cet email est déjà utilisé';
        }

        if (empty($errors)) {
            // Créer l'utilisateur
            $user = new Utilisateur();
            $user->setNom($nom);
            $user->setEmail($email);
            $user->setMotDePasse(password_hash($password, PASSWORD_DEFAULT));
            $user->setAdresse($adresse);
            $user->setRole('client'); // Par défaut
            $user->insert();

            // Connexion automatique
            session_start();
            $_SESSION['user_id'] = $user->getId();
            $_SESSION['user_nom'] = $user->getNom();
            $_SESSION['user_role'] = $user->getRole();

            header('Location: ' . BASE_URL . '/');
            exit;
        }

        // Afficher le formulaire avec les erreurs
        $this->render('auth/register', [
            'errors' => $errors,
            'nom' => $nom,
            'email' => $email,
            'adresse' => $adresse
        ]);
    }

    /**
     * Déconnexion
     */
    public function logout()
    {
        session_start();
        session_destroy();
        header('Location: ' . BASE_URL . '/');
        exit;
    }
}
