<?php
include("connection.php");
$result = mysqli_query($conn, "SELECT * FROM medicines ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Medicine Inventory</title>
    <style>
        body { font-family: Arial; background: #f0f8f0; padding: 30px; }
        h2 { color: #2e7d32; }
        table { width: 100%; border-collapse: collapse; background: white; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        th { background: #2e7d32; color: white; padding: 12px; text-align: left; }
        td { padding: 10px 12px; border-bottom: 1px solid #eee; }
        tr:hover td { background: #f1f8f1; }
        .btn { padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 13px; margin-right: 4px; }
        .btn-edit { background: #1976d2; color: white; }
        .btn-delete { background: #c62828; color: white; }
        .add-btn { background: #2e7d32; color: white; padding: 10px 18px; border-radius: 5px; text-decoration: none; display: inline-block; margin-bottom: 15px; }
        .low { color: red; font-weight: bold; }
    </style>
</head>
<body>
    <h2>🏥 Medical Store — Medicine Inventory</h2>
    <a href="add_medicine.php" class="add-btn">+ Add New Medicine</a>

    <table>
        <tr>
            <th>#</th>
            <th>Medicine Name</th>
            <th>Category</th>
            <th>Quantity</th>
            <th>Price (KES)</th>
            <th>Supplier</th>
            <th>Expiry Date</th>
            <th>Actions</th>
        </tr>
        <?php
        if (mysqli_num_rows($result) > 0) {
            $i = 1;
            while ($row = mysqli_fetch_assoc($result)) {
                $qClass = $row['quantity'] < 20 ? 'class="low"' : '';
                echo "<tr>
                    <td>{$i}</td>
                    <td>{$row['medicine_name']}</td>
                    <td>{$row['category']}</td>
                    <td $qClass>{$row['quantity']}</td>
                    <td>KES {$row['price']}</td>
                    <td>{$row['supplier']}</td>
                    <td>{$row['expiry_date']}</td>
                    <td>
                        <a href='edit_medicine.php?id={$row['id']}' class='btn btn-edit'>Edit</a>
                        <a href='delete_medicine.php?id={$row['id']}' class='btn btn-delete'
                           onclick=\"return confirm('Are you sure you want to delete this medicine?')\">Delete</a>
                    </td>
                </tr>";
                $i++;
            }
        } else {
            echo "<tr><td colspan='8' style='text-align:center;padding:20px;color:gray;'>No medicines found.</td></tr>";
        }
        ?>
    </table>
</body>
</html>