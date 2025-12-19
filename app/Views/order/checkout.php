<h1>Confirmation de commande</h1>

<?php if (isset($errors) && !empty($errors)): ?>
    <div class="alert alert-error">
        <?php foreach ($errors as $error): ?>
            <p><?= htmlspecialchars($error) ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<div class="checkout-container">
    <div class="checkout-summary">
        <h2>Récapitulatif de votre commande</h2>
        
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Prix unitaire</th>
                    <th>Quantité</th>
                    <th>Sous-total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cartItems as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['product']->getNom()) ?></td>
                        <td><?= number_format($item['product']->getPrix(), 2) ?> €</td>
                        <td><?= $item['quantity'] ?></td>
                        <td><?= number_format($item['subtotal'], 2) ?> €</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3"><strong>Total</strong></td>
                    <td><strong><?= number_format($total, 2) ?> €</strong></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="checkout-actions">
        <form method="POST" action="/mini_mvc/public/order/process">
            <p>En confirmant cette commande, vous acceptez nos conditions de vente.</p>
            <button type="submit" class="btn btn-primary btn-large">Confirmer la commande</button>
        </form>
        <a href="/mini_mvc/public/cart" class="btn btn-secondary">Retour au panier</a>
    </div>
</div>
