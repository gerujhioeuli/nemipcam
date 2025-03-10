<?php 
    include_once '../../includes/api.php';
    
    // SQL query to fetch all product details
    $sql = "SELECT product_name, brand, price, image_url, product_page_url, features FROM udendors";
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
    <title>Nem Ip Cam</title>
    <link rel="stylesheet" href="../../assets/css/Alarmpakkerstyle.css">
    <link rel="stylesheet" media="only screen and (max-width:1024px) "href="../../assets/css/telefonstyle.css" />
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
            <a href="../../index.php"><div class="header-logo">
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
                        <!-- Arrow added here -->
                        <span class="arrow">&#9662;</span>
                    </div>
                    <div class="kategori-listevisning hidden">
                        <a href="../Videoovervågning.php"><div class="unactive">Videoovervågning</div></a>
                        <a href="../Alarmpakker.php"><div class="unactive">Alarmpakker</div></a>
                        <a href="../Alarmpaneler.php"><div class="unactive">Alarmpaneler</div></a>
                        <a href="../Betjening.php"><div class="unactive">Betjening</div></a>
                        <a href="../Sensorer.php"><div class="active">Sensorer</div></a>
                            <a href="../categories/indendors.php"><div class="unactive_category">Indendørs detektorer</div></a>
                            <a href="../categories/udendors.php"><div class="active_category">Udendørs detektorer</div></a>
                            <a href="../categories/brand.php"><div class="unactive_category">Brand detektorer</div></a>
                        <a href="../Sirener.php"><div class="unactive">Sirener</div></a>
                        <a href="../Andet_tilbehør.html"><div class="unactive">Andet tilbehør</div></a>
                    </div>
                </div>
            </div>
            <div class="produkter">
                <h2>Alarmpaneler</h2>
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
                    <a href="products/ajax-motioncam-outdoor.html">
                        <img src="../../assets/images/0020237_ajax-motioncam-outdoor_415.png" alt="" class="produkt-listevisning-img">
                    </a>
                    <div class="produkt-listevisning">
                        <h3>Ajax MotionCam Outdoor</h3>
                        <h4>Ajax</h4>
                        <hr>
                        <div class="beskrivelse">
                            <ul>
                                <li>Trådløs udendørs bevægelsesdetektor med kamera</li>
                                <li>Visuel alarm verifikation</li>
                                <li>Anti-masking og pet immunitet</li>
                                <li>HDR-kamera</li>
                                <li>IR-baggrundsbelysning</li>
                                <li>Beskyttelseshætte medfølger</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <hr>
                
                <div class="produkt-wrap">
                    <a href="products/ajax-motioncam-outdoor-phod-2.html">
                        <img src="../../assets/images/0020253_ajax-motioncam-outdoor-phod_415.png" alt="" class="produkt-listevisning-img">
                    </a>
                    <div class="produkt-listevisning">
                        <h3>Ajax MotionCam Outdoor PhOD</h3>
                        <h4>Ajax</h4>
                        <hr>
                        <div class="beskrivelse">
                            <ul>
                                <li>Trådløs udendørs bevægelsesdetektor med kamera</li>
                                <li>Mulighed for at forespørge om et billede</li>
                                <li>Visuel alarm verifikation</li>
                                <li>Anti-masking og pet immunitet</li>
                                <li>HDR-kamera</li>
                                <li>IR-baggrundsbelysning</li>
                                <li>Beskyttelseshætte medfølger</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <hr>
                
                <div class="produkt-wrap">
                    <a href="products/ajax-motionprotect-outdoor.html">
                        <img src="../../assets/images/0020363_ajax-motionprotect-outdoor_415.png" alt="" class="produkt-listevisning-img">
                    </a>
                    <div class="produkt-listevisning">
                        <h3>Ajax MotionProtect Outdoor</h3>
                        <h4>Ajax</h4>
                        <hr>
                        <div class="beskrivelse">
                            <ul>
                                <li>Trådløs udendørs bevægelsesdetektor</li>
                                <li>2 PIR sensorer</li>
                                <li>To-trins algoritme</li>
                                <li>Justerbar følsomhed</li>
                                <li>Anti-masking og pet immunitet</li>
                                <li>Beskyttelseshætte købes separat</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <hr>
                
                <div class="produkt-wrap">
                    <a href="products/ajax-hood-til-motionprotect-outdoor.html">
                        <img src="../../assets/images/0020235_ajax-hood-til-motionprotect-outdoor_415.png" alt="" class="produkt-listevisning-img">
                    </a>
                    <div class="produkt-listevisning">
                        <h3>Ajax Hood til MotionProtect Outdoor</h3>
                        <h4>Ajax</h4>
                        <hr>
                        <div class="beskrivelse">
                            <ul>
                                <li>Nem montering</li>
                                <li>Til MotionProtect Outdoor</li>
                                <li>Beskytter mod vind og vejr</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <hr>
                
                <div class="produkt-wrap">
                    <a href="products/ajax-dualcurtain-outdoor.html">
                        <img src="../../assets/images/0020360_ajax-dualcurtain-outdoor_415.png" alt="" class="produkt-listevisning-img">
                    </a>
                    <div class="produkt-listevisning">
                        <h3>Ajax DualCurtain Outdoor</h3>
                        <h4>Ajax</h4>
                        <hr>
                        <div class="beskrivelse">
                            <ul>
                                <li>Trådløs udendørs dobbeltrettet gardin bevægelsesdetektor</li>
                                <li>2 uafhængige optiske systemer</li>
                                <li>4 x PIR sensorer</li>
                                <li>Anti-masking og pet immunitet</li>
                                <li>Sikrer ejendommen omkreds</li>
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
        <div class="footer-links">
            <div>
                <ul>
                    <li><a href="#">Kundeservice</a></li>
                    <li><a href="#">Ofte stillede spørgsmål</a></li>
                    <li><a href="#">Handelsvilkår</a></li>
                </ul>
            </div>
            <div>
                <ul>
                    <li><a href="#">Gamingmus</a></li>
                    <li><a href="#">Tastatur</a></li>
                    <li><a href="#">Konsol</a></li>
                </ul>
            </div>
        </div>
        <p>&copy; 2024 Nem Ip Cam - All Rights Reserved</p>
        <p>
            <a href="#">Privacy Policy</a> |
            <a href="#">Terms of Service</a> |
            <a href="#">Contact Us</a>
        </p>
    </div>
</body>
</html>
