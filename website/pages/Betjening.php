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
                <h2>Betjening</h2>
                <hr>
                <div id="product-container"></div>
                
                <?php 
                    // Assuming $result is the MySQLi result set from the API
                
                    // Fetch each row from the result set
                    while ($row = $result->fetch_assoc()) {
                        // Now $row contains data for each product
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
                    <a href="products/ajax-keypad.html">
                        <img src="../assets/images/0019259_ajax-keypad_415.png" alt="" class="produkt-listevisning-img">
                    </a>
                    <div class="produkt-listevisning">
                        <h3>Ajax KeyPad</h3>
                        <h4>Ajax</h4>
                        <hr>
                        <div class="beskrivelse">
                            <ul>
                                <li>Trådløst tastatur og betjeningspanel, tovejs</li>
                                <li>Til-/frakobling med personlig kode</li>
                                <li>Indikation om eventuelle fejl i systemet</li>
                                <li>Nem opsætning</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <hr>
                
                <div class="produkt-wrap">
                    <a href="products/ajax-keypad-plus.html">
                        <img src="../assets/images/0019887_ajax-keypad-plus_415.png" alt="" class="produkt-listevisning-img">
                    </a>
                    <div class="produkt-listevisning">
                        <h3>Ajax KeyPad Plus</h3>
                        <h4>Ajax</h4>
                        <hr>
                        <div class="beskrivelse">
                            <ul>
                                <li>Trådløst tastatur og betjeningspanel med kort og nøglebrikslæser</li>
                                <li>DESFire® EV1, EV2 (13,56MHz)</li>
                                <li>Administrer adgangstilladelser i app</li>
                                <li>Lys- og lydindikation</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <hr>
                
                <div class="produkt-wrap">
                    <a href="products/ajax-spacecontrol.html">
                        <img src="../assets/images/0019899_ajax-spacecontrol_415.png" alt="" class="produkt-listevisning-img">
                    </a>
                    <div class="produkt-listevisning">
                        <h3>Ajax SpaceControl</h3>
                        <h4>Ajax</h4>
                        <hr>
                        <div class="beskrivelse">
                            <ul>
                                <li>Trådløs fjernbetjening med panikknap, tovejs</li>
                                <li>Passer i nøglebundet</li>
                                <li>Aktiverer hel eller delvis alarmtilstand</li>
                                <li>Panik-knap funktion</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <hr>
                
                <div class="produkt-wrap">
                    <a href="products/ajax-button.html">
                        <img src="../assets/images/0019293_ajax-button_415.png" alt="" class="produkt-listevisning-img">
                    </a>
                    <div class="produkt-listevisning">
                        <h3>Ajax Button</h3>
                        <h4>Ajax</h4>
                        <hr>
                        <div class="beskrivelse">
                            <ul>
                                <li>Trådløs overfaldsknap</li>
                                <li>Fjernbetjening for scenariestyring</li>
                                <li>Justerbare tilstande: Panikknap, Medicinsk alarm, Scenarie styring</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <hr>
                
                <div class="produkt-wrap">
                    <a href="products/ajax-double-button.html">
                        <img src="../assets/images/0019384_ajax-double-button_415.png" alt="" class="produkt-listevisning-img">
                    </a>
                    <div class="produkt-listevisning">
                        <h3>Ajax DoubleButton</h3>
                        <h4>Ajax</h4>
                        <hr>
                        <div class="beskrivelse">
                            <ul>
                                <li>Trådløs overfaldsenhed</li>
                                <li>Bruges primært som panikknap</li>
                                <li>Avanceret beskyttelse mod fejltryk</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="produkt-wrap">
                    <a href="products/ajax-noglebrik.html">
                        <img src="../assets/images/0019412_ajax-noglebrik_415.png" alt="Ajax Nøglebrik" class="produkt-listevisning-img">
                    </a>
                    <div class="produkt-listevisning">
                        <h3>Ajax Nøglebrik</h3>
                        <h4>Ajax</h4>
                        <hr>
                        <div class="beskrivelse">
                            <ul>
                                <li>Nøglebrik til KeyPad Plus & KeyPad Touch</li>
                                <li>Kan tilsluttes op til 13 hubs</li>
                                <li>Nem tilføjelse via appen</li>
                                <li>Indstil navn og tilladelser via appen</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <hr>
                
                <div class="produkt-wrap">
                    <a href="products/ajax-noglekort.html">
                        <img src="../assets/images/0019401_a-noglekort_415.png" alt="Ajax Nøglekort" class="produkt-listevisning-img">
                    </a>
                    <div class="produkt-listevisning">
                        <h3>Ajax Nøglekort</h3>
                        <h4>Ajax</h4>
                        <hr>
                        <div class="beskrivelse">
                            <ul>
                                <li>Nøglekort til Tastatur Plus</li>
                                <li>Kan tilsluttes op til 13 hubs</li>
                                <li>Nem tilføjelse via appen</li>
                                <li>Indstil navn og tilladelser via appen</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <hr>
                
                <div class="produkt-wrap">
                    <a href="products/ajax-keypad-touchscreen.html">
                        <img src="../assets/images/0021206_ajax-keypad-touchscreen_415.png" alt="Ajax KeyPad TouchScreen" class="produkt-listevisning-img">
                    </a>
                    <div class="produkt-listevisning">
                        <h3>Ajax KeyPad TouchScreen</h3>
                        <h4>Ajax</h4>
                        <hr>
                        <div class="beskrivelse">
                            <ul>
                                <li>Trådløs tastatur med touchskærm</li>
                                <li>Kontaktløs adgang</li>
                                <li>5" touchskærm</li>
                                <li>Betjening via SmartPhone, kode eller kort/brik</li>
                                <li>DESFire teknologi</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <hr>
                
                <div class="produkt-wrap">
                    <a href="products/ajax-manual-call-point-red.html">
                        <img src="../assets/images/0021388_ajax-manual-call-point-red_415.png" alt="Ajax Manual Call Point (Red)" class="produkt-listevisning-img">
                    </a>
                    <div class="produkt-listevisning">
                        <h3>Ajax Manual Call Point (Red)</h3>
                        <h4>Ajax</h4>
                        <hr>
                        <div class="beskrivelse">
                            <ul>
                                <li>Trådløs, vægmonteret knap til manuel aktivering af brandalarmer</li>
                                <li>EN 54-11:2001, A1:2005 standard</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <hr>
                
                <div class="produkt-wrap">
                    <a href="products/ajax-manual-call-point-blue.html">
                        <img src="../assets/images/0022137_ajax-manual-call-point-blue_415.png" alt="Ajax Manual Call Point (Blue)" class="produkt-listevisning-img">
                    </a>
                    <div class="produkt-listevisning">
                        <h3>Ajax Manual Call Point (Blue)</h3>
                        <h4>Ajax</h4>
                        <hr>
                        <div class="beskrivelse">
                            <ul>
                                <li>Trådløs, vægmonteret knap til manuel aktivering af brandalarmer</li>
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
