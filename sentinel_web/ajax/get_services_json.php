<?php
// ajax/get_products_json.php
header('Content-Type: application/json');
require_once "../db.php"; // Adjust path if db.php is in root

// Check connection
if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed"]));
}

// Fetch Products from the correct table 'productslist'
$sql = "SELECT id, ps_header, ps_content, img_source FROM productslist ORDER BY id ASC";
$result = $conn->query($sql);

$data = [];

if ($result) {
    while($row = $result->fetch_assoc()) {
        // Create a short snippet for the sidebar
        // strip_tags removes HTML to make the sidebar clean
        $row['short_desc'] = mb_strimwidth(strip_tags($row['ps_content']), 0, 60, "...");
        
        // Ensure image path is valid
        $row['img_full'] = $row['img_source']; 
        
        $data[] = $row;
    }
}

echo json_encode($data);
$conn->close();
?>