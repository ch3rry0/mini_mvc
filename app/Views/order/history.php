<h1>Mes commandes</h1>

<?php if (empty($commandes)): ?>
    <div class="empty-state">
        <p>Vous n'avez pas encore passé de commande.</p>
        <a href="<?= $baseUrl ?>/" class="btn btn-primary">Découvrir nos produits</a>
    </div>
<?php else: ?>
    <div class="orders-list">
        <table class="orders-table">
            <thead>
                <tr>
                    <th>N° Commande</th>
                    <th>Date</th>
                    <th>Statut</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($commandes as $commande): ?>
                    <tr>
                        <td>#<?= $commande->getId() ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($commande->getDate())) ?></td>
                        <td>
                            <span class="status-badge status-<?= strtolower(str_replace(' ', '-', $commande->getStatut())) ?>">
                                <?= htmlspecialchars($commande->getStatut()) ?>
                            </span>
                        </td>
                        <td><strong><?= number_format($commande->getTotal(), 2) ?> €</strong></td>
                        <td>
                            <a href="<?= $baseUrl ?>/order/detail?id=<?= $commande->getId() ?>" class="btn btn-secondary btn-small">
                                Voir détails
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
