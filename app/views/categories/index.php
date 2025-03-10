<div class="category-section">
    <h1>Alle Kategorier</h1>
    
    <div class="categories">
        <?php foreach ($categories as $category): ?>
            <a href="/categories/<?php echo $category['id']; ?>">
                <div class="category">
                    <img src="/assets/images/<?php echo htmlspecialchars($category['image'] ?? 'default-category.png'); ?>" 
                         alt="<?php echo htmlspecialchars($category['navn'] ?? $category['name'] ?? 'Kategori'); ?>">
                    <p><?php echo htmlspecialchars($category['navn'] ?? $category['name'] ?? 'Kategori'); ?></p>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</div> 