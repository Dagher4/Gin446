<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "You must be logged in to perform this action."]);
    exit;
}

$user_id = $_SESSION['user_id'];
$data = json_decode(file_get_contents("php://input"), true);
$car_id = $data['car_id'];

if (!$car_id) {
    echo json_encode(["success" => false, "message" => "Invalid car ID."]);
    exit;
}

// Database connection
$servername = "sql113.infinityfree.com"; // WAMP default
$username = "if0_37882240";        // Default username
$password = "8DSymqAAph6P";            // Default password
$database = "if0_37882240_website";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Database connection failed."]);
    exit;
}

// Check if the car is already in the favorites table
$stmt = $conn->prepare("SELECT * FROM favorites WHERE car_id = ? AND user_id = ?");
$stmt->bind_param("ii", $car_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // If it's already a favorite, remove it
    $stmt = $conn->prepare("DELETE FROM favorites WHERE car_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $car_id, $user_id);
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Car removed from favorites."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to remove car from favorites."]);
    }
} else {
    // Otherwise, add it to favorites
    $stmt = $conn->prepare("INSERT INTO favorites (car_id, user_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $car_id, $user_id);
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Car added to favorites."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to add car to favorites."]);
    }
}

$conn->close();
exit;
