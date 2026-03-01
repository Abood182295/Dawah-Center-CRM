<?php include('lang.php'); ?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>" dir="<?php echo ($lang == 'ar' ? 'rtl' : 'ltr'); ?>">
<head>
    <meta charset="UTF-8">
    <title><?php echo $text['title']; ?></title>
    <style>
        body { font-family: sans-serif; text-align: center; background: #f4f4f4; padding: 50px; }
        .lang-switch { position: absolute; top: 20px; right: 20px; background: #fff; padding: 10px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); text-decoration: none; color: #007bff; }
        .menu-card { background: white; padding: 30px; border-radius: 10px; display: inline-block; width: 250px; margin: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); text-decoration: none; color: #333; vertical-align: top; }
        .menu-card:hover { transform: translateY(-5px); transition: 0.3s; background: #e9ecef; }
        h1 { color: #007bff; }
    </style>
</head>
<body>
    <a href="?lang=<?php echo ($lang == 'en' ? 'ar' : 'en'); ?>" class="lang-switch">
        <?php echo $text['switch']; ?>
    </a>

    <h1><?php echo $text['title']; ?></h1>
    <p><?php echo $text['welcome']; ?></p>

    <a href="add_customer.php" class="menu-card">
        <h3>➕ <?php echo $text['add_cust']; ?></h3>
        <p><?php echo $text['add_desc']; ?></p>
    </a>

    <a href="view_customers.php" class="menu-card">
        <h3>📋 <?php echo $text['view_db']; ?></h3>
        <p><?php echo $text['view_desc']; ?></p>
    </a>

    <a href="broadcast.php" class="menu-card" style="opacity: 1;">
        <h3>💬 <?php echo $text['send_msg']; ?></h3>
        <p><?php echo ($lang == 'ar' ? 'إرسال الرسائل الجماعية' : 'Send group messages'); ?></p>
    </a>
</body>
</html>