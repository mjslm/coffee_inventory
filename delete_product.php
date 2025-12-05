<?php
include 'database.php';
$id = $_GET['id'];
$product = $conn->query("SELECT image FROM products WHERE product_id='$id'")->fetch_assoc();
if($product && file_exists('uploads/'.$product['image'])){
    unlink('uploads/'.$product['image']);
}
$conn->query("DELETE FROM products WHERE product_id='$id'");
header("Location: index.php");
