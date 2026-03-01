<?php
include('db_connection.php'); // Your custom port 3307 connection

// 1. Set headers to force download as CSV/Excel
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=Association_Customers_' . date('Y-m-d') . '.csv');

// 2. Open the output stream
$output = fopen('php://output', 'w');

// 3. Add UTF-8 BOM for Arabic characters to display correctly in Excel
fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

// 4. Set the Column Headers
fputcsv($output, array('Full Name', 'Phone Number', 'Category', 'Registration Date', 'Last Messaged'));

// 5. Fetch Data from MySQL
$sql = "SELECT full_name, phone_number, category, created_at, last_messaged_at FROM customers ORDER BY created_at DESC";
$result = $conn->query($sql);

while($row = $result->fetch_assoc()) {
    fputcsv($output, $row);
}

fclose($output);
exit();
?>