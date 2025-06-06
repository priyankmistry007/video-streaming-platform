<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // OPTIONAL: Uncomment if you're using hashed passwords in the database
    // $password = hash('sha256', $password);

    $stmt = $db->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->execute([$username, $password]);

    if ($stmt->fetch()) {
        echo "✅ Login successful!";
        // TODO: Start session, redirect, etc.
    } else {
        echo "❌ Invalid credentials!";
    }
} else {
    echo "⛔ Access Denied: Please submit the form.";
}
?>
<?php
$stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch();

if ($user && password_verify($password, $user['password'])) {
    echo "✅ Login successful!";
} else {
    echo "❌ Invalid credentials!";
}

?>
