<div class="brand-products">
    <h1>Produkter fra <?php echo htmlspecialchars($brand['name'] ?? $brand['brand'] ?? 'Brand'); ?></h1>
    
    <?php if (!empty($brand['description'])): ?>
        <div class="brand-description">
            <?php echo htmlspecialchars($brand['description']); ?>
        </div>
    <?php endif; ?>
    
    <?php if (empty($products)): ?>
        <p>Ingen produkter fundet fra dette brand.</p>
    <?php else: ?>
        <div class="products">
            <?php foreach ($products as $product): ?>
                <div class="product">
                    <?php 
                    // Get image path or use a fallback from existing images
                    $imagePath = $product['image_url'] ?? $product['image'] ?? '0022027_ajax-turretcam-5-mp28-mm-hvid_415.png';
                    
                    // Check if the path already starts with assets/images
                    if (strpos($imagePath, 'assets/images/') === 0) {
                        $imagePath = '/' . $imagePath;
                    } 
                    // Check if the path has ../ prefix
                    else if (strpos($imagePath, '../') === 0) {
                        $imagePath = '/' . preg_replace('/^(\.\.\/)+/', '', $imagePath);
                    }
                    // If it's just a filename, add the path
                    else if (strpos($imagePath, '/') === false) {
                        $imagePath = '/assets/images/' . $imagePath;
                    }
                    ?>
                    <img src="<?php echo htmlspecialchars($imagePath); ?>" 
                         alt="<?php echo htmlspecialchars($product['product_name'] ?? $product['name'] ?? 'Produkt'); ?>">
                    <h3><?php echo htmlspecialchars($product['product_name'] ?? $product['name'] ?? 'Produkt'); ?></h3>
                    <p>DKK <?php echo number_format($product['price'] ?? 0, 2, ',', '.'); ?></p>
                    <a href="/products/<?php echo $product['id']; ?>">Se detaljer</a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div> 