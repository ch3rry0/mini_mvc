<h1>Détail de la commande #<?= $commande->getId() ?></h1>

<div class="order-detail-container">
    <div class="order-info">
        <h2>Informations</h2>
        <p><strong>Date :</strong> <?= date('d/m/Y H:i', strtotime($commande->getDate())) ?></p>
        <p><strong>Statut :</strong> 
            <span class="status-badge status-<?= strtolower(str_replace(' ', '-', $commande->getStatut())) ?>">
                <?= htmlspecialchars($commande->getStatut()) ?>
            </span>
        </p>
        <p><strong>Total :</strong> <span class="price-large"><?= number_format($commande->getTotal(), 2) ?> €</span></p>
    </div>

    <div class="order-items-detail">
        <h2>Articles commandés</h2>
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
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['produit_nom']) ?></td>
                        <td><?= number_format($item['prix_unitaire'], 2) ?> €</td>
                        <td><?= $item['quantite'] ?></td>
                        <td><?= number_format($item['prix_unitaire'] * $item['quantite'], 2) ?> €</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3"><strong>Total</strong></td>
                    <td><strong><?= number_format($commande->getTotal(), 2) ?> €</strong></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="order-actions">
        <a href="<?= $baseUrl ?>/order/history" class="btn btn-secondary">← Retour à mes commandes</a>
    </div>
</div>
