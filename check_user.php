<?php
require_once('models/Connection.php');

$conn = new Connection();
$connection = $conn->conn;

$email = 'nguyenduclong@gmail.com';
$password = md5('1234');

echo "Checking user: $email\n";
echo "Password hash: $password\n\n";

$query = "SELECT * FROM customers WHERE email = '$email'";
$result = $connection->query($query);

if ($result && $result->num_rows > 0) {
    $user = $result->fetch_assoc();
    echo "User found:\n";
    echo "Customer Number: " . $user['customerNumber'] . "\n";
    echo "Name: " . $user['customerName'] . "\n";
    echo "Email: " . $user['email'] . "\n";
    echo "Stored Password: " . $user['password'] . "\n";
    echo "Match: " . ($user['password'] === $password ? "YES" : "NO") . "\n";
} else {
    echo "User not found in database\n";
}

// Check all users
echo "\n--- All users in database ---\n";
$query = "SELECT customerNumber, customerName, email, password FROM customers LIMIT 10";
$result = $connection->query($query);
if ($result) {
    while ($row = $result->fetch_assoc()) {
        echo "ID: {$row['customerNumber']}, Name: {$row['customerName']}, Email: {$row['email']}, Pass: {$row['password']}\n";
    }
}
?>
