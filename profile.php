<?php
$pageTitle = "Profile";
require_once 'includes/header.php';

if (!isLoggedIn()) {
    redirect("login.php");
}

$stmt = $pdo->prepare("SELECT name, email, role, created_at, last_login FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<div class="card profile-card">
    <h2>My Profile</h2>
    <div class="profile-item"><strong>Name:</strong> <?= htmlspecialchars($user['name']); ?></div>
    <div class="profile-item"><strong>Email:</strong> <?= htmlspecialchars($user['email']); ?></div>
    <div class="profile-item"><strong>Role:</strong> <?= htmlspecialchars($user['role']); ?></div>
    <div class="profile-item"><strong>Account Created:</strong> <?= htmlspecialchars($user['created_at']); ?></div>
    <div class="profile-item"><strong>Last Login:</strong> <?= $user['last_login'] ? htmlspecialchars($user['last_login']) : 'N/A'; ?></div>
</div>

<?php require_once 'includes/footer.php'; ?>