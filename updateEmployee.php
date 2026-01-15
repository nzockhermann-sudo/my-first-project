<?php
header('Content-Type: application/json');
require_once 'db_connect.php';

$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['id'])) {
    echo json_encode(['success' => false, 'message' => 'Données invalides']);
    exit;
}

$stmt = $mysqli->prepare("UPDATE employes SET 
    nom = ?, 
    poste = ?, 
    salaire = ?, 
    email = ?, 
    date_embauche = ? 
    WHERE id = ?");

$stmt->bind_param(
    "ssdssi",
    $data['nom'],
    $data['poste'],
    $data['salaire'],
    $data['email'],
    $data['date_embauche'],
    $data['id']
);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => $stmt->error]);
}

$stmt->close();
$mysqli->close();
?>