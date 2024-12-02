<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
</head>
<body>
<form method="post" action="auth.php">
    <input type="hidden" name="action" value="signup">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <select name="role">
        <option value="user">User</option>
        <option value="admin">Admin</option>
    </select>
    <button type="submit">Sign Up</button>
</form>
<form method="post" action="auth.php">
    <input type="hidden" name="action" value="login">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
</form>



    <?php
// Database connection
$host = 'localhost'; // Database host
$dbname = 'website'; // Database name
$username = 'dagher'; // Database username
$password = 'AAdd1234!@#$'; // Database password

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Helper function to hash passwords
function hashPassword($password) {
    return password_hash($password, PASSWORD_BCRYPT);
}

// Helper function to verify passwords
function verifyPassword($password, $hashedPassword) {
    return password_verify($password, $hashedPassword);
}

// User Signup
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'signup') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = isset($_POST['role']) && $_POST['role'] === 'admin' ? 'admin' : 'user';

    // Check if the email already exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    if ($stmt->rowCount() > 0) {
        echo "Email is already registered.";
    } else {
        // Insert new user
        $hashedPassword = hashPassword($password);
        $stmt = $conn->prepare("INSERT INTO users (email, password, role) VALUES (:email, :password, :role)");
        if ($stmt->execute(['email' => $email, 'password' => $hashedPassword, 'role' => $role])) {
            echo "Signup successful!";
        } else {
            echo "Error during signup.";
        }
    }
}

// User Login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'login') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Fetch user details
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && verifyPassword($password, $user['password'])) {
        // Check user role
        if ($user['role'] === 'admin') {
            echo "Welcome, Admin!";
        } else {
            echo "Welcome, User!";
        }
    } else {
        echo "Invalid email or password.";
    }
}
?>

</body>
</html>


