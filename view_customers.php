<?php 
include('db_connection.php'); // Running on port 3307
include('lang.php'); 

// 1. Define search and filter variables at the top to avoid "Undefined" warnings
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'All';
// 2. Build the Dynamic SQL Query
$sql = "SELECT * FROM customers WHERE (full_name LIKE '%$search%' OR phone_number LIKE '%$search%')";
if ($filter != 'All') {
    $sql .= " AND category = '$filter'";
}
$sql .= " ORDER BY created_at DESC";
$result = $conn->query($sql);
$total_rows = $result->num_rows;
?>

<!DOCTYPE html>
<html lang="<?php echo $lang; ?>" dir="<?php echo ($lang == 'ar' ? 'rtl' : 'ltr'); ?>">
<head>
    <meta charset="UTF-8">
    <title><?php echo $text['view_db']; ?></title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f4f7f6; padding: 20px; }
        .container { background: #fff; padding: 20px; border-radius: 8px; max-width: 1000px; margin: auto; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .back-link { text-decoration: none; color: #007bff; margin-bottom: 20px; display: inline-block; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: inherit; }
        th { background-color: #007bff; color: white; }
        tr:nth-child(even) { background-color: #f9f9f9; }

        /* Print Media Query - Professional Reporting */
        @media print {
            .back-link, .search-form, .action-links, .btn-print-container {
                display: none !important;
            }
            table { width: 100%; border-collapse: collapse; }
            body { background: white; padding: 0; }
            .container { box-shadow: none; border: none; width: 100%; max-width: 100%; }
            th { background-color: #eee !important; color: black !important; border: 1px solid #333; }
            td { border: 1px solid #333; }
        }
        @keyframes fadeIn {
         from { opacity: 0; transform: translateY(-5px); }
          to { opacity: 1; transform: translateY(0); }
        }
       .fade-counter {
         animation: fadeIn 0.8s ease-out;
         background: #e9ecef;
         padding: 5px 12px;
         border-radius: 20px;
         font-size: 0.9em;
        }
    </style>
</head>
<body>

<div class="container">
    <a href="index.php" class="back-link">← <?php echo $text['back']; ?></a>
    <h2><?php echo $text['view_db']; ?></h2>

    <form method="GET" class="search-form" style="display: flex; gap: 10px; margin-bottom: 20px;">
        <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" 
               placeholder="<?php echo $text['search_placeholder']; ?>" 
               style="flex: 2; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
        
        <select name="filter" style="flex: 1; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
            <option value="All"><?php echo $text['all_cats']; ?></option>
            <option value="General" <?php if($filter == 'General') echo 'selected'; ?>><?php echo $text['opt_gen']; ?></option>
            <option value="Offer" <?php if($filter == 'Offer') echo 'selected'; ?>><?php echo $text['opt_off']; ?></option>
            <option value="Dawah" <?php if($filter == 'Dawah') echo 'selected'; ?>><?php echo $text['opt_dawah']; ?></option>
            <option value="Volunteer" <?php if($filter == 'Volunteer') echo 'selected'; ?>><?php echo $text['opt_vln']; ?></option>
        </select>

        <button type="submit" style="padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">
            <?php echo $text['filter_btn']; ?>
        </button>
    </form>

<div class="btn-print-container" style="display: flex; gap: 10px; justify-content: flex-end; align-items: center; margin-bottom: 15px;">
    
    <div class="fade-counter" style="margin-right: auto; font-weight: bold; color: #555;">
        <?php 
            if ($lang == 'ar') {
                echo "إجمالي السجلات: " . $total_rows;
            } else {
                echo "Total Records: " . $total_rows;
            }
        ?>
    </div>

    <a href="export_excel.php" style="background: #217346; color: white; text-decoration: none; padding: 10px 20px; border-radius: 4px; font-weight: bold; display: flex; align-items: center; gap: 8px;">
        📊 <?php echo $text['btn_export']; ?>
    </a>

    <button onclick="window.print()" style="background: #28a745; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; font-weight: bold; display: flex; align-items: center; gap: 8px;">
        🖨️ <?php echo $text['btn_print']; ?>
    </button>
</div>

    <table>
        <tr>
            <th><?php echo $text['lbl_name']; ?></th>
            <th><?php echo $text['lbl_phone']; ?></th>
            <th><?php echo $text['lbl_cat']; ?></th>
            <th><?php echo $text['date']; ?></th>
            <th class="action-links"><?php echo ($lang == 'ar' ? 'إجراءات' : 'Actions'); ?></th>
            <th><?php echo ($lang == 'ar' ? 'آخر مراسلة' : 'Last Messaged'); ?></th>
        </tr>
         
        <td>
            
        <?php
while($row = $result->fetch_assoc()) {
        $cat_raw = $row['category'];
        $cat_key = 'opt_' . strtolower($cat_raw == 'Offer' ? 'off' : ($cat_raw == 'Volunteer' ? 'vln' : $cat_raw));
        $display_cat = isset($text[$cat_key]) ? $text[$cat_key] : $cat_raw;

        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['full_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['phone_number']) . "</td>";
        echo "<td>" . $display_cat . "</td>";
        echo "<td>" . $row['created_at'] . "</td>";
        
        // Actions
        echo "<td class='action-links'>";
        echo "<a href='edit_customer.php?id=" . $row['id'] . "' style='color: green;'>" . $text['edit'] . "</a> | ";
        echo "<a href='delete_customer.php?id=" . $row['id'] . "' style='color: red;' onclick=\"return confirm('" . $text['confirm_delete'] . "')\">" . $text['delete'] . "</a>";
        echo "</td>";

        // Last Messaged Column
        echo "<td>";
        if (!empty($row['last_messaged_at'])) {
            echo date('M d, g:i A', strtotime($row['last_messaged_at']));
        } else {
            echo "<span style='color: gray;'>" . ($lang == 'ar' ? 'لم يراسل بعد' : 'Never') . "</span>";
        }
        echo "</td>";

        echo "</tr>";
    }
    ?>
</table> 
</div>

</body>
</html>