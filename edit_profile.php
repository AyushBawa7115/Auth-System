<?php
$pageTitle = "Edit Profile";
require_once 'includes/header.php';

if (!isLoggedIn()) {
    redirect("login.php");
}

$stmt = $pdo->prepare("SELECT name, email FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = sanitize($_POST["name"]);
    $email = sanitize($_POST["email"]);

    if (empty($name) || empty($email)) {
        setFlash("error", "All fields are required.");
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        setFlash("error", "Invalid email format.");
    } else {
        $updateStmt = $pdo->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
        try {
            $updateStmt->execute([$name, $email, $_SESSION['user_id']]);
            $_SESSION["user_name"] = $name;
            setFlash("success", "Profile updated successfully.");
            redirect("profile.php");
        } catch (PDOException $e) {
            setFlash("error", "Email already in use.");
        }
    }
}
?>

<div class="card auth-card">
    <h2>Edit Profile</h2>
    <form method="POST">
        <label>Full Name</label>
        <input type="text" name="name" value="<?= htmlspecialchars($user['name']); ?>" required>

        <label>Email Address</label>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']); ?>" required>

        <button type="submit" class="main-btn">Update Profile</button>
    </form>
</div>

<?php require_once 'includes/footer.php'; ?>