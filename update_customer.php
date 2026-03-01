<?php
include('db_connection.php');
include('lang.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST['id']);
    $name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone_number']);
    $cat = mysqli_real_escape_string($conn, $_POST['category']);

    $sql = "UPDATE customers SET full_name='$name', phone_number='$phone', category='$cat' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        // Redirect back with a success message
        echo "<script>alert('" . $text['success_update'] . "'); window.location.href='view_customers.php';</script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>