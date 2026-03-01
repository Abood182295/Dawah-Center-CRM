<?php include('lang.php'); ?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>" dir="<?php echo ($lang == 'ar' ? 'rtl' : 'ltr'); ?>">
<head>
    <meta charset="UTF-8">
    <title><?php echo $text['reg_header']; ?></title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f0f2f5; display: flex; justify-content: center; padding-top: 50px; }
        .card { background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); width: 100%; max-width: 400px; }
        .back-link { display: block; margin-bottom: 15px; text-decoration: none; color: #007bff; font-size: 0.9em; }
        input, select, button { width: 100%; padding: 12px; margin: 10px 0; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; }
        button { background: #28a745; color: white; border: none; font-weight: bold; cursor: pointer; }
        button:hover { background: #218838; }
    </style>
</head>
<body>
    <div class="card">
        <a href="index.php" class="back-link">← <?php echo ($lang == 'ar' ? 'العودة للرئيسية' : 'Back to Dashboard'); ?></a>
        <h2><?php echo $text['reg_header']; ?></h2>
        
        <form action="save_customer.php" method="POST">
            <label><?php echo $text['lbl_name']; ?></label>
            <input type="text" name="full_name" required>
            
            <label><?php echo $text['lbl_phone']; ?></label>
            <input type="text" name="phone_number" required>
            
            <label><?php echo $text['lbl_cat']; ?></label>
            <select name="category">
                <option value="General"><?php echo $text['opt_gen']; ?></option>
                <option value="Offer"><?php echo $text['opt_off']; ?></option>
                <option value="Volunteer"><?php echo $text['opt_vln']; ?></option>
                <option value="Dawah"><?php echo $text['opt_dawah']; ?></option>
            </select>
            
            <button type="submit" name="submit"><?php echo $text['btn_save']; ?></button>
        </form>
    </div>
</body>
</html>