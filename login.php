<!-- login.php -->

<?php
session_start();
include("config.inc.php");
//require_once 'config.php';

if (isset($_REQUEST['userid']) && isset($_REQUEST['password'])) {
    // Si l'utilisateur a essayé d'ouvrir une session
    $userid = $_REQUEST['userid'];
    $password = $_REQUEST['password'];

    // Connexion à la base de données avec mysqli
    $db_connect = new mysqli($bdserver, $bdlogin, $bdpwd, $bd);
    if ($db_connect->connect_error) {
        die("Erreur de connexion à la base de données : " . $db_connect->connect_error);
    }

    // Prépare la requête de l'utilisateur
    $query = "SELECT * FROM admino WHERE name = ? AND password = ?";
    $stmt = $db_connect->prepare($query);
    $stmt->bind_param("ss", $userid, $password);
    $stmt->execute();
    $result1 = $stmt->get_result();

    if ($result1->num_rows > 0) {
        // S'il est enregistré dans la base de données
        $_SESSION['valid_user'] = $userid;
    }
}
?>


<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Connexion</title>
  <link rel="stylesheet" href="style/form.css" />
</head>

<body>
  <header>
    <h1>Connexion</h1>
  </header>
  <main>
    <?php
if (isset($_SESSION['valid_user'])) { ?>
    <div class="connecty">
      <br>
      <div class="connect-user">
        <?php echo '<p>Vous êtes connecté(e) en tant que : ' . $_SESSION['valid_user'] . '</p>'; ?>
      </div>
      <div><a class="l" href="logout.php">Fermer votre session</a></div><br />
      <div class="dc"><a class="c" href="dashbord.php">contunuer</a></div><br />
    </div>
    <?php } 
else {

    if (isset($userid)) {
        echo '<p class="dennied"><b> ! Accès refusé ! </b></p>';
    } else {
        echo '<p class="nc">Vous n\'êtes pas connecté(e).</p><br />';
    } ?>
    <div>
      <form id="login-form" method="post" action="login.php" class="form-container">
        <div class="form-group">
          <label for="username">Nom d'utilisateur :</label>
          <input type="text" id="username" name="userid" required />
        </div>

        <div class="form-group">
          <label for="password">Mot de passe :</label>
          <input type="password" id="password" name="password" required />
        </div>

        <div class="form-actions">
          <button type="submit">Se connecter</button>
        </div>
      </form>
      <div class="text-link">
        <a href="register.html">Créer un compte</a>
      </div>
      <?php }
?>


    </div>
  </main>

  <footer>
    <p>© 2024 Gestion de Construction. Tous droits réservés.</p>
  </footer>

</body>

</html>