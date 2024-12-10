<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect to login page
    header("Location: Login.php");
    exit;
}
// Database connection
$servername = "sql113.infinityfree.com"; // WAMP default
$username = "if0_37882240";        // Default username
$password = "8DSymqAAph6P";            // Default password
$database = "if0_37882240_website";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$user_id = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;

$role = isset($_SESSION['role']) ? $_SESSION['role'] : 'guest';
if ($role === 'user') {
    $backUrl = 'CarSiteUser.php';
} else {
    $backUrl = 'CarSiteAdmin.php';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Details</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }

        header {
            background-color: #004aad;
            color: white;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h1 {
            margin: 0;
        }

        main {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        /* Card Design */
        .car-card {
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            max-width: 600px;
            width: 100%;
            text-align: center;
            padding: 20px;
        }

        .carousel {
            position: relative;
            margin-bottom: 20px;
        }

        .carousel img {
            max-width: 100%;
            border-radius: 15px;
            height: auto;
        }

        .nav-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(0, 0, 0, 0.6);
            color: white;
            border: none;
            padding: 10px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 20px;
        }

        #prev-btn {
            left: 10px;
        }

        #next-btn {
            right: 10px;
        }

        .nav-btn:hover {
            background-color: rgba(0, 0, 0, 0.8);
        }

        /* Car Info */
        .car-info {
            padding: 20px 10px;
        }

        .car-info h2 {
            margin-bottom: 10px;
            color: #004aad;
            font-size: 1.5rem;
            font-weight: bold;
        }

        .car-details {
            text-align: left;
            margin: 15px 0;
            font-size: 0.95rem;
            color: #555;
        }

        .car-details p {
            margin: 5px 0;
            line-height: 1.6;
        }

        .buttons {
            display: flex;
            justify-content: space-between;
            /* Spread buttons evenly */
            gap: 10px;
            /* Add spacing between buttons */
            margin-top: 20px;
        }

        .action-btn {
            flex: 1;
            /* Make all buttons equal in width */
            text-align: center;
            padding: 10px 15px;
            background-color: #004aad;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .action-btn:hover {
            background-color: #003385;
        }
    </style>
</head>

