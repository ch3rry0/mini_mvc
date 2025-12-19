<div class="product-detail">
    <div class="product-detail-container">
        <div class="product-detail-image">
            <span class="product-placeholder-large">📦</span>
        </div>
        <div class="product-detail-info">
            <h1><?= htmlspecialchars($product->getNom()) ?></h1>
            <p class="product-category-badge"><?= htmlspecialchars($product->getCategorieNom()) ?></p>
            
            <div class="product-price-large">
                <?= number_format($product->getPrix(), 2) ?> €
            </div>

            <div class="product-description-full">
                <h3>Description</h3>
                <p><?= nl2br(htmlspecialchars($product->getDescription())) ?></p>
            </div>

            <div class="product-stock-info">
                <?php if ($product->getStock() > 0): ?>
                    <span class="in-stock">✓ En stock (<?= $product->getStock() ?> disponibles)</span>
                <?php else: ?>
                    <span class="out-of-stock">✗ Rupture de stock</span>
                <?php endif; ?>
            </div>

            <?php if ($product->getStock() > 0): ?>
                <form method="POST" action="/mini_mvc/public/cart/add" class="add-to-cart-form">
                    <input type="hidden" name="product_id" value="<?= $product->getId() ?>">
                    <div class="quantity-selector">
                        <label for="quantity">Quantité :</label>
                        <input type="number" id="quantity" name="quantity" value="1" min="1" max="<?= $product->getStock() ?>">
                    </div>
                    <button type="submit" class="btn btn-primary btn-large">Ajouter au panier</button>
                </form>
            <?php endif; ?>

            <a href="/mini_mvc/public/" class="btn btn-secondary">← Retour aux produits</a>
        </div>
    </div>
</div>
