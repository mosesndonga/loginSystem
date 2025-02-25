   <?php
require 'dbConnect.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize inputs
    $username = trim(htmlspecialchars($_POST['username']));
    $password = $_POST['password'];

    // Check if username and password are provided
    if (empty($username) || empty($password)) {
        $_SESSION['login_status'] = "Please fill in all fields.";
        header("Location: login.php");
        exit;
    }

    // Prepare and execute the SQL query securely
    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify password and set session
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];  // Store user ID in session
            $_SESSION['username'] = $user['username']; // Store username
            $_SESSION['login_status'] = "success"; // Indicate login success
            header("Location: portal.php"); // Redirect to dashboard after login
            exit;
        } else {
            $_SESSION['login_status'] = "Invalid username or password."; // Indicate login failure
        }
    } catch (PDOException $e) {
        // Handle database errors
        $_SESSION['login_status'] = "Database error: " . $e->getMessage();
    }

    header("Location: login.php"); // Redirect back to login for error message
    exit;
}
?>
