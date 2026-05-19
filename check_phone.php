<?php
include('db_connection.php');

if (isset($_POST['phone'])) {
    $phone = trim($_POST['phone']);
    
    // Upgrade: Use COUNT(*) to get the total number of past registrations
    $stmt = $conn->prepare("SELECT COUNT(*) as total_visits FROM beneficiaries WHERE phone_number = ?");
    $stmt->bind_param("s", $phone);
    $stmt->execute();
    
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $count = $row['total_visits'];
    
    // If the count is greater than 0, send back 'exists' AND the exact count
    if ($count > 0) {
        echo json_encode(['exists' => true, 'count' => $count]);
    } else {
        echo json_encode(['exists' => false, 'count' => 0]);
    }
    
    $stmt->close();
}
?>