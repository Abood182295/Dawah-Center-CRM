<?php include('lang.php'); ?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>" dir="<?php echo ($lang == 'ar' ? 'rtl' : 'ltr'); ?>">
<head>
    <meta charset="UTF-8">
    <title><?php echo $text['import_title']; ?></title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f4f7f6; padding: 40px; }
        .import-box { background: white; padding: 30px; border-radius: 12px; max-width: 500px; margin: auto; box-shadow: 0 4px 10px rgba(0,0,0,0.1); text-align: center; }
        input[type="file"] { margin: 20px 0; border: 1px dashed #007bff; padding: 20px; width: 100%; border-radius: 8px; }
        .btn-import { background: #28a745; color: white; border: none; padding: 12px 25px; border-radius: 6px; cursor: pointer; font-weight: bold; }
    </style>
</head>
<body>
    <div class="import-box">
    <h2><?php echo $text['import_title']; ?></h2>
    
    <div style="background: #e9ecef; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
        <p style="margin-bottom: 10px; font-size: 0.9em; color: #495057;">
            <?php echo ($lang == 'ar' ? 'يرجى تحميل النموذج وتعبئته ثم رفعه هنا:' : 'Please download the template, fill it out, then upload it here:'); ?>
        </p>
        <a href="download_template.php" style="color: #007bff; font-weight: bold; text-decoration: none; border-bottom: 1px dashed #007bff;">
            📥 <?php echo ($lang == 'ar' ? 'تحميل نموذج Excel (CSV)' : 'Download CSV Template'); ?>
        </a>
    </div>

    <form action="process_import.php" method="POST" enctype="multipart/form-data">
        </form>
</div>
    <div class="import-box">
        <h2><?php echo $text['import_title']; ?></h2>
        <p><?php echo ($lang == 'ar' ? 'يجب أن يحتوي الملف على: الاسم، الهاتف، الفئة' : 'File must have: Name, Phone, Category'); ?></p>
        
        <form action="process_import.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="csv_file" accept=".csv" required>
            <br>
            <button type="submit" class="btn-import"><?php echo $text['btn_upload']; ?></button>
        </form>
        <br>
        <a href="index.php"><?php echo $text['back']; ?></a>
    </div>
</body>
</html>