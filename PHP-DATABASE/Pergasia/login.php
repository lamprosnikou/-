<?php
session_start();
require('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $res = $stmt->get_result();
    $user = $res->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['is_admin'] = $user['is_admin'];
        header("Location: index.php");
        exit();
    } else {
        $error = "Λανθασμένα στοιχεία";
    }
}
?>

<form method="POST">
    <input type="text" name="username" placeholder="Όνομα χρήστη" required>
    <input type="password" name="password" placeholder="Κωδικός" required>
    <button type="submit">Σύνδεση</button>
</form>
<?php if (isset($error)) echo "<p>$error</p>"; ?>
