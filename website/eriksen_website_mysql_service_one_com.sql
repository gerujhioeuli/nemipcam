-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Vært: eriksen.website.mysql.service.one.com:3306
-- Genereringstid: 10. 03 2025 kl. 20:22:31
-- Serverversion: 10.6.20-MariaDB-ubu2204
-- PHP-version: 8.1.2-1ubuntu2.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eriksen_websiteajax`
--
CREATE DATABASE IF NOT EXISTS `eriksen_websiteajax` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `eriksen_websiteajax`;

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `Alarmpakker`
--

CREATE TABLE `Alarmpakker` (
  `id` int(11) NOT NULL DEFAULT 0,
  `product_name` varchar(255) NOT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `product_page_url` varchar(255) DEFAULT NULL,
  `features` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Data dump for tabellen `Alarmpakker`
--

INSERT INTO `Alarmpakker` (`id`, `product_name`, `brand`, `price`, `image_url`, `product_page_url`, `features`) VALUES
(1, 'Ajax Hub2 Plus 4G StarterKit med kamera', 'Ajax', 4695.00, '../assets/images/0019371_ajax-hub2-starterkit-plus-med-kamera_415.png', 'products/ajax-hub2-starterkit-plus-med-kamera.html', 'Ajax alarm startsæt m. kamera; Hub 2 Plus alarmpanel; Ethernet; GSM (2 x SIM kort (2G), 4G, Wifi); Tilslut op til 200 enheder; Op til 200 brugere; Installer sættet på 30 minutter'),
(2, 'Ajax Hub2 2G StarterKit med kamera', 'Ajax', 3795.00, '../assets/images/0019356_ajax-hub2-starterkit-med-kamera_415.png', 'products/ajax-hub2-starterkit-med-kamera.html', 'Ajax alarm startsæt m. kamera; Hub 2 alarmpanel; Ethernet, GSM (2 x SIM kort (2G)); Tilslut op til 100 enheder; Op til 50 brugere; Installer sættet på 30 minutter');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `Alarmpaneler`
--

CREATE TABLE `Alarmpaneler` (
  `id` int(11) NOT NULL DEFAULT 0,
  `product_name` varchar(255) NOT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `product_page_url` varchar(255) DEFAULT NULL,
  `features` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Data dump for tabellen `Alarmpaneler`
--

INSERT INTO `Alarmpaneler` (`id`, `product_name`, `brand`, `price`, `image_url`, `product_page_url`, `features`) VALUES
(1, 'Ajax Hub 2 2G', 'Ajax', 2495.00, '../assets/images/0019335_ajax-hub-2_415.png', 'products/ajax-hub-2.html', 'Alarmpanel m. billedverifikation; GSM (2G), 2xSIM-kort; Ethernet; Tilsluttede enheder: 100; Tilsluttede repeatere: 5; Brugere: 50'),
(2, 'Ajax Hub 2 4G Plus', 'Ajax', 2995.00, '../assets/images/0019344_ajax-hub-2-plus_415.png', 'products/ajax-hub-2-plus.html', 'Alarmpanel m. billedverifikation; GSM (2G/3G/4G(LTE)) 2xSIM; Ethernet & Wifi; Tilsluttede enheder: 200; Tilsluttede repeatere: 5; Brugere: 200');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `Andet`
--

CREATE TABLE `Andet` (
  `id` int(11) NOT NULL DEFAULT 0,
  `product_name` varchar(255) NOT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `product_page_url` varchar(255) DEFAULT NULL,
  `features` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Data dump for tabellen `Andet`
--

INSERT INTO `Andet` (`id`, `product_name`, `brand`, `price`, `image_url`, `product_page_url`, `features`) VALUES
(1, 'Ajax TurretCam, 5 MP, 2.8 mm, hvid', 'Ajax', 1825.00, '../../assets/images/0022027_ajax-turretcam-5-mp28-mm-hvid_415.png', 'products/ajax-turretcam-5-mp-28-mm-hvid.html', '5MP og 75-85° billedvinkel; AI objekt genkendelse; Op til 30 m. IR lys; Indb. digital mikrofon; Opsæt motion detection område; Understøtter op til 256GB SD kort; IP65 klassificeret'),
(2, 'Ajax TurretCam, 8 MP, 2.8 mm, hvid', 'Ajax', 2425.00, '../../assets/images/0022035_ajax-turretcam-8-mp28-mm-hvid_415.png', 'products/ajax-turretcam-8-mp-28-mm-hvid.html', '8 MP og 100°-110° billedvinkel; AI objekt genkendelse; Op til 35 m. IR lys; Indb. digital mikrofon; Opsæt motion detection område; Understøtter op til 256GB SD kort; IP65 klassificeret');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `Betjening`
--

CREATE TABLE `Betjening` (
  `id` int(11) NOT NULL DEFAULT 0,
  `product_name` varchar(255) NOT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `product_page_url` varchar(255) DEFAULT NULL,
  `features` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Data dump for tabellen `Betjening`
--

INSERT INTO `Betjening` (`id`, `product_name`, `brand`, `price`, `image_url`, `product_page_url`, `features`) VALUES
(1, 'Ajax KeyPad Plus', 'Ajax', 1095.00, '../assets/images/0019887_ajax-keypad-plus_415.png', 'products/ajax-keypad-plus.html', 'Trådløst tastatur og betjeningspanel med kort og nøglebrikslæser; DESFire® EV1, EV2 (13,56MHz); Administrer adgangstilladelser i app; Lys- og lydindikation'),
(2, 'Ajax Nøglebrik', 'Ajax', 95.00, '../assets/images/0019412_ajax-noglebrik_415.png', 'products/ajax-noglebrik.html', 'Nøglebrik til KeyPad Plus & KeyPad Touch; Kan tilsluttes op til 13 hubs; Nem tilføjelse via appen; Indstil navn og tilladelser via appen'),
(3, 'Ajax Nøglekort', 'Ajax', 95.00, '../assets/images/0019401_a-noglekort_415.png', 'products/ajax-noglekort.html', 'Nøglekort til Tastatur Plus; Kan tilsluttes op til 13 hubs; Nem tilføjelse via appen; Indstil navn og tilladelser via appen');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `brand`
--

CREATE TABLE `brand` (
  `id` int(11) NOT NULL DEFAULT 0,
  `product_name` varchar(255) NOT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `product_page_url` varchar(255) DEFAULT NULL,
  `features` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Data dump for tabellen `brand`
--

INSERT INTO `brand` (`id`, `product_name`, `brand`, `price`, `image_url`, `product_page_url`, `features`) VALUES
(1, 'Ajax FireProtect', 'Ajax', 895.00, '../../assets/images/0017201_ajax-fireprotect_415.png', 'products/ajax-fireprotect.html', 'Trådløs røg- og varmedetektor; Med lydgiver / sirene; Registrerer røg- og hurtig temperaturstigning; Kan fungere uafhængigt af alarmsystemet; Giver besked om manglende rengøring');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `indendors`
--

CREATE TABLE `indendors` (
  `id` int(11) NOT NULL DEFAULT 0,
  `product_name` varchar(255) NOT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `product_page_url` varchar(255) DEFAULT NULL,
  `features` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Data dump for tabellen `indendors`
--

INSERT INTO `indendors` (`id`, `product_name`, `brand`, `price`, `image_url`, `product_page_url`, `features`) VALUES
(1, 'Ajax DoorProtect', 'Ajax', 395.00, '../../assets/images/0017151_ajax-doorprotect_415.png', 'products/ajax-doorprotect.html', 'Trådløs magnet dørkontakt; Registrerer når dør/vindue brydes op; 2 medfølgende magneter: stor og lille; Nem og hurtig installation'),
(2, 'Ajax MotionProtect', 'Ajax', 665.00, '../../assets/images/0019900_ajax-motionprotect_415.png', 'products/ajax-motionprotect.html', 'Trådløs bevægelsesdetektor; PIR-sensor; Hurtig og nem installation; Dyreimmun op til 20 kg., 50 cm.; Op til 5 års batterilevetid'),
(3, 'Ajax MotionProtect Plus', 'Ajax', 930.00, '../../assets/images/0019903_ajax-motionprotect-plus_415.png', 'products/ajax-motionprotect-plus.html', 'Trådløs bevægelsesdetektor med mikrobølgesensor; PIR & Mikrobølgesensor; Hurtig og nem installation; Dyreimmun op til 20 kg./50 cm.; Op til 5 års batterilevetid'),
(4, 'Ajax MotionCam', 'Ajax', 1495.00, '../../assets/images/0019743_ajax-motioncam-phod_415.png', 'products/motioncam-phod.html', 'Trådløs bevægelsessensor med kamera; Mulighed for at forespørge om et billede; Visuel alarmverifikation; Sender straks animeret fotoserie; IR-baggrundsbelysning for natbilleder; Dyreimmun: 20 kg. / 50 cm.'),
(5, 'Ajax MotionProtect Curtain', 'Ajax', 795.00, '../../assets/images/0019901_ajax-motionprotect-curtain_415.png', 'products/motionprotect-curtain.html', 'Trådløs indendørs gardin bevægelsesdetektor; Perimeter beskyttelse; Beskytter indgange og vinduer; 2 PIR sensorer; Nem og hurtig installation');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `kamera`
--

CREATE TABLE `kamera` (
  `id` int(11) NOT NULL DEFAULT 0,
  `product_name` varchar(255) NOT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `product_page_url` varchar(255) DEFAULT NULL,
  `features` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Data dump for tabellen `kamera`
--

INSERT INTO `kamera` (`id`, `product_name`, `brand`, `price`, `image_url`, `product_page_url`, `features`) VALUES
(1, 'Ajax TurretCam, 5 MP, 2.8 mm, hvid', 'Ajax', 1825.00, '../../assets/images/0022027_ajax-turretcam-5-mp28-mm-hvid_415.png', 'products/ajax-turretcam-5-mp-28-mm-hvid.html', '5MP og 75-85° billedvinkel; AI objekt genkendelse; Op til 30 m. IR lys; Indb. digital mikrofon; Opsæt motion detection område; Understøtter op til 256GB SD kort; IP65 klassificeret'),
(2, 'Ajax TurretCam, 8 MP, 2.8 mm, hvid', 'Ajax', 2425.00, '../../assets/images/0022035_ajax-turretcam-8-mp28-mm-hvid_415.png', 'products/ajax-turretcam-8-mp-28-mm-hvid.html', '8 MP og 100°-110° billedvinkel; AI objekt genkendelse; Op til 35 m. IR lys; Indb. digital mikrofon; Opsæt motion detection område; Understøtter op til 256GB SD kort; IP65 klassificeret');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `kategorier`
--

CREATE TABLE `kategorier` (
  `id` int(11) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `navn` varchar(255) NOT NULL,
  `parent_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Data dump for tabellen `kategorier`
