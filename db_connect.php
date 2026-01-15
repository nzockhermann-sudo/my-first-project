<?php
$mysqli = new mysqli("localhost", "root", "", "gest_const");

// Vérifier la connexion
if ($mysqli->connect_error) {
    die("Erreur de connexion à la base de données : " . $mysqli->connect_error);
}
?>