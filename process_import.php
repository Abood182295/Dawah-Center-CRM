<?php
include('db_connection.php'); // Port 3307
include('lang.php');

if (isset($_FILES['csv_file'])) {
    $fileName = $_FILES['csv_file']['tmp_name'];

    if ($_FILES['csv_file']['size'] > 0) {
        $file = fopen($fileName, "r");
        
        // Skip the first line (header)
        fgetcsv($file);

        $success_count = 0;

        while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
            $name = mysqli_real_escape_string($conn, $column[0]);
            $phone = mysqli_real_escape_string($conn, $column[1]);
            $category = mysqli_real_escape_string($conn, $column[2]);

            // SQL to insert and prevent duplicates based on phone number
            $sql = "INSERT IGNORE INTO customers (full_name, phone_number, category, status) 
                    VALUES ('$name', '$phone', '$category', 'Active')";
            
            if ($conn->query($sql)) { $success_count++; }
        }

        fclose($file);
        echo "<script>alert('$success_count " . $text['import_success'] . "'); window.location.href='view_customers.php';</script>";
    }
} else {
    header("Location: import_customers.php");
}
?>