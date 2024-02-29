<?php
include 'header.php';
include 'functions.php';

// Vérifiez si une erreur est présente dans l'URL (passée via la redirection depuis login_process.php)
$error_message = '';
if (isset($_GET['error']) && $_GET['error'] == '1') {
    $error_message = '<div class="alert alert-danger" role="alert">Adresse e-mail ou mot de passe incorrect.</div>';
}
?>

<div class="container mt-5">
    <h1>Connexion</h1>
    <?php echo $error_message; ?>
    <!-- Formulaire de connexion -->
    <form action="login_process.php" method="POST">
        <div class="form-group">
            <label for="inputEmail">Adresse email</label>
            <input type="email" class="form-control" id="inputEmail" name="email" aria-describedby="emailHelp">
        </div>
        <div class="form-group">
            <label for="inputPassword">Mot de passe</label>
            <input type="password" class="form-control" id="inputPassword" name="password">
        </div>
        <button type="submit" class="btn btn-primary">Se connecter</button>
    </form>
</div>

<?php include 'footer.php'; ?>
