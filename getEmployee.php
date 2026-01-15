<?php
header('Content-Type: application/json');
require_once 'db_connect.php';

$employeeId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$employeeId) {
    echo json_encode(['success' => false, 'message' => 'ID invalide']);
    exit;
}

$stmt = $mysqli->prepare("SELECT * FROM employes WHERE id = ?");
$stmt->bind_param("i", $employeeId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Employé non trouvé']);
    exit;
}

$employee = $result->fetch_assoc();
echo json_encode(['success' => true, 'employee' => $employee]);

$stmt->close();
$mysqli->close();
?>