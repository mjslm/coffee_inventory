<?php
include 'database.php';
if(isset($_POST['submit'])){
    $name = $_POST['category_name'];
    $stmt = $conn->prepare("INSERT INTO categories (category_name) VALUES (?)");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $stmt->close();
    header("Location: manage_categories.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Category - Coffee Inventory</title>
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
        <span class="breadcrumb-item active">Add Category</span>
    </div>

    <h2>Add New Category</h2>
    
    <form method="post" style="max-width: 500px;">
        <label>Category Name</label>
        <input type="text" name="category_name" placeholder="e.g., Single Origin, Blend, Decaf" required>
        
        <div style="display: flex; gap: 10px; margin-top: 25px;">
            <input type="submit" name="submit" value="Add Category">
            <a href="manage_categories.php"><button type="button" style="background-color: #999;">Cancel</button></a>
        </div>
    </form>
</div>

<?php include 'footer.php'; ?>
</body>
</html>