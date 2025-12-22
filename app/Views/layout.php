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
            <div class="container">
                <div class="nav-brand">
                    <a href="<?= $baseUrl ?>/">🛒 E-Commerce</a>
                </div>
                <ul class="nav-menu">
                    <li><a href="<?= $baseUrl ?>/">Accueil</a></li>
                    <li><a href="<?= $baseUrl ?>/cart">Panier <?php 
                        session_status() === PHP_SESSION_NONE && session_start();
                        $cartCount = isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0;
                        echo $cartCount > 0 ? "($cartCount)" : '';
                    ?></a></li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li><a href="<?= $baseUrl ?>/order/history">Mes commandes</a></li>
                        <li><span>Bonjour, <?= htmlspecialchars($_SESSION['user_nom']) ?></span></li>
                        <li><a href="<?= $baseUrl ?>/logout">Déconnexion</a></li>
                    <?php else: ?>
                        <li><a href="<?= $baseUrl ?>/login">Connexion</a></li>
                        <li><a href="<?= $baseUrl ?>/register">Inscription</a></li>
                    <?php endif; ?>
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
