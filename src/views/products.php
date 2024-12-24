<h2>Nos micro-ondes</h2>
<ul class="product-list">
    <?php foreach ($products as $product): ?>
        <li class="product-item">
            <a href="<?= $basePath ?>/product/<?= $product['id'] ?>">
                <img src="<?= $basePath . '/' . htmlspecialchars($product['image_url']) ?>"
                    alt="<?= htmlspecialchars($product['name']) ?>" />
                <h3><?= htmlspecialchars($product['name']) ?></h3>
                <p><?= htmlspecialchars($product['price']) ?>€</p>
            </a>
        </li>
    <?php endforeach; ?>
</ul>