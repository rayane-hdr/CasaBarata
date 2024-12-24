<h2><?= htmlspecialchars($product['name']) ?></h2>
<img src="<?= $basePath . '/' . htmlspecialchars($product['image_url']) ?>"
    alt="<?= htmlspecialchars($product['name']) ?>" />

<p>Prix : <?= htmlspecialchars($product['price']) ?>€</p>
<p>Description : <?= htmlspecialchars($product['description']) ?></p>

<form action="<?= $basePath ?>/cart/add" method="POST">
    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
    <button type="submit">Ajouter au panier</button>
</form>