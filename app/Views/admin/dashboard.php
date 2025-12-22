<h1>Administration - Gestion des commandes</h1>

<div class="admin-container">
    <div class="admin-stats">
        <div class="stat-card">
            <h3>Total commandes</h3>
            <p class="stat-number"><?= count($commandes) ?></p>
        </div>
    </div>

    <div class="orders-management">
        <table class="orders-table">
            <thead>
                <tr>
                    <th>N° Commande</th>
                    <th>Client</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($commandes as $commande): ?>
                    <tr>
                        <td>#<?= $commande->getId() ?></td>
                        <td><?= htmlspecialchars($commande->utilisateur_nom ?? 'N/A') ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($commande->getDate())) ?></td>
                        <td><?= number_format($commande->getTotal(), 2) ?> €</td>
                        <td>
                            <span class="status-badge status-<?= strtolower(str_replace(' ', '-', $commande->getStatut())) ?>">
                                <?= htmlspecialchars($commande->getStatut()) ?>
                            </span>
                        </td>
                        <td>
                            <form method="POST" action="<?= $baseUrl ?>/admin/update-status" class="status-form">
                                <input type="hidden" name="commande_id" value="<?= $commande->getId() ?>">
                                <select name="statut" onchange="this.form.submit()">
                                    <option value="">-- Modifier --</option>
                                    <option value="en attente">En attente</option>
                                    <option value="en cours de validation">En validation</option>
                                    <option value="en cours de livraison">En livraison</option>
                                    <option value="validee">Validée</option>
                                    <option value="livree">Livrée</option>
                                    <option value="annulee">Annulée</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>