<?php
session_start();

// Database connection settings
$databaseFile = 'users.db';

try {
    $pdo = new PDO("sqlite:$databaseFile");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Ensure the users table exists
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT UNIQUE NOT NULL,
        email TEXT UNIQUE NOT NULL,
        password TEXT NOT NULL
    )");
} catch (PDOException $e) {
    $_SESSION['error'] = "Database connection failed: " . $e->getMessage();
    header("Location: regForm.php");
    exit;
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Trim and sanitize user inputs
    $inputUsername = trim(htmlspecialchars($_POST['username']));
    $inputEmail = trim(htmlspecialchars($_POST['email']));
    $inputPassword = $_POST['password'];
    $inputConfirmPassword = $_POST['confirmpassword'];
  

    // Check if passwords match
    if ($inputPassword !== $inputConfirmPassword) {
        $_SESSION['error'] = "Passwords do not match!";
        header("Location: regForm.php");
        exit;
    }

    // Hash the password
    $hashedPassword = password_hash($inputPassword, PASSWORD_DEFAULT);


    try {
        // Check if the username or email already exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = :username OR email = :email");
        $stmt->bindParam(':username', $inputUsername, PDO::PARAM_STR);
        $stmt->bindParam(':email', $inputEmail, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $_SESSION['error'] = "Username or email already exists!";
            header("Location: regForm.php");
            exit;
        }

        // Insert new user into the database
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
        $stmt->bindParam(':username', $inputUsername, PDO::PARAM_STR);
        $stmt->bindParam(':email', $inputEmail, PDO::PARAM_STR);
        $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Successful registration
            $_SESSION['success'] = [
                'username' => $inputUsername,
                'email' => $inputEmail
            ];
            header("Location: regForm.php");
            exit;
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = "Database error: " . $e->getMessage();
        header("Location: regForm.php");
        exit;
    }
}
?>