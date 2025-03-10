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
                <h2>Andet tilbehør</h2>
                <hr>
                <div id="product-container"></div>
                <div class="produkt-wrap">
                    <a href="#">
                        <img src="../assets/images/0019375_ajax-holder-til-button-og-doublebutton_415.png" alt="" class="produkt-listevisning-img">
                    </a>
                    <div class="produkt-listevisning">
                        <h3>Ajax holder til Button og DoubleButton</h3>
                        <h4>Ajax</h4>
                        <hr>
                        <div class="beskrivelse">
                            <ul>
                                <li>Holder til installation af panikknap</li>
                                <li>Passer både til Panik- og dobbeltknappen</li>
                                <li>Kan monteres på væg</li>
                                <li>Knappen kan hurtigt løsnes fra beslaget</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <hr>
                
                <div class="produkt-wrap">
                    <a href="#">
                        <img src="../assets/images/0019906_ajax-leaksprotect_415.png" alt="" class="produkt-listevisning-img">
                    </a>
                    <div class="produkt-listevisning">
                        <h3>Ajax LeaksProtect</h3>
                        <h4>Ajax</h4>
                        <hr>
                        <div class="beskrivelse">
                            <ul>
                                <li>Trådløs vandskadedetektor</li>
                                <li>Mod små lækager og store oversvømmelser</li>
                                <li>Kræver ikke montering</li>
                                <li>Op til 200 detektorer i systemet</li>
                                <li>Få besked via push besked ved lækage</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <hr>
                
                <div class="produkt-wrap">
                    <a href="#">
                        <img src="../assets/images/0019925_ajax-multitransmitter-2-3-eol_415.png" alt="" class="produkt-listevisning-img">
                    </a>
                    <div class="produkt-listevisning">
                        <h3>Ajax multitransmitter 2-3 EOL</h3>
                        <h4>Ajax</h4>
                        <hr>
                        <div class="beskrivelse">
                            <ul>
                                <li>Modul til integration af fortrådet tredjeparts enheder</li>
                                <li>Understøtter både 2 og 3 EOL</li>
                                <li>Tilslutning af kablet alarm til Ajax</li>
                                <li>Styring af sikkerhed via appen</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <hr>
                
                <div class="produkt-wrap">
                    <a href="#">
                        <img src="../assets/images/0020318_ajax-rex-2_415.png" alt="" class="produkt-listevisning-img">
                    </a>
                    <div class="produkt-listevisning">
                        <h3>Ajax ReX 2</h3>
                        <h4>Ajax</h4>
                        <hr>
                        <div class="beskrivelse">
                            <ul>
                                <li>Repeater, signalforstærker</li>
                                <li>Sender alarmer på 0,3 sek.</li>
                                <li>Kommunikerer i en afstand op til 1800 m.</li>
                                <li>Op til 35 timer på backup-batteri</li>
                                <li>Tilføj op til 5 repeatere pr. Hub / system</li>
                                <li>Virker kun til Hub 2 / Hub 2 Plus</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="produkt-wrap">
                    <a href="#">
                        <img src="../assets/images/0019321_ajax-socket-230-v_415.png" alt="" class="produkt-listevisning-img">
                    </a>
                    <div class="produkt-listevisning">
                        <h3>Ajax Socket, 230 V</h3>
                        <h4>Ajax</h4>
                        <hr>
                        <div class="beskrivelse">
                            <ul>
                                <li>Trådløs smart plug&nbsp;med energi indikator</li>
                                <li>Tænd/sluk for enheder på kommando</li>
                                <li>Overvåger elforbrug</li>
                                <li>Beskytter mod overbeslatning og kortslutning</li>
                                <li>Øjeblikkelig advarsel ved strømafbrydelse</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="produkt-wrap">
                    <a href="#">
                        <img src="../assets/images/0020227_ajax-din-holder-til-relay-og-wallswitch_415.png" alt="" class="produkt-listevisning-img">
                    </a>
                    <div class="produkt-listevisning">
                        <h3>Ajax DIN Holder (Til Relay og WallSwitch)</h3>
                        <h4>Ajax</h4>
                        <hr>
                        <div class="beskrivelse">
                            <ul>
                                <li>Holder til at fastgøre Relay eller WallSwitch på DIN skinne</li>
                                <li>Indbygget knap til manuel betjening</li>
                                <li>Praktisk størrelse</li>
                                <li>Ingen overophedning</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <hr>
                
                <div class="produkt-wrap">
                    <a href="#">
                        <img src="../assets/images/0020220_ajax-waterstop-1-white_415.jpeg" alt="" class="produkt-listevisning-img">
                    </a>
                    <div class="produkt-listevisning">
                        <h3>Ajax WaterStop 1", Hvid</h3>
                        <h4>Ajax</h4>
                        <hr>
                        <div class="beskrivelse">
                            <ul>
                                <li>Fjernstyret vand afspærringsventil</li>
                                <li>Kompatibel med koldt- og varmtvandsrør</li>
                                <li>Vandet lukkes på 5 sekunder</li>
                                <li>Kan bruges sammen med Ajax LeaksProtect</li>
                                <li>1" Bonomi ventil</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <hr>
                
                <div class="produkt-wrap">
                    <a href="#">
                        <img src="../assets/images/0020221_ajax-waterstop-34_415.jpeg" alt="" class="produkt-listevisning-img">
                    </a>
                    <div class="produkt-listevisning">
                        <h3>Ajax WaterStop 3/4" White</h3>
                        <h4>Ajax</h4>
                        <hr>
                        <div class="beskrivelse">
                            <ul>
                                <li>Fjernstyret vand afspærringsventil</li>
                                <li>Kompatibel med koldt- og varmtvandsrør</li>
                                <li>Vandet lukkes på 5 sekunder</li>
                                <li>Kan bruges sammen med Ajax LeaksProtect</li>
                                <li>3/4" Bonomi ventil</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <hr>
                
                <div class="produkt-wrap">
                    <a href="#">
                        <img src="../assets/images/0020222_ajax-waterstop-12-white_415.jpeg" alt="" class="produkt-listevisning-img">
                    </a>
                    <div class="produkt-listevisning">
                        <h3>Ajax WaterStop 1/2", Hvid</h3>
                        <h4>Ajax</h4>
                        <hr>
                        <div class="beskrivelse">
                            <ul>
                                <li>Fjernstyret vand afspærringsventil</li>
                                <li>Kompatibel med koldt- og varmtvandsrør</li>
                                <li>Vandet lukkes på 5 sekunder</li>
                                <li>Kan bruges sammen med Ajax LeaksProtect</li>
                                <li>1/2" Bonomi ventil</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <hr>
                
                <div class="produkt-wrap">
                    <a href="#">
                        <img src="../assets/images/0020228_ajax-12v-psu-for-hub-2_415.png" alt="" class="produkt-listevisning-img">
                    </a>
                    <div class="produkt-listevisning">
                        <h3>Ajax 12V PSU for Hub 2</h3>
                        <h4>Ajax</h4>
                        <hr>
                        <div class="beskrivelse">
                            <ul>
                                <li>12 V strømforsyningsmodul til Hub 2</li>
                                <li>Trådløst relæ med spændingsfri kontaktsæt</li>
                                <li>Forbinder hub 2 med lavspændingskilde</li>
                                <li>Installeres i Hubbens 'krop' og erstatter den eksisterende 110/230 V</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="produkt-wrap">
                    <a href="#">
                        <img src="../assets/images/0020233_ajax-12v-psu-for-hubhub-plusrex_415.png" alt="" class="produkt-listevisning-img">
                    </a>
                    <div class="produkt-listevisning">
                        <h3>Ajax 12V PSU for Hub/Hub Plus/ReX</h3>
                        <h4>Ajax</h4>
                        <hr>
                        <div class="beskrivelse">
                            <ul>
                                <li>12 V strømforsyningsmodul til Hub/Hub Plus/ReX</li>
                                <li>Trådløst relæ med spændingsfri kontaktsæt</li>
                                <li>Forbinder hub 2 med lavspændingskilde</li>
                                <li>Installeres i Hubbens 'krop' og erstatter den eksisterende 110/230 V</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <hr>
                
                <div class="produkt-wrap">
                    <a href="#">
                        <img src="../assets/images/0020234_ajax-6v-psu-for-hub-2_415.png" alt="" class="produkt-listevisning-img">
                    </a>
                    <div class="produkt-listevisning">
                        <h3>Ajax 6V PSU for Hub 2</h3>
                        <h4>Ajax</h4>
                        <hr>
                        <div class="beskrivelse">
                            <ul>
                                <li>6V strømforsyningsmodul til Hub 2 /Hub 2 Plus/ReX 2</li>
                                <li>Trådløst relæ med spændingsfri kontaktsæt</li>
                                <li>Forbinder hub 2 med lavspændingskilde</li>
                                <li>Installeres i Hubbens 'krop' og erstatter den eksisterende 110/230 V</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <hr>
                
                <div class="produkt-wrap">
                    <a href="#">
                        <img src="../assets/images/0020240_ajax-relay_415.png" alt="" class="produkt-listevisning-img">
                    </a>
                    <div class="produkt-listevisning">
                        <h3>Ajax Relay</h3>
                        <h4>Ajax</h4>
                        <hr>
                        <div class="beskrivelse">
                            <ul>
                                <li>Trådløst relæ med spændingsfri kontaktsæt</li>
                                <li>Til fjernstyring af apparater</li>
                                <li>Strømforsyning: 7-24 V DC</li>
                                <li>Relæ belastning: 5A ved 36V DC, 13A ved 230V AC</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <hr>
                
                <div class="produkt-wrap">
                    <a href="#">
                        <img src="../assets/images/0020247_ajax-transmitter_415.png" alt="" class="produkt-listevisning-img">
                    </a>
                    <div class="produkt-listevisning">
                        <h3>Ajax Transmitter</h3>
                        <h4>Ajax</h4>
                        <hr>
                        <div class="beskrivelse">
                            <ul>
                                <li>Modul til integration af fortrådet tredjeparts enheder</li>
                                <li>Konverterer tredjepartsdetektorer</li>
                                <li>Kan bruges som strømforsyning til 3. parts enheder</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <hr>
                
                <div class="produkt-wrap">
                    <a href="#">
                        <img src="../assets/images/0020248_ajax-wallswitch-sort_415.png" alt="" class="produkt-listevisning-img">
                    </a>
                    <div class="produkt-listevisning">
                        <h3>Ajax WallSwitch sort</h3>
                        <h4>Ajax</h4>
                        <hr>
                        <div class="beskrivelse">
                            <ul>
                                <li>Trådløs relækontakt til 230V med energi indikator</li>
                                <li>Til fjernstyring af elektrisk forsyning</li>
                                <li>Strømforsyning: 110-230 V ± 10% 50/60 Hz</li>
                                <li>Beskytter enheder mod overstrøm og spændingsstød</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="produkt-wrap">
                    <a href="#">
                        <img src="../assets/images/0020382_ajax-ocbridge-plus_415.png" alt="" class="produkt-listevisning-img">
                    </a>
                    <div class="produkt-listevisning">
                        <h3>Ajax ocBridge Plus</h3>
                        <h4>Ajax</h4>
                        <hr>
                        <div class="beskrivelse">
                            <ul>
                                <li>Forbinder Ajax enheder til kablede 3-parts centraler</li>
                                <li>NC/NO kontakter</li>
                                <li>To-vejs forbindelse for aktiv/passiv tilstand</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <hr>
                
                <div class="produkt-wrap">
                    <a href="#">
                        <img src="../assets/images/0020380_ajax-uartbridge_415.png" alt="" class="produkt-listevisning-img">
                    </a>
                    <div class="produkt-listevisning">
                        <h3>Ajax uartBridge</h3>
                        <h4>Ajax</h4>
                        <hr>
                        <div class="beskrivelse">
                            <ul>
                                <li>Forbinder Ajax enheder til trådløse 3-parts systemer</li>
                                <li>Via UART interface</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <hr>
                
                <div class="produkt-wrap">
                    <a href="#">
                        <img src="../assets/images/0020383_ajax-vhfbridge_415.png" alt="" class="produkt-listevisning-img">
                    </a>
                    <div class="produkt-listevisning">
                        <h3>Ajax vhfBridge</h3>
                        <h4>Ajax</h4>
                        <hr>
                        <div class="beskrivelse">
                            <ul>
                                <li>Forbinder Ajax systemet til 3-parts VHF sendere</li>
                                <li>8 transistor udgange</li>
                                <li>100-240 V</li>
                                <li>Kan tilsluttes et 12V backup batteri</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <hr>
                
                <div class="produkt-wrap">
                    <a href="#">
                        <img src="../assets/images/0020506_ajax-lifequality_415.png" alt="" class="produkt-listevisning-img">
                    </a>
                    <div class="produkt-listevisning">
                        <h3>Ajax LifeQuality</h3>
                        <h4>Ajax</h4>
                        <hr>
                        <div class="beskrivelse">
                            <ul>
                                <li>Luftkvalitetssensor</li>
                                <li>Temperatur- fugt og C02 sensor</li>
                                <li>Opsæt scenarier udfra målte værdier</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <hr>
                
                <div class="produkt-wrap">
                    <a href="#">
                        <img src="../assets/images/0022105_ajax-12-24v-psu-for-hub-2hub-2-plusrex-2_415.jpeg" alt="" class="produkt-listevisning-img">
                    </a>
                    <div class="produkt-listevisning">
                        <h3>Ajax 12-24V PSU for Hub 2/Hub 2 Plus/ReX 2</h3>
                        <h4>Ajax</h4>
                        <hr>
                        <div class="beskrivelse">
                            <ul>
                                <li>12-24V strømforsyningsmodul til Hub2/Hub 2 Plus/ReX 2</li>
                                <li>Trådløst relæ med spændingsfri kontaktsæt</li>
                                <li>Forbinder Hubs/Rex med lavspændingskilde</li>
                                <li>Installeres i Hubbens 'krop' og erstatter den eksisterende 110/230 V</li>
                            </ul>
                        </div>
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
