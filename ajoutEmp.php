<!-- ajoutEmp.php -->

<?php
// Inclure le fichier de connexion à la base de données
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier que les champs nécessaires sont bien remplis
    if (!empty($_POST['nom']) && !empty($_POST['poste']) && isset($_POST['salaire'])) {
        // Préparer la requête
        $stmt = $mysqli->prepare("INSERT INTO employes (nom, poste, salaire) VALUES (?, ?, ?)");

        // Vérifier si la préparation a réussi
        if ($stmt) {
            // Lier les paramètres
            $stmt->bind_param("ssd", $_POST['nom'], $_POST['poste'], $_POST['salaire']);

            // Exécuter la requête
            if ($stmt->execute()) {
                echo "<p style='color: green;'>Employé ajouté avec succès. <a href='employes.php'>Retour à la liste</a></p>";
            } else {
                echo "<p style='color: red;'>Erreur lors de l'ajout de l'employé : " . $stmt->error . "</p>";
            }

            // Fermer la requête
            $stmt->close();
        } else {
            echo "<p style='color: red;'>Erreur de préparation de la requête : " . $mysqli->error . "</p>";
        }
    } else {
        echo "<p style='color: red;'>Tous les champs doivent être remplis.</p>";
    }
} else {
    echo "<p style='color: red;'>Méthode de requête non autorisée.</p>";
}

// Fermer la connexion
$mysqli->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Document</title>
  <style>
  /* style/ajoutEmp.css */

  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #e9ecef;
    display: flex;
    justify-content: center;
    flex-direction: column;
    align-items: center;
    min-height: 100vh;
    margin: 0;
  }

  p {
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 4px;
    padding: 15px;
    margin-bottom: 20px;
    text-align: center;
    font-size: 1rem;
  }

  p.success {
    color: #155724;
    background-color: #d4edda;
    border-color: #c3e6cb;
  }

  p.error {
    color: #721c24;
    background-color: #f8d7da;
    border-color: #f5c6cb;
  }

  a {
    background-color: #007bff;
    text-decoration: none;
    font-weight: bold;
    color: #fff;
    padding: 5px 10px;
    margin-left: 10px;
    border-radius: 15px;
    transition: 0.3s;
    border: 1px solid #007bff;
  }

  a:hover {
    background-color: #fff;
    color: #007bff;
    border: 1px solid #007bff;
  }
  </style>
</head>

<body>

</body>

</html>