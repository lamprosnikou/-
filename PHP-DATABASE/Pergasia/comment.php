<?php
session_start();
require('db.php');

if (isset($_POST['recipe_id'], $_POST['content'], $_SESSION['user_id'])) {
    $recipeId = intval($_POST['recipe_id']);
    $userId = $_SESSION['user_id'];
    $content = $conn->real_escape_string(trim($_POST['content']));

    if (!empty($content)) {
        $conn->query("INSERT INTO comments (user_id, recipe_id, content) VALUES ($userId, $recipeId, '$content')");
    }
}
header("Location: index.php");
