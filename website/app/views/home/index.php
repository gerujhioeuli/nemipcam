<!-- Category Section -->
<div class="category-section">
    <h2>Søg efter kategori</h2>
    <div class="categories">
        <?php if (!empty($categories)): ?>
            <?php foreach ($categories as $category): ?>
                <a href="/categories/<?php echo $category['id']; ?>">
                    <div class="category">
                        <?php 
                        // Get the correct image based on category name
                        $categoryName = $category['navn'] ?? $category['name'] ?? '';
                        
                        // Map category names to specific image files
                        $categoryImageMap = [
                            'Videoovervågning' => 'assets/images/0022067_ajax-videoovervagning_450.png',
                            'Alarmpakker' => 'assets/images/Alarmpakker.png',
                            'Alarmpaneler' => 'assets/images/Alarmpaneler.png',
                            'Betjening' => 'assets/images/Betjening.png',
                            'Sensorer' => 'assets/images/Sensorer.png',
                            'Sirener' => 'assets/images/Sirener.png',
                            'Andet' => 'assets/images/Andettilbehor.png'
                        ];
                        
                        // Get image path from map or use a fallback
                        $imagePath = $categoryImageMap[$categoryName] ?? 'assets/images/Alarmpakker.png';
                        
                        // Ensure path starts with a slash
                        if (strpos($imagePath, '/') !== 0) {
                            $imagePath = '/' . $imagePath;
                        }
                        ?>
                        <img src="<?php echo htmlspecialchars($imagePath); ?>" 
                             alt="<?php echo htmlspecialchars($categoryName); ?>">
                        <p><?php echo htmlspecialchars($categoryName); ?></p>
                    </div>
                </a>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Ingen kategorier fundet.</p>
        <?php endif; ?>
    </div>
</div>

<!-- Product Section -->
<div class="product-section">
    <h2 class="section-title">Populære produkter</h2>
    <div class="products">
        <?php if (!empty($popularProducts)): ?>
            <?php foreach ($popularProducts as $product): ?>
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
        <?php else: ?>
            <p>Ingen produkter fundet.</p>
        <?php endif; ?>
    </div>
</div> 