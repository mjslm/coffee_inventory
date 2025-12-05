<?php
include 'database.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>MJCafe - Coffee Inventory System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <!-- Premium Hero Section -->
    <section class="home-hero-section">
        <div class="home-hero-content">
            <h1 class="home-hero-title">Welcome to MJCafe</h1>
            <p class="home-hero-subtitle">Premium Coffee Inventory Management System</p>
            <p class="home-hero-description">Discover excellence in every cup. Manage your coffee inventory with precision and passion.</p>
        </div>
    </section>

    <!-- Hero Section with Brand Story -->
    <section class="hero-section">
        <div class="hero-content">
            <h2>Why MJCafe Coffee?</h2>
            <div class="brand-story">
                <div class="story-card">
                    <h3>Premium Quality</h3>
                    <p>Sourced from the finest coffee farms, every bean is hand-selected for exceptional taste and aroma.</p>
                </div>
                <div class="story-card">
                    <h3>Artisan Craft</h3>
                    <p>Our expert baristas perfect every cup with precision brewing techniques and passion for coffee.</p>
                </div>
                <div class="story-card">
                    <h3>Fresh Daily</h3>
                    <p>Roasted fresh daily to ensure maximum flavor and quality in every single cup you enjoy.</p>
                </div>
                <div class="story-card">
                    <h3>Customer First</h3>
                    <p>Your satisfaction is our priority. We deliver excellence in every interaction and transaction.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Dashboard -->
    <div class="container">
        <h2 class="section-title">Your Inventory Overview</h2>
        <div class="stats-grid">
            <?php
                $products_count = $conn->query("SELECT COUNT(*) as count FROM products")->fetch_assoc()['count'];
                $categories_count = $conn->query("SELECT COUNT(*) as count FROM categories")->fetch_assoc()['count'];
                $customers_count = $conn->query("SELECT COUNT(*) as count FROM customers")->fetch_assoc()['count'];
                $orders_count = $conn->query("SELECT COUNT(*) as count FROM orders")->fetch_assoc()['count'];
            ?>
            
            <div class="stat-card">
                <div class="stat-number"><?php echo $products_count; ?></div>
                <div class="stat-label">Products</div>
                <a href="index.php" class="stat-link">Manage Products</a>
            </div>

            <div class="stat-card">
                <div class="stat-number"><?php echo $categories_count; ?></div>
                <div class="stat-label">Categories</div>
                <a href="manage_categories.php" class="stat-link">Manage Categories</a>
            </div>

            <div class="stat-card">
                <div class="stat-number"><?php echo $customers_count; ?></div>
                <div class="stat-label">Customers</div>
                <a href="manage_customers.php" class="stat-link">Manage Customers</a>
            </div>

            <div class="stat-card">
                <div class="stat-number"><?php echo $orders_count; ?></div>
                <div class="stat-label">Orders</div>
                <a href="view_orders.php" class="stat-link">View Orders</a>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>