<h1>Nos Produits</h1>

<!-- Filtre par catégorie -->
<div class="filter-section">
    <form method="GET" action="<?= $baseUrl ?>/">
        <label for="categorie">Filtrer par catégorie :</label>
        <select name="categorie" id="categorie" onchange="this.form.submit()">
            <option value="">Toutes les catégories</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat->getId() ?>" <?= $categorie_id == $cat->getId() ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat->getNom()) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>
</div>

<!-- Liste des produits -->
<div class="products-grid">
    <?php if (empty($products)): ?>
        <p>Aucun produit disponible.</p>
    <?php else: ?>
        <?php foreach ($products as $product): ?>
            <div class="product-card">
                <div class="product-image">
                    <span class="product-placeholder">📦</span>
                </div>
                <div class="product-info">
                    <h3><?= htmlspecialchars($product->getNom()) ?></h3>
                    <p class="product-category"><?= htmlspecialchars($product->getCategorieNom()) ?></p>
                    <p class="product-description"><?= htmlspecialchars(substr($product->getDescription(), 0, 100)) ?>...</p>
                    <p class="product-price"><?= number_format($product->getPrix(), 2) ?> €</p>
                    <p class="product-stock">
                        <?php if ($product->getStock() > 0): ?>
                            <span class="in-stock">En stock (<?= $product->getStock() ?>)</span>
                        <?php else: ?>
                            <span class="out-of-stock">Rupture de stock</span>
                        <?php endif; ?>
                    </p>
                    <div class="product-actions">
                        <a href="<?= $baseUrl ?>/product?id=<?= $product->getId() ?>" class="btn btn-secondary">Voir détails</a>
                        <?php if ($product->getStock() > 0): ?>
                            <form method="POST" action="<?= $baseUrl ?>/cart/add" style="display:inline;">
                                <input type="hidden" name="product_id" value="<?= $product->getId() ?>">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-primary">Ajouter au panier</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
