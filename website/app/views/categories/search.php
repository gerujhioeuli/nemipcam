<div class="search-results">
    <h1>Søgeresultater for: <?php echo htmlspecialchars($query); ?></h1>
    
    <?php if (empty($categories)): ?>
        <p>Ingen kategorier fundet for "<?php echo htmlspecialchars($query); ?>".</p>
    <?php else: ?>
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
    <?php endif; ?>
</div> 