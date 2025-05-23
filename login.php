<?php
session_start();
include 'db.php'; // Include your database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id']; // Store user ID in session
        $_SESSION['user_type'] = $user['user_type']; // Store user type in session

        // Redirect based on user type
        if ($user['user_type'] === 'customer') {
            header("Location: customer.php");
        } elseif ($user['user_type'] === 'admin') {
            header("Location: admin.html");
        } else {
            echo "Unknown user type.";
        }
        exit();
    } else {
        echo "Invalid email or password.";
    }
}
?>