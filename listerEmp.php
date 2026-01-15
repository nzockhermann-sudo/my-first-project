<!-- listerEmp.php -->

<?php
$mysqli = new mysqli("localhost", "root", "", "gest_const");

// Vérifier la connexion
if ($mysqli->connect_error) {
    die("Erreur de connexion à la base de données : " . $mysqli->connect_error);
}

$result = $mysqli->query("SELECT * FROM employes ORDER BY id DESC");

if ($result) {
    $employes = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($employes);
    $result->free(); // Libérer le jeu de résultats
} else {
    echo json_encode(["error" => "Erreur lors de la récupération des employés : " . $mysqli->error]);
}

$mysqli->close();
?>

