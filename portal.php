<?php
// Start the session to check user authentication
session_start();
require 'dbConnect.php'; 

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Fetch user details including profile picture
$user_id = $_SESSION['user_id'];
$query = "SELECT username FROM users WHERE id = :user_id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Default values
$username = htmlspecialchars($user["username"] ?? "Guest");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal</title>
    <link rel="stylesheet" href="portal.css">
</head>
<body>

    <!-- Navigation Bar -->
    <nav class="navbar">
        <h1 class="logo">Portal</h1>
        <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">Profile</a></li>
            <li><a href="#">Dashboard</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <!-- Main Portal Content -->
    <div class="portal-container">
        <div class="glass-card">
            <h2>Welcome, User!</h2>
            <p>This is your personal portal. Access your dashboard, manage your profile, and explore features.</p>
            <button class="btn">Go to Dashboard</button>
        </div>

        <div class="glass-card">
            <h3>Your Profile</h3>
            <p>You are logged in as, <span id="user-name"><?php echo $username; ?></span></p>
            <button class="btn">Edit Profile</button>
        </div>

        <div class="glass-card">
            <h3>Recent Activities</h3>
            <ul>
                <li>✔ Logged in successfully</li>
                <li>✔ Updated profile information</li>
                <li>✔ Accessed the AI services</li>
            </ul>
        </div>
    </div>

</body>
</html>

