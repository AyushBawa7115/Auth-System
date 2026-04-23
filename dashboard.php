<?php
$pageTitle = "Dashboard";
require_once 'includes/header.php';

if (!isLoggedIn()) {
    redirect("login.php");
}

$stmt = $pdo->prepare("SELECT created_at, last_login, email, role FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$logStmt = $pdo->prepare("SELECT action, log_time FROM login_logs WHERE user_id = ? ORDER BY log_time DESC LIMIT 5");
$logStmt->execute([$_SESSION['user_id']]);
$logs = $logStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="dashboard-grid">
    <div class="card welcome-card">
        <h2>Hello, <?= htmlspecialchars($_SESSION["user_name"]); ?></h2>
        <p>This is your secure dashboard.</p>
    </div>

    <div class="card stat-card">
        <h3>Email</h3>
        <p><?= htmlspecialchars($user["email"]); ?></p>
    </div>

    <div class="card stat-card">
        <h3>Role</h3>
        <p><?= htmlspecialchars($user["role"]); ?></p>
    </div>

    <div class="card stat-card">
        <h3>Joined</h3>
        <p><?= htmlspecialchars($user["created_at"]); ?></p>
    </div>

    <div class="card stat-card">
        <h3>Last Login</h3>
        <p><?= $user["last_login"] ? htmlspecialchars($user["last_login"]) : "First login"; ?></p>
    </div>
<p class="empty-state">No activity yet. Start using the system.</p>
    <div class="card full-width">
        <h3>Recent Activity</h3>
        <?php if ($logs): ?>
            <table>
                <tr>
                    <th>Action</th>
                    <th>Time</th>
                </tr>
                <?php foreach ($logs as $log): ?>
                    <tr>
                        <td><?= htmlspecialchars($log["action"]); ?></td>
                        <td><?= htmlspecialchars($log["log_time"]); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>No activity found.</p>
        <?php endif; ?>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>