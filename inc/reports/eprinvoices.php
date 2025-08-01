<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

$con = dbCon();

$period = isset($_GET['period']) ? $_GET['period'] : '';
$pickup_categories = isset($_GET['pickup_categories']) ? $_GET['pickup_categories'] : '';
$customer_id = isset($_GET['customer']) ? $_GET['customer'] : '';

switch ($period) {
    case 'quarterly':
        // Get data for the current quarter
        $start_date = date('Y-m-d', strtotime('first day of this quarter'));
        $end_date = date('Y-m-d', strtotime('last day of this quarter'));
        break;
    case 'half_yearly':
        // Get data for the current half-year
        $start_date = date('Y-m-d', strtotime('first day of January'));
        $end_date = date('Y-m-d', strtotime('last day of June'));
        break;
    case 'yearly':
        // Get data for the current year
        $start_date = date('Y-m-d', strtotime('first day of January'));
        $end_date = date('Y-m-d', strtotime('last day of December'));
        break;
    default:
        // Default to yearly data
        $start_date = date('Y-m-d', strtotime('first day of January'));
        $end_date = date('Y-m-d', strtotime('last day of December'));
}



$limit = 10; // Number of items per page
$page = isset($_GET['page']) ? $_GET['page'] : 1; // Current page
$start = ($page - 1) * $limit; // Offset

if ($pickup_categories > 0) {
    $count_query = "SELECT COUNT(zw_epr_invoices.id) as total FROM zw_epr_invoices INNER JOIN zw_epr_invoice_items ON zw_epr_invoices.id = zw_epr_invoice_items.invoice_id WHERE zw_epr_invoices.customer_id='$customer_id' AND zw_epr_invoices.invoice_date BETWEEN '$start_date' AND '$end_date' AND zw_epr_invoice_items.category='$pickup_categories' ";

    // Count total number of rows (for pagination)
    $count_result = $con->query($count_query);
    $count_row = $count_result->fetch_assoc();
    $total_rows = $count_row['total'];
    // Calculate total pages
    $total_pages = ceil($total_rows / $limit);
} else {
    $count_query = "SELECT COUNT(*) as total FROM zw_epr_invoices WHERE customer_id='$customer_id' AND invoice_date BETWEEN '$start_date' AND '$end_date'";
    // Count total number of rows (for pagination)
    $count_result = $con->query($count_query);
    $count_row = $count_result->fetch_assoc();
    $total_rows = $count_row['total'];
    // Calculate total pages
    $total_pages = ceil($total_rows / $limit);
}

