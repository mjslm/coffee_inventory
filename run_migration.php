<?php
include 'database.php';

// MIGRATION: Add unit_price column to order_items and populate it
// Run this once, then delete or disable this file for security.

$migrations_run = false;
$errors = [];

// Step 1: Check if unit_price column exists; if not, add it
$check_col = $conn->query("SHOW COLUMNS FROM order_items LIKE 'unit_price'");
if(!$check_col){
    $errors[] = "Error checking column: " . $conn->error;
} elseif($check_col->num_rows == 0){
    // Column doesn't exist, add it
    $add_col = $conn->query("ALTER TABLE `order_items` ADD COLUMN `unit_price` DECIMAL(10,2) NOT NULL DEFAULT '0.00' AFTER `quantity`");
    if(!$add_col){
        $errors[] = "Error adding unit_price column: " . $conn->error;
    } else {
        $migrations_run = true;
    }
} else {
    // Column already exists
    $migrations_run = true;
}

// Step 2: Populate unit_price for existing orders
if(!empty($errors) == false){
    $update = $conn->query("UPDATE `order_items` oi JOIN `products` p ON oi.product_id = p.product_id SET oi.unit_price = p.price WHERE oi.unit_price = 0.00");
    if(!$update){
        $errors[] = "Error populating unit_price: " . $conn->error;
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Database Migration - Coffee Inventory</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'header.php'; ?>
<div class="container" style="max-width: 600px; margin: 40px auto;">
    <h2>Database Migration</h2>
    
    <?php if(count($errors) == 0 && $migrations_run): ?>
        <div style="background: #c8e6c9; border: 1px solid #66bb6a; padding: 20px; border-radius: 6px; margin-bottom: 20px;">
            <h3 style="color: #2e7d32; margin-top: 0;">✓ Migration Completed Successfully</h3>
            <p><strong>unit_price</strong> column added to order_items table and populated with existing product prices.</p>
            <p>Your orders will now correctly store and display prices at the time of ordering.</p>
            <p style="margin-top: 20px; font-size: 13px; color: #555;">
                <strong>Next steps:</strong><br>
                1. Delete or rename this file (run_migration.php) for security<br>
                2. Create new orders to test the fix<br>
                3. Go to Order Details to verify prices display correctly
            </p>
        </div>
        <a href="view_orders.php"><button class="btn btn-primary">Go to Orders</button></a>
    <?php elseif(count($errors) > 0): ?>
        <div style="background: #ffcdd2; border: 1px solid #ef5350; padding: 20px; border-radius: 6px; margin-bottom: 20px;">
            <h3 style="color: #c62828; margin-top: 0;">✗ Migration Failed</h3>
            <p><strong>Errors encountered:</strong></p>
            <ul style="color: #d32f2f;">
                <?php foreach($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
            <p style="margin-top: 15px; font-size: 13px; color: #555;">
                Please run the migration manually using phpMyAdmin or MySQL CLI:
                <br><code>ALTER TABLE order_items ADD COLUMN unit_price DECIMAL(10,2) NOT NULL DEFAULT '0.00' AFTER quantity;</code>
            </p>
        </div>
        <a href="home.php"><button class="btn" style="background: #999;">Go Back</button></a>
    <?php else: ?>
        <div style="background: #fff9c4; border: 1px solid #fbc02d; padding: 20px; border-radius: 6px; margin-bottom: 20px;">
            <h3 style="color: #f57f17; margin-top: 0;">⚠ Migration Already Completed</h3>
            <p>The <strong>unit_price</strong> column already exists in your order_items table.</p>
            <p style="margin-top: 15px; font-size: 13px; color: #555;">
                <strong>Tip:</strong> You can safely delete this file (run_migration.php) now.
            </p>
        </div>
        <a href="view_orders.php"><button class="btn btn-primary">Go to Orders</button></a>
    <?php endif; ?>
</div>
<?php include 'footer.php'; ?>
</body>
</html>
