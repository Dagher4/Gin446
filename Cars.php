<!DOCTYPE html>
<html>

<head>
    <title>Car Database</title>
</head>

<body>
    <h1>Car List</h1>

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
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image'])) {
        $image = $_FILES['image']['tmp_name'];
        $imageData = file_get_contents($image);
        $imageType = $_FILES['image']['type'];
    
        $stmt = $conn->prepare("INSERT INTO images (image_data, image_type) VALUES (?, ?)");
        $stmt->bind_param('bs', $imageData, $imageType); // 'b' for blob, 's' for string
        $stmt->execute();
    
        echo "Image uploaded successfully!";
        $stmt->close();
    }
    
    $conn->close();

    


    ?>

<form action="upload.php" method="POST" enctype="multipart/form-data">
    <input type="file" name="image" />
    <button type="submit">Upload</button>
</form>

</body>

</html>