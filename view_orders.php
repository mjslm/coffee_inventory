<?php
include 'database.php';
$orders = $conn->query("SELECT o.order_id, o.order_date, c.customer_name 
                        FROM orders o 
                        LEFT JOIN customers c ON o.customer_id = c.customer_id
                        ORDER BY o.order_date DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders - Coffee Inventory</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'header.php'; ?>

<div class="container">
    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <span class="breadcrumb-item"><a href="home.php">Home</a></span>
        <span class="breadcrumb-separator">/</span>
        <span class="breadcrumb-item active">Orders</span>
    </div>

    <h2>Orders</h2>
    
    <div class="add-btn">
        <a href="create_order.php"><button class="btn-primary">+ Create New Order</button></a>
    </div>

    <?php 
    $check = $conn->query("SELECT COUNT(*) as count FROM orders");
    $count = $check->fetch_assoc()['count'];
    if($count == 0): 
    ?>
        <div class="empty-state">
            <h2>No Orders Found</h2>
            <p>Create your first order to get started.</p>
            <a href="create_order.php" class="btn btn-primary">Create Order</a>
        </div>
    <?php else: ?>

    <table>
        <thead>
        <tr>
            <th>Order ID</th>
            <th>Customer</th>
            <th>Order Date</th>
            <th>Items</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php $orders = $conn->query("SELECT o.order_id, o.order_date, c.customer_name FROM orders o LEFT JOIN customers c ON o.customer_id = c.customer_id ORDER BY o.order_date DESC"); while($order = $orders->fetch_assoc()): ?>
        <tr>
            <td><strong>#<?php echo $order['order_id']; ?></strong></td>
            <td><?php echo $order['customer_name']; ?></td>
            <td><?php echo date('M d, Y H:i', strtotime($order['order_date'])); ?></td>
            <td>
                <ul style="margin:0;padding-left:20px;list-style-type: none;">
                <?php
                    $items = $conn->query("SELECT p.product_name, oi.quantity FROM order_items oi 
                                           LEFT JOIN products p ON oi.product_id = p.product_id 
                                           WHERE oi.order_id = ".$order['order_id']);
                    while($item = $items->fetch_assoc()){
                        echo "<li style='margin-bottom: 4px;'>".$item['product_name']." <strong style='color: var(--primary-tan);'>x".$item['quantity']."</strong></li>";
                    }
                ?>
                </ul>
            </td>
            <td>
                <div style="display: flex; gap: 10px;">
                    <a href="order_details.php?id=<?php echo $order['order_id']; ?>"><button class="btn btn-primary" style="padding:8px 14px;font-size:12px;">View Details</button></a>
                    <a href="delete_order.php?id=<?php echo $order['order_id']; ?>" onclick="return confirm('Are you sure you want to delete this order?');"><button class="btn" style="background: linear-gradient(135deg, var(--danger) 0%, #d32f2f 100%); color: white; padding:8px 14px;font-size:12px; box-shadow: 0 4px 10px rgba(244, 67, 54, 0.2);">Delete</button></a>
                </div>
            </td>
        </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
</body>
</html>