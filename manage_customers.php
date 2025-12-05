<?php
include 'database.php';

if(isset($_POST['add'])){
    $name = $_POST['customer_name'];
    $email = $_POST['email'];
    $conn->query("INSERT INTO customers (customer_name,email) VALUES ('$name','$email')");
    header("Location: manage_customers.php");
}

$customers = $conn->query("SELECT * FROM customers");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Customers - Coffee Inventory</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'header.php'; ?>

<div class="container">
    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <span class="breadcrumb-item"><a href="home.php">Home</a></span>
        <span class="breadcrumb-separator">/</span>
        <span class="breadcrumb-item active">Customers</span>
    </div>

    <h2>Customers</h2>
    
    <form method="post" style="background: var(--accent-light); padding: 20px; border-radius: 8px; margin-bottom: 30px;">
        <label>Name</label>
        <input type="text" name="customer_name" placeholder="Customer name" required>
        
        <label>Email</label>
        <input type="email" name="email" placeholder="customer@example.com" required>
        
        <input type="submit" name="add" value="Add Customer">
    </form>

    <?php 
    $check = $conn->query("SELECT COUNT(*) as count FROM customers");
    $count = $check->fetch_assoc()['count'];
    if($count == 0): 
    ?>
        <div class="empty-state">
            <h2>No Customers Found</h2>
            <p>Add your first customer to get started.</p>
        </div>
    <?php else: ?>

    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php while($row = $customers->fetch_assoc()): ?>
        <tr>
            <td><strong>#<?php echo $row['customer_id']; ?></strong></td>
            <td><?php echo $row['customer_name']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td>
                <a href="edit_customer.php?id=<?php echo $row['customer_id']; ?>"><button>Edit</button></a>
                <a href="delete_customer.php?id=<?php echo $row['customer_id']; ?>" onclick="return confirm('Are you sure you want to delete this customer?')"><button style="background-color: #f44336;">Delete</button></a>
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