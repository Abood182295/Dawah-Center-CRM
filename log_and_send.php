<?php
include('db_connection.php'); // Confirmed on port 3307

// 1. Force the correct timezone for the timestamp
date_default_timezone_set('Asia/Riyadh');

if (isset($_GET['phone']) && isset($_GET['message']) && !empty($_GET['phone'])) {
    
    // The raw phone as it exists in your database (e.g., '0508979312')
    $raw_phone = $_GET['phone']; 
    // The raw message text
    $message = $_GET['message']; 

    /* =========================================
       STEP 1: CLEAN AND FORMAT FOR WHATSAPP
       ========================================= */
    // Remove ANY spaces, dashes, or non-numeric characters
    $clean_phone = preg_replace('/[^0-9]/', '', $raw_phone);

    // Smart formatting for Saudi Arabia (+966)
    if (strpos($clean_phone, '966') === 0) {
        // It already starts with 966, leave it alone
    } elseif (strpos($clean_phone, '05') === 0) {
        // Starts with 05 -> replace the 0 with 966
        $clean_phone = '966' . substr($clean_phone, 1);
    } elseif (strpos($clean_phone, '5') === 0 && strlen($clean_phone) == 9) {
        // Starts with 5 and is 9 digits -> just add 966 to the front
        $clean_phone = '966' . $clean_phone;
    }

    /* =========================================
       STEP 2: SECURE DATABASE LOGGING
       ========================================= */
    // Use Prepared Statements to prevent SQL Injection
    // Note: We use the $raw_phone here to match exactly what is in the DB
    $stmt = $conn->prepare("UPDATE beneficiaries SET last_messaged_at = NOW() WHERE phone_number = ?");
    $stmt->bind_param("s", $raw_phone);
    
    if ($stmt->execute()) {
        $stmt->close();
    } else {
        // If the DB fails, stop the script before opening WhatsApp
        die("Database update failed. Please check your connection.");
    }

    /* =========================================
       STEP 3: WHATSAPP API REDIRECT
       ========================================= */
    // Ensure the message is perfectly URL encoded for the browser
    $wa_url = "https://api.whatsapp.com/send?phone=" . $clean_phone . "&text=" . urlencode($message);
    
    // Redirect the browser to WhatsApp
    header("Location: " . $wa_url);
    exit();

} else {
    // Fallback if the file is accessed directly without parameters
    echo "Error: Missing phone number or message parameters.";
}
?>