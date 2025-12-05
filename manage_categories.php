<?php
include 'database.php';

if(isset($_POST['add'])){
    $name = $_POST['category_name'];
    $conn->query("INSERT INTO categories (category_name) VALUES ('$name')");
    header("Location: manage_categories.php");
}

$categories = $conn->query("SELECT * FROM categories");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Categories - Coffee Inventory</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'header.php'; ?>

<div class="container">
    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <span class="breadcrumb-item"><a href="home.php">Home</a></span>
        <span class="breadcrumb-separator">/</span>
        <span class="breadcrumb-item active">Categories</span>
    </div>

    <h2>Categories</h2>
    
    <form method="post" style="background: var(--accent-light); padding: 20px; border-radius: 8px; margin-bottom: 30px;">
        <label>Category Name</label>
        <input type="text" name="category_name" placeholder="Enter category name" required>
        <input type="submit" name="add" value="Add Category">
    </form>

    <?php 
    $check = $conn->query("SELECT COUNT(*) as count FROM categories");
    $count = $check->fetch_assoc()['count'];
    if($count == 0): 
    ?>
        <div class="empty-state">
            <h2>No Categories Found</h2>
            <p>Create your first coffee category to organize products.</p>
        </div>
    <?php else: ?>

    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Category Name</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php while($row = $categories->fetch_assoc()): ?>
        <tr>
            <td><strong>#<?php echo $row['category_id']; ?></strong></td>
            <td><?php echo $row['category_name']; ?></td>
            <td>
                <a href="edit_category.php?id=<?php echo $row['category_id']; ?>"><button>Edit</button></a>
                <a href="delete_category.php?id=<?php echo $row['category_id']; ?>" onclick="return confirm('Are you sure you want to delete this category?')"><button style="background-color: #f44336;">Delete</button></a>
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