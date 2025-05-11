<?php
session_start();

// Database connection
$host = "localhost";
$dbname = "user_registration";
$username = "root";
$password = "";

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get login form inputs
$email = $_POST['email'];
$password_input = $_POST['password'];

// Check if user exists
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user && password_verify($password_input, $user['password'])) {
    // Login successful
    $_SESSION['email'] = $user['email'];
    $_SESSION['user_type'] = $user['user_type'];

    // Redirect based on user type
    switch (strtolower($user['user_type'])) {
        case 'customer':
            header("Location: Customer.html");
            break;
        case 'retailer':
            header("Location: Retailer.html");
            break;
        case 'supplier':
            header("Location: Supplier.html");
            break;
        default:
            echo "Unknown user type.";
    }
    exit;
} else {
    // Login failed
    echo "<script>
        alert('Invalid email or password.');
        window.location.href = 'Login.html';
    </script>";
}
?>
