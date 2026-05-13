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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo ($lang == 'ar' ? 'قائمة الإرسال المختارة' : 'Selected Dispatch List'); ?></title>
    <style>
        /* Global Reset & Fluid Typography */
        * { box-sizing: border-box; margin: 0; padding: 0; }
        html { font-size: clamp(16px, 2vw, 18px); }
        
        body { 
            font-family: system-ui, -apple-system, 'Segoe UI', sans-serif; 
            background: #f0f2f5; 
            padding: clamp(15px, 4vw, 40px); /* Safe padding for mobile */
            display: flex;
            justify-content: center;
            /* Note: No vertical centering here so long lists can scroll naturally */
        }

        .dispatch-card { 
            background: white; 
            padding: clamp(20px, 5vw, 40px); 
            border-radius: 12px; 
            width: 100%;
            max-width: 600px; 
            box-shadow: 0 8px 16px rgba(0,0,0,0.08); 
        }

        h2 {
            color: #2c3e50;
            margin-bottom: 5px;
            font-size: clamp(22px, 4vw, 28px);
        }

        .subtitle {
            color: #6c757d;
            font-weight: 500;
            margin-bottom: 20px;
        }

        .beneficiary-row { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            padding: 15px 0; 
            border-bottom: 1px solid #eee;
            flex-wrap: wrap; /* Allows stacking on very narrow screens */
            gap: 10px;
        }

        .beneficiary-row:last-child {
            border-bottom: none;
        }

        .phone-number {
            font-weight: 600;
            color: #333;
            font-size: 1.1rem;
        }

        /* Touch-Friendly WhatsApp Button */
        .whatsapp-btn { 
            background: #25D366; 
            color: white; 
            padding: 12px 20px; 
            border-radius: 8px; 
            text-decoration: none; 
            font-weight: bold; 
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 0.95rem;
        }
        
        .whatsapp-btn:hover { 
            background: #128C7E; 
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(37, 211, 102, 0.3);
        }
        
        .whatsapp-btn:active {
            transform: translateY(0);
        }

        /* Shows the supervisor which links they already clicked */
        .whatsapp-btn:visited { 
            background: #075e54; 
            opacity: 0.7; 
        }

        .back-link { 
            display: block; 
            margin-top: 30px; 
            text-decoration: none; 
            color: #6c757d; 
            font-weight: 500;
            text-align: center;
            transition: color 0.2s;
        }
        
        .back-link:hover { 
            color: #343a40; 
        }
    </style>
</head>
<body>
    <div class="dispatch-card">
        <h2><?php echo ($lang == 'ar' ? 'تجهيز الرسائل' : 'Ready to Send'); ?></h2>
        <p class="subtitle"><?php echo count($numbers); ?> <?php echo ($lang == 'ar' ? 'عملاء تم اختيارهم' : 'beneficiarys selected'); ?></p>
        
        <hr style="border: 0; border-top: 1px solid #eee; margin-bottom: 10px;">

        <?php foreach ($numbers as $num): ?>
            <div class="beneficiary-row">
                <span class="phone-number" dir="ltr"><?php echo htmlspecialchars($num); ?></span>
                
                <a href="log_and_send.php?phone=<?php echo urlencode($num); ?>&message=<?php echo $message; ?>"
                   target="_blank" 
                   class="whatsapp-btn">
                   💬 <?php echo ($lang == 'ar' ? 'إرسال وتسجيل' : 'Send & Log'); ?>
                </a>
            </div>
        <?php endforeach; ?>

        <a href="broadcast.php" class="back-link">
            <?php echo ($lang == 'ar' ? '→ العودة للتعديل' : '← Back to Selection'); ?>
        </a>
    </div>
</body>
</html>

<?php 
} else {
    // If no numbers were selected, send them back with a reminder
    echo "<script>alert('" . ($lang == 'ar' ? 'يرجى اختيار عميل واحد على الأقل' : 'Please select at least one beneficiary') . "'); window.location.href='broadcast.php';</script>";
}
?>