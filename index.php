<?php
include 'header.php';
include 'functions.php';

// Connexion à la base de données
$conn = db_connect();

// Récupération des 12 derniers articles
$posts = get_latest_posts($conn);

?>

<div class="container mt-5">
    <h1>Page d'accueil</h1>
    <div class="row">
        <?php foreach ($posts as $post) : ?>
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title"><?= $post['title'] ?></h5>
                        <h6 class="card-subtitle mb-2 text-muted"><?= $post['createdAt'] ?></h6>
                        <p class="card-text"><?= $post['body'] ?></p>
                        <a href="post.php?id=<?php echo $post['id']; ?>"class="card-link">Voir l'article</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <!-- Pagination -->
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Précédent</a>
            </li>
            <li class="page-item"><a class="page-link" href="#">Suivant</a></li>
        </ul>
    </nav>
</div>

<?php include 'footer.php'; ?>
