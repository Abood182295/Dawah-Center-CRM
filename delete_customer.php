<?php
include('db_connection.php');
include('lang.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // SQL to delete a specific record
    $sql = "DELETE FROM customers WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        header("Location: view_customers.php");
    } else {
        echo "Error deleting record: " . $conn->error;
    } else {
    header("Location: view_customers.php");
    }
}
?>