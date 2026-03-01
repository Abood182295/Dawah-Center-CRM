<?php
include('db_connection.php');

if (isset($_POST['submit'])) {
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);
    $category = $_POST['category'];

    // Prevent duplicate numbers
    $check = $conn->query("SELECT id FROM customers WHERE phone_number = '$phone_number'");

    if ($check->num_rows > 0) {
        echo "<script>alert('Duplicate Number! This customer is already registered.'); window.history.back();</script>";
    } else {
        $sql = "INSERT INTO customers (full_name, phone_number, category) VALUES ('$full_name', '$phone_number', '$category')";
        if ($conn->query($sql)) {
            echo "<script>alert('Customer Added!'); window.location.href='view_customers.php';</script>";
        }
    }
}
?>