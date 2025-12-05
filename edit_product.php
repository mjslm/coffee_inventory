<?php
include 'database.php';
$id = $_GET['id'];
$product = $conn->query("SELECT * FROM products WHERE product_id='$id'")->fetch_assoc();
$categories = $conn->query("SELECT * FROM categories");

if(isset($_POST['submit'])){
    $name = $_POST['product_name'];
    $category = $_POST['category_id'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    $image = $product['image'];
    if($_FILES['image']['name']){
        $image = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "uploads/".$image);
    }

    $conn->query("UPDATE products SET product_name='$name', category_id='$category', price='$price', stock='$stock', image='$image' WHERE product_id='$id'");
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Product - Coffee Inventory</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'header.php'; ?>

<div class="container">
    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <span class="breadcrumb-item"><a href="home.php">Home</a></span>
        <span class="breadcrumb-separator">/</span>
        <span class="breadcrumb-item"><a href="index.php">Products</a></span>
        <span class="breadcrumb-separator">/</span>
        <span class="breadcrumb-item active">Edit Product</span>
    </div>

    <h2>Edit Product</h2>
    
    <form method="post" enctype="multipart/form-data" style="max-width: 600px;">
        <label>Product Name</label>
        <input type="text" name="product_name" value="<?php echo $product['product_name']; ?>" required>

        <label>Category</label>
        <select name="category_id" required>
            <option value="">-- Select Category --</option>
            <?php 
            $categories = $conn->query("SELECT * FROM categories");
            while($cat = $categories->fetch_assoc()): 
            ?>
                <option value="<?php echo $cat['category_id']; ?>" 
                <?php if($cat['category_id']==$product['category_id']) echo "selected"; ?>>
                    <?php echo $cat['category_name']; ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label>Price</label>
        <input type="number" name="price" step="0.01" value="<?php echo $product['price']; ?>" required>

        <label>Stock Quantity</label>
        <input type="number" name="stock" value="<?php echo $product['stock']; ?>" required>

        <label>Product Image</label>
        <input type="file" name="image" accept="image/*">
        <?php if($product['image']): ?>
            <p style="font-size: 13px; color: #666; margin: 10px 0;">Current image:</p>
            <img src="uploads/<?php echo $product['image']; ?>" class="product-img" style="margin-bottom: 15px;">
        <?php endif; ?>

        <div style="display: flex; gap: 10px; margin-top: 25px;">
            <input type="submit" name="submit" value="Update Product">
            <a href="index.php"><button type="button" style="background-color: #999;">Cancel</button></a>
        </div>
    </form>
</div>

<?php include 'footer.php'; ?>
</body>
</html>