<?php
include 'db.php'; // Include your database connection

// Fetch common questions and answers from the database
$query = "SELECT question, answer FROM common_questions";
$stmt = $pdo->prepare($query);
$stmt->execute();

$commonQuestions = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $commonQuestions[$row['question']] = $row['answer'];
}

// Return the common questions as a JSON response
header('Content-Type: application/json');
echo json_encode($commonQuestions);
?>
