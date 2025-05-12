<?php
session_start();
require('header.php');
require('leftsidebar.php');
require('db.php'); // το αρχείο που συνδέεται με τη βάση
?>

<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <title>Αρχική Σελίδα Συνταγών</title>
    <link rel="stylesheet" href="mycss.css">
</head>
<body>
<div id="container">
    <div id="main">
        <h2>Συνταγές</h2>
        <div class="recipe-grid">
            <?php
            $query = "SELECT * FROM recipes ORDER BY created_at DESC LIMIT 5";
            $result = mysqli_query($conn, $query);

            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="recipe-card">';
                echo '<img src="uploads/' . htmlspecialchars($row['image']) . '" alt="Εικόνα συνταγής">';
                echo '<div class="recipe-content">';
                echo '<h3>' . htmlspecialchars($row['title']) . '</h3>';
                echo '<p><strong>Χρόνος:</strong> ' . htmlspecialchars($row['prep_time']) . ' λεπτά</p>';
                echo '<p><strong>Μερίδες:</strong> ' . htmlspecialchars($row['servings']) . '</p>';
                echo '<p>' . substr(htmlspecialchars($row['content']), 0, 100) . '...</p>';
                echo '</div>';
                echo '</div>';
            }

            mysqli_close($conn);
            ?>
        </div>
    </div>
</div>
</body>
</html>
