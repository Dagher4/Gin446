<?php
session_start();

$servername = "sql113.infinityfree.com"; // WAMP default
$username = "if0_37882240";        // Default username
$password = "8DSymqAAph6P";            // Default password
$database = "if0_37882240_website";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Get car_id and user_id from the query string
if (!isset($_GET['car_id']) || !isset($_GET['user_id'])) {
    die("Required parameters are missing.");
}

$car_id = isset($_GET['car_id']) ? (int)$_GET['car_id'] : 0;
$user_id = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;


$sql = "SELECT start_date, end_date FROM rentals WHERE car_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $car_id);
$stmt->execute();
$result = $stmt->get_result();

$rentalDates = [];
while ($row = $result->fetch_assoc()) {
    $rentalDates[] = $row;
}
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Rent Car</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 500px;
            width: 100%;
            text-align: center;
        }

        h1,
        h2 {
            color: #004aad;
            margin-bottom: 20px;
        }

        ul {
            text-align: left;
            padding: 0;
            list-style: none;
            margin-bottom: 20px;
        }

        ul li {
            background-color: #eaf4ff;
            margin: 5px 0;
            padding: 10px;
            border-radius: 5px;
            font-size: 0.95rem;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        form label {
            font-weight: bold;
            margin: 10px 0 5px;
            align-self: flex-start;
        }

        form input[type="date"] {
            padding: 10px;
            margin-bottom: 15px;
            width: 100%;
            max-width: 300px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 0.95rem;
            outline: none;
            transition: border-color 0.3s;
        }

        form input[type="date"]:focus {
            border-color: #004aad;
            box-shadow: 0 0 5px rgba(0, 74, 173, 0.3);
        }

        button {
            background-color: #004aad;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            width: 100%;
            max-width: 200px;
            transition: background-color 0.3s ease;
            text-transform: uppercase;
            font-weight: bold;
        }

        button:hover {
            background-color: #003385;
        }

        @media (max-width: 600px) {
            .container {
                padding: 15px;
            }

            h1,
            h2 {
                font-size: 1.2rem;
            }

            ul li {
                font-size: 0.85rem;
            }

            form input[type="date"] {
                font-size: 0.9rem;
            }

            button {
                font-size: 0.9rem;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Rent Car </h1>
        <h2>Unavailable Dates:</h2>
        <ul>
            <?php
            if (count($rentalDates) > 0) {
                foreach ($rentalDates as $range) {
                    echo "<li>" . $range['start_date'] . " to " . $range['end_date'] . "</li>";
                }
            } else {
                echo "<li>No rentals yet. All dates are available!</li>";
            }
            ?>
        </ul>

        <!-- Rental Form -->
        <form action="process_rental.php" method="POST">
            <input type="hidden" name="car_id" value="<?php echo $car_id; ?>">
            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">

            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date" min="<?php echo date('Y-m-d'); ?>" required>

            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date" required>

            <button type="submit">Confirm Rental</button>
        </form>
    </div>
</body>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const today = new Date().toISOString().split("T")[0];
        const startDateInput = document.getElementById("start_date");
        const endDateInput = document.getElementById("end_date");

        // Set minimum date for start_date as today
        startDateInput.setAttribute("min", today);

        // Add event listener to validate end_date > start_date
        startDateInput.addEventListener("change", () => {
            const startDate = startDateInput.value;
            endDateInput.setAttribute("min", startDate); // Update min for end_date
        });

        // Add form validation before submission
        document.querySelector("form").addEventListener("submit", (e) => {
            const startDate = startDateInput.value;
            const endDate = endDateInput.value;

            if (new Date(startDate) < new Date(today)) {
                alert("Start date must be today or later.");
                e.preventDefault();
                return;
            }

            if (new Date(endDate) <= new Date(startDate)) {
                alert("End date must be greater than start date.");
                e.preventDefault();
            }
        });
    });
</script>
<script>
    document.querySelector("form").addEventListener("submit", function(e) {
        e.preventDefault(); // Prevent default form submission

        const formData = new FormData(this);
        fetch("process_rental.php", {
                method: "POST",
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    window.location.href = "CarSiteUser.php"; // Redirect to another page
                } else {
                    alert("Error: " + data.message);
                }
            })
            .catch(error => {
                console.error("Error:", error);
                alert("An unexpected error occurred.");
            });
    });
</script>

</html>