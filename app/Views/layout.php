<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'E-Commerce' ?></title>
    <link rel="stylesheet" href="<?= $baseUrl ?>/css/style.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="container navbar-container">
                <div class="nav-left"></div>
                <div class="nav-brand">
                    <a href="<?= $baseUrl ?>/">E-Commerce</a>
                </div>
                <ul class="nav-menu">
                    <li><a href="<?= $baseUrl ?>/">Accueil</a></li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                            <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                                <li><a href="<?= $baseUrl ?>/admin/dashboard">📊 Admin</a></li>
                            <?php endif; ?>
                        <li><a href="<?= $baseUrl ?>/order/history">Commandes</a></li>
                        <li><a href="<?= $baseUrl ?>/logout">Déconnexion</a></li>
                    <?php else: ?>
                        <li><a href="<?= $baseUrl ?>/login">Connexion</a></li>
                        <li><a href="<?= $baseUrl ?>/register">Inscription</a></li>
                    <?php endif; ?>
                    <li>
                        <a href="<?= $baseUrl ?>/cart" class="cart-icon">🛒 <?php 
                            session_status() === PHP_SESSION_NONE && session_start();
                            $cartCount = isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0;
                            echo $cartCount > 0 ? "<span class='cart-count'>$cartCount</span>" : '';
                        ?></a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <main class="container">
        <?= $content ?>
    </main>

    <footer>
        <div class="container">
            <p>&copy; <?= date('Y') ?> E-Commerce - Tous droits réservés</p>
        </div>
    </footer>
</body>
</html>
