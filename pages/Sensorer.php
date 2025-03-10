<?php
include_once '../includes/api.php'; // Tilslutning til databasen
include_once '../includes/functions.php'; // Inkluderer funktioner

// Hent kategorier fra databasen
$categories = [];
$sql = "SELECT * FROM kategorier";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories[$row['slug']] = $row['navn'];
    }
} else {
    echo "Ingen kategorier fundet.";
    exit;
}

// Automatisk identificer aktiv kategori baseret på filnavnet
$activeCategory = basename($_SERVER['PHP_SELF'], '.php');

// SQL query to fetch all product details for the current category table
$sql = "SELECT product_name, brand, price, image_url, product_page_url, features FROM `$activeCategory`";
$result = $conn->query($sql);

// Check if we have data
if ($result->num_rows <= 0) {
    echo "No products found";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nem Ip Cam</title>
    <link rel="stylesheet" href="../assets/css/Alarmpakkerstyle.css">
    <link rel="stylesheet" media="only screen and (max-width:1024px) "href="../assets/css/telefonstyle.css" />
    <style>
        .hidden {
            height: 0;
            overflow: hidden;
            transition: height 0.4s ease-out;
        }

        .kategori-listevisning {
            height: auto;
            overflow: hidden;
            transition: height 0.4s ease-out;
        }

        /* Arrow styles */
        #kategori-title {
            background: #55728a;
            color: white;
            padding: 0.5em 1em;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
        }





        /* Arrow pointing upwards when the dropdown is open */
        .rotate {
            transform: rotate(180deg);
        }

        /* Smooth expand/collapse transition */
        .kategori-listevisning.expanded {
            height: 200px; /* Adjust this value according to your content */
        }
    </style>
</head>
<body>
    <!-- Top Bar -->
    <?php include '../includes/topbar.php'; ?>
    
    <!-- Header with Logo and Search -->
    <div class="header">
        <div class="header-section">
            <a href="../index.php"><div class="header-logo">
                <p>Nem Ip Cam</p>
            </div></a>
            <div class="header-search">
                <input type="text" value="" placeholder="Søg produkt, kategori eller varemærke">
            </div>
            <div class="header-icons">
                <a href="#">Login</a>
            </div>
        </div>
    </div>
    <div class="phonesearch">
        <img src="../assets/images/sogeknap.png" class="sogeknap">
        <input type="text" value="" placeholder="Søg produkt, kategori eller varemærke">
    </div>

    <!-- Product Section -->
    <div class="product-section">
        <div class="product-wrapper">
            <div class="kategori-wrapper">
                <div class="kategori-liste">
                    <div id="kategori-title">
                        <h3>Kategorier</h3>
                        
                    </div>
                    <?php
                    // Generer og vis dynamisk kategori-listevisning
                    echo generateCategoryList($categories, $activeCategory);
                    ?>
                </div>
            </div>
            <div class="produkter">
                <h2>Sensorer</h2>
                <hr>
                    <div class="kategori-valg">
                        <div class="produkt-wrap">
                            <a href="categories/indendors.php">
                                <img src="../assets/images/4444.png" alt="Camera Y" class="produkt-listevisning-img">
                                <h4 style="display: flex;justify-content:  center; font-weight: 400;">Indendørs detektorer</h4>
                            </a>
    
                        </div>
                        <div class="produkt-wrap">
                            <a href="categories/udendors.php">
                                <img src="../assets/images/5555.png" alt="Camera Y" class="produkt-listevisning-img">
                                <h4 style="display: flex;justify-content:  center; font-weight: 400;">Udendørs detektorer</h4>
                            </a>
                        </div>
                        <div class="produkt-wrap">
                            <a href="categories/brand.php">
                                <img src="../assets/images/6666.png" alt="Camera Y" class="produkt-listevisning-img">
                                <h4 style="display: flex;justify-content:  center; font-weight: 400;">Brand detektorer</h4>
                            </a>
                        </div>
                    </div>
                    <hr>
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
