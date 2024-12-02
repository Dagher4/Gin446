<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Image to Imgbb</title>
</head>
<body>
    <h2>Upload Image</h2>
    <form action="upload_to_imgbb.php" method="post" enctype="multipart/form-data">
        <label for="image">Choose an image:</label>
        <input type="file" name="image" id="image" required>
        <input type="submit" value="Upload Image" name="submit">
    </form>

    <?php
if (isset($_POST['submit'])) {
    // Get the uploaded image file
    $image = $_FILES['image'];
    $apiKey = 'YOUR_IMGBB_API_KEY';  // Replace with your Imgbb API key

    // Check for upload errors
    if ($image['error'] !== UPLOAD_ERR_OK) {
        die('Error: File upload error. Code: ' . $image['error']);
    }

    // Read the image content and encode it in base64
    $imageData = base64_encode(file_get_contents($image['tmp_name']));

    // Imgbb API URL for uploading the image
    $url = 'https://api.imgbb.com/1/upload?key=' . $apiKey;

    // Prepare the post data
    $postData = [
        'image' => $imageData
    ];

    // Use cURL to send the request to Imgbb API
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: multipart/form-data']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute the request and get the response
    $response = curl_exec($ch);

    // Check for cURL errors
    if (curl_errno($ch)) {
        echo 'Curl error: ' . curl_error($ch);
        exit;
    }

    curl_close($ch);

    // Check the response
    echo '<pre>';
    print_r($response);  // This will print the raw API response
    echo '</pre>';

    // Decode the response
    $result = json_decode($response, true);

    if ($result && isset($result['data']['url'])) {
        $imageUrl = $result['data']['url'];
        echo "Image uploaded successfully! View it <a href='$imageUrl'>here</a>";
    } else {
        echo "Error: Unable to upload image. API response: " . json_encode($result);
    }
}
?>


</body>
</html>
