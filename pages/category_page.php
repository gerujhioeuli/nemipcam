<?php
include_once '../includes/api.php';
include_once '../includes/functions.php';

// Hent kategorier fra databasen
$categories = [];
$sql = "SELECT * FROM kategorier";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $categories[$row['slug']] = $row['navn'];
    }
} else {
    echo "Ingen kategorier fundet.";
}

// Automatisk identificer aktiv kategori baseret på URL-parameter
$activeCategory = isset($_GET['category']) ? $_GET['category'] : null;

// Generer og vis dynamisk kategori-listevisning
echo generateCategoryList($categories, $activeCategory);

// Generer brødkrummesti baseret på de aktuelle kategorier fra databasen
echo generateBreadcrumb($categories);

$conn->close();
?>
