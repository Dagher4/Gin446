<?php
session_start();

$servername = "sql113.infinityfree.com"; // WAMP default
$username = "if0_37882240";        // Default username
$password = "8DSymqAAph6P";            // Default password
$database = "if0_37882240_website";

$conn = new mysqli($servername, $username, $password, $database);


// Ensure user is logged in and has a valid session
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page or handle unauthorized access
    header("Location: Login.php");
    exit;
}

// Get car ID and user ID from POST request
$car_id = $_POST['car_id'];
$user_id = $_SESSION['user_id'];

// Get car details from the database
$sql = "SELECT make, model FROM car WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $car_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// Insert into sold_car table
$sql = "INSERT INTO sold_car (car_id, user_id, make, model) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iiis", $car_id, $user_id, $row['make'], $row['model']);
$stmt->execute();

// Delete from car table
$sql = "DELETE FROM car WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $car_id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    $response = array('success' => true, 'message' => 'Car purchased successfully!');
} else {
    $response = array('success' => false, 'message' => 'Error purchasing car.');
}

echo json_encode($response);
