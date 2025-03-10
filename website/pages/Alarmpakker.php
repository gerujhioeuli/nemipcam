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

// Hent søgeparameter
$searchQuery = isset($_GET['search']) ? trim($_GET['search']) : '';

// Tilpas SQL-query baseret på søgning eller kategori
if (!empty($searchQuery)) {
    $sql = "
    SELECT 
        product_name, brand, price, image_url, product_page_url, features 
    FROM 
        `$activeCategory`
    WHERE 
        product_name LIKE '%$searchQuery%' OR 
        brand LIKE '%$searchQuery%' OR 
        features LIKE '%$searchQuery%'";
} else {
    $sql = "SELECT product_name, brand, price, image_url, product_page_url, features FROM `$activeCategory`";
}

$result = $conn->query($sql);

// Check if we have data
if ($result->num_rows <= 0) {
    echo '<div class="no-products">
            <h3>Vi fandt ingen produkter.</h3>
            <p>Prøv at søge efter noget andet eller udforsk vores kategorier.</p>
            <a href="../index.php" class="button">Tilbage til forsiden</a>
          </div>';
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
    <link rel="stylesheet" media="only screen and (max-width:1024px) "href="../assets/css/telefonstyle.css"/>
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
                <form action="" method="GET">
                    <input type="text" name="search" value="<?php echo htmlspecialchars($searchQuery); ?>" placeholder="Søg produkt, kategori eller varemærke">
                    <button type="submit">Søg</button>
                </form>
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
                <h2>Alarmpakker</h2>
                <hr>
                <?php 
                if (!empty($searchQuery)) {
                    echo "<p>Søgeresultat for '<b>" . htmlspecialchars($searchQuery) . "</b>': " . $result->num_rows . " produkter fundet.</p>";
                }
                ?>

                <div id="product-container"></div>
                <?php 
                    // Assuming $result is the MySQLi result set from the API
                
                    // Fetch each row from the result set
                    while ($row = $result->fetch_assoc()) {
                        // Now $row contains data for each product
                ?>
                        <div class="produkt-wrap">
                            <a href="<?php echo $row['product_page_url']; ?>">
                                <img src="<?php echo $row['image_url']; ?>" alt="" class="produkt-listevisning-img" loading="lazy">
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
                                        // Explode features into a list
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


                <!--
                <div class="produkt-wrap">
                    <a href="products/ajax-hub2-starterkit-med-kamera.html">
                        <img src="../assets/images/0019356_ajax-hub2-starterkit-med-kamera_415.png" alt="" class="produkt-listevisning-img">
                    </a>
                    <div class="produkt-listevisning">
                        <h3>Ajax Hub2 StarterKit med kamera</h3>
                        <div class="pris" style="display: flex; justify-content: space-between;">
                            <h4>Ajax</h4>
                            <h4 style="color: green; font-weight: bold; font-size: 20;">1.000,00 kr.</h4>
                        </div>
                        <hr>
                        <div class="beskrivelse">
                            <ul>
                                <li>Ajax alarm startsæt m. kamera</li>
                                <li>Hub 2 alarmpanel</li>
                                <li>Ethernet, GSM (2 x SIM kort (2G))</li>
                                <li>Tilslut op til 100 enheder</li>
                                <li>Op til 50 brugere</li>
                                <li>Installer sættet på 30 minutter</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <hr>
                
                <div class="produkt-wrap">
                    <a href="products/ajax-hub2-starterkit-med-sirene.html">
                        <img src="../assets/images/0021993_ajax-hub2-starterkit-med-sirene_415.png" alt="" class="produkt-listevisning-img">
                    </a>
                    <div class="produkt-listevisning">
                        <h3>Ajax Hub2 StarterKit med sirene</h3>
                        <h4>PK-Ajax10</h4>
                        <hr>
                        <div class="beskrivelse">
                            <ul>
                                <li>Ajax alarm startsæt</li>
                                <li>Hub2 alarmpanel</li>
                                <li>Tilslut op til 100 enheder</li>
                                <li>Op til 50 brugere</li>
                                <li>Inkl. indendørs sirene</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="produkt-wrap">
                    <a href="products/ajax-hub2-starterkit-med-sirene-keypad.html">
                        <img src="../assets/images/0021968_ajax-hub2-starterkit-med-sirene-keypad_415.png" alt="" class="produkt-listevisning-img">
                    </a>
                    <div class="produkt-listevisning">
                        <h3>Ajax Hub2 StarterKit med sirene & Keypad</h3>
                        <h4>PK-Ajax14</h4>
                        <hr>
                        <div class="beskrivelse">
                            <ul>
                                <li>Ajax alarm startsæt</li>
                                <li>Hub2 alarmpanel</li>
                                <li>Tilslut op til 100 enheder</li>
                                <li>Op til 50 brugere</li>
                                <li>Inkl. indendørs sirene og KeyPad</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="produkt-wrap">
                    <a href="products/ajax-hub2-starterkit-med-sirene-keypad-plus.html">
                        <img src="../assets/images/0022476_ajax-hub2-starterkit-med-sirene-keypad-plus_415.png" alt="" class="produkt-listevisning-img">
                    </a>
                    <div class="produkt-listevisning">
                        <h3>Ajax Hub2 StarterKit med sirene & Keypad plus</h3>
                        <h4>PK-Ajax15</h4>
                        <hr>
                        <div class="beskrivelse">
                            <ul>
                                <li>Ajax alarm startsæt</li>
                                <li>Hub2 alarmpanel</li>
                                <li>Tilslut op til 100 enheder</li>
                                <li>Op til 50 brugere</li>
                                <li>Inkl. indendørs sirene og KeyPad Plus</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <hr>
                <div class="produkt-wrap">
                    <a href="products/ajax-hub2-starterkit-med-foto-pir.html">
                        <img src="../assets/images/0019448_ajax-hub2-starterkit-med-foto-pir_415.jpeg" alt="" class="produkt-listevisning-img">
                    </a>
                    <div class="produkt-listevisning">
                        <h3>Ajax Hub2 StarterKit med foto + PIR</h3>
                        <div class="pris" style="display: flex; justify-content: space-between;">
                            <h4>Ajax</h4>
                            <h4 style="color: green; font-weight: bold; font-size: 20;">1.000,00 kr.</h4>
                        </div>
                        <hr>
                        <div class="beskrivelse">
                            <ul>
                                <li>Ajax alarm startsæt m. kamera</li>
                                <li>Hub 2&nbsp;alarmpanel</li>
                                <li>Ethernet,&nbsp;GSM (2 x SIM kort (2G)</li>
                                <li>Tilslut op til 100&nbsp;enheder</li>
                                <li>Op til 50&nbsp;brugere</li>
                                <li>Inkl. PIR og røgalarm</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="produkt-wrap">
                    <a href="products/ajax-hub2-starterkit-med-foto-keypad.html">
                        <img src="../assets/images/0019497_ajax-hub2-starterkit-med-foto-keypad_415.png" alt="" class="produkt-listevisning-img">
                    </a>
                    <div class="produkt-listevisning">
                        <h3>Ajax Hub2 StarterKit med foto & Keypad</h3>
                        <div class="pris" style="display: flex; justify-content: space-between;">
                            <h4>Ajax</h4>
                            <h4 style="color: green; font-weight: bold; font-size: 20;">1.000,00 kr.</h4>
                        </div>
                        <hr>
                        <div class="beskrivelse">
                            <ul>
                                <li>Ajax alarm startsæt m. kamera</li>
                                <li>Hub 2 alarmpanel</li>
                                <li>Ethernet, GSM (2 x SIM kort (2G)</li>
                                <li>Tilslut op til 100 enheder</li>
                                <li>Op til 50 brugere</li>
                                <li>Inkl. PIR, røgalarm og KeyPad</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <hr>
                
                <div class="produkt-wrap">
                    <a href="products/ajax-hub2-starterkit-med-foto-sirene-wifi-kamera.html">
                        <img src="../assets/images/0019503_ajax-hub2-starterkit-med-foto-sirene-wifi-kamera_415.png" alt="" class="produkt-listevisning-img">
                    </a>
                    <div class="produkt-listevisning">
                        <h3>Ajax Hub2 StarterKit med foto, sirene & WiFi kamera</h3>
                        <h4>PK-Ajax5</h4>
                        <hr>
                        <div class="beskrivelse">
                            <ul>
                                <li>Hub 2</li>
                                <li>Doorprotect</li>
                                <li>Motioncam</li>
                                <li>Homesiren</li>
                                <li>Safire PT WiFi kamera (indendørs)</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <hr>
                -->
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
