<?php 
include('db_connection.php'); 
include('lang.php'); 

$selected_cat = isset($_GET['category']) ? $_GET['category'] : 'All';
if ($selected_cat == 'All') {
    $query = "SELECT * FROM customers WHERE status = 'Active'";
} else {
    $query = "SELECT * FROM customers WHERE category = '$selected_cat' AND status = 'Active'";
}
$result = $conn->query($query);
$numbers = [];
while($row = $result->fetch_assoc()) {
    $numbers[] = $row['phone_number'];
}
?>

<!DOCTYPE html>
<html lang="<?php echo $lang; ?>" dir="<?php echo ($lang == 'ar' ? 'rtl' : 'ltr'); ?>">
<head>
    <meta charset="UTF-8">
    <title><?php echo $text['send_msg']; ?></title>
    <style>
        body { font-family: sans-serif; background: #f4f7f6; padding: 40px; }
        .box { background: #fff; padding: 25px; border-radius: 12px; max-width: 600px; margin: auto; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        textarea { width: 100%; height: 150px; padding: 10px; margin-top: 15px; border-radius: 8px; border: 1px solid #ccc; box-sizing: border-box; }
        .send-btn { background: #25D366; color: white; border: none; padding: 15px; width: 100%; border-radius: 8px; font-weight: bold; margin-top: 10px; cursor: pointer; }
    </style>
</head>
<body>
    <style>
    .flex-container { display: flex; gap: 20px; flex-wrap: wrap; justify-content: center; }
    .phone-mockup { 
        width: 300px; height: 500px; border: 12px solid #333; border-radius: 36px; 
        background: #ece5dd; position: relative; overflow: hidden; 
    }
    .chat-header { background: #075e54; color: white; padding: 10px; font-size: 0.8em; text-align: center; }
    .message-bubble { 
        background: #dcf8c6; padding: 10px; border-radius: 8px; margin: 10px; 
        max-width: 80%; font-size: 0.9em; position: relative; word-wrap: break-word;
        box-shadow: 0 1px 1px rgba(0,0,0,0.1);
    }
    /* Layout fix for RTL/LTR */
    <?php echo ($lang == 'ar' ? '.message-bubble { float: right; }' : '.message-bubble { float: left; }'); ?>
</style>

<div class="flex-container">
    <div class="box" style="flex: 1; min-width: 350px;">
        <h2><?php echo $text['broadcast_header']; ?></h2>
        <form action="send_logic.php" method="POST">
            <textarea id="messageInput" name="message" placeholder="<?php echo $text['msg_placeholder']; ?>" required oninput="updatePreview()"></textarea>
            <button type="submit" class="send-btn"><?php echo $text['send_btn']; ?></button>
        </form>
    </div>

    <div class="phone-mockup">
        <div class="chat-header"><?php echo $text['preview_header']; ?></div>
        <div id="previewBubble" class="message-bubble">
            <?php echo ($lang == 'ar' ? 'نص المعاينة سيظهر هنا...' : 'Preview text will appear here...'); ?>
        </div>
    </div>
</div>
    <div style="margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 10px;">
    <strong><?php echo $text['select_cat']; ?>:</strong>
    <a href="?category=All" style="margin: 0 10px;">[ <?php echo ($lang == 'ar' ? 'الكل' : 'All'); ?> ]</a>
    <a href="?category=Offer" style="margin: 0 10px;">[ <?php echo $text['opt_off']; ?> ]</a>
    <a href="?category=Dawah" style="margin: 0 10px;">[ <?php echo $text['opt_dawah']; ?> ]</a>
    <a href="?category=Volunteer" style="margin: 0 10px;">[ <?php echo $text['opt_vln']; ?> ]</a>
</div>

<h2><?php echo $text['broadcast_header']; ?> (<?php echo $selected_cat; ?>)</h2>
<p><?php echo $text['count_label'] . count($numbers); ?></p>
    <div class="box">
        <h2><?php echo $text['broadcast_header']; ?></h2>
        <p><?php echo $text['count_label'] . count($numbers); ?></p>

<form action="send_logic.php" method="POST">
    <input type="hidden" name="numbers" value="<?php echo implode(',', $numbers); ?>">
    <textarea name="message" id="messageInput" placeholder="<?php echo $text['msg_placeholder']; ?>" required oninput="updatePreview()"></textarea>
    <button type="submit" class="send-btn"><?php echo $text['send_btn']; ?></button>

    <div style="background: white; padding: 15px; border-radius: 8px; border: 1px solid #ddd; margin-bottom: 20px;">
    <label style="font-weight: bold; cursor: pointer;">
        <input type="checkbox" id="selectAll" checked onclick="toggleAll(this)"> 
        <?php echo ($lang == 'ar' ? 'تحديد الكل' : 'Select All'); ?>
    </label>
    <hr>
    <div style="max-height: 200px; overflow-y: auto; text-align: <?php echo ($lang == 'ar' ? 'right' : 'left'); ?>;">
        <?php 
        // Re-running the query to get names for the checkboxes
        $result = $conn->query($query); 
        while($row = $result->fetch_assoc()): 
        ?>
            <div style="padding: 5px 0; border-bottom: 1px solid #eee;">
                <label style="cursor: pointer;">
                    <input type="checkbox" name="selected_numbers[]" 
                           value="<?php echo $row['phone_number']; ?>" 
                           class="cust-check" checked>
                    <span><?php echo $row['full_name']; ?> (<?php echo $row['phone_number']; ?>)</span>
                </label>
            </div>
        <?php endwhile; ?>
    </div>
</div>
</form>
    </div>
    <div style="padding: 10px 20px;">
    <a href="index.php" style="text-decoration: none; color: #007bff; font-weight: bold; font-size: 1.1em;">
        <?php echo ($lang == 'ar' ? '← العودة للرئيسية' : '← Back to Dashboard'); ?>
    </a>
</div>

<hr style="border: 0; border-top: 1px solid #eee; margin-bottom: 20px;">
    <script>
function toggleAll(source) {
    let checkboxes = document.getElementsByClassName('cust-check');
    for(let i=0; i < checkboxes.length; i++) {
        checkboxes[i].checked = source.checked;
    }
}        
function updatePreview() {
    const input = document.getElementById('messageInput');
    const preview = document.getElementById('previewBubble');
    
    // Replace newlines with <br> to show line breaks in preview
    preview.innerHTML = input.value.replace(/\n/g, '<br>') || '...';
}
</script>
</body>
</html>