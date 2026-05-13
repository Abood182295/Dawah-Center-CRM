<?php
include('db_connection.php'); // Confirmed on port 3307
include('lang.php');

if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] == 0) {
    $fileName = $_FILES['csv_file']['tmp_name'];

    if ($_FILES['csv_file']['size'] > 0) {
        $file = fopen($fileName, "r");
        
        // Skip the first line (header)
        fgetcsv($file);

        $success_count = 0;

        /* =========================================
           SECURE PREPARED STATEMENT
           ========================================= */
        // We prepare the query ONCE outside the loop for better performance
        $stmt = $conn->prepare("INSERT IGNORE INTO beneficiaries (full_name, phone_number, category, created_at) VALUES (?, ?, ?, NOW())");

        while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
            // Ensure the CSV has at least 3 columns to avoid "Undefined offset" errors
            if (count($column) >= 3) {
                $name = trim($column[0]);
                $phone = trim($column[1]);
                $category = trim($column[2]);

                // Bind the variables and execute
                $stmt->bind_param("sss", $name, $phone, $category);
                
                if ($stmt->execute()) {
                    // Check if a row was actually inserted (INSERT IGNORE might skip duplicates)
                    if ($stmt->affected_rows > 0) {
                        $success_count++;
                    }
                }
            }
        }

        $stmt->close();
        fclose($file);
        
        // Use singular naming convention: view_beneficiary.php
        echo "<script>alert('$success_count " . $text['import_success'] . "'); window.location.href='view_beneficiary.php';</script>";
    }
} else {
    // Use singular naming convention: import_beneficiary.php
    header("Location: import_beneficiary.php");
    exit();
}
?>