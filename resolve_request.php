<?php
include 'db.php'; // Include the database connection

// Get the raw POST data
$data = json_decode(file_get_contents("php://input"), true);

if ($data) {
    $requestId = $data['requestId']; // The ID of the request to resolve
    $adminResponse = $data['adminResponse']; // The admin's response

    try {
        // Update the service request with the admin response
        $stmt = $pdo->prepare("UPDATE service_requests SET status = 'Resolved', admin_response = ? WHERE id = ?");
        $stmt->execute([$adminResponse, $requestId]);

        // Return success response
        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        // Return error response
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'No data received']);
}
?>