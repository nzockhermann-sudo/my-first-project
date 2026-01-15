<!-- register.php -->

<?php
    include("config.inc.php");
    
    $name = $_POST['name'];
    $pass = $_POST['password'];
    $email = $_POST['email'];
    $user = $_POST['username'];
    
    $base = new mysqli($bdserver, $bdlogin, $bdpwd, $bd);
    $requet = "INSERT INTO admino (`name`, `password`, `email`, `username`)
    VALUES (?, ?, ?, ?)";
    $stmt = $base->prepare($requet);
    $stmt->bind_param("ssss",$name,$pass,$email,$user);
        
    if ($stmt->execute()) {
        echo "Nouveau enregistrement créé avec succès";
    } else {
        echo "Erreur: " . $stmt->error;
    }
    $stmt->close();
    $base->close();
    header("location: login.php ");
?>