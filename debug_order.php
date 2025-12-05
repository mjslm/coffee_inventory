<?php
include 'database.php';

// Get recent order
$order = $conn->query("SELECT * FROM orders ORDER BY order_id DESC LIMIT 1")->fetch_assoc();
echo "Latest Order ID: " . $order['order_id'] . "<br>";

// Get order items with price info
$items = $conn->query("SELECT oi.order_item_id, oi.quantity, p.product_id, p.product_name, p.price 
                       FROM order_items oi 
                       LEFT JOIN products p ON oi.product_id = p.product_id 
                       WHERE oi.order_id = " . $order['order_id']);

echo "<h3>Order Items:</h3>";
$total = 0;
while($item = $items->fetch_assoc()){
    $subtotal = $item['quantity'] * $item['price'];
    $total += $subtotal;
    echo "<pre>";
    print_r($item);
    echo "Subtotal: " . $subtotal . "<br>";
    echo "</pre>";
}
echo "Total: " . $total . "<br>";
?>
