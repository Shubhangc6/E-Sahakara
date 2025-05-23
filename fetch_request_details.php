<?php
include 'db.php'; // Include your database connection

$requestId = $_GET['id'];

$query = "SELECT * FROM service_requests WHERE id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$requestId]);
$request = $stmt->fetch(PDO::FETCH_ASSOC);

if ($request) {
    echo json_encode($request);
} else {
    echo json_encode(['error' => 'Request not found']);
}
?>
<?php
include 'db.php';

$id = $_GET['id'];
$query = "SELECT * FROM requests WHERE id = $id";
$result = mysqli_query($conn, $query);
if ($result && mysqli_num_rows($result) > 0) {
    echo json_encode(mysqli_fetch_assoc($result));
} else {
    echo json_encode(["error" => "Request not found"]);
}
?>
