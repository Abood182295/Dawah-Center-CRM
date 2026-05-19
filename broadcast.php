<?php
session_start();
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header("Location: login.php?redirect=broadcast.php");
    exit();
}

include('db_connection.php'); 
include('lang.php'); 

// Fetch beneficiaries for the selection list
$result = $conn->query("SELECT id, full_name, phone_number, category FROM beneficiaries ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="<?php echo $lang; ?>" dir="<?php echo ($lang == 'ar' ? 'rtl' : 'ltr'); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo ($lang == 'ar' ? 'إرسال رسالة جماعية' : 'Broadcast Message'); ?></title>
    <style>
        /* Global Reset & Fluid Typography */
        * { box-sizing: border-box; margin: 0; padding: 0; }
        html { font-size: clamp(16px, 2vw, 18px); }
        
        body { 
            font-family: system-ui, -apple-system, 'Segoe UI', sans-serif; 
            background: #f0f2f5; 
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23007bff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            padding: clamp(15px, 4vw, 40px);
            display: flex;
            justify-content: center;
        }

        .broadcast-card { 
            background: white; 
            padding: clamp(20px, 5vw, 40px); 
            border-radius: 12px; 
            width: 100%;
            max-width: 800px; /* Wider to accommodate the table and text area nicely */
            box-shadow: 0 8px 16px rgba(0,0,0,0.08); 
        }

        h2 {
            color: #2c3e50;
            margin-bottom: 20px;
            font-size: clamp(22px, 4vw, 28px);
            text-align: center;
        }

        /* Message Text Area Styling */
        .message-container {
            margin-bottom: 25px;
        }

        textarea {
            width: 100%;
            padding: 15px;
            border: 1.5px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            font-family: inherit;
            resize: vertical;
            min-height: 120px;
            transition: all 0.3s ease;
        }

        textarea:focus {
            outline: none;
            border-color: #25D366;
            box-shadow: 0 0 0 3px rgba(37, 211, 102, 0.15);
        }

        /* beneficiary Selection Table Wrapper */
        .table-responsive {
            width: 100%;
            overflow-x: auto;
            border-radius: 6px;
            box-shadow: 0 0 0 1px #ddddddbb;
            margin-bottom: 40px;
        }

        table { 
            width: 100%; 
            border-collapse: collapse; 
            min-width: 500px; 
        }
        
        th, td { border: 1px solid #00ff00; padding: 12px; text-align: inherit; }
        th { background-color: #007bff; color: black; }
        tr:nth-child(even) { background-color: #f9f9f9; }

        /* Custom Checkbox for Better Touch Targets */
        input[type="checkbox"] {
            width: 20px;
            height: 20px;
            cursor: pointer;
        }

        .submit-btn { 
            background: #25D366; 
            color: gold; 
            border: none; 
            padding: 15px; 
            width: 100%; 
            border-radius: 8px; 
            cursor: pointer; 
            font-weight: bold; 
            font-size: 1.1rem;
            transition: background 0.3s ease;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }

        .submit-btn:hover { 
            background: #1dad00; 
        }

        .back-link { 
            display: block; 
            margin-top: 20px; 
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
    <div class="broadcast-card">
        <h2><?php echo ($lang == 'ar' ? 'إرسال رسالة جماعية' : 'Broadcast Message'); ?></h2>
        
        <form action="dispatch_list.php" method="POST">
            
            <div class="message-container">
                <textarea name="message" required 
                          placeholder="<?php echo ($lang == 'ar' ? 'اكتب نص العرض هنا...' : 'Type your message here...'); ?>"></textarea>
            </div>

            <h3 style="margin-bottom: 15px; color: #444; font-size: 1.1rem;">
                <?php echo ($lang == 'ar' ? 'اختر العملاء:' : 'Select beneficiarys:'); ?>
            </h3>

            <div class="table-responsive">
                <table>
                    <tr>
                        <th style="width: 50px; text-align: center;">✅</th>
                        <th><?php echo $text['lbl_name']; ?></th>
                        <th><?php echo $text['lbl_phone']; ?></th>
                        <th><?php echo $text['lbl_cat']; ?></th>
                    </tr>
                    
                    <?php
                    if ($result && $result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            // Map categories for translation
                            $cat_raw = $row['category'];
                            $cat_key = 'opt_' . strtolower($cat_raw == 'Offer' ? 'off' : ($cat_raw == 'Volunteer' ? 'vln' : $cat_raw));
                            $display_cat = isset($text[$cat_key]) ? $text[$cat_key] : $cat_raw;

                            echo "<tr>";
                            echo "<td style='text-align: center;'>
                                    <input type='checkbox' name='selected_numbers[]' value='" . htmlspecialchars($row['phone_number']) . "'>
                                  </td>";
                            echo "<td>" . htmlspecialchars($row['full_name']) . "</td>";
                            echo "<td dir='ltr'>" . htmlspecialchars($row['phone_number']) . "</td>";
                            echo "<td>" . $display_cat . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4' style='text-align: center; color: gray;'>" . ($lang == 'ar' ? 'لا يوجد عملاء' : 'No beneficiarys found') . "</td></tr>";
                    }
                    ?>
                </table> 
            </div>
            
            <button type="submit" class="submit-btn">
                💬 <?php echo ($lang == 'ar' ? 'متابعة للإرسال' : 'Proceed to Dispatch'); ?>
            </button>
        </form>

        <a href="index.php" class="back-link">
            <?php echo ($lang == 'ar' ? '→ العودة للرئيسية' : '← Back to Dashboard'); ?>
        </a>
    </div>
</body>
</html>