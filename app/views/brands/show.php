<div class="brand-detail">
    <h1><?php echo htmlspecialchars($brand['name']); ?></h1>
    
    <?php if (!empty($brand['logo'])): ?>
        <div class="brand-logo">
            <img src="/assets/images/<?php echo htmlspecialchars($brand['logo']); ?>" 
                 alt="<?php echo htmlspecialchars($brand['name']); ?>">
        </div>
    <?php endif; ?>
    
    <?php if (!empty($brand['description'])): ?>
        <div class="brand-description">
            <?php echo htmlspecialchars($brand['description']); ?>
        </div>
    <?php endif; ?>
    
    <h2>Produkter fra <?php echo htmlspecialchars($brand['name']); ?></h2>
    
    <?php if (empty($products)): ?>
        <p>Ingen produkter fundet fra dette brand.</p>
    <?php else: ?>
        <div class="products">
            <?php foreach ($products as $product): ?>
                <div class="product">
                    <img src="/assets/images/<?php echo htmlspecialchars($product['image_url']); ?>" 
                         alt="<?php echo htmlspecialchars($product['product_name']); ?>">
                    <h3><?php echo htmlspecialchars($product['product_name']); ?></h3>
                    <p>DKK <?php echo number_format($product['price'], 2, ',', '.'); ?></p>
                    <a href="/products/<?php echo $product['id']; ?>">Se detaljer</a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div> 