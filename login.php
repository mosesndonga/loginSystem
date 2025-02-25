<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOG IN</title>
    <link rel="stylesheet" href="/assets/styles.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2>Login</h2>
            <form class="form" id="loginForm" action="LogAuth.php" method="POST">
                <input type="text" placeholder="username" name="username" required>
                <input type="password" placeholder="Password" name="password" required>
                <button type="submit">Login</button>
            </form>
            <p>Don't have an account? <a href="regForm.php">Register here</a></p>
        </div>
    </div>
</body>
</html>
    
    <?php
    if (isset($_SESSION['login_status'])) {
        if ($_SESSION['login_status'] == "success") {
            echo "<script>
                Swal.fire({
                    title: 'Login Successful!',
                    text: 'Welcome back, " . $_SESSION['username'] . "!',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = 'portal.php';
                });
            </script>";
        } elseif ($_SESSION['login_status'] == "failed") {
            echo "<script>
                Swal.fire({
                    title: 'Login Failed!',
                    text: 'Invalid username or password. Please try again.',
                    icon: 'error',
                    timer: 2500,
                    showConfirmButton: false
                });
            </script>";
        }
        unset($_SESSION['login_status']); 
    }
    ?>

</body>
</html>
