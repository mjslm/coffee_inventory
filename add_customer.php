<?php
include 'database.php';
if(isset($_POST['submit'])){
    $name = $_POST['customer_name'];
    $email = $_POST['email'];
    $stmt = $conn->prepare("INSERT INTO customers (customer_name, email) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $email);
    $stmt->execute();
    $stmt->close();
    header("Location: manage_customers.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Customer - Coffee Inventory</title>
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
        <span class="breadcrumb-item active">Add Customer</span>
    </div>

    <h2>Add New Customer</h2>
    
    <form method="post" style="max-width: 500px;">
        <label>Customer Name</label>
        <input type="text" name="customer_name" placeholder="Full name" required>
        
        <label>Email</label>
        <input type="email" name="email" placeholder="customer@example.com" required>
        
        <div style="display: flex; gap: 10px; margin-top: 25px;">
            <input type="submit" name="submit" value="Add Customer">
            <a href="manage_customers.php"><button type="button" style="background-color: #999;">Cancel</button></a>
        </div>
    </form>
</div>

<?php include 'footer.php'; ?>
</body>
</html>