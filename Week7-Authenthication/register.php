<?php
include("connection.php");
$message = "";

if (isset($_POST['email'])) {
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $role     = $_POST['role'];
    $password = $_POST['password'];
    $confirm  = $_POST['confirm_password'];

    if (empty($fullname) || empty($email) || empty($password)) {
        $message = "<p class='error'>All fields are required.</p>";
    } elseif ($password !== $confirm) {
        $message = "<p class='error'>Passwords do not match.</p>";
    } elseif (strlen($password) < 6) {
        $message = "<p class='error'>Password must be at least 6 characters.</p>";
    } else {
        $check = mysqli_query($conn, "SELECT id FROM users WHERE email='$email'");
        if (mysqli_num_rows($check) > 0) {
            $message = "<p class='error'>Email is already registered.</p>";
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (fullname, email, password, role)
                    VALUES ('$fullname','$email','$hashed','$role')";
            if (mysqli_query($conn, $sql)) {
                $message = "<p class='success'>✅ Registered! <a href='login.php'>Login here</a></p>";
            } else {
                $message = "<p class='error'>Error: " . mysqli_error($conn) . "</p>";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register - Medical Store</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: Arial; background: #e8f5e9; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .card { background: white; padding: 35px; border-radius: 10px; width: 400px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
        h2 { color: #2e7d32; text-align: center; }
        label { font-weight: bold; font-size: 14px; }
        input, select { width: 100%; padding: 10px; margin: 5px 0 13px; border: 1px solid #ccc; border-radius: 5px; }
        button { width: 100%; background: #2e7d32; color: white; padding: 11px; border: none; border-radius: 5px; cursor: pointer; font-size: 15px; }
        button:hover { background: #1b5e20; }
        .error { color: red; background: #fdecea; padding: 10px; border-radius: 5px; margin-bottom: 10px; }
        .success { color: green; background: #e8f5e9; padding: 10px; border-radius: 5px; margin-bottom: 10px; }
        p { text-align: center; font-size: 14px; margin-top: 12px; }
    </style>
</head>
<body>
<div class="card">
    <h2>🏥 Medical Store<br><small style="font-size:14px;font-weight:normal;">Staff Registration</small></h2>

    <?php echo $message; ?>

    <form method="POST">
        <label>Full Name</label>
        <input type="text" name="fullname" placeholder="e.g. Jane Wanjiku" required>

        <label>Email Address</label>
        <input type="email" name="email" placeholder="jane@medstore.com" required>

        <label>Role</label>
        <select name="role">
            <option value="pharmacist">Pharmacist</option>
            <option value="cashier">Cashier</option>
            <option value="admin">Admin</option>
        </select>

        <label>Password</label>
        <input type="password" name="password" placeholder="Minimum 6 characters" required>

        <label>Confirm Password</label>
        <input type="password" name="confirm_password" placeholder="Repeat your password" required>

        <button type="submit">Register</button>
    </form>
    <p>Already registered? <a href="login.php">Login</a></p>
</div>
</body>
</html>