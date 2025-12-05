<?php
include 'database.php';
$id = $_GET['id'];
$conn->query("DELETE FROM customers WHERE customer_id='$id'");
header("Location: manage_customers.php");
