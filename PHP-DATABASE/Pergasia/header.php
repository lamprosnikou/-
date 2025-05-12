<div id="header">
<h1>Καλώς ήρθατε στο Pergasia Recipes</h1>
<?php if (isset($_SESSION['username'])) echo "<p>Χαίρετε, " . $_SESSION['username'] . "! (<a href='logout.php'>Logout</a>)</p>"; ?>
</div>