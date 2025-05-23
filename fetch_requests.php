<?php
session_start();
include 'db.php'; // Include your database connection

$customerId = $_GET['customerId'];

$query = "SELECT * FROM service_requests WHERE customer_id = ?";
$stmt = $pdo->prepare($query);
$stmt->bindParam(1, $customerId);
$stmt->execute();
$requests = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($requests);
?>