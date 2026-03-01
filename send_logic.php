<?php
include('db_connection.php'); // Confirmed on port 3307
include('lang.php');

// We check for 'selected_numbers' which is the array from your checkboxes
if (isset($_POST['selected_numbers']) && isset($_POST['message'])) {
    $message = urlencode($_POST['message']);
    $numbers = $_POST['selected_numbers']; // This is now an array of checked numbers
?>

<!DOCTYPE html>
<html lang="<?php echo $lang; ?>" dir="<?php echo ($lang == 'ar' ? 'rtl' : 'ltr'); ?>">
<head>
    <meta charset="UTF-8">
    <title><?php echo ($lang == 'ar' ? 'قائمة الإرسال المختارة' : 'Selected Dispatch List'); ?></title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f0f2f5; padding: 20px; }
        .dispatch-card { background: white; padding: 25px; border-radius: 12px; max-width: 500px; margin: auto; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        .customer-row { display: flex; justify-content: space-between; align-items: center; padding: 12px; border-bottom: 1px solid #eee; }
        .whatsapp-btn { background: #25D366; color: white; padding: 10px 18px; border-radius: 6px; text-decoration: none; font-weight: bold; transition: 0.3s; }
        .whatsapp-btn:hover { background: #128C7E; }
        .whatsapp-btn:visited { background: #075e54; opacity: 0.6; } /* Shows which ones were clicked */
    </style>
</head>
<body>
    <div class="dispatch-card">
        <h2><?php echo ($lang == 'ar' ? 'تجهيز الرسائل' : 'Ready to Send'); ?></h2>
        <p><?php echo count($numbers); ?> <?php echo ($lang == 'ar' ? 'عملاء تم اختيارهم' : 'customers selected'); ?></p>
        
        <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">

        <?php foreach ($numbers as $num): ?>
            <div class="customer-row">
                <span><strong><?php echo $num; ?></strong></span>
                <a href="log_and_send.php?phone=<?php echo $num; ?>&message=<?php echo $message; ?>"
                   target="_blank" 
                   class="whatsapp-btn">
                  <?php echo ($lang == 'ar' ? 'إرسال وتسجيل' : 'Send & Log'); ?>
                </a>
            </div>
        <?php endforeach; ?>

        <div style="margin-top: 25px;">
            <a href="broadcast.php" style="color: #666; text-decoration: none; font-size: 0.9em;">
                <?php echo ($lang == 'ar' ? '← العودة للتعديل' : '← Back to Selection'); ?>
            </a>
        </div>
    </div>
</body>
</html>

<?php 
} else {
    // If no numbers were selected, send them back with a reminder
    echo "<script>alert('" . ($lang == 'ar' ? 'يرجى اختيار عميل واحد على الأقل' : 'Please select at least one customer') . "'); window.location.href='broadcast.php';</script>";
}
?>