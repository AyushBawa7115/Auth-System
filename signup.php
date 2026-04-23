<?php
$pageTitle = "Signup";
require_once 'includes/header.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = sanitize($_POST["name"]);
    $email = sanitize($_POST["email"]);
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirm_password"];

    if (empty($name) || empty($email) || empty($password) || empty($confirmPassword)) {
        setFlash("error", "All fields are required.");
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        setFlash("error", "Enter a valid email address.");
    } elseif (strlen($password) < 6) {
        setFlash("error", "Password must be at least 6 characters.");
    } elseif ($password !== $confirmPassword) {
        setFlash("error", "Passwords do not match.");
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        try {
            $stmt->execute([$name, $email, $hashedPassword]);
            setFlash("success", "Account created successfully. Please login.");
            redirect("login.php");
        } catch (PDOException $e) {
            setFlash("error", "Email already exists.");
        }
    }
}
?>

<div class="auth-wrapper">
    <div class="card auth-card">
        <h2>Create Account</h2>
        <p class="subtitle">Build your secure account</p>

        <form method="POST">
            <label>Full Name</label>
            <input type="text" name="name" required>

            <label>Email Address</label>
            <input type="email" name="email" required>

            <label>Password</label>
            <div class="password-box">
                <input type="password" name="password" id="signupPassword" required>
                <button type="button" class="toggle-btn" onclick="togglePassword('signupPassword', this)">Show</button>
            </div>

            <label>Confirm Password</label>
            <div class="password-box">
                <input type="password" name="confirm_password" id="confirmPassword" required>
                <button type="button" class="toggle-btn" onclick="togglePassword('confirmPassword', this)">Show</button>
                <hr>

            </div>

            <button type="submit" class="main-btn">Signup</button>
        </form>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>