<div class="contact-section">
    <h1>Kontakt os</h1>
    
    <div class="contact-info">
        <div class="contact-details">
            <h2>Kontaktoplysninger</h2>
            <p><strong>Email:</strong> info@nemipcam.dk</p>
            <p><strong>Telefon:</strong> +45 12 34 56 78</p>
            <p><strong>Adresse:</strong> Eksempelvej 123, 1234 Eksempelby, Danmark</p>
            <p><strong>Åbningstider:</strong> Mandag-Fredag: 9:00-17:00</p>
        </div>
        
        <div class="contact-form">
            <h2>Send os en besked</h2>
            <form action="/contact/send" method="post">
                <div class="form-group">
                    <label for="name">Navn</label>
                    <input type="text" id="name" name="name" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="phone">Telefon</label>
                    <input type="tel" id="phone" name="phone">
                </div>
                
                <div class="form-group">
                    <label for="subject">Emne</label>
                    <input type="text" id="subject" name="subject" required>
                </div>
                
                <div class="form-group">
                    <label for="message">Besked</label>
                    <textarea id="message" name="message" rows="5" required></textarea>
                </div>
                
                <button type="submit" class="btn">Send besked</button>
            </form>
        </div>
    </div>
</div> 