<?php
include('db_connection.php'); // Port 3307
include('lang.php');

if (isset($_GET['id'])) {
    // 1. Sanitize the input
    $id = intval($_GET['id']);
    
    // 2. Use a Prepared Statement (Software Engineering Best Practice)
    $stmt = $conn->prepare("DELETE FROM beneficiaries WHERE id = ?");
    $stmt->bind_param("i", $id); // "i" means the ID is an integer

    if ($stmt->execute()) {
        // 3. Success: Go back to the list
        header("Location: view_beneficiary.php?status=deleted");
        exit();
    } else {
        // 4. Error: Show what went wrong
        echo "Error deleting record: " . $conn->error;
    }
    
    $stmt->close();
} else {
    // If no ID is provided, just send them back to the list
    header("Location: view_beneficiary.php");
    exit();
}

$conn->close();
?>