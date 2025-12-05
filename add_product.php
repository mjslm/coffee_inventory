<?php
include 'database.php';
$categories = $conn->query("SELECT * FROM categories");

if(isset($_POST['submit'])){
    $name = $_POST['product_name'];
    $category = $_POST['category_id'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    // Handle image upload
    $image = $_FILES['image']['name'];
    $target = "uploads/".basename($image);
    move_uploaded_file($_FILES['image']['tmp_name'], $target);

    $conn->query("INSERT INTO products (product_name, category_id, price, stock, image) 
                  VALUES ('$name','$category','$price','$stock','$image')");
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Product - Coffee Inventory</title>
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
        <span class="breadcrumb-item active">Add Product</span>
    </div>

    <h2>Add New Product</h2>
    
    <form method="post" enctype="multipart/form-data" style="max-width: 600px;">
        <label>Product Name</label>
        <input type="text" name="product_name" placeholder="e.g., Espresso Beans" required>

        <label>Category</label>
        <select name="category_id" required>
            <option value="">-- Select Category --</option>
            <?php while($cat = $categories->fetch_assoc()): ?>
                <option value="<?php echo $cat['category_id']; ?>"><?php echo $cat['category_name']; ?></option>
            <?php endwhile; ?>
        </select>

        <label>Price</label>
        <input type="number" name="price" step="0.01" placeholder="0.00" required>

        <label>Stock Quantity</label>
        <input type="number" name="stock" placeholder="0" required>

        <label>Product Image</label>
        <input type="file" name="image" accept="image/*">

        <div style="display: flex; gap: 10px; margin-top: 25px;">
            <input type="submit" name="submit" value="Add Product">
            <a href="index.php"><button type="button" style="background-color: #999;">Cancel</button></a>
        </div>
    </form>
</div>

<?php include 'footer.php'; ?>
</body>
</html>