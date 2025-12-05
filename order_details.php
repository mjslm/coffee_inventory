<?php
include 'database.php';
$order_id = $_GET['id'];
$order_q = $conn->query("SELECT o.*, c.customer_name, c.email FROM orders o LEFT JOIN customers c ON o.customer_id=c.customer_id WHERE o.order_id='$order_id'");
if(!$order_q){
    die('Database error fetching order: ' . $conn->error);
}
$order = $order_q->fetch_assoc();

// Try to fetch items preferring stored unit_price; if that query fails (e.g. column missing), fallback to product price
$items_q = $conn->query("SELECT oi.*, p.product_name, COALESCE(oi.unit_price, p.price) AS price FROM order_items oi LEFT JOIN products p ON oi.product_id=p.product_id WHERE oi.order_id='$order_id'");
if(!$items_q){
    // fallback query without referencing oi.unit_price
    $items_q = $conn->query("SELECT oi.*, p.product_name, p.price AS price FROM order_items oi LEFT JOIN products p ON oi.product_id=p.product_id WHERE oi.order_id='$order_id'");
    if(!$items_q){
        die('Database error fetching order items: ' . $conn->error);
    }
}
$items = $items_q;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Order Details - Coffee Inventory</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'header.php'; ?>

<div class="container">
    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <span class="breadcrumb-item"><a href="home.php">Home</a></span>
        <span class="breadcrumb-separator">/</span>
        <span class="breadcrumb-item"><a href="view_orders.php">Orders</a></span>
        <span class="breadcrumb-separator">/</span>
        <span class="breadcrumb-item active">Order #<?php echo $order['order_id']; ?></span>
    </div>

    <h2>Order #<?php echo $order['order_id']; ?> Details</h2>
    
    <div style="background: linear-gradient(135deg, var(--cream) 0%, #f0e6d8 100%); padding: 25px; border-radius: 8px; margin-bottom: 30px; border-left: 4px solid var(--secondary-gold);">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
            <div>
                <p style="font-size: 13px; color: var(--text-light); margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.8px; font-weight: 700;">Customer</p>
                <p style="font-size: 16px; font-weight: 700; margin: 0; color: var(--primary-brown);"><?php echo $order['customer_name']; ?></p>
                <p style="font-size: 13px; color: var(--text-light); margin: 5px 0 0 0;"><?php echo $order['email']; ?></p>
            </div>
            <div>
                <p style="font-size: 13px; color: var(--text-light); margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.8px; font-weight: 700;">Order Date</p>
                <p style="font-size: 16px; font-weight: 700; margin: 0; color: var(--primary-brown);"><?php echo date('M d, Y H:i', strtotime($order['order_date'])); ?></p>
            </div>
        </div>
    </div>

    <h3 style="color: var(--primary-brown); font-size: 1.2em; margin-bottom: 20px; border-bottom: 2px solid var(--secondary-gold); padding-bottom: 12px;">Order Items</h3>

    <table>
        <thead>
        <tr>
            <th>Product</th>
            <th>Unit Price</th>
            <th>Quantity</th>
            <th>Subtotal</th>
        </tr>
        </thead>
        <tbody>
        <?php 
        $total = 0;
        while($item = $items->fetch_assoc()):
            $subtotal = $item['quantity'] * $item['price'];
            $total += $subtotal;
        ?>
        <tr>
            <td><?php echo $item['product_name']; ?></td>
            <td>₱<?php echo number_format($item['price'], 2); ?></td>
            <td><?php echo $item['quantity']; ?></td>
            <td><strong>₱<?php echo number_format($subtotal, 2); ?></strong></td>
        </tr>
        <?php endwhile; ?>
        <tr style="background: linear-gradient(135deg, var(--cream) 0%, #f0e6d8 100%); font-weight: 700;">
            <td colspan="3" style="text-align: right; padding-right: 15px; color: var(--primary-brown);">Total Amount</td>
            <td><strong style="font-size: 18px; color: var(--secondary-gold);">₱<?php echo number_format($total, 2); ?></strong></td>
        </tr>
        </tbody>
    </table>

    <div style="display: flex; gap: 15px; margin-top: 30px; justify-content: flex-end;">
        <a href="view_orders.php"><button style="background: linear-gradient(135deg, #999 0%, #777 100%); color: white; box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15); padding: 12px 24px;">Back to Orders</button></a>
    </div>
</div>

<?php include 'footer.php'; ?>
</body>
</html>