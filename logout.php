<?php
session_start();
require_once 'config/db.php';

if (isset($_SESSION['user_id'])) {
    $logStmt = $pdo->prepare("INSERT INTO login_logs (user_id, action) VALUES (?, 'logout')");
    $logStmt->execute([$_SESSION['user_id']]);
}

session_unset();
session_destroy();

header("Location: login.php");
exit();