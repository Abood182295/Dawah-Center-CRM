<?php 
// 1. Check if the session is running
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Destroy the security badge! 
// (We use unset so we don't delete your Arabic/English language memory)
if (isset($_SESSION['authenticated'])) {
    unset($_SESSION['authenticated']);
}
include('lang.php'); ?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>" dir="<?php echo ($lang == 'ar' ? 'rtl' : 'ltr'); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $text['title']; ?></title>
    <style>
    body { 
        font-family: sans-serif; 
        text-align: center; 
        padding: 50px; 
        
        /* THE PREMIUM BACKGROUND */
        background-color: #f4f7f6;
        background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23007bff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    .lang-switch { 
        position: absolute; 
        top: 20px; 
        right: 20px; 
        background: #fff; 
        padding: 10px; 
        border-radius: 3px; 
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.67); 
        text-decoration: none; 
        color: #007bff; 
    }

    .menu-card { 
        background: lightgray; 
        padding: 30px; 
        border-radius: 20px 20px 20px 20px; 
        display: inline-block; 
        width: 250px; 
        margin: 10px; 
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.97); 
        text-decoration: none; 
        color: #333; 
        vertical-align: sid; 
    }

    .menu-card:hover { 
        transform: translateY(-10px); 
        transition: 0.3s; 
        background: #e9efec; 
    }

    h1 { 
    background: linear-gradient(90deg, #0056b3 50%, #00d2ff 100%);
    
    -webkit-background-clip: text;
    background-clip: text;
    
    -webkit-text-fill-color: transparent;
    color: transparent; 
    font-size: clamp(28px, 5vw, 36px);
    font-family:  'playfair display', serif;
    margin-bottom: 10px; 
}
</style>

<body>
    <a href="?lang=<?php echo ($lang == 'en' ? 'ar' : 'en'); ?>" class="lang-switch">
        <?php echo $text['switch']; ?>
    </a>

    <h1 style="color: #007bff; margin-bottom: 10px;">
        <?php echo $text['title']; ?>
    </h1>
    <p><?php echo $text['welcome']; ?></p>

    <a href="add_beneficiary.php" class="menu-card">
        <h3>➕ <?php echo $text['add_cust']; ?></h3>
        <p><?php echo $text['add_desc']; ?></p>
    </a>

    <a href="view_beneficiary.php" class="menu-card">
        <h3>📋 <?php echo $text['view_db']; ?></h3>
        <p><?php echo $text['view_desc']; ?></p>
    </a>

    <a href="broadcast.php" class="menu-card" style="opacity: 1;">
        <h3>💬 <?php echo $text['send_msg']; ?></h3>
        <p><?php echo ($lang == 'ar' ? 'إرسال الرسائل الجماعية' : 'Send group messages'); ?></p>
    </a>
</body>
</html>