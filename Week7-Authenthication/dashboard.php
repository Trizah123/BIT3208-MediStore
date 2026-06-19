<?php
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }

include("connection.php");

$total     = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS t FROM medicines"))['t'];
$low_stock = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS t FROM medicines WHERE quantity < 20"))['t'];
$users     = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS t FROM users"))['t'];
$recent    = mysqli_query($conn, "SELECT * FROM medicines ORDER BY created_at DESC LIMIT 5");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Medical Store</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial; background: #f4f9f4; }
        nav { background: #2e7d32; color: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; }
        nav h1 { font-size: 18px; }
        nav span { font-size: 14px; }
        nav a { color: white; background: #c62828; padding: 7px 14px; border-radius: 4px; text-decoration: none; margin-left: 15px; }
        .main { padding: 30px; }
        h2 { color: #2e7d32; margin-bottom: 20px; }
        .stats { display: flex; gap: 20px; margin-bottom: 25px; flex-wrap: wrap; }
        .stat { background: white; padding: 20px 25px; border-radius: 8px; flex: 1; min-width: 140px;
                box-shadow: 0 2px 6px rgba(0,0,0,0.08); border-left: 5px solid #2e7d32; }
        .stat.warn { border-left-color: #e65100; }
        .stat.blue { border-left-color: #1565c0; }
        .stat h3 { font-size: 30px; }
        .stat p { color: #777; font-size: 13px; margin-top: 4px; }
        .links { display: flex; gap: 12px; margin-bottom: 25px; flex-wrap: wrap; }
        .links a { background: #2e7d32; color: white; padding: 10px 18px; border-radius: 5px; text-decoration: none; font-size: 14px; }
        .links a:hover { background: #1b5e20; }
        .box { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.08); }
        .box h3 { color: #2e7d32; margin-bottom: 15px; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #2e7d32; color: white; padding: 10px; text-align: left; }
        td { padding: 9px 10px; border-bottom: 1px solid #eee; font-size: 14px; }
    </style>
</head>
<body>
<nav>
    <h1>🏥 Medical Store Management System</h1>
    <div>
        <span>Welcome, <strong><?php echo htmlspecialchars($_SESSION['user_name']); ?></strong>
        (<?php echo ucfirst($_SESSION['user_role']); ?>)</span>
        <a href="logout.php">Logout</a>
    </div>
</nav>

<div class="main">
    <h2>Dashboard</h2>

    <div class="stats">
        <div class="stat">
            <h3><?php echo $total; ?></h3>
            <p>Total Medicines</p>
        </div>
        <div class="stat warn">
            <h3><?php echo $low_stock; ?></h3>
            <p>Low Stock (&lt;20)</p>
        </div>
        <div class="stat blue">
            <h3><?php echo $users; ?></h3>
            <p>Registered Staff</p>
        </div>
    </div>

    <div class="links">
        <a href="../week6/view_medicines.php">📋 View Inventory</a>
        <a href="../week6/add_medicine.php">➕ Add Medicine</a>
    </div>

    <div class="box">
        <h3>Recently Added Medicines</h3>
        <table>
            <tr><th>Medicine</th><th>Category</th><th>Qty</th><th>Price</th><th>Expiry</th></tr>
            <?php
            if (mysqli_num_rows($recent) > 0) {
                while ($r = mysqli_fetch_assoc($recent)) {
                    echo "<tr><td>{$r['medicine_name']}</td><td>{$r['category']}</td>
                          <td>{$r['quantity']}</td><td>KES {$r['price']}</td><td>{$r['expiry_date']}</td></tr>";
                }
            } else {
                echo "<tr><td colspan='5' style='text-align:center;color:gray;'>No medicines yet.</td></tr>";
            }
            ?>
        </table>
    </div>
</div>
</body>
</html>