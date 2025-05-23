<?php
include 'db.php'; // Include your database connection

$queryTotal = "SELECT COUNT(*) as total FROM service_requests";
$queryPending = "SELECT COUNT(*) as pending FROM service_requests WHERE status = 'PENDING'";
$queryResolved = "SELECT COUNT(*) as resolved FROM service_requests WHERE status = 'RESOLVED'";

$total = $pdo->query($queryTotal)->fetchColumn();
$pending = $pdo->query($queryPending)->fetchColumn();
$resolved = $pdo->query($queryResolved)->fetchColumn();

echo json_encode(['total' => $total, 'pending' => $pending, 'resolved' => $resolved]);
?>