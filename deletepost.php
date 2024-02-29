<?php
include 'functions.php';

// Vérification de l'authentification
check_authentication();

// Vérification du rôle
if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Vérification de la présence de l'identifiant du post à supprimer
if (!isset($_GET['id'])) {
    header("Location: admin.php");
    exit();
}

// Récupération de l'identifiant du post à supprimer
$post_id = $_GET['id'];

// Supprimer le poste de la base de données
if (delete_post($post_id)) {
    header("Location: admin.php");
    exit();
} else {
    echo "Une erreur s'est produite lors de la suppression du poste.";
}
?>
