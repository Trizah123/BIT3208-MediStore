<?php
session_start();
if (isset($_SESSION['user_id'])) { header("Location: dashboard.php"); exit(); }

include("connection.php");
$message = "";

if (isset($_POST['email'])) {
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $message = "<p class='error'>Please enter your email and password.</p>";
    } else {
        $result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
        $user   = mysqli_fetch_assoc($result);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id']   = $user['id'];
            $_SESSION['user_name'] = $user['fullname'];
            $_SESSION['user_role'] = $user['role'];
            header("Location: dashboard.php");
            exit();
        } else {
            $message = "<p class='error'>❌ Invalid email or password.</p>";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login - Medical Store</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: Arial; background: #e8f5e9; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .card { background: white; padding: 35px; border-radius: 10px; width: 380px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
        h2 { color: #2e7d32; text-align: center; margin-bottom: 5px; }
        .sub { text-align: center; color: #777; font-size: 13px; margin-bottom: 20px; }
        label { font-weight: bold; font-size: 14px; }
        input { width: 100%; padding: 10px; margin: 5px 0 14px; border: 1px solid #ccc; border-radius: 5px; }
        button { width: 100%; background: #2e7d32; color: white; padding: 11px; border: none; border-radius: 5px; cursor: pointer; font-size: 15px; }
        button:hover { background: #1b5e20; }
        .error { color: red; background: #fdecea; padding: 10px; border-radius: 5px; margin-bottom: 10px; }
        p { text-align: center; font-size: 14px; margin-top: 12px; }
    </style>
</head>
<body>
<div class="card">
    <h2>🏥 Medical Store</h2>
    <p class="sub">Management System — Staff Login</p>

    <?php echo $message; ?>

    <form method="POST">
        <label>Email Address</label>
        <input type="email" name="email" placeholder="your@email.com" required>

        <label>Password</label>
        <input type="password" name="password" placeholder="Your password" required>

        <button type="submit">Login</button>
    </form>
    <p>No account? <a href="register.php">Register here</a></p>
</div>
</body>
</html>