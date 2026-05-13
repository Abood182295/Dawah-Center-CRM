<?php
include('db_connection.php');
include('lang.php');

// 1. Get the parameters from the GET request (matching your JavaScript)
$query = isset($_GET['query']) ? mysqli_real_escape_string($conn, $_GET['query']) : '';
$filter = isset($_GET['filter']) ? mysqli_real_escape_string($conn, $_GET['filter']) : 'All';

// 2. Build the Secure SQL Query
$sql = "SELECT * FROM beneficiaries WHERE (full_name LIKE ? OR phone_number LIKE ?)";

// Add category filter if it's not "All"
if ($filter !== 'All') {
    $sql .= " AND category = ?";
}
$sql .= " ORDER BY created_at DESC";

$stmt = $conn->prepare($sql);
$searchTerm = "%$query%";

if ($filter !== 'All') {
    $stmt->bind_param("sss", $searchTerm, $searchTerm, $filter);
} else {
    $stmt->bind_param("ss", $searchTerm, $searchTerm);
}

$stmt->execute();
$result = $stmt->get_result();
$count = $result->num_rows;

$html = "";

// 3. Generate the HTML for the table body
if ($count > 0) {
    while($row = $result->fetch_assoc()) {
        // Translate the category display
        $c = $row['category'];
        $k = 'opt_' . strtolower($c == 'Offer' ? 'off' : ($c == 'Volunteer' ? 'vln' : $c));
        $display_cat = isset($text[$k]) ? $text[$k] : $c;

        // Format dates for professional look
        $reg_date = date('M d, Y', strtotime($row['created_at']));
        $last_msg = !empty($row['last_messaged_at']) 
            ? "<span style='color: #17a2b8; font-weight: 600;'>" . date('M d, H:i', strtotime($row['last_messaged_at'])) . "</span>"
            : "<span style='color: #bbb;'>" . ($lang == 'ar' ? 'أبداً' : 'Never') . "</span>";

        $html .= "<tr>";
        $html .= "<td><strong>" . htmlspecialchars($row['full_name']) . "</strong></td>";
        $html .= "<td dir='ltr'>" . htmlspecialchars($row['phone_number']) . "</td>";
        $html .= "<td>" . $display_cat . "</td>";
        $html .= "<td>" . $reg_date . "</td>";
        $html .= "<td>" . $last_msg . "</td>";
        $html .= "<td class='action-links'>
                    <a href='edit_beneficiary.php?id=" . $row['id'] . "' style='color: #007bff; text-decoration: none; font-weight: bold;'>" . $text['edit'] . "</a> | 
                    <a href='delete_beneficiary.php?id=" . $row['id'] . "' style='color: #dc3545; text-decoration: none; font-weight: bold;' onclick='return confirm(\"" . $text['confirm_delete'] . "\")'>" . $text['delete'] . "</a>
                  </td>";
        $html .= "</tr>";
    }
} else {
    $no_results = ($lang == 'ar' ? 'لا توجد نتائج' : 'No results found');
    $html = "<tr><td colspan='6' style='padding:30px; color:#999; text-align:center;'>$no_results</td></tr>";
}

// 4. Return as JSON (Crucial for your JavaScript to read it)
echo json_encode([
    'html' => $html,
    'count' => $count
]);

$stmt->close();
$conn->close();
?>