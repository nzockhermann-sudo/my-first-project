<!-- employes.php -->

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestion des Employés</title>
  <link rel="stylesheet" href="style/employe.css">
</head>

<body>
  <div class="container">
    <div class="header">
      <h1>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
          <path d="M4 22a8 8 0 1 1 16 0H4zm8-9c-3.315 0-6-2.685-6-6s2.685-6 6-6 6 2.685 6 6-2.685 6-6 6z" />
        </svg>
        <span>Gestion des Employés</span>
      </h1>
      <button class="btn btn-primary" onclick="window.location.href='ajoutEmp.html'">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
          <path d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2h6z" />
        </svg>
        <span>Ajouter un Employé</span>
      </button>
    </div>

    <div class="table-container">
      <table id="employeeTable">
        <thead>
          <tr>
            <th>
              <a href="?sort=nom&order=<?php echo (isset($_GET['sort']) && $_GET['sort'] === 'nom' && isset($_GET['order']) && $_GET['order'] === 'asc' ? 'desc' : 'asc'); ?>"
                class="sort-link">
                Nom
                <span class="sort-icon">
                  <?php if(isset($_GET['sort']) && $_GET['sort'] === 'nom'): ?>
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 8l-6 6h12z" />
                  </svg>
                  <?php else: ?>
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 8l-6 6h12zm0 8l-6-6h12z" />
                  </svg>
                  <?php endif; ?>
                </span>
              </a>
            </th>
            <th>
              <a href="?sort=poste&order=<?php echo (isset($_GET['sort']) && $_GET['sort'] === 'poste' && isset($_GET['order']) && $_GET['order'] === 'asc' ? 'desc' : 'asc'); ?>"
                class="sort-link">
                Poste
                <span class="sort-icon">
                  <?php if(isset($_GET['sort']) && $_GET['sort'] === 'poste'): ?>
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 8l-6 6h12z" />
                  </svg>
                  <?php else: ?>
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 8l-6 6h12zm0 8l-6-6h12z" />
                  </svg>
                  <?php endif; ?>
                </span>
              </a>
            </th>
            <th>
              <a href="?sort=salaire&order=<?php echo (isset($_GET['sort']) && $_GET['sort'] === 'salaire') && isset($_GET['order']) && $_GET['order'] === 'asc' ? 'desc' : 'asc'; ?>"
                class="sort-link">
                Salaire
                <span class="sort-icon">
                  <?php if(isset($_GET['sort']) && $_GET['sort'] === 'salaire'): ?>
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 8l-6 6h12z" />
                  </svg>
                  <?php else: ?>
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 8l-6 6h12zm0 8l-6-6h12z" />
                  </svg>
                  <?php endif; ?>
                </span>
              </a>
            </th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          include 'db_connect.php';

          $sortColumn = isset($_GET['sort']) && in_array($_GET['sort'], ['nom', 'poste', 'salaire']) ? $_GET['sort'] : 'nom';
          $sortOrder = isset($_GET['order']) && in_array($_GET['order'], ['asc', 'desc']) ? $_GET['order'] : 'asc';

          $sql = "SELECT id, nom, poste, salaire FROM employes ORDER BY $sortColumn $sortOrder";
          $result = $mysqli->query($sql);

          if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td>" . htmlspecialchars($row["nom"]) . "</td>";
                  echo "<td>" . htmlspecialchars($row["poste"]) . "</td>";
                  echo "<td>" . number_format($row["salaire"], 2, ',', ' ') . " Fcfa</td>";
                  echo '<td class="action-cell">
                          <button class="btn btn-primary edit-btn" data-id="'.$row["id"].'">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                              <path d="M15.728 9.686l-1.414-1.414L5 17.586V19h1.414l9.314-9.314zm1.414-1.414l1.414-1.414-1.414-1.414-1.414 1.414 1.414 1.414zM7.242 21H3v-4.243L16.435 3.322a1 1 0 0 1 1.414 0l2.829 2.829a1 1 0 0 1 0 1.414L7.243 21z"/>
                            </svg>
                            Modifier
                          </button>
                          <button class="btn btn-danger delete-btn" data-id="'.$row["id"].'">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                              <path d="M17 6h5v2h-2v13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V8H2V6h5V3a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v3zm1 2H6v12h12V8zm-9 3h2v6H9v-6zm4 0h2v6h-2v-6zM9 4v2h6V4H9z"/>
                            </svg>
                            Supprimer
                          </button>
                        </td>';
                  echo "</tr>";
              }
          } else {
              echo "<tr><td colspan='4'>Aucun employé trouvé</td></tr>";
          }

          $mysqli->close();
          ?>
        </tbody>
      </table>
    </div>
    <div class="dash">
      <a href="dashbord.php">
        retour</a>
    </div>
  </div>

  <script>
  document.addEventListener('DOMContentLoaded', function() {
    // Redirection vers la page de modification
    document.querySelectorAll('.edit-btn').forEach(btn => {
      btn.addEventListener('click', function() {
        const employeeId = this.dataset.id;
        window.location.href = `modifEmp.html?id=${employeeId}`;
      });
    });

    // Gestion de la suppression
    document.querySelectorAll('.delete-btn').forEach(btn => {
      btn.addEventListener('click', function() {
        if (confirm('Êtes-vous sûr de vouloir supprimer cet employé ?')) {
          fetch(`deleteEmployee.php?id=${this.dataset.id}`, {
              method: 'DELETE'
            })
            .then(response => response.json())
            .then(data => {
              if (data.success) {
                this.closest('tr').remove();
              } else {
                alert('Erreur lors de la suppression');
              }
            })
            .catch(error => {
              console.error('Erreur:', error);
              alert('Erreur lors de la communication avec le serveur');
            });
        }
      });
    });
  });
  </script>
</body>

</html>