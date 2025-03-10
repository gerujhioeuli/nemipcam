<?php 
    include_once '../../includes/api.php';
    
    // SQL query to fetch all product details
    $sql = "SELECT product_name, brand, price, image_url, product_page_url, features FROM brand";
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
                            <a href="../categories/udendors.php"><div class="unactive_category">Udendørs detektorer</div></a>
                            <a href="../categories/brand.php"><div class="active_category">Brand detektorer</div></a>
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
                    <a href="products/ajax-fireprotect-2.html">
                        <img src="../../assets/images/0020641_ajax-fireprotect-2_415.png" alt="Ajax FireProtect 2" class="produkt-listevisning-img">
                    </a>
                    <div class="produkt-listevisning">
                        <h3>Ajax FireProtect 2</h3>
                        <h4>Ajax</h4>
                        <hr>
                        <div class="beskrivelse">
                            <ul>
                                <li>Sensor med temperatur- og røg detektor</li>
                                <li>85 dB indbygget sirene</li>
                                <li>Kan fungere selvstændigt uden Hub</li>
                                <li>Indbyrdes forbundet</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <hr>
                
                <div class="produkt-wrap">
                    <a href="products/ajax-fireprotect-2-plus.html">
                        <img src="../../assets/images/0020642_ajax-fireprotect-2-plus_415.png" alt="Ajax FireProtect 2 Plus" class="produkt-listevisning-img">
                    </a>
                    <div class="produkt-listevisning">
                        <h3>Ajax FireProtect 2 Plus</h3>
                        <h4>Ajax</h4>
                        <hr>
                        <div class="beskrivelse">
                            <ul>
                                <li>Sensor med røg-, temperatur- og kulilte detektor</li>
                                <li>85 dB indbygget sirene</li>
                                <li>Kan fungere selvstændigt uden Hub</li>
                                <li>Indbyrdes forbundet</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <hr>
                
                <div class="produkt-wrap">
                    <a href="products/ajax-fireprotect.html">
                        <img src="../../assets/images/0017201_ajax-fireprotect_415.png" alt="Ajax FireProtect" class="produkt-listevisning-img">
                    </a>
                    <div class="produkt-listevisning">
                        <h3>Ajax FireProtect</h3>
                        <h4>Ajax</h4>
                        <hr>
                        <div class="beskrivelse">
                            <ul>
                                <li>Trådløs røg- og varmedetektor</li>
                                <li>Med lydgiver / sirene</li>
                                <li>Registrerer røg- og hurtig temperaturstigning</li>
                                <li>Kan fungere uafhængigt af alarmsystemet</li>
                                <li>Giver besked om manglende rengøring</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <hr>
                
                <div class="produkt-wrap">
                    <a href="products/ajax-fireprotect-plus.html">
                        <img src="../../assets/images/0017210_ajax-fireprotect-plus_415.png" alt="Ajax FireProtect Plus" class="produkt-listevisning-img">
                    </a>
                    <div class="produkt-listevisning">
                        <h3>Ajax FireProtect Plus</h3>
                        <h4>Ajax</h4>
                        <hr>
                        <div class="beskrivelse">
                            <ul>
                                <li>Trådløs røg, varme og kulilte detektor</li>
                                <li>Med lydgiver / sirene</li>
                                <li>Registrerer røg- og hurtig temperaturstigning</li>
                                <li>Registrerer forhøjet kulilte niveau</li>
                                <li>Kan fungere uafhængigt af alarmsystemet</li>
                                <li>Giver besked om manglende rengøring</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <hr>
            
                <div class="produkt-wrap">
                    <a href="products/ajax-fireprotect-2-heat-termo.html">
                        <img src="../../assets/images/0021964_ajax-fireprotect-2-heat-termo_415.png" alt="" class="produkt-listevisning-img">
                    </a>
                    <div class="produkt-listevisning">
                        <h3>Ajax FireProtect 2 - Heat / Termo</h3>
                        <h4>Ajax</h4>
                        <hr>
                        <div class="beskrivelse">
                            <ul>
                                <li>Branddetektor med varme/termo sensor</li>
                                <li>85 dB indbygget sirene</li>
                                <li>Kan fungere selvstændigt uden Hub</li>
                                <li>Indbyrdes forbundet</li>
                                <li>Udskiftelige batterier</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <hr>
                
                <div class="produkt-wrap">
                    <a href="products/ajax-manual-call-point-blue.html">
                        <img src="../../assets/images/0022137_ajax-manual-call-point-blue_415.png" alt="" class="produkt-listevisning-img">
                    </a>
                    <div class="produkt-listevisning">
                        <h3>Ajax Manual Call Point (Blue)</h3>
                        <h4>Ajax</h4>
                        <hr>
                        <div class="beskrivelse">
                            <ul>
                                <li>Trådløs, vægmonteret knap til manuel aktivering af brand alarmer</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <hr>
                
                <div class="produkt-wrap">
                    <a href="products/ajax-manual-call-point-red.html">
                        <img src="../../assets/images/0021388_ajax-manual-call-point-red_415.png" alt="" class="produkt-listevisning-img">
                    </a>
                    <div class="produkt-listevisning">
                        <h3>Ajax Manual Call Point (Red)</h3>
                        <h4>Ajax</h4>
                        <hr>
                        <div class="beskrivelse">
                            <ul>
                                <li>Trådløs, vægmonteret knap til manuel aktivering af brand alarmer</li>
                                <li>EN 54-11:2001, A1:2005</li>
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
