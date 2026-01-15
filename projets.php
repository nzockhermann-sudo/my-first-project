<?php
// Inclure le fichier de connexion à la base de données
include 'db_connect.php';

// Requête SQL pour récupérer la liste des projets (vous pouvez personnaliser cette requête)
$sql = "SELECT id, nom_projet, client, budget, date_debut, date_fin, statut FROM projets";
$result = $mysqli->query($sql);

// Vérifier si la requête a réussi
if ($result) {
    $projets = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $projets = []; // Tableau vide en cas d'erreur
    $erreur_sql = $mysqli->error;
}

// Fermer la connexion à la base de données
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Liste des Projets</title>
  <link rel="stylesheet" href="style/projets.css" />
</head>

<body>
  <div class="container">
    <header class="header">
      <h1>Liste des Projets</h1>
      <a href="dashbord.php">Retour au Tableau de Bord</a>
    </header>

    <section class="project-list">
      <?php if (!empty($projets)) : ?>
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Nom du Projet</th>
            <th>Client</th>
            <th>Budget</th>
            <th>Date de Début</th>
            <th>Date de Fin</th>
            <th>Statut</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($projets as $projet) : ?>
          <tr>
            <td><?php echo htmlspecialchars($projet['id']); ?></td>
            <td><?php echo htmlspecialchars($projet['nom_projet']); ?></td>
            <td><?php echo htmlspecialchars($projet['client']); ?></td>
            <td><?php echo htmlspecialchars(number_format($projet['budget'], 0, ',', ' ')); ?> FCFA</td>
            <td><?php echo htmlspecialchars($projet['date_debut']); ?></td>
            <td><?php echo htmlspecialchars($projet['date_fin']); ?></td>
            <td>
              <span
                class="statut <?php echo strtolower(htmlspecialchars(str_replace(' ', '-', $projet['statut']))); ?>">
                <?php echo htmlspecialchars($projet['statut']); ?>
              </span>
            </td>
            <td class="actions">
              <a href="modifier_projet.php?id=<?php echo htmlspecialchars($projet['id']); ?>">Modifier</a>
              <a href="supprimer_projet.php?id=<?php echo htmlspecialchars($projet['id']); ?>"
                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce projet ?')">Supprimer</a>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <?php else : ?>
      <p>
        <?php echo isset($erreur_sql) ? "Erreur lors de la récupération des projets : " . htmlspecialchars($erreur_sql) : "Aucun projet trouvé."; ?>
      </p>
      <?php endif; ?>
    </section>

    <section class="add-new">
      <a href="ajouter_projet.php" class="button">Ajouter un Nouveau Projet</a>
    </section>
  </div>
</body>

</html>