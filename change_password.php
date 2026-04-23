<?php
$pageTitle = "Change Password";
require_once 'includes/header.php';

if (!isLoggedIn()) {
    redirect("login.php");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $currentPassword = $_POST["current_password"];
    $newPassword = $_POST["new_password"];
    $confirmPassword = $_POST["confirm_password"];

    $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
        setFlash("error", "All fields are required.");
    } elseif (!password_verify($currentPassword, $user["password"])) {
        setFlash("error", "Current password is incorrect.");
    } elseif (strlen($newPassword) < 6) {
        setFlash("error", "New password must be at least 6 characters.");
    } elseif ($newPassword !== $confirmPassword) {
        setFlash("error", "New passwords do not match.");
    } else {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $updateStmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
        $updateStmt->execute([$hashedPassword, $_SESSION['user_id']]);

        setFlash("success", "Password changed successfully.");
        redirect("profile.php");
    }
}
?>

<div class="card auth-card">
    <h2>Change Password</h2>
    <form method="POST">
        <label>Current Password</label>
        <input type="password" name="current_password" required>

        <label>New Password</label>
        <input type="password" name="new_password" required>

        <label>Confirm New Password</label>
        <input type="password" name="confirm_password" required>

        <button type="submit" class="main-btn">Update Password</button>
    </form>
</div>

<?php require_once 'includes/footer.php'; ?>