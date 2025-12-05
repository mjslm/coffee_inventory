<?php
include 'database.php';
$id = $_GET['id'];
$conn->query("DELETE FROM categories WHERE category_id='$id'");
header("Location: manage_categories.php");
