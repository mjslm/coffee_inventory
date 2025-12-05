<?php
include 'database.php';
$customers = $conn->query("SELECT * FROM customers");
$products = $conn->query("SELECT * FROM products");

if(isset($_POST['submit'])){
    $customer_id = $_POST['customer_id'];
    $date = date('Y-m-d H:i:s');

    // Create order
    $conn->query("INSERT INTO orders (customer_id, order_date) VALUES ('$customer_id','$date')");
    $order_id = $conn->insert_id;

    // Iterate over checked products; quantities are keyed by product_id now
    foreach($_POST['product_id'] as $product_id){
        $quantity = isset($_POST['quantity'][$product_id]) ? intval($_POST['quantity'][$product_id]) : 0;

        if($quantity > 0){
            // Check stock availability
            $product = $conn->query("SELECT stock, price FROM products WHERE product_id='$product_id'")->fetch_assoc();
            if($quantity <= $product['stock']){
                // Insert order item and store unit price at time of order if column exists
                // Check if order_items has unit_price column
                $hasUnitPrice = false;
                $res = $conn->query("SHOW COLUMNS FROM order_items LIKE 'unit_price'");
                if($res && $res->num_rows > 0) $hasUnitPrice = true;

                $unit_price = $product['price'];
                if($hasUnitPrice){
                    $conn->query("INSERT INTO order_items (order_id, product_id, quantity, unit_price) VALUES ('$order_id','$product_id','$quantity','$unit_price')");
                } else {
                    $conn->query("INSERT INTO order_items (order_id, product_id, quantity) VALUES ('$order_id','$product_id','$quantity')");
                }

                // Deduct stock
                $conn->query("UPDATE products SET stock = stock - $quantity WHERE product_id = '$product_id'");
            } else {
                echo "<p style='color:#f44336; padding: 12px; background: #ffebee; border-radius: 6px; margin: 10px 0;'>Not enough stock for this item. Order not added for product ID $product_id.</p>";
            }
        }
    }

    header("Location: view_orders.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Create Order - Coffee Inventory</title>
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
        <span class="breadcrumb-item active">Create Order</span>
    </div>

    <h2>Create New Order</h2>
    
    <form method="post">
        <div style="background: linear-gradient(135deg, var(--cream) 0%, #f0e6d8 100%); padding: 25px; border-radius: 8px; margin-bottom: 30px; border-left: 4px solid var(--secondary-gold);">
            <label>Customer</label>
            <select name="customer_id" required>
                <option value="">-- Select Customer --</option>
                <?php 
                $customers = $conn->query("SELECT * FROM customers");
                while($cust = $customers->fetch_assoc()): 
                ?>
                    <option value="<?php echo $cust['customer_id']; ?>"><?php echo $cust['customer_name']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <h3 style="color: var(--primary-brown); font-size: 1.2em; margin-bottom: 20px; border-bottom: 2px solid var(--secondary-gold); padding-bottom: 12px;">Select Products</h3>
        
        <div style="background: linear-gradient(135deg, var(--cream) 0%, #f0e6d8 100%); padding: 25px; border-radius: 8px; border-left: 4px solid var(--secondary-gold);">
            <?php 
            $products = $conn->query("SELECT * FROM products");
            $count = 0;
            while($prod = $products->fetch_assoc()): 
                $count++;
            ?>
                <div class="order-product">
                    <input type="checkbox" name="product_id[]" value="<?php echo $prod['product_id']; ?>"> 
                    <label>
                        <strong><?php echo $prod['product_name']; ?></strong><br>
                        <span style="font-size: 13px; color: #666;">Price: ₱<?php echo number_format($prod['price'], 2); ?> | Stock: <?php echo $prod['stock']; ?> units</span>
                    </label>
                    <input type="number" name="quantity[<?php echo $prod['product_id']; ?>]" min="0" value="0" placeholder="Qty">
                </div>
            <?php endwhile; ?>
            
            <?php if($count == 0): ?>
                <p style="color: #666; text-align: center; padding: 20px;">No products available. Please add products first.</p>
            <?php endif; ?>
        </div>

        <div style="display: flex; gap: 15px; margin-top: 30px; justify-content: flex-end;">
            <a href="view_orders.php"><button type="button" class="btn" style="background: linear-gradient(135deg, #999 0%, #777 100%); color: white; box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);">Cancel</button></a>
            <input type="submit" name="submit" value="Create Order" style="background: linear-gradient(135deg, var(--secondary-gold) 0%, var(--accent-warm) 100%); color: var(--primary-dark); box-shadow: 0 8px 20px rgba(212, 175, 55, 0.3);">
        </div>
    </form>
</div>

<?php include 'footer.php'; ?>
</body>
</html>