<?php
$pageTitle = "Home";
require_once 'includes/header.php';
?>

<div class="hero-section">
    <div class="hero-glow"></div>

    <div class="hero-text">
        <h1 class="hero-title">Secure Login & Authentication System</h1>
        <p>
            A modern PHP authentication project with secure login, signup, session handling,
            profile management, and a polished user interface.
        </p>

        <div class="hero-buttons">
            <a href="signup.php" class="fancy-btn primary-btn">Get Started</a>
            <a href="login.php" class="fancy-btn secondary-btn">Login</a>
        </div>
    </div>
</div>

<div class="features-grid">
    <div class="card feature-card">
        <h3>Secure Signup</h3>
        <p>Password hashing, clean validation, and reliable authentication flow.</p>
    </div>
    <div class="card feature-card">
        <h3>Protected Dashboard</h3>
        <p>Session-based security with a dedicated private user area.</p>
    </div>
    <div class="card feature-card">
        <h3>Profile Management</h3>
        <p>Edit user profile, change password, and manage personal details.</p>
    </div>
    <div class="card feature-card">
        <h3>Activity Tracking</h3>
        <p>Track login and logout activity to make the project feel more real.</p>
    </div>
</div>
 
<div class="cursor-glow"></div>

<?php require_once 'includes/footer.php'; ?>