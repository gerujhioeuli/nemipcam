<div class="welcome-section">
    <h1>Velkommen til Nem Ip Cam</h1>
    
    <div class="welcome-content">
        <p>Din pålidelige forhandler af Ajax sikkerhedsudstyr i Danmark.</p>
        
        <div class="welcome-links">
            <a href="/about" class="btn">Om os</a>
            <a href="/contact" class="btn">Kontakt os</a>
        </div>
        
        <?php if (isset($error) && getenv('APP_ENV') === 'development'): ?>
            <div class="dev-error">
                <p><strong>Udvikler fejl:</strong> <?php echo htmlspecialchars($error); ?></p>
            </div>
        <?php endif; ?>
    </div>
</div> 