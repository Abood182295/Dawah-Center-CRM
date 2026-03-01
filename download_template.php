<?php
// Set headers to force download as a CSV file
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=customer_template.csv');

// Open the output stream
$output = fopen('php://output', 'w');

// Set the column headers (Must match your process_import.php order)
fputcsv($output, array('Full Name', 'Phone Number', 'Category'));

// Add a sample row so the supervisor knows what to do
fputcsv($output, array('Abdullah Mohammed', '966500000000', 'Volunteer'));
fputcsv($output, array('Sample Name', '0501234567', 'Dawah'));

fclose($output);
exit();
?>