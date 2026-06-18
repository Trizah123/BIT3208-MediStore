<?php
include("connection.php");
$message = "";

if (isset($_POST['medicine_name'])) {
    $medicine_name = mysqli_real_escape_string($conn, $_POST['medicine_name']);
    $category      = mysqli_real_escape_string($conn, $_POST['category']);
    $quantity      = (int) $_POST['quantity'];
    $price         = (float) $_POST['price'];
    $supplier      = mysqli_real_escape_string($conn, $_POST['supplier']);
    $expiry_date   = $_POST['expiry_date'];

    if (empty($medicine_name) || empty($category)) {
        $message = "<p style='color:red;'>Please fill all required fields.</p>";
    } else {
        $sql = "INSERT INTO medicines (medicine_name, category, quantity, price, supplier, expiry_date)
                VALUES ('$medicine_name','$category','$quantity','$price','$supplier','$expiry_date')";

        if (mysqli_query($conn, $sql)) {
            $message = "<p style='color:green;'>✅ Medicine added successfully!</p>";
        } else {
            $message = "<p style='color:red;'>Error: " . mysqli_error($conn) . "</p>";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Medicine</title>
    <style>
        body { font-family: Arial; background: #f0f8f0; padding: 30px; }
        h2 { color: #2e7d32; }
        form { background: white; padding: 25px; max-width: 480px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        input, select { width: 100%; padding: 10px; margin: 6px 0 14px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; }
        label { font-weight: bold; }
        button { width: 100%; background: #2e7d32; color: white; padding: 11px; border: none; border-radius: 5px; cursor: pointer; font-size: 15px; }
        button:hover { background: #1b5e20; }
        a { color: #2e7d32; display: block; margin-top: 12px; }
    </style>
</head>
<body>
    <h2>🏥 MediStore — Add Medicine</h2>
    <?php echo $message; ?>
    <form method="POST">
        <label>Medicine Name *</label>
        <input type="text" name="medicine_name" placeholder="e.g. Paracetamol 500mg" required>

        <label>Category *</label>
        <select name="category" required>
            <option value="">-- Select Category --</option>
            <option value="Pain Relief">Pain Relief</option>
            <option value="Antibiotics">Antibiotics</option>
            <option value="Diabetes">Diabetes</option>
            <option value="Antacids">Antacids</option>
            <option value="Supplements">Supplements</option>
            <option value="Cardiovascular">Cardiovascular</option>
            <option value="Other">Other</option>
        </select>

        <label>Quantity</label>
        <input type="number" name="quantity" placeholder="e.g. 100" min="0">

        <label>Price (KES)</label>
        <input type="number" step="0.01" name="price" placeholder="e.g. 15.50">

        <label>Supplier</label>
        <input type="text" name="supplier" placeholder="e.g. PharmaCo Ltd">

        <label>Expiry Date</label>
        <input type="date" name="expiry_date">

        <button type="submit">Add Medicine</button>
    </form>
    <a href="view_medicines.php">← View All Medicines</a>
</body>
</html>