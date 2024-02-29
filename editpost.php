<?php
include 'header.php';
include 'functions.php';

// Vérification de l'authentification
check_authentication();

// Vérification du rôle
if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Vérification de la présence de l'identifiant du post à modifier
if (!isset($_GET['id'])) {
    header("Location: admin.php");
    exit();
}

// Récupération de l'identifiant du post à modifier
$post_id = $_GET['id'];

// Récupération des données du post
$post = get_post($post_id);

// Traitement du formulaire de modification de poste
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les valeurs du formulaire
    $title = $_POST["title"];
    $body = $_POST["body"];

    // Modifier le poste dans la base de données
    if (edit_post($post_id, $title, $body)) {
        header("Location: admin.php");
        exit();
    } else {
        echo "Une erreur s'est produite lors de la modification du poste.";
    }
}
?>

<div class="container mt-5">
    <h1>Modifier le poste</h1>
    <!-- Formulaire de modification de poste -->
    <form action="" method="POST">
        <div class="form-group">
            <label for="title">Titre</label>
            <input type="text" class="form-control" id="title" name="title" value="<?= $post['title'] ?>">
        </div>
        <div class="form-group">
            <label for="body">Contenu</label>
            <textarea class="form-control" id="body" name="body" rows="5"><?= $post['body'] ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Modifier</button>
    </form>
</div>

<?php include 'footer.php'; ?>
