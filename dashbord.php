<!--dashbord.php-->


<?php
// Inclure le fichier de connexion à la base de données
include 'db_connect.php';

// Requête SQL pour compter le nombre total d'employés
$sql_employes = "SELECT COUNT(*) AS total_employes FROM employes";
$result_employes = $mysqli->query($sql_employes);

if ($result_employes && $result_employes->num_rows > 0) {
    $row_employes = $result_employes->fetch_assoc();
    $nombreTotalEmployes = $row_employes['total_employes'];
} else {
    $nombreTotalEmployes = "Erreur de chargement";
}

// Requête SQL pour compter le nombre total de projets
$sql_total_projets = "SELECT COUNT(*) AS total_projets FROM projets";
$result_total_projets = $mysqli->query($sql_total_projets);

if ($result_total_projets && $result_total_projets->num_rows > 0) {
    $row_total_projets = $result_total_projets->fetch_assoc();
    $nombreTotalProjets = $row_total_projets['total_projets'];
} else {
    $nombreTotalProjets = "Erreur de chargement";
}

// Requête SQL pour compter le nombre de projets en cours
$sql_projets_en_cours = "SELECT COUNT(*) AS projets_en_cours FROM projets WHERE statut = 'En cours'";
$result_projets_en_cours = $mysqli->query($sql_projets_en_cours);

if ($result_projets_en_cours && $result_projets_en_cours->num_rows > 0) {
    $row_projets_en_cours = $result_projets_en_cours->fetch_assoc();
    $nombreProjetsEnCours = $row_projets_en_cours['projets_en_cours'];
} else {
    $nombreProjetsEnCours = "Erreur de chargement";
}

// Requête SQL pour compter le nombre de projets terminés
$sql_projets_termines = "SELECT COUNT(*) AS projets_termines FROM projets WHERE statut = 'Terminé'";
$result_projets_termines = $mysqli->query($sql_projets_termines);

if ($result_projets_termines && $result_projets_termines->num_rows > 0) {
    $row_projets_termines = $result_projets_termines->fetch_assoc();
    $nombreProjetsTermines = $row_projets_termines['projets_termines'];
} else {
    $nombreProjetsTermines = "Erreur de chargement";
}

// Requête SQL pour récupérer les derniers projets, triés par statut puis par date de fin
$sql_derniers_projets = "SELECT id, nom_projet, client, budget, date_debut, date_fin, statut
                         FROM projets
                         ORDER BY
                           CASE
                             WHEN statut = 'En cours' THEN 1
                             ELSE 2
                           END,
                           date_fin ASC
                         LIMIT 4"; // Limiter à 4 pour "derniers" projets

$result_derniers_projets = $mysqli->query($sql_derniers_projets);

if ($result_derniers_projets) {
    $derniersProjets = $result_derniers_projets->fetch_all(MYSQLI_ASSOC);
} else {
    $derniersProjets = [];
    // Gérer l'erreur ici si nécessaire
    // echo "Erreur lors de la récupération des derniers projets : " . $mysqli->error;
}


// Fermer la connexion à la base de données
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tableau de Bord</title>
  <link rel="stylesheet" href="style/dashbord.css" />
</head>

<body>
  <div class="dashboard">
    <header class="header">
      <h1>Tableau de Bord</h1>
      <a href="logout.php">Se Deconnecter</a>
    </header>

    <section class="stats">
      <a href="employes.php">
        <div class="stat green">
          <h3 class="h">Nombre Total d'Employés</h3>
          <p><?php echo $nombreTotalEmployes; ?></p>
        </div>
      </a>
      <a href="projets.php">
        <div class="stat blue">
          <h3 class="h">Nombre Total de Projets</h3>
          <p><?php echo $nombreTotalProjets; ?></p>
        </div>
      </a>
      <a href="projets.php">
        <div class="stat yellow">
          <h3>Projets En Cours</h3>
          <p><?php echo $nombreProjetsEnCours; ?></p>
        </div>
      </a>
      <a href="projets.php">
        <div class="stat lightblue">
          <h3>Projets Terminés</h3>
          <p><?php echo $nombreProjetsTermines; ?></p>
        </div>
      </a>
    </section>

    <section class="projects">
      <h2>Derniers Projets</h2>
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
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($derniersProjets)) : ?>
          <?php foreach ($derniersProjets as $projet) : ?>
          <tr>
            <td class="col1"><?php echo htmlspecialchars($projet['id']); ?></td>
            <td class="col2"><?php echo htmlspecialchars($projet['nom_projet']); ?></td>
            <td class="col3"><?php echo htmlspecialchars($projet['client']); ?></td>
            <td class="clo4"><?php echo htmlspecialchars(number_format($projet['budget'], 0, ',', ' ')); ?></td>
            <td class="col5"><?php echo htmlspecialchars($projet['date_debut']); ?></td>
            <td class="col6"><?php echo htmlspecialchars($projet['date_fin']); ?></td>
            <td class="col7"><?php echo htmlspecialchars($projet['statut']); ?></td>
          </tr>
          <?php endforeach; ?>
          <?php else : ?>
          <tr>
            <td colspan="7">Aucun projet trouvé.</td>
          </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </section>
  </div>
</body>

</html>