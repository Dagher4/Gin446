<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action="upload_image.php" method="post" enctype="multipart/form-data">
    <label for="image">Choose an image:</label>
    <input type="file" name="image" id="image">
    <input type="submit" value="Upload Image" name="submit">
</form>
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


if (isset($_POST['submit'])) {
    // Get the image data and file details
    $image = $_FILES['image']['tmp_name'];
    $image_name = $_FILES['image']['name'];
    $image_type = $_FILES['image']['type'];

    // Check if the file is an image
    if (getimagesize($image)) {
        $image_data = addslashes(file_get_contents($image));
        
        // Prepare the SQL query
        $sql = "INSERT INTO images (image_data, image_name, image_type) VALUES ('$image_data', '$image_name', '$image_type')";

        if ($conn->query($sql) === TRUE) {
            echo "Image uploaded successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "File is not an image!";
    }
}

$conn->close();
?>

</body>
</html>