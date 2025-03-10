<div class="brands-section">
    <h1>Alle Brands</h1>
    
    <div class="brands">
        <?php foreach ($brands as $brand): ?>
            <a href="/brands/<?php echo $brand['id']; ?>">
                <div class="brand">
                    <?php if (!empty($brand['logo'])): ?>
                        <img src="/assets/images/<?php echo htmlspecialchars($brand['logo']); ?>" 
                             alt="<?php echo htmlspecialchars($brand['name']); ?>">
                    <?php endif; ?>
                    <h3><?php echo htmlspecialchars($brand['name']); ?></h3>
                    <p><?php echo $brand['product_count']; ?> produkter</p>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</div> 