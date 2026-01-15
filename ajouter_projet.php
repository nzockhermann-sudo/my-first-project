<?php
// Inclure le fichier de connexion à la base de données
include 'db_connect.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier que tous les champs sont remplis
    if (!empty($_POST['nom_projet']) && !empty($_POST['client']) && isset($_POST['budget']) && !empty($_POST['date_debut']) && !empty($_POST['date_fin']) && !empty($_POST['statut'])) {
        // Préparer la requête d'insertion
        $stmt = $mysqli->prepare("INSERT INTO projets (nom_projet, client, budget, date_debut, date_fin, statut) VALUES (?, ?, ?, ?, ?, ?)");

        if ($stmt) {
            // Lier les paramètres
            $stmt->bind_param("ssdsss", $_POST['nom_projet'], $_POST['client'], $_POST['budget'], $_POST['date_debut'], $_POST['date_fin'], $_POST['statut']);

            // Exécuter la requête
            if ($stmt->execute()) {
                $message = "<p class='success'>Projet ajouté avec succès.</p>";
            } else {
                $message = "<p class='error'>Erreur lors de l'ajout du projet : " . $stmt->error . "</p>";
            }

            // Fermer la requête préparée
            $stmt->close();
        } else {
            $message = "<p class='error'>Erreur de préparation de la requête : " . $mysqli->error . "</p>";
        }
    } else {
        $message = "<p class='error'>Tous les champs doivent être remplis.</p>";
    }
}

// Fermer la connexion à la base de données
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Ajouter un Projet</title>
  <link rel="stylesheet" href="style/ajouter_projet.css" />
</head>

<body>
  <div class="container">
    <header>
      <h1>Ajouter un Nouveau Projet</h1>
      <a href="projets.php" class="back-button">Retour à la Liste des Projets</a>
    </header>

    <?php echo $message; ?>

    <form action="ajouter_projet.php" method="post">
      <div class="form-group">
        <label for="nom_projet">Nom du Projet :</label>
        <input type="text" id="nom_projet" name="nom_projet" required />
      </div>

      <div class="form-group">
        <label for="client">Client :</label>
        <input type="text" id="client" name="client" required />
      </div>

      <div class="form-group">
        <label for="budget">Budget (FCFA) :</label>
        <input type="number" id="budget" name="budget" step="0.01" required />
      </div>

      <div class="form-group">
        <label for="date_debut">Date de Début :</label>
        <input type="date" id="date_debut" name="date_debut" required />
      </div>

      <div class="form-group">
        <label for="date_fin">Date de Fin :</label>
        <input type="date" id="date_fin" name="date_fin" required />
      </div>

      <div class="form-group">
        <label for="statut">Statut :</label>
        <select id="statut" name="statut" required>
          <option value="" disabled selected>Sélectionner un statut</option>
          <option value="En cours">En cours</option>
          <option value="Terminé">Terminé</option>


        </select>
      </div>

      <div class="form-actions">
        <button type="submit" class="submit-button">Ajouter le Projet</button>
        <button type="reset" class="reset-button">Réinitialiser</button>
      </div>
    </form>
  </div>
</body>

</html>