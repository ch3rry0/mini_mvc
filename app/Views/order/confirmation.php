<div class="confirmation-container">
    <div class="confirmation-box">
        <div class="confirmation-icon">✓</div>
        <h1>Commande validée !</h1>
        <p>Merci pour votre commande. Votre commande n°<?= $commande->getId() ?> a bien été enregistrée.</p>
        
        <div class="order-summary">
            <h2>Récapitulatif</h2>
            <p><strong>Date :</strong> <?= date('d/m/Y H:i', strtotime($commande->getDate())) ?></p>
            <p><strong>Statut :</strong> <?= htmlspecialchars($commande->getStatut()) ?></p>
            <p><strong>Total :</strong> <?= number_format($commande->getTotal(), 2) ?> €</p>
            
            <h3>Articles commandés</h3>
            <ul class="order-items">
                <?php foreach ($items as $item): ?>
                    <li>
                        <?= htmlspecialchars($item['produit_nom']) ?> - 
                        Quantité: <?= $item['quantite'] ?> - 
                        Prix: <?= number_format($item['prix_unitaire'] * $item['quantite'], 2) ?> €
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="confirmation-actions">
            <a href="<?= $baseUrl ?>/" class="btn btn-primary">Retour à l'accueil</a>
            <a href="<?= $baseUrl ?>/order/history" class="btn btn-secondary">Mes commandes</a>
        </div>
    </div>
</div>
