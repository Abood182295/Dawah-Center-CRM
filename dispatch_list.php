<?php
include('db_connection.php'); 
include('lang.php');

// This file catches the array of numbers you checked in broadcast.php
if (isset($_POST['selected_numbers']) && isset($_POST['message'])) {
    $message = urlencode($_POST['message']);
    $numbers = $_POST['selected_numbers']; 
?>

<!DOCTYPE html>
<html lang="<?php echo $lang; ?>" dir="<?php echo ($lang == 'ar' ? 'rtl' : 'ltr'); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo ($lang == 'ar' ? 'قائمة الإرسال' : 'Dispatch List'); ?></title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        html { font-size: clamp(16px, 2vw, 18px); }
        body { font-family: system-ui, sans-serif; background: #f0f2f5;  padding: 20px; display: flex; justify-content: center; }
        .dispatch-card { background: white; padding: 30px; border-radius: 12px; width: 100%; max-width: 550px; box-shadow: 0 8px 16px rgba(0,0,0,0.08); }
        .beneficiary-row { display: flex; justify-content: space-between; align-items: center; padding: 15px 0; border-bottom: 1px solid #eee; flex-wrap: wrap; gap: 10px; }
        .whatsapp-btn { background: #25D366; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: bold; font-size: 0.9rem; }
    </style>
</head>
<body>
    <div class="dispatch-card">
        <h2 style="margin-bottom: 10px;"><?php echo ($lang == 'ar' ? 'تجهيز الرسائل' : 'Ready to Send'); ?></h2>
        <p style="color: #666; margin-bottom: 20px;"><?php echo count($numbers); ?> <?php echo ($lang == 'ar' ? 'عملاء مختارين' : 'beneficiarys selected'); ?></p>
        
        <?php foreach ($numbers as $num): ?>
            <div class="beneficiary-row">
                <span style="font-weight: 600;" dir="ltr"><?php echo htmlspecialchars($num); ?></span>
                <a href="log_and_send.php?phone=<?php echo urlencode($num); ?>&message=<?php echo $message; ?>" target="_blank" class="whatsapp-btn">
                   💬 <?php echo ($lang == 'ar' ? 'إرسال وتسجيل' : 'Send & Log'); ?>
                </a>
            </div>
        <?php endforeach; ?>

        <a href="broadcast.php" style="display: block; margin-top: 25px; text-align: center; color: #007bff; text-decoration: none; font-weight: 500;">
            <?php echo ($lang == 'ar' ? '← العودة للتعديل' : '← Back to Selection'); ?>
        </a>
    </div>
</body>
</html>

<?php 
} else {
    // If someone tries to open this file without selecting numbers, send them back
    header("Location: broadcast.php");
    exit();
}
?>