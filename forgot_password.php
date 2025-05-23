<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Here you would typically send a reset link to the user's email
    echo "Password reset link has been sent to your email.";
    header("Location: login.html");
}
?>