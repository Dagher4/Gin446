<?php
// Start the session to verify the user and role
session_start();


// Database connection
$servername = "sql113.infinityfree.com"; // WAMP default
$username = "if0_37882240";        // Default username
$password = "8DSymqAAph6P";            // Default password
$database = "if0_37882240_website";

$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the car ID from the POST request
$data = json_decode(file_get_contents("php://input"), true);
$car_id = isset($data['car_id']) ? (int)$data['car_id'] : 0;

// Validate car ID
if ($car_id <= 0) {
    echo json_encode(["success" => false, "message" => "Invalid car ID"]);
    exit;
}

// SQL query to delete the car from the "car" table
$sql = "DELETE FROM car WHERE ID = ?";

// Prepare the SQL statement
$stmt = $conn->prepare($sql);

// Bind the car ID to the prepared statement
$stmt->bind_param("i", $car_id);

// Execute the query
if ($stmt->execute()) {
    // If the deletion is successful, send a success response
    if ($_SESSION['role'] !== 'admin') {
        echo json_encode(["success" => true, "message" => "Congratulations"]);
    } else {
        echo json_encode(["success" => true, "message" => "Car deleted successfully"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Error deleting car: " . $conn->error]);
}

// Close the database connection
$stmt->close();
$conn->close();
