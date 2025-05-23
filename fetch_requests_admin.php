<?php
include 'db.php'; // Include your database connection

$status = isset($_GET['status']) ? $_GET['status'] : '';

$query = "
    SELECT sr.*, u.email AS customer_email 
    FROM service_requests sr
    JOIN users u ON sr.customer_id = u.id
";

if ($status) {
    $query .= " WHERE sr.status = ?";
}

$stmt = $pdo->prepare($query);

if ($status) {
    $stmt->execute([$status]);
} else {
    $stmt->execute();
}

$requests = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $requests[] = $row;
}

echo json_encode($requests);
?>