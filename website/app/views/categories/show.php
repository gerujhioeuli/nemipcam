<div class="category-detail">
    <h1><?php echo htmlspecialchars($category['navn'] ?? $category['name'] ?? 'Kategori'); ?></h1>
    
    <?php if (!empty($category['description'])): ?>
        <div class="category-description">
            <?php echo htmlspecialchars($category['description']); ?>
        </div>
    <?php endif; ?>
    
    <div class="products">
        <?php if (empty($products)): ?>
            <p>Ingen produkter fundet i denne kategori.</p>
        <?php else: ?>
            <?php foreach ($products as $product): ?>
                <div class="product">
                    <?php 
                    // Get image path or use a fallback
                    $imagePath = $product['image_url'] ?? $product['image'] ?? 'default-product.png';
                    
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
                    
                    $productName = $product['product_name'] ?? $product['name'] ?? 'Produkt';
                    $productPrice = $product['price'] ?? 0;
                    $productId = $product['id'] ?? 0;
                    ?>
                    <img src="<?php echo htmlspecialchars($imagePath); ?>" 
                         alt="<?php echo htmlspecialchars($productName); ?>">
                    <h3><?php echo htmlspecialchars($productName); ?></h3>
                    <p>DKK <?php echo number_format($productPrice, 2, ',', '.'); ?></p>
                    <a href="/products/<?php echo $productId; ?>">Se detaljer</a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div> 