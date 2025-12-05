<?php
include 'database.php';
$result = $conn->query("SELECT p.*, c.category_name FROM products p 
                        LEFT JOIN categories c ON p.category_id = c.category_id");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Products - Coffee Inventory</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'header.php'; ?>

<div class="container">
    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <span class="breadcrumb-item"><a href="home.php">Home</a></span>
        <span class="breadcrumb-separator">/</span>
        <span class="breadcrumb-item active">Products</span>
    </div>

    <h2>Products</h2>
    
    <div class="add-btn">
        <a href="add_product.php"><button class="btn-primary">+ Add New Product</button></a>
    </div>

    <?php 
    $check = $conn->query("SELECT COUNT(*) as count FROM products");
    $count = $check->fetch_assoc()['count'];
    if($count == 0): 
    ?>
        <div class="empty-state">
            <h2>No Products Found</h2>
            <p>Add your first coffee product to get started.</p>
            <a href="add_product.php" class="btn btn-primary">Add Product</a>
        </div>
    <?php else: ?>

    <table>
        <thead>
        <tr>
            <th>Image</th>
            <th>Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td>
                <?php
                    $imageFile = 'uploads/' . $row['image'];
                    if(file_exists($imageFile) && $row['image'] != ""){
                        echo '<img src="' . $imageFile . '" class="product-img">';
                    } else {
                        echo '<span style="color: #999; font-size: 13px;">No image</span>';
                    }
                ?>
            </td>
            <td><strong><?php echo $row['product_name']; ?></strong></td>
            <td><?php echo $row['category_name'] ? $row['category_name'] : 'Uncategorized'; ?></td>
            <td><strong>₱<?php echo number_format($row['price'], 2); ?></strong></td>
            <td>
                <span style="<?php echo $row['stock'] < 10 ? 'color: #f44336; font-weight: bold;' : 'color: #4caf50;'; ?>">
                    <?php echo $row['stock']; ?> units
                </span>
            </td>
            <td>
                <a href="edit_product.php?id=<?php echo $row['product_id']; ?>"><button>Edit</button></a>
                <a href="delete_product.php?id=<?php echo $row['product_id']; ?>" 
                   onclick="return confirm('Are you sure you want to delete this product?')">
                   <button style="background-color: #f44336;">Delete</button>
                </a>
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