--

INSERT INTO `kategorier` (`id`, `slug`, `navn`, `parent_id`) VALUES
(1, 'videoovervogning', 'Videoovervågning', NULL),
(2, 'alarmpakker', 'Alarmpakker', NULL),
(3, 'alarmpaneler', 'Alarmpaneler', NULL),
(4, 'betjening', 'Betjening', NULL),
(5, 'sensorer', 'Sensorer', NULL),
(6, 'sirener', 'Sirener', NULL),
(7, 'andet', 'Andet', NULL);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `NVRoptager`
--

CREATE TABLE `NVRoptager` (
  `id` int(11) NOT NULL DEFAULT 0,
  `product_name` varchar(255) NOT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `product_page_url` varchar(255) DEFAULT NULL,
  `features` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Data dump for tabellen `NVRoptager`
--

INSERT INTO `NVRoptager` (`id`, `product_name`, `brand`, `price`, `image_url`, `product_page_url`, `features`) VALUES
(1, 'Ajax NVR - 8 kanals', 'Ajax', 4000.00, '../../assets/images/0020757_ajax-nvr-8-kanals_550.png', 'products/ajax-nvr-8-kanals.html', 'Video optager; Integrer 3-parts kameraer; ONVIF/RTSP; Bevægelsesdetektion'),
(2, 'Ajax NVR - 16 kanals', 'Ajax', 5000.00, '../../assets/images/0021303_ajax-nvr-16-kanals.png', 'products/ajax-nvr-16-kanals.html', 'Video optager; Integrer 3-parts kameraer; ONVIF/RTSP; Bevægelsesdetektion');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `product_page_url` varchar(255) DEFAULT NULL,
  `features` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Data dump for tabellen `products`
--

INSERT INTO `products` (`id`, `product_name`, `brand`, `price`, `image_url`, `product_page_url`, `features`) VALUES
(1, 'Ajax Hub2 Plus StarterKit med kamera', 'Ajax', 3400.00, '../assets/images/0019371_ajax-hub2-starterkit-plus-med-kamera_415.png', 'products/ajax-hub2-starterkit-plus-med-kamera.html', 'Ajax alarm startsæt m. kamera; Hub 2 Plus alarmpanel; Ethernet; GSM (2 x SIM kort (2G), LTE, Wifi); Tilslut op til 200 enheder; Op til 200 brugere; Installer sættet på 30 minutter'),
(2, 'Ajax Hub2 StarterKit med kamera', 'Ajax', 2250.00, '../assets/images/0019356_ajax-hub2-starterkit-med-kamera_415.png', 'products/ajax-hub2-starterkit-med-kamera.html', 'Ajax alarm startsæt m. kamera; Hub 2 alarmpanel; Ethernet, GSM (2 x SIM kort (2G)); Tilslut op til 100 enheder; Op til 50 brugere; Installer sættet på 30 minutter'),
(3, 'Ajax Hub 2', 'Ajax', 1450.00, '../assets/images/0019335_ajax-hub-2_415.png', 'products/ajax-hub-2.html', 'Alarmpanel m. billedverifikation; GSM (2G), 2xSIM-kort; Ethernet; Tilsluttede enheder: 100; Tilsluttede repeatere: 5; Brugere: 50'),
(5, 'Ajax KeyPad Plus', 'Ajax', 990.00, '../assets/images/0019887_ajax-keypad-plus_415.png', 'products/ajax-keypad-plus.html', 'Trådløst tastatur og betjeningspanel med kort og nøglebrikslæser; DESFire® EV1, EV2 (13,56MHz); Administrer adgangstilladelser i app; Lys- og lydindikation'),
(6, 'Ajax Nøglebrik', 'Ajax', 75.00, '../assets/images/0019412_ajax-noglebrik_415.png', 'products/ajax-noglebrik.html', 'Nøglebrik til KeyPad Plus & KeyPad Touch; Kan tilsluttes op til 13 hubs; Nem tilføjelse via appen; Indstil navn og tilladelser via appen'),
(7, 'Ajax Nøglekort', 'Ajax', 75.00, '../assets/images/0019401_a-noglekort_415.png', 'products/ajax-noglekort.html', 'Nøglekort til Tastatur Plus; Kan tilsluttes op til 13 hubs; Nem tilføjelse via appen; Indstil navn og tilladelser via appen'),
(20002, 'Ajax Hub 2 Plus', 'Ajax', 1900.00, '../assets/images/0019344_ajax-hub-2-plus_415.png', 'products/ajax-hub-2-plus.html', 'Alarmpanel m. billedverifikation; GSM (2G/3G/4G(LTE)) 2xSIM; Ethernet & Wifi; Tilsluttede enheder: 200; Tilsluttede repeatere: 5; Brugere: 200'),
(20004, 'Ajax Hub2 Plus StarterKit med kamera', 'Ajax', 3400.00, '../assets/images/0019371_ajax-hub2-starterkit-plus-med-kamera_415.png', 'products/ajax-hub2-starterkit-plus-med-kamera.html', 'Ajax alarm startsæt m. kamera; Hub 2 Plus alarmpanel; Ethernet; GSM (2 x SIM kort (2G), LTE, Wifi); Tilslut op til 200 enheder; Op til 200 brugere; Installer sættet på 30 minutter');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `Sensorer`
--

CREATE TABLE `Sensorer` (
  `id` int(11) NOT NULL DEFAULT 0,
  `product_name` varchar(255) NOT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `product_page_url` varchar(255) DEFAULT NULL,
  `features` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Data dump for tabellen `Sensorer`
--

INSERT INTO `Sensorer` (`id`, `product_name`, `brand`, `price`, `image_url`, `product_page_url`, `features`) VALUES
(1, 'Ajax TurretCam, 5 MP, 2.8 mm, hvid', 'Ajax', 1825.00, '../../assets/images/0022027_ajax-turretcam-5-mp28-mm-hvid_415.png', 'products/ajax-turretcam-5-mp-28-mm-hvid.html', '5MP og 75-85° billedvinkel; AI objekt genkendelse; Op til 30 m. IR lys; Indb. digital mikrofon; Opsæt motion detection område; Understøtter op til 256GB SD kort; IP65 klassificeret'),
(2, 'Ajax TurretCam, 8 MP, 2.8 mm, hvid', 'Ajax', 2425.00, '../../assets/images/0022035_ajax-turretcam-8-mp28-mm-hvid_415.png', 'products/ajax-turretcam-8-mp-28-mm-hvid.html', '8 MP og 100°-110° billedvinkel; AI objekt genkendelse; Op til 35 m. IR lys; Indb. digital mikrofon; Opsæt motion detection område; Understøtter op til 256GB SD kort; IP65 klassificeret');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `Sirener`
--

CREATE TABLE `Sirener` (
  `id` int(11) NOT NULL DEFAULT 0,
  `product_name` varchar(255) NOT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `product_page_url` varchar(255) DEFAULT NULL,
  `features` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Data dump for tabellen `Sirener`
--

INSERT INTO `Sirener` (`id`, `product_name`, `brand`, `price`, `image_url`, `product_page_url`, `features`) VALUES
(1, 'Ajax HomeSiren', 'Ajax', 665.00, '../assets/images/0019250_ajax-homesiren_415.png', 'products/ajax-homesiren.html', 'Trådløs indendørs sirene; Justerbar lydstyrke og alarmlængde; Angivelse af til/frakobling med indb. LED; Mulighed for tilslutning af ekstern LED'),
(2, 'Ajax StreetSiren', 'Ajax', 1295.00, '../assets/images/0017184_ajax-streetsiren_415.png', 'products/ajax-streetsiren.html', 'Trådløs udendørs sirene; Med indbygget LED lys; Vejrbestandig; Justerbar lydstyrkeniveau; Lyd ved til/frakobling af system');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `udendors`
--

CREATE TABLE `udendors` (
  `id` int(11) NOT NULL DEFAULT 0,
  `product_name` varchar(255) NOT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `product_page_url` varchar(255) DEFAULT NULL,
  `features` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Data dump for tabellen `udendors`
--

INSERT INTO `udendors` (`id`, `product_name`, `brand`, `price`, `image_url`, `product_page_url`, `features`) VALUES
(1, 'Ajax MotionCam Outdoor', 'Ajax', 2895.00, '../../assets/images/0020237_ajax-motioncam-outdoor_415.png', 'products/ajax-motioncam-outdoor.html', 'Trådløs udendørs bevægelsesdetektor med kamera; Visuel alarm verifikation; Anti-masking og pet immunitet; HDR-kamera; IR-baggrundsbelysning; Beskyttelseshætte medfølger'),
(2, 'Ajax DualCurtain Outdoor', 'Ajax', 1695.00, '../../assets/images/0020360_ajax-dualcurtain-outdoor_415.png', 'products/ajax-dualcurtain-outdoor.html', 'Trådløs udendørs dobbeltrettet gardin bevægelsesdetektor; 2 uafhængige optiske systemer; 4 x PIR sensorer; Anti-masking og pet immunitet; Sikrer ejendommen omkreds');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `Videoovervågning`
--

CREATE TABLE `Videoovervågning` (
  `id` int(11) NOT NULL DEFAULT 0,
  `product_name` varchar(255) NOT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `product_page_url` varchar(255) DEFAULT NULL,
  `features` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Data dump for tabellen `Videoovervågning`
--

INSERT INTO `Videoovervågning` (`id`, `product_name`, `brand`, `price`, `image_url`, `product_page_url`, `features`) VALUES
(1, 'Ajax TurretCam, 5 MP, 2.8 mm, hvid', 'Ajax', 1825.00, '../../assets/images/0022027_ajax-turretcam-5-mp28-mm-hvid_415.png', 'products/ajax-turretcam-5-mp-28-mm-hvid.html', '5MP og 75-85° billedvinkel; AI objekt genkendelse; Op til 30 m. IR lys; Indb. digital mikrofon; Opsæt motion detection område; Understøtter op til 256GB SD kort; IP65 klassificeret'),
(2, 'Ajax TurretCam, 8 MP, 2.8 mm, hvid', 'Ajax', 2425.00, '../../assets/images/0022035_ajax-turretcam-8-mp28-mm-hvid_415.png', 'products/ajax-turretcam-8-mp-28-mm-hvid.html', '8 MP og 100°-110° billedvinkel; AI objekt genkendelse; Op til 35 m. IR lys; Indb. digital mikrofon; Opsæt motion detection område; Understøtter op til 256GB SD kort; IP65 klassificeret');

--
-- Begrænsninger for dumpede tabeller
--

--
-- Indeks for tabel `Alarmpakker`
--
ALTER TABLE `Alarmpakker`
  ADD PRIMARY KEY (`id`);

--
-- Indeks for tabel `Alarmpaneler`
--
ALTER TABLE `Alarmpaneler`
  ADD PRIMARY KEY (`id`);

--
-- Indeks for tabel `Betjening`
--
ALTER TABLE `Betjening`
  ADD PRIMARY KEY (`id`);

--
-- Indeks for tabel `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`id`);

--
-- Indeks for tabel `indendors`
--
ALTER TABLE `indendors`
  ADD PRIMARY KEY (`id`);

--
-- Indeks for tabel `kamera`
--
ALTER TABLE `kamera`
  ADD PRIMARY KEY (`id`);

--
-- Indeks for tabel `kategorier`
--
ALTER TABLE `kategorier`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indeks for tabel `NVRoptager`
--
ALTER TABLE `NVRoptager`
  ADD PRIMARY KEY (`id`);

--
-- Indeks for tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indeks for tabel `Sirener`
--
ALTER TABLE `Sirener`
  ADD PRIMARY KEY (`id`);

--
-- Indeks for tabel `udendors`
--
ALTER TABLE `udendors`
  ADD PRIMARY KEY (`id`);

--
-- Brug ikke AUTO_INCREMENT for slettede tabeller
--

--
-- Tilføj AUTO_INCREMENT i tabel `kategorier`
--
ALTER TABLE `kategorier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Tilføj AUTO_INCREMENT i tabel `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20005;

--
-- Begrænsninger for dumpede tabeller
--

--
-- Begrænsninger for tabel `kategorier`
--
ALTER TABLE `kategorier`
  ADD CONSTRAINT `kategorier_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `kategorier` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
