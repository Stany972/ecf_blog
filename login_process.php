<?php
include 'functions.php';

// Connexion à la base de données
$conn = db_connect();

// Vérifier si la connexion est réussie
if ($conn === false) {
    die("Erreur de connexion à la base de données");
}

// Vérifiez si les données de formulaire sont soumises
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les valeurs des champs du formulaire
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Vérifier l'authentification de l'utilisateur
    $user = authenticate_user($email, $password, $conn);

    // Si l'utilisateur est authentifié avec succès, redirigez-le vers une autre page
    if ($user !== false) {
        // Vérification du rôle de l'utilisateur
        if ($user['role'] == 'admin') {
            // Authentification réussie pour un admin, rediriger vers la page admin
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = 'admin';
            header("Location: admin.php");
            exit();
        } else {
            // Authentification réussie pour un utilisateur non-admin, rediriger vers la page index
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = 'user';
            header("Location: index.php");
            exit();
        }
    } else {
        // Authentification échouée, rediriger vers la page de connexion avec un message d'erreur
        header("Location: login.php?error=1");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}
?>
