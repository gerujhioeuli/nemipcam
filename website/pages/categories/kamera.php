<?php 
    include_once '../../includes/api.php';
    
    // SQL query to fetch all product details
    $sql = "SELECT product_name, brand, price, image_url, product_page_url, features FROM kamera";
    $result = $conn->query($sql);
    
    // Check if we have data
    if ($result->num_rows > 0) {
        // The $result is used in your main PHP file to loop through all products
        // No need to fetch a single row here since it's done in the other file
    } else {
        echo "No products found";
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nem Ip Cam - Kamera</title>
    <link rel="stylesheet" href="../../assets/css/Alarmpakkerstyle.css">
    <link rel="stylesheet" media="only screen and (max-width:1024px)" href="../../assets/css/telefonstyle.css">
</head>
<body>
    <!-- Top Bar -->
    <div class="top-bar">
        <div class="top-bar-wrap">
            <div>
                <span>Send til: Danmark</span>
            </div>
            <div>
                <a href="#">Kontakt</a>
            </div>
        </div>
    </div>

    <!-- Header with Logo and Search -->
    <div class="header">
        <div class="header-section">
            <a href="../../index.php">
                <div class="header-logo">
                    <p>Nem Ip Cam</p>
                </div>
            </a>
            <div class="header-search">
                <input type="text" value="" placeholder="Søg produkt, kategori eller varemærke">
            </div>
            <div class="header-icons">
                <a href="#">Login</a>
            </div>
        </div>
    </div>
    <div class="phonesearch">
        <img src="../../assets/images/sogeknap.png" class="sogeknap">
        <input type="text" value="" placeholder="Søg produkt, kategori eller varemærke">
    </div>

    <!-- Product Section -->
    <div class="product-section">
        <div class="product-wrapper">
            <!-- Dynamisk Kategori Liste -->
            <div class="kategori-wrapper">
                <div class="kategori-liste">
                    <div id="kategori-title">
                        <h3>Kategorier</h3>
                        <span class="arrow">&#9662;</span> <!-- Arrow -->
                    </div>
                    <div class="kategori-listevisning hidden">
                        <a href="../Videoovervågning.php"><div class="<?php echo ($activeCategory == 'videoovervågning') ? 'active' : 'unactive'; ?>">Videoovervågning</div></a>
                        <a href="../categories/kamera.php"><div class="<?php echo ($activeSubCategory == 'kamera') ? 'active_category' : 'unactive_category'; ?>">Kamera</div></a>
                        <a href="../categories/NVRoptager.php"><div class="<?php echo ($activeSubCategory == 'NVRoptager') ? 'active_category' : 'unactive_category'; ?>">NVR optager</div></a>
                        <a href="../Alarmpakker.php"><div class="unactive">Alarmpakker</div></a>
                        <a href="../Alarmpaneler.php"><div class="unactive">Alarmpaneler</div></a>
                        <a href="../Betjening.php"><div class="unactive">Betjening</div></a>
                        <a href="../Sensorer.php"><div class="unactive">Sensorer</div></a>
                        <a href="../Sirener.php"><div class="unactive">Sirener</div></a>
                        <a href="../Andet_tilbehør.html"><div class="unactive">Andet tilbehør</div></a>
                    </div>
                </div>
            </div>
            
            <!-- Products List -->
            <div class="produkter">
                <h2>Kamera</h2>
                <hr>
                <div id="product-container">
                    <?php 
                    // Loop igennem hvert produkt i databasen
                    while ($row = $result->fetch_assoc()) {
                    ?>
                        <div class="produkt-wrap">
                            <a href="<?php echo $row['product_page_url']; ?>">
                                <img src="<?php echo $row['image_url']; ?>" alt="" class="produkt-listevisning-img">
                            </a>
                            <div class="produkt-listevisning">
                                <h3><?php echo $row['product_name']; ?></h3>
                                <div class="pris" style="display: flex; justify-content: space-between;">
                                    <h4><?php echo $row['brand']; ?></h4>
                                    <h4 style="color: green; font-weight: bold; font-size: 20;"><?php echo number_format($row['price'], 2, ',', '.'); ?> kr.</h4>
                                </div>
                                <hr>
                                <div class="beskrivelse">
                                    <ul>
                                        <?php
                                        // Eksploder features til en liste
                                        $features = explode('; ', $row['features']);
                                        foreach ($features as $feature) {
                                            echo "<li>$feature</li>";
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <hr>
                    <?php 
                    } // End while loop
                    ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Get the kategori-title and arrow element
        const kategoriTitle = document.getElementById("kategori-title");
        const kategoriList = document.querySelector(".kategori-listevisning");
        const arrow = document.querySelector(".arrow");

        // Add click event to toggle visibility and arrow rotation
        kategoriTitle.addEventListener("click", () => {
            kategoriList.classList.toggle("hidden");
            arrow.classList.toggle("rotate");
            
            // Animate the height expansion or collapse
            if (kategoriList.classList.contains("hidden")) {
                kategoriList.style.height = "0";
            } else {
                kategoriList.style.height = kategoriList.scrollHeight + "px";
            }
        });
    </script>

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
