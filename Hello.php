<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>My first PHP page</h1>
    <?php

$servername = "localhost"; // WAMP default
    $username = "dagher";        // Default username
    $password = "AAdd1234!@#$";            // Default password
    $database = "website";

    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        echo "Hello, World!";
    }

    // Retrieve the image from the database
$sql = "SELECT image_data, image_type FROM images WHERE id = 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Get the image data
    $row = $result->fetch_assoc();
    $image_data = $row['image_data'];
    $image_type = $row['image_type'];
    
    // Output the image
    header("Content-Type: $image_type");
    echo $image_data;
} else {
    echo "Image not found!";
}

$conn->close();
?>

</body>
</html>