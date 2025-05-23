<?php
session_start();
include 'db.php'; // Include your database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $user_type = $_POST['user_type'];

    try {
        // Check if the email already exists
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $exists = $stmt->fetchColumn();

        if ($exists) {
            // Email already exists, update the existing record
            $stmt = $pdo->prepare("UPDATE users SET password = ?, user_type = ? WHERE email = ?");
            if ($stmt->execute([$password, $user_type, $email])) {
                echo "User  updated successfully!";
            } else {
                echo "Error updating user: " . $stmt->errorInfo()[2];
            }
        } else {
            // Email does not exist, insert a new record
            $stmt = $pdo->prepare("INSERT INTO users (email, password, user_type) VALUES (?, ?, ?)");
            if ($stmt->execute([$email, $password, $user_type])) {
                echo "Signup successful!";
                header("Location: login.html"); // Redirect to login page
                exit();
            } else {
                echo "Error inserting data: " . $stmt->errorInfo()[2];
            }
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"/>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="bg-white rounded-lg shadow-lg flex overflow-hidden max-w-4xl w-full">
        <div class="w-1/2 p-8">
            <div class="flex flex-col items-center">
                <img alt="E-Sahakara Logo" class="mb-4" src="logo.png" width="100" height="100"/>
                <h1 class="text-orange-500 text-2xl font-bold">JOIN OUR</h1>
                <h2 class="text-black text-3xl font-bold">SOCIETY</h2>
                <p class="text-orange-500 text-sm">Co-operative societies BUILD A BETTER WORLD</p>
            </div>
            <p class="mt-6 text-gray-700">Create your account to get started.</p>
            <form class="mt-4" action="" method="POST">
                <div class="mb-4">
                    <label class="block text-gray-700">User  Type</label>
                    <select name="user_type" class="w-full px-3 py-2 border border-gray-300 rounded" required>
                        <option value="customer">Customer</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Email Address</label>
                    <input id="signup-email" name="email" class="w-full px-3 py-2 border border-gray-300 rounded" type="email" required />
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Password</label>
                    <input id="signup-password" name="password" class="w-full px-3 py-2 border border-gray-300 rounded" type="password" required />
                </div>
                <div class="flex space-x-4">
                    <button class="bg-orange-500 text-white px-4 py-2 rounded" type="submit">
                        Sign Up
                    </button>
                    <button class="border border-orange-500 text-orange-500 px-4 py-2 rounded" onclick="window.location.href='login.html'">
                        Login
                    </button>
                </div>
            </form>
        </div>
        <div class="w-1/2 bg-orange-500 flex items-center justify-center relative">
            <img alt="Building with columns" class="absolute inset-0 w-full h-full object-cover opacity-50" src="building.jpg" width="400" height="400"/>
            <div class="relative z-10 text-center">
                <img alt="E-Sahakara Logo" class="mb-4 mx-auto" src="logo.png" width="100" height="100"/>
                <h1 class="text-black text-2xl font-bold">ESAHKARA</h1>
            </div>
        </div>
    </div>
</body>
</html>