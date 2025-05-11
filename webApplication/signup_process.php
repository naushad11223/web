<?php
$host = "localhost";
$dbname = "user_registration";
$username = "root"; // default XAMPP username
$password = "";     // default XAMPP password is empty

$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Sanitize and get form values
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$phone = $_POST['phoneNumber'];
$email = $_POST['email'];
$password_plain = $_POST['password'];
$user_type = $_POST['user_type'];

// Hash the password
$password_hashed = password_hash($password_plain, PASSWORD_DEFAULT);

// SQL Insert
$sql = "INSERT INTO users (first_name, last_name, phone, email, password, user_type)
        VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssss", $first_name, $last_name, $phone, $email, $password_hashed, $user_type);

if ($stmt->execute()) {
    echo "Registration successful!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
