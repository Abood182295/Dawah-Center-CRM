<?php 
include('db_connection.php'); 
include('lang.php'); 

// --- 1. POST HANDLER: Save the changes when the form is submitted ---
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = intval($_POST['id']); 
    $full_name = trim($_POST['full_name']); 
    $phone_number = trim($_POST['phone_number']);
    $category = trim($_POST['category']);

    // Update statement
    $stmt = $conn->prepare("UPDATE beneficiaries SET full_name = ?, phone_number = ?, category = ? WHERE id = ?");
    $stmt->bind_param("sssi", $full_name, $phone_number, $category, $id);

    if ($stmt->execute()) {
        header("Location: view_beneficiary.php?status=updated");
        exit(); 
    } else {
        echo "<div style='color:red; text-align:center; padding:10px;'>Error: " . $conn->error . "</div>";
    }
    $stmt->close();
}

// --- 2. GET HANDLER: Load the existing data when the page first opens ---
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    $stmt = $conn->prepare("SELECT * FROM beneficiaries WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $beneficiary = $result->fetch_assoc(); 
    } else {
        header("Location: view_beneficiary.php");
        exit();
    }
    $stmt->close();
} else {
    // Redirect if someone tries to access this page without an ID
    header("Location: view_beneficiary.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="<?php echo $lang; ?>" dir="<?php echo ($lang == 'ar' ? 'rtl' : 'ltr'); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $text['edit_title']; ?></title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        html { font-size: clamp(16px, 2vw, 18px); }
        body { 
            font-family: system-ui, -apple-system, 'Noto Sans Arabic', sans-serif; 
            background: #f4f7f6;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23007bff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E"); 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            min-height: 100vh;
            padding: 20px; 
        }

        .form-container { 
            background: #fff; 
            padding: clamp(20px, 5vw, 40px); 
            border-radius: 12px; 
            width: 100%;
            max-width: 500px; 
            box-shadow: 0 8px 16px rgba(0.57,0.57,0.57,0.57); 
        }

        h2 { margin-bottom: 25px; color: #2c3e50; font-size: clamp(24px, 4vw, 32px); text-align: center; }

        label { display: block; margin-bottom: 8px; font-weight: 600; color: #444; }

        input, select { 
            width: 100%; padding: 14px; margin-bottom: 20px; 
            border: 1.5px solid #ccc; border-radius: 8px; 
            font-size: 1rem; font-family: inherit; transition: all 0.3s ease;
        }

        input:focus, select:focus {
            outline: none; border-color: #007bff; box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.15);
        }

        .save-btn { 
            background: #007bff; color: white; border: none; padding: 15px; 
            width: 100%; border-radius: 8px; cursor: pointer; 
            font-weight: bold; font-size: 1.1rem; transition: background 0.3s ease;
        }
        .save-btn:hover { background: #0056b3; }

        .back-link { 
            display: inline-block; margin-top: 20px; text-decoration: none; 
            color: #6c757d; font-weight: 500; transition: color 0.2s;
            text-align: center; width: 100%;
        }
        .back-link:hover { color: #343a40; }
    </style>
</head>
<body>
    <div class="form-container">
        <h2><?php echo $text['edit_title']; ?></h2>
        
        <form action="edit_beneficiary.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $beneficiary['id']; ?>">

            <label><?php echo $text['lbl_name']; ?></label>
            <input type="text" name="full_name" value="<?php echo htmlspecialchars($beneficiary['full_name']); ?>" required>

            <label><?php echo $text['lbl_phone']; ?></label>
            <input type="tel" name="phone_number" value="<?php echo htmlspecialchars($beneficiary['phone_number']); ?>" 
                   required pattern="\+?[0-9]{7,15}" maxlength="16" dir="ltr">

            <label><?php echo $text['lbl_cat']; ?></label>
            <select name="category">
                <option value="General" <?php if($beneficiary['category'] == 'General') echo 'selected'; ?>><?php echo $text['opt_gen']; ?></option>
                <option value="Lectures" <?php if($beneficiary['category'] == 'Lectures') echo 'selected'; ?>><?php echo $text['opt_lectures']; ?></option>
                <option value="Projects" <?php if($beneficiary['category'] == 'Projects') echo 'selected'; ?>><?php echo $text['opt_projects']; ?></option>
                <option value="Library" <?php if($beneficiary['category'] == 'Library') echo 'selected'; ?>><?php echo $text['opt_library']; ?></option>
            </select>

            <button type="submit" class="save-btn"><?php echo $text['update_btn']; ?></button>
        </form>
        
        <a href="view_beneficiary.php" class="back-link" style="text-decoration: none; color: #007bff; font-weight: 600; display: inline-block; margin-top: 15px;">
            <?php echo ($lang == 'ar' ? '→ ' . $text['back_to_db'] : '← ' . $text['back_to_db']); ?>
        </a>
    </div>
</body>
</html>