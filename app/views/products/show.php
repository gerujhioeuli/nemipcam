<div class="product-detail">
    <div class="product-image">
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
    </div>
    
    <div class="product-info">
        <h1><?php echo htmlspecialchars($product['product_name'] ?? $product['name'] ?? 'Produkt'); ?></h1>
        
        <div class="product-price">
            <p>DKK <?php echo number_format($product['price'] ?? 0, 2, ',', '.'); ?></p>
        </div>
        
        <div class="product-brand">
            <p>Brand: <?php echo htmlspecialchars($product['brand'] ?? 'Ajax'); ?></p>
        </div>
        
        <?php if (!empty($product['features'])): ?>
            <div class="product-features">
                <h3>Funktioner</h3>
                <p><?php echo nl2br(htmlspecialchars($product['features'])); ?></p>
            </div>
        <?php endif; ?>
        
        <div class="product-actions">
            <a href="#" class="btn">Tilføj til kurv</a>
            <a href="/products" class="btn secondary">Tilbage til produkter</a>
        </div>
    </div>
</div>

<?php if (!empty($relatedProducts)): ?>
    <div class="related-products">
        <h2>Relaterede produkter</h2>
        
        <div class="products">
            <?php foreach ($relatedProducts as $relatedProduct): ?>
                <?php if ($relatedProduct['id'] != $product['id']): ?>
                    <div class="product">
                        <?php 
                        // Get image path or use a fallback from existing images
                        $relatedImagePath = $relatedProduct['image_url'] ?? $relatedProduct['image'] ?? '0022027_ajax-turretcam-5-mp28-mm-hvid_415.png';
                        
                        // Check if the path already starts with assets/images
                        if (strpos($relatedImagePath, 'assets/images/') === 0) {
                            $relatedImagePath = '/' . $relatedImagePath;
                        } 
                        // Check if the path has ../ prefix
                        else if (strpos($relatedImagePath, '../') === 0) {
                            $relatedImagePath = '/' . preg_replace('/^(\.\.\/)+/', '', $relatedImagePath);
                        }
                        // If it's just a filename, add the path
                        else if (strpos($relatedImagePath, '/') === false) {
                            $relatedImagePath = '/assets/images/' . $relatedImagePath;
                        }
                        ?>
                        <img src="<?php echo htmlspecialchars($relatedImagePath); ?>" 
                             alt="<?php echo htmlspecialchars($relatedProduct['product_name'] ?? $relatedProduct['name'] ?? 'Produkt'); ?>">
                        <h3><?php echo htmlspecialchars($relatedProduct['product_name'] ?? $relatedProduct['name'] ?? 'Produkt'); ?></h3>
                        <p>DKK <?php echo number_format($relatedProduct['price'] ?? 0, 2, ',', '.'); ?></p>
                        <a href="/products/<?php echo $relatedProduct['id']; ?>">Se detaljer</a>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?> 