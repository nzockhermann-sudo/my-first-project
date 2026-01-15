<?php
// Inclure le fichier de connexion à la base de données
include 'db_connect.php';

$message = "";

// Vérifier si l'ID du projet est passé dans l'URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $projet_id = $_GET['id'];

    // Récupérer les informations du projet à modifier
    $stmt_select = $mysqli->prepare("SELECT nom_projet, client, budget, date_debut, date_fin, statut FROM projets WHERE id = ?");
    $stmt_select->bind_param("i", $projet_id);
    $stmt_select->execute();
    $result_select = $stmt_select->get_result();

    if ($result_select->num_rows === 1) {
        $projet = $result_select->fetch_assoc();
        $nom_projet = $projet['nom_projet'];
        $client = $projet['client'];
        $budget = $projet['budget'];
        $date_debut = $projet['date_debut'];
        $date_fin = $projet['date_fin'];
        $statut = $projet['statut'];
    } else {
        $message = "<p class='error'>Projet non trouvé.</p>";
        $projet = null; // Indiquer que le projet n'a pas été trouvé
    }

    $stmt_select->close();

    // Traitement du formulaire de modification
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $projet !== null) {
        // Vérifier que tous les champs sont remplis
        if (!empty($_POST['nom_projet']) && !empty($_POST['client']) && isset($_POST['budget']) && !empty($_POST['date_debut']) && !empty($_POST['date_fin']) && !empty($_POST['statut'])) {
            // Préparer la requête de mise à jour
            $stmt_update = $mysqli->prepare("UPDATE projets SET nom_projet = ?, client = ?, budget = ?, date_debut = ?, date_fin = ?, statut = ? WHERE id = ?");

            if ($stmt_update) {
                // Lier les paramètres
                $stmt_update->bind_param("ssdsssi", $_POST['nom_projet'], $_POST['client'], $_POST['budget'], $_POST['date_debut'], $_POST['date_fin'], $_POST['statut'], $projet_id);

                // Exécuter la requête
                if ($stmt_update->execute()) {
                    $message = "<p class='success'>Projet mis à jour avec succès. <a href='projets.php'>Retour à la liste des projets</a></p>";
                    // Recharger les informations du projet après la mise à jour
                    $stmt_select_refresh = $mysqli->prepare("SELECT nom_projet, client, budget, date_debut, date_fin, statut FROM projets WHERE id = ?");
                    $stmt_select_refresh->bind_param("i", $projet_id);
                    $stmt_select_refresh->execute();
                    $result_select_refresh = $stmt_select_refresh->get_result();
                    $projet = $result_select_refresh->fetch_assoc();
                    $nom_projet = $projet['nom_projet'];
                    $client = $projet['client'];
                    $budget = $projet['budget'];
                    $date_debut = $projet['date_debut'];
                    $date_fin = $projet['date_fin'];
                    $statut = $projet['statut'];
                    $stmt_select_refresh->close();
                } else {
                    $message = "<p class='error'>Erreur lors de la mise à jour du projet : " . $stmt_update->error . "</p>";
                }

                // Fermer la requête de mise à jour
                $stmt_update->close();
            } else {
                $message = "<p class='error'>Erreur de préparation de la requête de mise à jour : " . $mysqli->error . "</p>";
            }
        } else {
            $message = "<p class='error'>Tous les champs doivent être remplis.</p>";
        }
    }

} else {
    $message = "<p class='error'>ID de projet invalide.</p>";
}

// Fermer la connexion à la base de données (sera fermé à la fin du script)
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Modifier le Projet</title>
  <link rel="stylesheet" href="style/modifier_projet.css" />
</head>

<body>
  <div class="container">
    <header>
      <h1>Modifier le Projet</h1>
      <a href="projets.php" class="back-button">Retour à la Liste des Projets</a>
    </header>

    <?php echo $message; ?>

    <?php if ($projet !== null) : ?>
    <form action="modifier_projet.php?id=<?php echo htmlspecialchars($projet_id); ?>" method="post">
      <div class="form-group">
        <label for="nom_projet">Nom du Projet :</label>
        <input type="text" id="nom_projet" name="nom_projet" value="<?php echo htmlspecialchars($nom_projet); ?>"
          required />
      </div>

      <div class="form-group">
        <label for="client">Client :</label>
        <input type="text" id="client" name="client" value="<?php echo htmlspecialchars($client); ?>" required />
      </div>

      <div class="form-group">
        <label for="budget">Budget (FCFA) :</label>
        <input type="number" id="budget" name="budget" step="0.01" value="<?php echo htmlspecialchars($budget); ?>"
          required />
      </div>

      <div class="form-group">
        <label for="date_debut">Date de Début :</label>
        <input type="date" id="date_debut" name="date_debut" value="<?php echo htmlspecialchars($date_debut); ?>"
          required />
      </div>

      <div class="form-group">
        <label for="date_fin">Date de Fin :</label>
        <input type="date" id="date_fin" name="date_fin" value="<?php echo htmlspecialchars($date_fin); ?>" required />
      </div>

      <div class="form-group">
        <label for="statut">Statut :</label>
        <select id="statut" name="statut" required>
          <option value="">Sélectionner un statut</option>
          <option value="En cours" <?php if ($statut === 'En cours') echo 'selected'; ?>>En cours</option>
          <option value="Terminé" <?php if ($statut === 'Terminé') echo 'selected'; ?>>Terminé</option>
          <option value="En attente" <?php if ($statut === 'En attente') echo 'selected'; ?>>En attente</option>
          <option value="Annulé" <?php if ($statut === 'Annulé') echo 'selected'; ?>>Annulé</option>
        </select>
      </div>

      <div class="form-actions">
        <button type="submit" class="submit-button">Enregistrer les Modifications</button>
        <a href="projets.php" class="cancel-button">Annuler</a>
      </div>
    </form>
    <?php endif; ?>
  </div>
</body>

</html>
<?php
// Fermer la connexion à la base de données (s'assure qu'elle est fermée même en cas d'erreur)
if (isset($mysqli)) {
    $mysqli->close();
}
?>