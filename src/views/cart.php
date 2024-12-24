<h2>Votre Panier</h2>

<?php if (!empty($cartItems)): ?>
    <table class="cart-table">
        <thead>
            <tr>
                <th>Produit</th>
                <th>Prix Unitaire</th>
                <th>Quantité</th>
                <th>Total</th>
                <th></th> <!-- colonne pour le bouton de suppression -->
            </tr>
        </thead>
        <tbody>
            <?php
            $grandTotal = 0;
            foreach ($cartItems as $item):
                $lineTotal = $item['price'] * $item['quantity'];
                $grandTotal += $lineTotal;
                ?>
                <tr>
                    <td><?= htmlspecialchars($item['name']) ?></td>
                    <td><?= htmlspecialchars($item['price']) ?>€</td>
                    <td><?= $item['quantity'] ?></td>
                    <td><?= $lineTotal ?>€</td>
                    <td>
                        <form action="<?= $basePath ?>/cart/remove" method="POST" style="display:inline;">
                            <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                            <button type="submit" class="remove-btn">Retirer</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <p class="cart-total">Total général : <?= $grandTotal ?>€</p>
<?php else: ?>
    <p>Votre panier est vide.</p>
    <p><a href="<?= $basePath ?>/products">Retourner aux produits</a></p>
<?php endif; ?>