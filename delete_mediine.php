<?php
include("connection.php");

if (!isset($_GET['id'])) { header("Location: view_medicines.php"); exit(); }

$id = (int) $_GET['id'];
mysqli_query($conn, "DELETE FROM medicines WHERE id=$id");
header("Location: view_medicines.php");
exit();
?>