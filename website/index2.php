<?php 
    include_once 'includes/api.php'; // Include your database connection file

    // SQL query to fetch all products
    $sql = "SELECT * FROM products;";
    $result = mysqli_query($conn, $sql);

    // Array to hold all product data
    $products = array();

    if($result) {
        // Check if there are any rows in the result
        if(mysqli_num_rows($result) > 0) {
            // Fetch each row and add it to the $products array
            while($row = mysqli_fetch_assoc($result)) {
                $products[] = $row; // Add each row's data as an associative array to the $products array
            }

            // Output the $products array as JSON
            header('Content-Type: application/json'); // Set the header to indicate JSON response
            echo json_encode($products, JSON_PRETTY_PRINT); // Convert the array to JSON format
        } else {
            echo json_encode(["message" => "No products found"]);
        }
    } else {
        echo json_encode(["error" => "Error executing query: " . mysqli_error($conn)]);
    }

    // Close the database connection
    mysqli_close($conn);
?>

