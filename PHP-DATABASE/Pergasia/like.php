<?php
session_start();
require('db.php');

if (isset($_POST['recipe_id'], $_SESSION['user_id'])) {
    $recipeId = intval($_POST['recipe_id']);
    $userId = $_SESSION['user_id'];

    // Προσθήκη like μόνο αν δεν υπάρχει ήδη
    $check = $conn->query("SELECT * FROM likes WHERE user_id=$userId AND recipe_id=$recipeId");
    if ($check->num_rows == 0) {
        $conn->query("INSERT INTO likes (user_id, recipe_id) VALUES ($userId, $recipeId)");
    }
}
header("Location: index.php");
