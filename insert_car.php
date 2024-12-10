<?php
session_start();
header("Content-Type: application/json");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo json_encode(["success" => false, "message" => "You are not authorized to insert a car."]);
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

$make = $_POST['make'];
$model = $_POST['model'];
$year = $_POST['year'];
$mileage = $_POST['mileage'];
$horsepower = $_POST['horsepower'];
$engine = $_POST['engine'];
$fuel_consumption = $_POST['fuel_consumption'];
$color = $_POST['color'];
$price = $_POST['price'];
$rent = $_POST['rent'];
$doors = $_POST['doors'];

$sql = "INSERT INTO car (Make, Model, Year, Mileage, Horsepower, Engine, FuelConsumption, Color, Price, Rent, Doors) 
        VALUES ('$make', '$model', '$year', '$mileage', '$horsepower', '$engine', '$fuel_consumption', '$color', '$price', '$rent', '$doors')";

if ($conn->query($sql) === TRUE) {
    $car_id = $conn->insert_id;

    // Handle image uploads
    if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
        $imageCount = count($_FILES['images']['name']);
        for ($i = 0; $i < $imageCount; $i++) {
            $imageTmpName = $_FILES['images']['tmp_name'][$i];
            $imageData = addslashes(file_get_contents($imageTmpName));

            $sql2 = "INSERT INTO images (car_id, image) VALUES ('$car_id', '$imageData')";
            if (!$conn->query($sql2)) {
                echo json_encode(["success" => false, "message" => "Error inserting image: " . $conn->error]);
                exit;
            }
        }
    }

    echo json_encode(["success" => true, "message" => "Car and images inserted successfully."]);
} else {
    echo json_encode(["success" => false, "message" => "Error: " . $conn->error]);
}

$conn->close();