if ($pickup_categories > 0) {
    $query = "SELECT zw_epr_invoices.* FROM zw_epr_invoices INNER JOIN zw_epr_invoice_items ON zw_epr_invoices.id = zw_epr_invoice_items.invoice_id WHERE zw_epr_invoices.customer_id='$customer_id' AND zw_epr_invoices.invoice_date BETWEEN '$start_date' AND '$end_date' AND zw_epr_invoice_items.category='$pickup_categories' LIMIT $start, $limit";
    $res = mysqli_query($con, $query);
} else {
    $query = "SELECT * FROM zw_epr_invoices WHERE customer_id='$customer_id' AND invoice_date BETWEEN '$start_date' AND '$end_date' LIMIT $start, $limit";
    $res = mysqli_query($con, $query);
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,300,0,0" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,700,0,0" />
</head>
<style>
    body {
        font-optical-sizing: auto;
        background-color: #f8f8f8;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        height: 100vh;
    }
    #page,
    {
        
        padding: 0px 0px !important; 
    }

    * {
        font-family: "Montserrat", sans-serif;
    }

    .container {
        /* padding: 20px 50px; */
        width: 90%;
        height: 95%;
        margin-top: 50px;
    }

    .disabled-link {
        pointer-events: none;
        color: #999;
        /* Optional: Change text color to indicate it's disabled */
        text-decoration: none;
        /* Optional: Remove underline */
    }

    .table-container {
        padding: 20px;
        width: 100%;
        height: max-content;
        background-color: white;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        border-radius: 30px;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-right: -30px;
        margin-bottom: 20px;
    }

    .heading {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .header h1 {
        font-size: 34px;
        font-weight: 500;
        margin: 0;
    }

    .increasedFont {
        font-size: 35px !important;
    }

    .add-button {
        background-color: #ffd500;
        border: none;
        padding: 10px 20px;
        border-radius: 15px;
        cursor: pointer;
        font-size: 14px;
        margin-right: 0;
        font-weight: 500;
    }

    .payments-table {
        width: 100%;
        background-color: white;
        border-radius: 8px;
        border-collapse: collapse;
        border-bottom: 1px solid #fff;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .filter {
        display: inline-flex;
        flex-direction: column;
        margin-left: 2px;
    }

    .arrow-up,
    .arrow-down {
        background: none;
        border: none;
        cursor: pointer;
        font-size: 8px;
        line-height: 10px;
        color: #7070704B;
        padding: 0;
    }

    .payments-table thead tr th {
        vertical-align: middle;
        font-size: 12px;
        font-weight: 500;
        text-transform: uppercase;
        color: #707070;
    }

    .payments-table th:first-child {
        padding-left: 50px;

    }

    .th-data {
        display: flex;
        gap: 5px;
    }

    .payments-table th,
    .payments-table td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #fff;
    }

    .payments-table th {
        background-color: white;
        border-radius: 30px;
    }

    .payments-table tr {
        height: 70px;
        border-radius: 30px;
        border-bottom: 1px solid #fff;
    }

    .payments-table tr:nth-child(odd) {
        background-color: #F7F7F7;
    }

    .footer {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .payments-table tbody tr td:first-child {
        border-top-left-radius: 30px;
        border-bottom-left-radius: 30px;
        padding-left: 50px !important;

    }

    .payments-table tbody tr td:last-child {
        border-top-right-radius: 30px;
        border-bottom-right-radius: 30px;
        /* font-size: 20px;
        font-weight: 500; */
    }

    .pagination-button-prev {
        background-color: white;
        color: black;
        border: 2px solid black;
        padding: 10px;
        margin: 0 10px;
        cursor: pointer;
        width: 50px;
        height: 35px;
        display: flex;
        align-items: center;
        border-radius: 15px 0px 0px 15px;
    }

    .pagination-button-next {
        background-color: #000;
        color: white;
        height: 35px;
        border: none;
        padding: 10px;
        margin: 0 0px;
        cursor: pointer;
        border: 2px solid black;
        border-radius: 0px 15px 15px 0px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 50px;
        width: 60%;
        margin-left: 40%;
    }

    .pagination {
        display: flex;
        align-items: end;
        justify-content: end;
    }

    .footer input {
        width: 40px;
        text-align: center;
        margin: 0 5px;
        border-radius: 5px;
        border-width: 1px;
    }

    /* Popup Menu Styles */
    .more-options {
        cursor: pointer;
        position: relative;
        z-index: 1;
    }

    .popup-menu {
        display: none;
        position: absolute;
        right: 20;
        background-color: white;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        border-radius: 18px;
        z-index: 2;
        padding: 10px;
    }

    .popup-item {
        padding: 10px 20px;
        cursor: pointer;
        display: flex;
        gap: 5px;
        align-items: center;
        font-size: 12px;
    }

    .popup-item.edit {
        color: #FFD500;
    }

    .popup-item.delete {
        color: #FF0000;
    }

    .popup-item:not(:last-child) {
        border-bottom: 0.5px solid #ddd;

    }

    .popup-item:hover {
        background-color: #f1f1f1;
    }
</style>

<body>
    <div class="container col-md" style='padding:0% 3%;background:#fff;transform:none!important;margin-bottom: 20px;'>
        <header class="header">
            <div class="heading">
                <div class="material-symbols-rounded increasedFont">
                    library_books
                </div>
                <h1>Reports</h1>
            </div>
        </header>
        <style>
            .col-md-12 select {
                height: 35px;
                padding: 5px;
                border: none;
            }
        </style>
        <div class="row col-12" style='margin-bottom:20px'>
            <div class="col-md-12" style='display:flex;gap:15px'>
                <div>
                    <div class="form-group">

                        <select name="period" id="period">
                            <option value="">Select Period</option>
                            <option <?php if ($_GET['period'] == 'for_invoice') {
                                        echo 'selected';
                                    } ?> value="for_invoice">For Invoice</option>
                            <option <?php if ($_GET['period'] == 'quarterly') {
                                        echo 'selected';
                                    } ?> value="quarterly">Quarterly</option>
                            <option <?php if ($_GET['period'] == 'half_yearly') {
                                        echo 'selected';
                                    } ?> value="half_yearly">Half-Yearly</option>
                            <option <?php if ($_GET['period'] == 'yearly') {
                                        echo 'selected';
                                    } ?> value="yearly">Yearly</option>
                        </select>
                    </div>
                </div>
                <div>
                    <div class="form-group">
                        <select name="pickup_categories" id="pickup_categories" required>
                            <option value="">Select Categories</option>
                            <?php optionPrintAdv("zw_pickup_categories", "id", "title", isset($_GET['pickup_categories']) ? $_GET['pickup_categories'] : 0); ?>
                        </select>
                    </div>
                </div>

                  <div class="form-group">
                   <select name="customer" id="customer" required>
                        <option value="">Select Customer</option>
                        <?php optionPrintAdv("zw_customers WHERE customer_type!='ulb' and status=1", "id", "customer_display_name",isset($_GET['customer']) ? $_GET['customer'] : 0); ?>
                    </select>
                  </div>
               
                <div>
                    <button id="applyFilterBtn" class='btn' style='border-radius: 12px;color: #000;font-weight: 600;background: #ffc43b; font-size: 14px;'>Apply Filter </button>
                </div>
            </div>

        </div>
        <div class="table-container">
            <table class="payments-table">
                <thead>
                    <tr>
                        <th>
                            <div class="th-data">
                                Date <span class="filter"><button class="arrow-up" onclick="sortTable(0, 'asc')">▲</button><button class="arrow-down" onclick="sortTable(0, 'desc')">▼</button></span>
                            </div>
                        </th>
                        <th>
                            <div class="th-data">Invoice# <span class="filter"><button class="arrow-up" onclick="sortTable(1, 'asc')">▲</button><button class="arrow-down" onclick="sortTable(1, 'desc')">▼</button></span></div>
                        </th>
                        <th>
                            <div class="th-data">PO# <span class="filter"><button class="arrow-up" onclick="sortTable(3, 'asc')">▲</button><button class="arrow-down" onclick="sortTable(3, 'desc')">▼</button></span></div>
                        </th>
                        <th>
                            <div class="th-data">Customer Name<span class="filter"><button class="arrow-up" onclick="sortTable(4, 'asc')">▲</button><button class="arrow-down" onclick="sortTable(4, 'desc')">▼</button></span></div>
                        </th>
                        <th>
                            <div class="th-data">Terms <span class="filter"><button class="arrow-up" onclick="sortTable(4, 'asc')">▲</button><button class="arrow-down" onclick="sortTable(4, 'desc')">▼</button></span></div>
                        </th>
                        
                        <th>
                            <div class="th-data">Due Date <span class="filter"><button class="arrow-up" onclick="sortTable(5, 'asc')">▲</button><button class="arrow-down" onclick="sortTable(5, 'desc')">▼</button></span></div>
                        </th>
                        <th></th>
                    </tr>
                </thead>
                <tbody class="payments-table-body">
                    <?php
                    while ($row = mysqli_fetch_assoc($res)) {
                        $row['customer_name'] = namebyAid($row['customer_id'],"customer_display_name","zw_customers");
                          if($row['customer_name'] == null || $row['customer_name'] ==''){
                              $row['customer_name']="No Details";
                          }
                           $row['invoice_date']= date('d/m/Y',strtotime($row['invoice_date']));
                           $row['due_date']= date('d/m/Y',strtotime($row['due_date']));
                        if ($period == 'for_invoice') { 
                    ?>

                            <tr>
                                <td><a href="print.php?type=eprinvoice&id=<?php echo $row['id']; ?>" class="" style="text-decoration:none;color:#000;"><?php echo $row['invoice_date']; ?></a></td>
                                <td><a href="print.php?type=eprinvoice&id=<?php echo $row['id']; ?>" class="" style="text-decoration:none;color:#000;"><?php echo $row['invoice_id']; ?></a></td>
                                <td><?php echo $row['po_id']; ?></td>
                                <td><?php echo $row['customer_name']; ?></td>
                                <td><?php echo $row['terms']; ?></td>
                                <td><?php echo $row['due_date']; ?></td>
                            </tr>
                        <?php } else { ?>
                            <tr>
                                <td><a onclick="openPopup('inc/reports/eprpickups/index.php?type=eprinvoice&poid=<?php echo $row['po_id']; ?>', 'popup', 930, 800); return false;"><?php echo $row['invoice_date']; ?></a></td>
                                <td><a onclick="openPopup('inc/reports/eprpickups/index.php?type=eprinvoice&poid=<?php echo $row['po_id']; ?>', 'popup', 930, 800); return false;"><?php echo $row['invoice_id']; ?></a></td>
                                <td><?php echo $row['po_id']; ?></td>
                                <td><?php echo $row['customer_name']; ?></td>
                                <td><?php echo $row['terms']; ?></td>
                                <td><?php echo $row['due_date']; ?></td>
                            </tr>
                    <?php }
                    } ?>
                </tbody>
            </table>
        </div>
        <footer class="footer">
            <div class="pagination">

                <a href="?t=eprinvoice&page=<?php echo ($page - 1); ?>&g=epr" class="pagination-button-prev <?php if ($page <= 1) : ?>disabled-link<?php endif; ?>"><span class="material-symbols-outlined">
                        arrow_back
                    </span></a>


                <a href="?t=eprinvoice&page=<?php echo ($page + 1); ?>&g=epr" class="pagination-button-next <?php if ($page >= $total_pages) : ?>disabled-link<?php endif; ?>">Next Page
                    <span class="material-symbols-outlined">
                        arrow_forward
                    </span></a>

            </div>

            <div>
                Page <input type="number" style="padding: 0px 0px !important; " id="page" value="<?php echo $page; ?>" min="1" max="<?php echo $total_pages; ?>"> of <span id="total_page"><?php echo $total_pages; ?></span>
            </div>
        </footer>
    </div>
    <script>
        function sortTable(columnIndex, order) {
            const table = document.querySelector(".payments-table tbody");
            const rows = Array.from(table.rows);

            rows.sort((rowA, rowB) => {
                const cellA = rowA.cells[columnIndex].innerText;
                const cellB = rowB.cells[columnIndex].innerText;

                if (order === "asc") {
                    return cellA.localeCompare(cellB, undefined, {
                        numeric: true
                    });
                } else {
                    return cellB.localeCompare(cellA, undefined, {
                        numeric: true
                    });
                }
            });

            rows.forEach(row => table.appendChild(row));
        }

        function togglePopup(element) {
            const allPopups = document.querySelectorAll('.popup-menu');
            allPopups.forEach(popup => popup.style.display = 'none');

            const popup = element.nextElementSibling;
            popup.style.display = popup.style.display === 'block' ? 'none' : 'block';
        }

        window.addEventListener('click', function(e) {
            if (!e.target.matches('.more-options')) {
                const allPopups = document.querySelectorAll('.popup-menu');
                allPopups.forEach(popup => popup.style.display = 'none');
            }
        });

        function editRow(element) {
            const row = element.closest('tr');
            console.log('Edit', row);
        }

        function deleteRow(element) {
            const row = element.closest('tr');
            console.log('Delete', row);
        }
    </script>

    <script>
        function openPopup(url, name, width, height) {
            var left = (screen.width - width) / 2;
            var top = 2;
            var options = 'width=' + width + ', height=' + height + ', top=' + top + ', left=' + left + ', fullscreen=no, resizable=no, scrollbars=yes, location=no';
            window.open(url, name, options);
        }

        $('#applyFilterBtn').on('click', function() {
            var url = 'reports.php?t=eprinvoice&g=epr';

            var period = $('select[name=\'period\']').val();

            if (period != 0) {
                url += '&period=' + encodeURIComponent(period);
            }

            var pickup_categories = $('select[name=\'pickup_categories\']').val();

            if (pickup_categories != 0) {
                url += '&pickup_categories=' + encodeURIComponent(pickup_categories);
            }

            var customer = $('select[name=\'customer\']').val();

            if (customer != 0) {
                url += '&customer=' + encodeURIComponent(customer);
            }

            location = url;
        });
    </script>
</body>

</html>