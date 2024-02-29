<?php
// Démarrer la session PHP
session_start();

// Fonction pour établir une connexion à la base de données
function db_connect()
{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ECF";

    // Création de la connexion
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("La connexion a échoué : " . $conn->connect_error);
    }

    return $conn;
}

// Fonction pour récupérer les 12 derniers articles
function get_latest_posts($conn)
{
    $sql = "SELECT * FROM posts ORDER BY createdAt DESC LIMIT 12";
    $result = $conn->query($sql);
    $posts = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $posts[] = $row;
        }
    }

    return $posts;
}

// Fonction pour récupérer tous les articles
function get_all_posts($conn)
{
    $sql = "SELECT * FROM posts";
    $result = $conn->query($sql);
    $posts = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $posts[] = $row;
        }
    }

    return $posts;
}

// Fonction pour vérifier l'authentification de l'utilisateur
function check_authentication()
{
    if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
        header("Location: login.php");
        exit();
    }
}

// Fonction pour authentifier l'utilisateur
function authenticate_user($email, $password, $conn) {
    $sql = "SELECT * FROM user WHERE email = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return false;
    }
}

// Fonction pour ajouter un article
function add_post($title, $body) {
    $conn = db_connect();
    if (!$conn) {
        return false;
    }
    
    $user_id = $_SESSION['user_id'];
    $query = "INSERT INTO posts (title, body, userId) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssi", $title, $body, $user_id);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
}

// Fonction pour supprimer un article
function delete_post($post_id) {
    $conn = db_connect();
    if (!$conn) {
        return false;
    }
    
    $query = "DELETE FROM posts WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $post_id);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
}

// Fonction pour modifier un article
function edit_post($post_id, $title, $body) {
    $conn = db_connect();
    if (!$conn) {
        return false;
    }
    
    $query = "UPDATE posts SET title = ?, body = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssi", $title, $body, $post_id);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
}

// Fonction pour récupérer un article par son ID
function get_post($post_id) {
    return array(
        'id' => $post_id,
        'title' => 'Titre du poste',
        'body' => 'Contenu du poste'
    );
}
?>
