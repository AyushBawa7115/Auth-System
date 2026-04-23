<?php
$pageTitle = "Login";
require_once 'includes/header.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = sanitize($_POST["email"]);
    $password = $_POST["password"];

    if (empty($email) || empty($password)) {
        setFlash("error", "All fields are required.");
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user["password"])) {
            session_regenerate_id(true);

            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_name"] = $user["name"];
            $_SESSION["user_role"] = $user["role"];

           $updateStmt = $pdo->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
$updateStmt->execute([$user["id"]]);

$logStmt = $pdo->prepare("INSERT INTO login_logs (user_id, action) VALUES (?, 'login')");
$logStmt->execute([$user["id"]]);

            setFlash("success", "Login successful. Welcome back.");
            redirect("dashboard.php");
        } else {
            setFlash("error", "Invalid email or password.");
        }
    }
}
?>

<div class="auth-wrapper">
    <div class="card auth-card">
        <h2>Welcome Back</h2>
        <p class="subtitle">Login to continue</p>

        <form method="POST">
            <label>Email Address</label>
            <input type="email" name="email" required>

            <label>Password</label>
            <div class="password-box">
                <input type="password" name="password" id="loginPassword" required>
                <button type="button" class="toggle-btn" onclick="togglePassword('loginPassword', this)">Show</button>
            </div>
            <button type="submit" class="main-btn">Login</button>
        </form>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>