<body>
    <header>
        <h1>Car Details</h1>
    </header>
    <main>
        <div class="car-card">
            <div class="carousel">
                <button id="prev-btn" class="nav-btn">❮</button>
                <img id="carousel-image" src="" alt="Car Image">
                <button id="next-btn" class="nav-btn">❯</button>
            </div>
            <div class="car-info">
                <?php
                $sql = "SELECT * FROM car WHERE id=$id";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {

                        echo "<h2>" . $row['Make'] . " " . $row['Model'] . "</h2>
                <div class='car-details'>";
                        echo  "<p><strong>Year:</strong> <span>" . $row['Year'] . "</span></p>";
                        echo  "<p><strong>Mileage:</strong> <span>" . $row['Mileage'] . "</span></p>";
                        echo  "<p><strong>Horsepower:</strong> <span>" . $row['Horsepower'] . "</span> HP</p>";
                        echo  "<p><strong>Engine:</strong> <span>" . $row['Engine'] . "</span></p>";
                        echo  "<p><strong>Fuel Consumption:</strong> <span>" . $row['FuelConsumption'] . "</span></p>";
                        echo  "<p><strong>Color:</strong> <span>" . $row['Color'] . "</span></p>";
                        echo  "<p><strong>Price:</strong> <span>$" . $row['Price'] . "</span></p>";
                        echo  "<p><strong>Rent:</strong> <span>$" . $row['Rent'] . "/day</span></p>";
                        echo  "<p><strong>Doors:</strong> <span>" . $row['Doors'] . "</span></p>";
                    }
                }
                ?>
            </div>
        </div>
        <div class="buttons">
            <button id="back-button" class="action-btn">Back</button>
            <?php if ($role == 'user') {
                echo "<button id='buy-button' class='action-btn'>Buy</button>
        <button id='rent-button' class='action-btn' data-car-id=$id  
        data-user-id=$user_id>Rent</button>
        <button id='favorite-button' class='action-btn'>Favorites</button>";
            } else {
                echo "<button id='delete-button' class='action-btn'>Delete</button>";
            }
            ?>

        </div>
        </div>
    </main>
    <script>
        const carouselImage = document.getElementById("carousel-image");
        const prevButton = document.getElementById("prev-btn");
        const nextButton = document.getElementById("next-btn");
        const backButton = document.getElementById("back-button");
        const favoriteButton = document.getElementById("favorite-button");
        const buyButton = document.getElementById("buy-button");
        const rentButton = document.getElementById("rent-button");
        const deleteButton = document.getElementById("delete-button");
        <?php
        $sql = "SELECT image FROM images where car_id=$id";
        $result = $conn->query($sql);

        $imageArray = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $imageData = base64_encode($row['image']);
                $imageArray[] = "data:image/jpeg;base64," . $imageData;
            }
        } else {
            echo "<p>No images found in the database.</p>";
        }

        $conn->close();
        ?>
        const images = <?php echo json_encode($imageArray); ?>;



        let currentImageIndex = 0;

        function updateCarDetails() {
            carouselImage.src = images[currentImageIndex];
        }

        if (buyButton) {
            buyButton.addEventListener("click", () => {
                if (confirm("Are you sure you want to buy this car?")) {
                    fetch("delete_car.php", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                            },
                            body: JSON.stringify({
                                car_id: <?php echo $id; ?>
                            }),
                        })
                        .then((response) => response.json())
                        .then((data) => {
                            if (data.success) {
                                alert(data.message);
                                window.location.href = backUrl;
                            } else {
                                alert("Error: " + data.message);
                            }
                        })
                        .catch((error) => {
                            console.error("Error:", error);
                            alert("An unexpected error occurred.");
                        });
                }
            });
        }
        if (rentButton) {
            rentButton.addEventListener("click", function() {
                const carId = this.getAttribute("data-car-id"); // Get car_id from button
                const userId = this.getAttribute("data-user-id"); // Get user_id from button

                if (!carId || !userId) {
                    alert("Car ID or User ID is missing!");
                    return;
                }

                // Redirect to the rent page with car_id and user_id as query parameters
                window.location.href = `rent_car.php?car_id=${carId}&user_id=${userId}`;
            });
        }






        prevButton.addEventListener("click", () => {
            currentImageIndex =
                (currentImageIndex - 1 + images.length) % images.length;
            carouselImage.src = images[currentImageIndex];
        });

        nextButton.addEventListener("click", () => {
            currentImageIndex = (currentImageIndex + 1) % images.length;
            carouselImage.src = images[currentImageIndex];
        });

        const backUrl = "<?php echo $backUrl; ?>";

        backButton.addEventListener("click", () => {
            window.location.href = backUrl;
        });
        if (favoriteButton) {
            favoriteButton.addEventListener("click", () => {
                fetch("add_to_favorites.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                        },
                        body: JSON.stringify({
                            car_id: <?php echo $id; ?>
                        }),
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.message);
                        } else {
                            alert("Error: " + data.message);
                        }
                    })
                    .catch(error => {
                        console.error("Error:", error);
                        alert("An unexpected error occurred.");
                    });
            });

        }
        if (deleteButton) {
            deleteButton.addEventListener("click", () => {
                if (confirm("Are you sure you want to delete this car?")) {
                    fetch("delete_car.php", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                            },
                            body: JSON.stringify({
                                car_id: <?php echo $id; ?>
                            }),
                        })
                        .then((response) => response.json())
                        .then((data) => {
                            if (data.success) {
                                alert(data.message);
                                window.location.href = backUrl;
                            } else {
                                alert("Error: " + data.message);
                            }
                        })
                        .catch((error) => {
                            console.error("Error:", error);
                            alert("An unexpected error occurred.");
                        });
                }
            });
        }


        updateCarDetails();
    </script>
</body>

</html>