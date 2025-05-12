<?php
session_start();
require('db.php');

if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] && isset($_POST['recipe_id'])) {
    $stmt = $conn->prepare("UPDATE recipes SET deleted = 1 WHERE id = ?");
    $stmt->bind_param("i", $_POST['recipe_id']);
    $stmt->execute();
}
header("Location: index.php");
