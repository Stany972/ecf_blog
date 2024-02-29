<?php
// Connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=ecf', 'root', '');

// Vérification de l'ID du poste dans l'URL
if (isset($_GET['id'])) {
    // Récupération de l'ID du poste depuis l'URL
    $postId = $_GET['id'];

    // Récupération des détails du poste
    $postQuery = $pdo->prepare('SELECT * FROM posts WHERE id = :id');
    $postQuery->bindParam(':id', $postId, PDO::PARAM_INT);
    $postQuery->execute();
    $post = $postQuery->fetch(PDO::FETCH_ASSOC);

    // Récupération des commentaires associés au poste
    $commentsQuery = $pdo->prepare('SELECT name, body FROM comments WHERE postId = :postId');
    $commentsQuery->bindParam(':postId', $postId, PDO::PARAM_INT);
    $commentsQuery->execute();
    $comments = $commentsQuery->fetchAll(PDO::FETCH_ASSOC);

    // Affichage des commentaires
    if (!empty($comments)) {
        echo '<h2>Commentaires</h2>';
        echo '<ul>';
        foreach ($comments as $comment) {
            echo "<li>$comment[body] par $comment[author] - $comment[createdAt]</li>";
        }
        echo '</ul>';
    } else {
        echo '<p>Aucun commentaire pour cet article.</p>';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($post) ? $post['title'] : 'Post non trouvé'; ?></title>
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
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="admin.php">Administration</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Déconnexion</a>
                        </li>
                    <?php else : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Connexion</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

<div class="container">
    <?php if (isset($post)): ?>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php echo $post['title']; ?></h5>
                <p class="card-text"><?php echo $post['body']; ?></p>
                <p class="card-text">Auteur: <?php echo $post['userId']; ?></p>
                <p class="card-text">Publié le: <?php echo $post['createdAt']; ?></p>
            </div>
        </div>

        <?php if (!empty($comments)): ?>
            <h2>Commentaires</h2>
            <?php foreach ($comments as $comment): ?>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $comment['name']; ?></h5>
                        <p class="card-text"><?php echo $comment['body']; ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Pas de nouveaux commentaires.</p>
        <?php endif; ?>

    <?php else: ?>
        <p>Poste non trouvé.</p>
    <?php endif; ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
