<?php
session_start();
include 'db.php'; // Include your database connection

header('Content-Type: application/json'); // Set the content type to JSON

$data = json_decode(file_get_contents("php://input"), true);
$requestId = $data['requestId'];
$response = $data['response'];

// Check if requestId and response are set
if (!isset($requestId) || !isset($response)) {
    echo json_encode(['success' => false, 'message' => 'Invalid input.']);
    exit;
}

// Update the service request with the admin response
$query = "UPDATE service_requests SET admin_response = ?, customer_response = 'PENDING' WHERE id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$response, $requestId]);

if ($stmt->rowCount() > 0) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update response.']);
}
?>
