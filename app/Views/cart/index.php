<h1>Mon Panier</h1>

<?php if (empty($cartItems)): ?>
    <div class="empty-cart">
        <p>Votre panier est vide.</p>
        <a href="/mini_mvc/public/" class="btn btn-primary">Continuer mes achats</a>
    </div>
<?php else: ?>
    <div class="cart-container">
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Prix unitaire</th>
                    <th>Quantité</th>
                    <th>Sous-total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cartItems as $item): ?>
                    <tr>
                        <td>
                            <a href="/mini_mvc/public/product?id=<?= $item['product']->getId() ?>">
                                <?= htmlspecialchars($item['product']->getNom()) ?>
                            </a>
                        </td>
                        <td><?= number_format($item['product']->getPrix(), 2) ?> €</td>
                        <td>
                            <form method="POST" action="/mini_mvc/public/cart/update" class="quantity-form">
                                <input type="hidden" name="product_id" value="<?= $item['product']->getId() ?>">
                                <input type="number" name="quantity" value="<?= $item['quantity'] ?>" 
                                       min="1" max="<?= $item['product']->getStock() ?>" 
                                       onchange="this.form.submit()">
                            </form>
                        </td>
                        <td><strong><?= number_format($item['subtotal'], 2) ?> €</strong></td>
                        <td>
                            <a href="/mini_mvc/public/cart/remove?id=<?= $item['product']->getId() ?>" 
                               class="btn btn-danger btn-small"
                               onclick="return confirm('Supprimer cet article ?')">
                                Supprimer
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="cart-summary">
            <div class="cart-total">
                <h2>Total : <?= number_format($total, 2) ?> €</h2>
            </div>
            <div class="cart-actions">
                <a href="/mini_mvc/public/" class="btn btn-secondary">Continuer mes achats</a>
                <a href="/mini_mvc/public/order/checkout" class="btn btn-primary btn-large">Passer la commande</a>
            </div>
        </div>
    </div>
<?php endif; ?>
