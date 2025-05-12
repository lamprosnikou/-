<?php
session_start();
require('db.php');
require('header.php');
require('leftsidebar.php');

// Χειρισμός LIKE
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['like_recipe_id'])) {
    $stmt = $conn->prepare("INSERT INTO likes (user_id, recipe_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $_SESSION['user_id'], $_POST['like_recipe_id']);
    $stmt->execute();
}

// Χειρισμός ΣΧΟΛΙΟΥ
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['comment_recipe_id'], $_POST['comment'])) {
    $stmt = $conn->prepare("INSERT INTO comments (user_id, recipe_id, content) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $_SESSION['user_id'], $_POST['comment_recipe_id'], $_POST['comment']);
    $stmt->execute();
}
?>

<link rel="stylesheet" type="text/css" href="mycss.css?v=3" />

<div id="main">
    <h2>Συνταγές</h2>

    <?php if (isset($_SESSION['username'])): ?>
        <p><a href="add_recipe.php" class="btn">➕ Προσθήκη Συνταγής</a></p>
    <?php endif; ?>

    <?php
    $sql = "SELECT * FROM recipes";
    $result = $conn->query($sql);

    echo '<div class="recipe-grid">';

    while ($row = $result->fetch_assoc()) {
        $recipe_id = $row['id'];

        // Likes count
        $likes_sql = "SELECT COUNT(*) as like_count FROM likes WHERE recipe_id = $recipe_id";
        $likes_result = $conn->query($likes_sql);
        $likes = $likes_result->fetch_assoc()['like_count'];

        // Comments
        $comments_sql = "SELECT c.content, u.username FROM comments c JOIN users u ON c.user_id = u.id WHERE c.recipe_id = $recipe_id ORDER BY c.created_at DESC";
        $comments_result = $conn->query($comments_sql);

        echo '<div class="recipe-card">';
        echo '<img src="images/' . htmlspecialchars($row['image']) . '" alt="recipe image">';
        echo '<div class="recipe-content">';
        echo '<h3>' . htmlspecialchars($row['title']) . '</h3>';
        echo '<p><strong>Χρόνος:</strong> ' . intval($row['prep_time']) . ' λεπτά</p>';
        echo '<p><strong>Μερίδες:</strong> ' . intval($row['servings']) . '</p>';

        // Like button
        if (isset($_SESSION['user_id'])) {
            echo '<form method="POST" style="display:inline;">';
            echo '<input type="hidden" name="like_recipe_id" value="' . $recipe_id . '">';
            echo '<button type="submit">❤️ Like (' . $likes . ')</button>';
            echo '</form>';
        }

        // Comments display
        echo '<div class="comments">';
        while ($comment = $comments_result->fetch_assoc()) {
            echo '<p><strong>' . htmlspecialchars($comment['username']) . ':</strong> ' . htmlspecialchars($comment['content']) . '</p>';
        }
        echo '</div>';

        // Comment form
        if (isset($_SESSION['user_id'])) {
            echo '<form method="POST">';
            echo '<input type="hidden" name="comment_recipe_id" value="' . $recipe_id . '">';
            echo '<textarea name="comment" placeholder="Γράψε σχόλιο..." required></textarea>';
            echo '<button type="submit">💬 Σχόλιο</button>';
            echo '</form>';
        }

        echo '</div>'; // recipe-content
        echo '</div>'; // recipe-card
    }

    echo '</div>';
    ?>
</div>

<?php require('footer.php'); ?>
