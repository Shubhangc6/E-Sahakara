<?php
session_start();
include 'db.php'; // Include your database connection

$data = json_decode(file_get_contents("php://input"), true);
$customerId = $data['customerId'];
$issueType = $data['issueType'];
$message = $data['message'];

// Check if the data is valid
if (empty($customerId) || empty($issueType) || empty($message)) {
    echo json_encode(['success' => false, 'message' => 'Invalid data']);
    exit;
}

// Fetch the customer's email
$queryEmail = "SELECT email FROM users WHERE id = ?";
$stmtEmail = $pdo->prepare($queryEmail);
$stmtEmail->execute([$customerId]);
$customer = $stmtEmail->fetch(PDO::FETCH_ASSOC);

if (!$customer) {
    echo json_encode(['success' => false, 'message' => 'Customer not found']);
    exit;
}

$customerEmail = $customer['email'];

// Prepare the query to insert the service request
$query = "INSERT INTO service_requests (customer_id, customer_email, issue_type, message) VALUES (?, ?, ?, ?)";
$stmt = $pdo->prepare($query);

try {
    $stmt->execute([$customerId, $customerEmail, $issueType, $message]);
    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error inserting data: ' . $e->getMessage()]);
    exit;
}
?>