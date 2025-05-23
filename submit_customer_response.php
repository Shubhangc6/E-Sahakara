<?php
session_start();
include 'db.php'; // Include your database connection

$data = json_decode(file_get_contents("php://input"), true);
$requestId = $data['requestId'];
$response = $data['response'];

// Determine the status based on the response
$status = ($response === '👍') ? 'RESOLVED' : 'PENDING';

$query = "UPDATE service_requests SET customer_response = ?, status = ? WHERE id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$response, $status, $requestId]);

if ($stmt->rowCount() > 0) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update response.']);
}
?>