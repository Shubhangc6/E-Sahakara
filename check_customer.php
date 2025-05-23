<?php
include 'db.php'; // Include the database connection

// Get the raw POST data
$data = json_decode(file_get_contents("php://input"), true);

if ($data) {
    $customerId = $data['customerId'];

    try {
        // Check if the customer ID exists
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE id = ?");
        $stmt->execute([$customerId]);
        $exists = $stmt->fetchColumn() > 0;

        // Return response
        echo json_encode(['exists' => $exists]);
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'No data received']);
}
?>