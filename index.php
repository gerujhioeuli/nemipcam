<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nem Ip Cam</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" media="only screen and (max-width:1024px)" href="assets/css/telefonstyle.css" />
</head>
<body>
    <!-- Top Bar -->
    <?php include 'includes/topbar.php'; ?>
    
    <!-- Header with Logo and Search -->
    <div class="header">
        <div class="header-section">
            <a href="index.php"><div class="header-logo">
                <p>Nem Ip Cam</p>
            </div></a>
            <div class="header-search">
                <input type="text" value="" placeholder="Søg produkt, kategori eller varemærke">
            </div>
            <div class="header-icons">
                <a href="/login">Login</a>
            </div>
        </div>
    </div>
    <div class="phonesearch">
        <img src="assets/images/sogeknap.png" class="sogeknap">
        <input type="text" value="" placeholder="Søg produkt, kategori eller varemærke">
    </div>
    
    <!-- Category Section -->
    <div class="category-section">
        <h2>Søg efter kategori</h2>
        <div class="categories">
            <a href="/categories/1"><div class="category">
                <img src="assets/images/0022067_ajax-videoovervagning_450.png" style="padding: 0px 0px;" alt="Videoovervågning">
                <p>Videoovervågning</p>
            </div></a>
            <a href="/categories/2"><div class="category">
                <img src="assets/images/Alarmpakker.png" style="padding: 20px 0px;" alt="Alarmpakker">
                <p>Alarmpakker</p>
            </div></a>
            <a href="/categories/3">
            <div class="category">
                <img src="assets/images/Alarmpaneler.png" alt="Alarmpaneler">
                <p>Alarmpaneler</p>
            </div></a>
            <a href="/categories/4">
            <div class="category">
                <img src="assets/images/Betjening.png" alt="Betjening">
                <p>Betjening</p>
            </div></a>
            <a href="/categories/5">
            <div class="category">
                <img src="assets/images/Sensorer.png" alt="Sensorer">
                <p>Sensorer</p>
            </div></a>
            <a href="/categories/6">
            <div class="category">
                <img src="assets/images/Sirener.png" alt="Sirener">
                <p>Sirener</p>
            </div></a>
            <!--
            <a href="/categories/7">
            <div class="category">
                <img src="assets/images/Andettilbehor.png" alt="Andet tilbehør">
                <p>Andet tilbehør</p>
            </div></a>
            -->
        </div>
    </div>

    <!-- Product Section -->
    <div class="product-section">
        <h2 class="section-title">Populære produkter</h2>
        <div class="products">
            <div class="product">
                <img src="assets/images/0019371_ajax-hub2-starterkit-plus-med-kamera_415.png" alt="Ajax Hub2 Plus StarterKit med kamera" style="margin-top: 4.5em; margin-bottom: 4em;">
                <h3>Ajax Hub2 Plus StarterKit med kamera</h3>
                <p>DKK 4.695,00.</p>
                <a href="/products/1">View Details</a>
            </div>
            <div class="product">
                <img src="assets/images/0019335_ajax-hub-2_415.png" alt="Camera Y" style="">
                <h3>Ajax Hub 2</h3>
                <p>DKK 2.495,00</p>
                <a href="/products/2">View Details</a>
            </div>
            <div class="product">
                <img src="assets/images/0022027_ajax-turretcam-5-mp28-mm-hvid_415.png" alt="Camera Z" style="">
                <h3>Ajax TurretCam, 5 MP, 2.8 mm, hvid</h3>
                <p>DKK 1.825,00</p>
                <a href="/products/3">View Details</a>
            </div>
        </div>
    </div>

    

    <!-- Footer -->
    <div class="footer">
        <p>&copy; 2024 Nem Ip Cam - All Rights Reserved</p>
        <p>
            <a href="#">Privacy Policy</a> |
            <a href="#">Terms of Service</a> |
            <a href="#">Contact Us</a>
        </p>
    </div>

</body>
</html>
