<?php
session_start();
require('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    $title = $_POST['title'];
    $desc = $_POST['description'];
    $imagePath = 'uploads/' . basename($_FILES['image']['name']);
    move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);

    $stmt = $mysqli->prepare("INSERT INTO recipes (user_id, title, description, image_path) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $_SESSION['user_id'], $title, $desc, $imagePath);
    $stmt->execute();
    header("Location: index.php");
    exit();
}
?>
