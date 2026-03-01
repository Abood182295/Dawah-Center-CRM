<?php 
include('db_connection.php'); // Still using port 3307
include('lang.php'); 

// Get the customer ID from the URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$result = $conn->query("SELECT * FROM customers WHERE id = $id");
$customer = $result->fetch_assoc();

if (!$customer) {
    die("Customer not found.");
}
?>

<!DOCTYPE html>
<html lang="<?php echo $lang; ?>" dir="<?php echo ($lang == 'ar' ? 'rtl' : 'ltr'); ?>">
<head>
    <meta charset="UTF-8">
    <title><?php echo $text['edit_title']; ?></title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f4f7f6; padding: 40px; }
        .form-container { background: #fff; padding: 30px; border-radius: 12px; max-width: 500px; margin: auto; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        input, select { width: 100%; padding: 12px; margin: 10px 0; border: 1px solid #ccc; border-radius: 6px; box-sizing: border-box; }
        .save-btn { background: #007bff; color: white; border: none; padding: 15px; width: 100%; border-radius: 6px; cursor: pointer; font-weight: bold; }
    </style>
</head>
<body>
    <div class="form-container">
        <h2><?php echo $text['edit_title']; ?></h2>
        <form action="update_customer.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $customer['id']; ?>">

            <label><?php echo $text['lbl_name']; ?></label>
            <input type="text" name="full_name" value="<?php echo htmlspecialchars($customer['full_name']); ?>" required>

            <label><?php echo $text['lbl_phone']; ?></label>
            <input type="text" name="phone_number" value="<?php echo htmlspecialchars($customer['phone_number']); ?>" required>

            <label><?php echo $text['lbl_cat']; ?></label>
            <select name="category">
                <option value="General" <?php if($customer['category'] == 'General') echo 'selected'; ?>><?php echo $text['opt_gen']; ?></option>
                <option value="Offer" <?php if($customer['category'] == 'Offer') echo 'selected'; ?>><?php echo $text['opt_off']; ?></option>
                <option value="Dawah" <?php if($customer['category'] == 'Dawah') echo 'selected'; ?>><?php echo $text['opt_dawah']; ?></option>
                <option value="Volunteer" <?php if($customer['category'] == 'Volunteer') echo 'selected'; ?>><?php echo $text['opt_vln']; ?></option>
            </select>

            <button type="submit" class="save-btn"><?php echo $text['update_btn']; ?></button>
        </form>
        <br>
        <a href="view_customers.php"><?php echo $text['back']; ?></a>
    </div>
</body>
</html>