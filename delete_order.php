<?php
include 'database.php';

if(isset($_GET['id'])){
    $order_id = $_GET['id'];
    
    // Get order items to restore stock
    $items = $conn->query("SELECT product_id, quantity FROM order_items WHERE order_id = '$order_id'");
    while($item = $items->fetch_assoc()){
        // Restore stock for each product
        $conn->query("UPDATE products SET stock = stock + ".$item['quantity']." WHERE product_id = ".$item['product_id']);
    }
    
    // Delete order items
    $conn->query("DELETE FROM order_items WHERE order_id = '$order_id'");
    
    // Delete the order
    $conn->query("DELETE FROM orders WHERE order_id = '$order_id'");
    
    header("Location: view_orders.php");
} else {
    header("Location: view_orders.php");
}
?>
