<?php
include 'functions.php';

// Vérification de l'authentification
check_authentication();

// Vérification du rôle
if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Connexion à la base de données
$conn = db_connect();

// Récupération des postes
$posts = get_all_posts($conn);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog PHP</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Mon Blog</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Accueil</a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="admin.php">Administration</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Déconnexion</a>
                        </li>
                
                </ul>
            </div>
        </div>
    </nav>

<div class="container mt-5">
    <h1>Administration</h1>
    <a href="addpost.php" class="btn btn-primary mb-3">Ajouter un poste</a>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Titre</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($posts as $post) : ?>
                <tr>
                    <th scope="row"><?= $post['id'] ?></th>
                    <td><?= $post['title'] ?></td>
                    <td>
                        <a href="editpost.php?id=<?= $post['id'] ?>" class="btn btn-sm btn-primary">Modifier</a>
                        <a href="deletepost.php?id=<?= $post['id'] ?>" class="btn btn-sm btn-danger">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>
