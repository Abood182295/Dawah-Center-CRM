<?php 
include('db_connection.php'); 
include('lang.php'); 

// Initial load logic (for when the page first opens)
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'All';

$sql = "SELECT * FROM beneficiaries WHERE (full_name LIKE '%$search%' OR phone_number LIKE '%$search%')";
if ($filter != 'All') { $sql .= " AND category = '$filter'"; }
$sql .= " ORDER BY created_at DESC";

$result = $conn->query($sql);
$total_rows = $result->num_rows;
?>

<!DOCTYPE html>
<html lang="<?php echo $lang; ?>" dir="<?php echo ($lang == 'ar' ? 'rtl' : 'ltr'); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $text['view_db']; ?></title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        html { font-size: clamp(14px, 2vw, 16px); }
        body { font-family: system-ui, -apple-system, sans-serif; background: #f4f7f6; padding: 20px; }
        
        .container { 
            background: #fff; padding: 30px; border-radius: 12px; 
            max-width: 1200px; margin: auto; box-shadow: 0 4px 20px rgba(0,0,0,0.05); 
        }

        .back-link { text-decoration: none; color: #007bff; margin-bottom: 20px; display: inline-block; font-weight: 600; }

        /* Modern Search Bar Area */
        .search-area {
            display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 25px;
            background: #f8f9fa; padding: 20px; border-radius: 10px; align-items: center;
        }

        .search-area input, .search-area select {
            padding: 12px; border: 1px solid #ddd; border-radius: 8px; flex: 1; min-width: 200px; font-size: 1rem;
        }

        .btn-action-group { display: flex; gap: 10px; justify-content: flex-end; margin-bottom: 15px; }
        
        .action-btn {
            padding: 10px 18px; border-radius: 8px; font-weight: bold; 
            text-decoration: none; border: none; cursor: pointer; display: flex; align-items: center; gap: 8px;
        }

        /* Table Styling */
        .table-responsive { width: 100%; overflow-x: auto; border-radius: 10px; box-shadow: 0 8px 16px rgba(0.57,0.57,0.57,0.57); }
        table { width: 100%; border-collapse: collapse; min-width: 900px; }
        th { background-color: #007bff; color: white; padding: 15px; text-align: inherit; position: sticky; top: 0; }
        td { padding: 15px; border-bottom: 1px solid #eee; text-align: inherit; }
        tr:hover { background-color: #fcfcfc; }

        .fade-counter { background: #eef2f7; padding: 8px 20px; border-radius: 50px; font-weight: bold; color: #444; }

        /* Print Media Queries */
        @media print {
            .back-link, .search-area, .btn-action-group, .action-links { display: none !important; }
            .container { box-shadow: none; border: none; padding: 0; width: 100%; max-width: 100%; }
            th { background: #eee !important; color: #000 !important; border: 1px solid #000; }
            td { border: 1px solid #000; }
        }
    </style>
</head>
<body>

<div class="container">
    <a href="index.php" class="back-link">
        <?php echo ($lang == 'ar' ? '← ' . $text['back'] : '← ' . $text['back']); ?>
    </a>
    
    <div style="display:flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 style="color: #2c3e50;"><?php echo $text['view_db']; ?></h2>
        <div class="fade-counter" id="rowCount">
            <?php echo ($lang == 'ar' ? "إجمالي المستفيدين: " : "Total Beneficiaries: ") . $total_rows; ?>
        </div>
    </div>

    <div class="search-area" style="display: flex; gap: 15px; margin-bottom: 20px; max-width: 600px; margin-left: auto; margin-right: auto;">
        <input type="text" id="liveSearch" placeholder="<?php echo ($lang == 'ar' ? 'بحث بالاسم أو الجوال...' : 'Search name or phone...'); ?>" style="flex: 2; padding: 12px; border: 1.5px solid #ddd; border-radius: 8px;">
        
    <select id="filterSelect">
        <option value="All"><?php echo ($lang == 'ar' ? 'جميع الفئات' : 'All Categories'); ?></option>
        <option value="General"><?php echo $text['opt_gen']; ?></option>
        <option value="Lectures"><?php echo $text['opt_lectures']; ?></option>
        <option value="Projects"><?php echo $text['opt_projects']; ?></option>
        <option value="Library"><?php echo $text['opt_library']; ?></option>
    </select>
    </div>

    <div class="btn-action-group">
        <a href="export_excel.php" class="action-btn" style="background: #217346; color: white;">📊 <?php echo $text['btn_export']; ?></a>
        <button onclick="window.print()" class="action-btn" style="background: #6c757d; color: white;">🖨️ <?php echo $text['btn_print']; ?></button>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?php echo $text['lbl_name']; ?></th>
                    <th><?php echo $text['lbl_phone']; ?></th>
                    <th><?php echo $text['lbl_cat']; ?></th>
                    <th><?php echo $text['date']; ?></th>
                    <th><?php echo ($lang == 'ar' ? 'آخر مراسلة' : 'Last Messaged'); ?></th>
                    <th class="action-links"><?php echo $text['actions']; ?></th>
                </tr>
            </thead>
            <tbody id="tableBody">
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><strong><?php echo htmlspecialchars($row['full_name']); ?></strong></td>
                    <td dir="ltr"><?php echo htmlspecialchars($row['phone_number']); ?></td>
                    <td>
                        <?php 
                            $c = $row['category'];
                            $k = 'opt_' . strtolower($c == 'Offer' ? 'off' : ($c == 'Volunteer' ? 'vln' : $c));
                            echo $text[$k] ?? $c;
                        ?>
                    </td>
                    <td><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                    <td>
                        <?php if (!empty($row['last_messaged_at'])): ?>
                            <span style="color: #17a2b8; font-weight: 600;"><?php echo date('M d, H:i', strtotime($row['last_messaged_at'])); ?></span>
                        <?php else: ?>
                            <span style="color: #bbb;"><?php echo ($lang == 'ar' ? 'أبداً' : 'Never'); ?></span>
                        <?php endif; ?>
                    </td>
                    <td class="action-links">
                        <a href="edit_beneficiary.php?id=<?php echo $row['id']; ?>" style="color: #007bff; text-decoration: none; font-weight: bold;"><?php echo $text['edit']; ?></a> | 
                        <a href="delete_beneficiary.php?id=<?php echo $row['id']; ?>" style="color: #dc3545; text-decoration: none; font-weight: bold;" onclick="return confirm('<?php echo $text['confirm_delete']; ?>')"><?php echo $text['delete']; ?></a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table> 
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const categoryFilter = document.getElementById('categoryFilter');
    const tableBody = document.querySelector('tbody'); // Make sure this targets your table body

    // The function that sends the request
    function performSearch() {
        const query = searchInput.value;
        const category = categoryFilter.value;
    // AJAX Fetch call
    fetch(`search_logic.php?q=${encodeURIComponent(query)}&cat=${encodeURIComponent(category)}`)
            .then(response => response.text())
            .then(data => {
                tableBody.innerHTML = data; // Update the table instantly
            })
            .catch(error => console.error('Error:', error));
    }
// Trigger search on typing or changing the category
searchInput.addEventListener('keyup', performSearch);
categoryFilter.addEventListener('change', performSearch);
});
</script>

</body>
</html>