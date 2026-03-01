<?php
include('db_connection.php'); // Port 3307

if (isset($_GET['phone']) && isset($_GET['message'])) {
    $phone = mysqli_real_escape_string($conn, $_GET['phone']);
    $message = $_GET['message'];

    // 1. Clean the number: Remove leading '0' and add Saudi country code '966'
    // This turns '0508979312' into '966508979312'
    if (substr($phone, 0, 1) === '0') {
        $clean_phone = '966' . substr($phone, 1);
    } else {
        $clean_phone = $phone;
    }

    // 2. Log the activity in your database
    $sql = "UPDATE customers SET last_messaged_at = NOW() WHERE phone_number = '$phone'";
    $conn->query($sql);

    // 3. Use the API redirect - this is much more stable than the direct web link
    $wa_url = "https://api.whatsapp.com/send?phone=" . $clean_phone . "&text=" . $message;
    
    header("Location: " . $wa_url);
    exit();
}
?>