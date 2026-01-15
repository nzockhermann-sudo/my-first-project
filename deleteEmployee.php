<?php
header('Content-Type: application/json');
require_once 'db_connect.php';

$employeeId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$employeeId) {
    echo json_encode(['success' => false, 'message' => 'ID invalide']);
    exit;
}

$stmt = $mysqli->prepare("DELETE FROM employes WHERE id = ?");
$stmt->bind_param("i", $employeeId);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => $stmt->error]);
}

$stmt->close();
$mysqli->close();
?>