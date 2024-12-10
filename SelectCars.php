<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect to login page
    header("Location: Login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Rufina:400,700" rel="stylesheet">

    <!-- title of site -->
    <title>AutoVibe Motors</title>

    <!-- For favicon png -->
    <link rel="shortcut icon" type="image/icon" href="assets/logo/favicon.png" />

    <!--font-awesome.min.css-->
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">

    <!--linear icon css-->
    <link rel="stylesheet" href="assets/css/linearicons.css">

    <!--flaticon.css-->
    <link rel="stylesheet" href="assets/css/flaticon.css">

    <!--animate.css-->
    <link rel="stylesheet" href="assets/css/animate.css">

    <!--owl.carousel.css-->
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/owl.theme.default.min.css">

    <!--bootstrap.min.css-->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <!-- bootsnav -->
    <link rel="stylesheet" href="assets/css/bootsnav.css">

    <!--style.css-->
    <link rel="stylesheet" href="assets/css/style.css">

    <!--responsive.css-->
    <link rel="stylesheet" href="assets/css/responsive.css">


</head>

<body>
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
    $user_id = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;
    $role = isset($_GET['role']) ? (int)$_GET['role'] : 'user';
    $whereConditions = [];

    // Year
    if (isset($_GET['year']) && $_GET['year'] !== 'default') {
        $year = (int)$_GET['year'];
        $whereConditions[] = "year = $year";
    }

    // Make
    if (isset($_GET['make']) && $_GET['make'] !== 'default') {
        $make = mysqli_real_escape_string($conn, $_GET['make']);
        $whereConditions[] = "make = '$make'";
    }

    // Model
    if (isset($_GET['model']) && $_GET['model'] !== 'default') {
        $model = mysqli_real_escape_string($conn, $_GET['model']);
        $whereConditions[] = "model = '$model'";
    }

    // Doors
    if (isset($_GET['doors']) && $_GET['doors'] !== 'default') {
        $doors = (int)$_GET['doors'];
        $whereConditions[] = "doors = $doors";
    }

    // Color
    if (isset($_GET['color']) && $_GET['color'] !== 'default') {
        $color = mysqli_real_escape_string($conn, $_GET['color']);
        $whereConditions[] = "color = '$color'";
    }

    // Price (Adjust logic based on how you plan to handle price ranges)
    if (isset($_GET['price']) && $_GET['price'] !== 'default') {
        $price = mysqli_real_escape_string($conn, $_GET['price']);
        // Handle price range if needed, e.g.:
        if (strpos($price, '-') !== false) {
            $priceRange = explode('-', $price);
            $whereConditions[] = "price BETWEEN $priceRange[0] AND $priceRange[1]";
        } else if(strpos($price, '1') !== false){
            $whereConditions[] = "price < '$price'";
        }
        else{
            $whereConditions[] = "price > '$price'";
        }

    }
    // Build the SQL query dynamically
    if (count($whereConditions) > 0) {
        $sql = "SELECT * FROM car WHERE " . implode(" AND ", $whereConditions);
    } else {
        $sql = "SELECT * FROM car";
    }
    $result = $conn->query($sql);
    $sql2 = "SELECT * FROM images";
    $result2 = $conn->query($sql2);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        while ($row) {
            $i = 0;
            echo "<div class='row'>";
            while ($row && $i < 4) {
                $i++;
                $sql2 = "SELECT * FROM images where car_id=" . $row['ID'] . "";
                $result2 = $conn->query($sql2);
                $row2 = $result2->fetch_assoc();
                $imageData = base64_encode($row2['image']);
                echo "<div class='col-lg-3 col-md-4 col-sm-6'>";
                echo "<div class='single-featured-cars'>";
                echo "<div class='featured-img-box'>";
                echo "<div class='featured-cars-img'>";
                echo "<img src='data:image/jpeg;base64, $imageData' alt='img'/>";
                echo "</div>";
                echo "<div class='featured-model-info'>";
                echo "<p>
                                            Year: " . $row['Year'] . "
                                            <span class='featured-mi-span'> " . $row['Mileage'] . " km</span> 
                                            <span class='featured-hp-span'> " . $row['Horsepower'] . "HP</span>
                                            automatic</p></div></div>";
                echo "<div class='featured-cars-txt'>";
                echo "<h2><a href='Cars.php?id=" . $row['ID'] . "&user_id=" .$user_id. "&role=" . $role . "'>" . $row['Make'] . " " . $row['Model'] . "<span> " . $row['Engine'] . "</span></a></h2>
                                    <h3>$" . $row['Price'] . " or $" . $row['Rent'] . "/day</h3>
                                   </div></div></div>";
                $row = $result->fetch_assoc();
            }
            echo "</div>";
        }
    } else {
        echo "No cars found.";
    }
    ?>
    <script src="assets/js/jquery.js"></script>

    <!--modernizr.min.js-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>

    <!--bootstrap.min.js-->
    <script src="assets/js/bootstrap.min.js"></script>

    <!-- bootsnav js -->
    <script src="assets/js/bootsnav.js"></script>

    <!--owl.carousel.js-->
    <script src="assets/js/owl.carousel.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>

    <!--Custom JS-->
    <script src="assets/js/custom.js"></script>
</body>

</html>