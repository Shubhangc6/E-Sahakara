<?php
$host = 'localhost';
$db = 'e_sahakara'; // Replace with your database name
$user = 'root'; // Replace with your database username
$pass = '9380'; // Replace with your database password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit(); // Exit the script if connection fails
}
?>