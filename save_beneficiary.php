<?php
include('db_connection.php'); // Confirmed on port 3307
include('lang.php');

// We only process the data if the form was actually submitted
if (isset($_POST['submit'])) {
    
    // 1. Capture the form data
    $full_name = $_POST['full_name'];
    $phone_number = $_POST['phone_number'];
    $id_number = !empty($_POST['id_number']) ? $_POST['id_number'] : NULL;
    $nationality = !empty($_POST['nationality']) ? $_POST['nationality'] : NULL;
    $gender = !empty($_POST['gender']) ? $_POST['gender'] : NULL;
    $category = $_POST['category'];
    
    /* =========================================
       SECURE DATABASE INSERT (Prepared Statement)
       ========================================= */
    // Note: We are still using the table name 'beneficiarys' in the database 
    // unless you decide to rename the actual table in phpMyAdmin.
    $stmt = $conn->prepare("INSERT INTO beneficiaries (full_name, phone_number, id_number, nationality, gender, category) VALUES (?, ?, ?, ?, ?, ?)");    
    // "sss" means we are passing 3 strings (Name, Phone, Category)
    $stmt->bind_param("ssssss", $full_name, $phone_number, $id_number, $nationality, $gender, $category);
    if ($stmt->execute()) {
        // 2. Success: Redirect to the beneficiary database view
        // We add a success parameter so you can show a message later if you want
        header("Location: add_beneficiary.php?status=success");
        exit();
    } else {
        // 3. Error Handling
        echo "Database Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

} else {
    // If someone tries to access this file directly without the form, send them back
    header("Location: add_beneficiary.php");
    exit();
}
?>