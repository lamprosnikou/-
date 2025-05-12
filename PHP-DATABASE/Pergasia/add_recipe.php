<?php
session_start();
require('db.php');

// Αν δεν είναι συνδεδεμένος ο χρήστης, τον στέλνουμε πίσω
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $prep_time = intval($_POST['prep_time']);
    $servings = intval($_POST['servings']);
    $imageName = "";

    // Εικόνα
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $imageName = basename($_FILES['image']['name']);
        $targetDir = "images/";
        $targetFilePath = $targetDir . $imageName;
        move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath);
    }

    // Εισαγωγή
    $stmt = $conn->prepare("INSERT INTO recipes (title, prep_time, servings, image) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("siis", $title, $prep_time, $servings, $imageName);

    if ($stmt->execute()) {
        header("Location: index.php"); // ✅ Redirect
        exit();
    } else {
        $message = "❌ Σφάλμα: " . $stmt->error;
    }

    $stmt->close();
}
?>

<?php require('header.php'); ?>
<?php require('leftsidebar.php'); ?>

<div id="main">
    <h2>Προσθήκη Συνταγής</h2>

    <?php if ($message): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <p>Τίτλος: <input type="text" name="title" required></p>
        <p>Χρόνος Προετοιμασίας: <input type="number" name="prep_time" required> λεπτά</p>
        <p>Μερίδες: <input type="number" name="servings" required></p>
        <p>Εικόνα: <input type="file" name="image"></p>
        <p><input type="submit" value="Προσθήκη Συνταγής"></p>
    </form>
</div>

<?php require('footer.php'); ?>
