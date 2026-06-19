<?php
include("connection.php");
$message = "";

if (!isset($_GET['id'])) { header("Location: view_medicines.php"); exit(); }
$id = (int) $_GET['id'];
$record = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM medicines WHERE id=$id"));
if (!$record) { die("Medicine not found."); }

if (isset($_POST['medicine_name'])) {
    $medicine_name = mysqli_real_escape_string($conn, $_POST['medicine_name']);
    $category      = mysqli_real_escape_string($conn, $_POST['category']);
    $quantity      = (int) $_POST['quantity'];
    $price         = (float) $_POST['price'];
    $supplier      = mysqli_real_escape_string($conn, $_POST['supplier']);
    $expiry_date   = $_POST['expiry_date'];

    $sql = "UPDATE medicines SET
                medicine_name='$medicine_name', category='$category',
                quantity='$quantity', price='$price',
                supplier='$supplier', expiry_date='$expiry_date'
            WHERE id=$id";

    if (mysqli_query($conn, $sql)) {
        $message = "<p style='color:green;'>✅ Medicine updated successfully!</p>";
        $record = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM medicines WHERE id=$id"));
    } else {
        $message = "<p style='color:red;'>Error: " . mysqli_error($conn) . "</p>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Medicine</title>
    <style>
        body { font-family: Arial; background: #f0f8f0; padding: 30px; }
        h2 { color: #1976d2; }
        form { background: white; padding: 25px; max-width: 480px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        input, select { width: 100%; padding: 10px; margin: 6px 0 14px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; }
        label { font-weight: bold; }
        button { width: 100%; background: #1976d2; color: white; padding: 11px; border: none; border-radius: 5px; cursor: pointer; font-size: 15px; }
        a { color: #2e7d32; display: block; margin-top: 12px; }
    </style>
</head>
<body>
    <h2>✏️ Edit Medicine</h2>
    <?php echo $message; ?>
    <form method="POST">
        <label>Medicine Name</label>
        <input type="text" name="medicine_name" value="<?php echo htmlspecialchars($record['medicine_name']); ?>" required>

        <label>Category</label>
        <select name="category">
            <?php
            foreach (['Pain Relief','Antibiotics','Diabetes','Antacids','Supplements','Cardiovascular','Other'] as $cat) {
                $sel = $record['category'] == $cat ? 'selected' : '';
                echo "<option value='$cat' $sel>$cat</option>";
            }
            ?>
        </select>

        <label>Quantity</label>
        <input type="number" name="quantity" value="<?php echo $record['quantity']; ?>">

        <label>Price (KES)</label>
        <input type="number" step="0.01" name="price" value="<?php echo $record['price']; ?>">

        <label>Supplier</label>
        <input type="text" name="supplier" value="<?php echo htmlspecialchars($record['supplier']); ?>">

        <label>Expiry Date</label>
        <input type="date" name="expiry_date" value="<?php echo $record['expiry_date']; ?>">

        <button type="submit">Update Medicine</button>
    </form>
    <a href="view_medicines.php">← Back to Inventory</a>
</body>
</html>