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

// Traitement du formulaire d'ajout de poste
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les valeurs du formulaire
    $title = $_POST["title"];
    $body = $_POST["body"];

    // Ajouter le poste dans la base de données
    if (add_post($title, $body)) {
        header("Location: admin.php");
        exit();
    } else {
        echo "Une erreur s'est produite lors de l'ajout du poste.";
    }
}
?>

<div class="container mt-5">
    <h1>Ajouter un poste</h1>
    <!-- Formulaire d'ajout de poste -->
    <form action="" method="POST">
        <div class="form-group">
            <label for="title">Titre</label>
            <input type="text" class="form-control" id="title" name="title">
        </div>
        <div class="form-group">
            <label for="body">Contenu</label>
            <textarea class="form-control" id="body" name="body" rows="5"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Ajouter</button>
    </form>
</div>

<?php include 'footer.php'; ?>
