<?php
include 'database.php';
$id = $_GET['id'];
$category = $conn->query("SELECT * FROM categories WHERE category_id='$id'")->fetch_assoc();

if(isset($_POST['update'])){
    $name = $_POST['category_name'];
    $conn->query("UPDATE categories SET category_name='$name' WHERE category_id='$id'");
    header("Location: manage_categories.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Category - Coffee Inventory</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'header.php'; ?>

<div class="container">
    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <span class="breadcrumb-item"><a href="home.php">Home</a></span>
        <span class="breadcrumb-separator">/</span>
        <span class="breadcrumb-item"><a href="manage_categories.php">Categories</a></span>
        <span class="breadcrumb-separator">/</span>
        <span class="breadcrumb-item active">Edit Category</span>
    </div>

    <h2>Edit Category</h2>
    
    <form method="post" style="max-width: 500px;">
        <label>Category Name</label>
        <input type="text" name="category_name" value="<?php echo $category['category_name']; ?>" required>
        
        <div style="display: flex; gap: 10px; margin-top: 25px;">
            <input type="submit" name="update" value="Update Category">
            <a href="manage_categories.php"><button type="button" style="background-color: #999;">Cancel</button></a>
        </div>
    </form>
</div>

<?php include 'footer.php'; ?>
</body>
</html>