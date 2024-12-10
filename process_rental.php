<?php
$servername = "sql113.infinityfree.com"; // WAMP default
$username = "if0_37882240";        // Default username
$password = "8DSymqAAph6P";            // Default password
$database = "if0_37882240_website";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
if (!isset($_POST['car_id']) || !isset($_POST['user_id']) || !isset($_POST['start_date']) || !isset($_POST['end_date'])) {
    die("Required parameters are missing.");
}

$car_id = (int)$_POST['car_id'];
$user_id = (int)$_POST['user_id'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];

// Validate the dates
if (strtotime($start_date) > strtotime($end_date)) {
    die("Error: Start date cannot be later than the end date.");
}

$sql = "SELECT * FROM rentals WHERE car_id = ? AND (
            (start_date BETWEEN ? AND ?) OR
            (end_date BETWEEN ? AND ?) OR
            (? BETWEEN start_date AND end_date) OR
            (? BETWEEN start_date AND end_date)
        )";
$stmt = $conn->prepare($sql);
$stmt->bind_param("issssss", $car_id, $start_date, $end_date, $start_date, $end_date, $start_date, $end_date);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    if ($result->num_rows > 0) {
        // Send a JSON response with error message
        echo json_encode(["success" => false, "message" => "The car is already rented for the selected period."]);
        exit;
    }
}

// Insert the rental record
$sql2 = "INSERT INTO rentals (car_id, user_id, start_date, end_date) VALUES (?, ?, ?, ?)";
$stmt2 = $conn->prepare($sql2);
$stmt2->bind_param("iiss", $car_id, $user_id, $start_date, $end_date);

if ($stmt2->execute()) {

    echo json_encode(["success" => true, "message" => "Rental confirmed!"]);
} else {
    echo "Error: " . $stmt2->error;
}

$stmt->close();
$stmt2->close();
$conn->close();