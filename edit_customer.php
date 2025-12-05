<?php
include 'database.php';
$id = $_GET['id'];
$customer = $conn->query("SELECT * FROM customers WHERE customer_id='$id'")->fetch_assoc();

if(isset($_POST['update'])){
    $name = $_POST['customer_name'];
    $email = $_POST['email'];
    $conn->query("UPDATE customers SET customer_name='$name', email='$email' WHERE customer_id='$id'");
    header("Location: manage_customers.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Customer - Coffee Inventory</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'header.php'; ?>

<div class="container">
    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <span class="breadcrumb-item"><a href="home.php">Home</a></span>
        <span class="breadcrumb-separator">/</span>
        <span class="breadcrumb-item"><a href="manage_customers.php">Customers</a></span>
        <span class="breadcrumb-separator">/</span>
        <span class="breadcrumb-item active">Edit Customer</span>
    </div>

    <h2>Edit Customer</h2>
    
    <form method="post" style="max-width: 500px;">
        <label>Name</label>
        <input type="text" name="customer_name" value="<?php echo $customer['customer_name']; ?>" required>

        <label>Email</label>
        <input type="email" name="email" value="<?php echo $customer['email']; ?>" required>

        <div style="display: flex; gap: 10px; margin-top: 25px;">
            <input type="submit" name="update" value="Update Customer">
            <a href="manage_customers.php"><button type="button" style="background-color: #999;">Cancel</button></a>
        </div>
    </form>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
