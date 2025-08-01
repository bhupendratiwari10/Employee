<?php

$res = array();

// Initialize database connection FIRST
$con = dbCon();

$limit = 10; // Number of items per page
$page = isset($_GET['page']) ? $_GET['page'] : 1; // Current page
$start = ($page - 1) * $limit; // Offset

// Count total number of rows (for pagination)
$count_query = "SELECT COUNT(*) as total FROM zw_Bill";
$count_result = mysqli_query($con, $count_query);

if ($count_result) {
    $count_row = mysqli_fetch_assoc($count_result);
    $total_rows = $count_row['total'];
    // Calculate total pages
    $total_pages = ceil($total_rows / $limit);
} else {
    // Handle query error
    $total_rows = 0;
    $total_pages = 1;
    error_log("Count query failed: " . mysqli_error($con));
}

// Get paginated results
$query = "SELECT * FROM zw_Bill LIMIT $start, $limit";
$res = mysqli_query($con, $query);

if (!$res) {
    error_log("Main query failed: " . mysqli_error($con));
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bills</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,300,0,0" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,700,0,0" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

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

        * {
            font-family: "Montserrat", sans-serif;
        }

        .payment-received-container {
            width: 100%;
            height: 95%;
            margin-top: 50px;
        }

        .disabled-link {
            pointer-events: none;
            color: #999;
            text-decoration: none;
        }

        .table-container {
            padding: 20px;
            width: 100%;
            height: max-content;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 30px;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .heading {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .modal-header h3 {
            font-size: 30px;
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

        .payments-table th:first-child {
            padding-left: 50px;
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
</head>

<body>
    <div class="container col-md" style='padding:0% 3%;background:#fff;transform:none!important;'>
        <div class="payment-received-container">
            <header class="header" style="margin-bottom: 42px;">
                <div class="heading">
                    <div class="material-symbols-rounded increasedFont">
                        account_balance_wallet
                    </div>
                    <h1>Bills</h1>
                </div>
                <a href='add.php?type=bill' style='float:right;padding: 9px 16px;border-radius: 12px;color: #fff;font-weight: 600;background: #0f6b2b;' class="add-button">+ Add</a>
            </header>
            
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
                                <div class="th-data">Bill# <span class="filter"><button class="arrow-up" onclick="sortTable(1, 'asc')">▲</button><button class="arrow-down" onclick="sortTable(1, 'desc')">▼</button></span></div>
                            </th>
                            <th>
                                <div class="th-data">Vendor <span class="filter"><button class="arrow-up" onclick="sortTable(2, 'asc')">▲</button><button class="arrow-down" onclick="sortTable(2, 'desc')">▼</button></span></div>
                            </th>
                            <th>
                                <div class="th-data">Status <span class="filter"><button class="arrow-up" onclick="sortTable(3, 'asc')">▲</button><button class="arrow-down" onclick="sortTable(3, 'desc')">▼</button></span></div>
                            </th>
                            <th>
                                <div class="th-data">Due Date <span class="filter"><button class="arrow-up" onclick="sortTable(4, 'asc')">▲</button><button class="arrow-down" onclick="sortTable(4, 'desc')">▼</button></span></div>
                            </th>
                            <th>
                                <div class="th-data">Amount <span class="filter"><button class="arrow-up" onclick="sortTable(5, 'asc')">▲</button><button class="arrow-down" onclick="sortTable(5, 'desc')">▼</button></span></div>
                            </th>
                            <th>
                                <div class="th-data">Balance Due <span class="filter"><button class="arrow-up" onclick="sortTable(6, 'asc')">▲</button><button class="arrow-down" onclick="sortTable(6, 'desc')">▼</button></span></div>
                            </th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="payments-table-body">
                        <?php
                        if ($res) {
                            while ($row = mysqli_fetch_assoc($res)) {
                                $vendor_name = namebyAid($row['customer_id'], "company_name", "zw_company");
                                $salesPerson_name = getUserDetails($row['sales_person']);
                        ?>
                            <tr>
                                <td><?php echo date('d-m-Y', strtotime($row['bill_date'])); ?></td>
                                <td>BILL-<?php echo $row['id']; ?></td>
                                <td><?php echo htmlspecialchars($vendor_name); ?></td>
                                <td><?php echo htmlspecialchars($row['status']); ?></td>
                                <td><?php echo date('d-m-Y', strtotime($row['due_date'])); ?></td>
                                <td>₹ <?php echo number_format($row['subTotal'], 2); ?></td>
                                <td>₹ <?php echo number_format($row['amount_due'], 2); ?></td>
                                <td>
                                    <span class="more-options" onclick="togglePopup(this)">...</span>
                                    <div class="popup-menu">
                                        <div class="popup-item edit" onclick="editRow(<?php echo $row['id']; ?>)">
                                            <span class="material-symbols-outlined">edit_square</span> Edit
                                        </div>
                                        <div class="popup-item delete" onclick="deleteRow(<?php echo $row['id']; ?>)">
                                            <span class="material-symbols-outlined">delete</span> Delete
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php 
                            }
                        } else {
                            echo "<tr><td colspan='8' style='text-align:center;'>No bills found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            
            <footer class="footer">
                <div class="pagination">
                    <a href="?t=bill&g=prc&page=<?php echo ($page - 1); ?>" class="pagination-button-prev <?php if ($page <= 1) : ?>disabled-link<?php endif; ?>">
                        <span class="material-symbols-outlined">arrow_back</span>
                    </a>
                    <a href="?t=bill&g=prc&page=<?php echo ($page + 1); ?>" class="pagination-button-next <?php if ($page >= $total_pages) : ?>disabled-link<?php endif; ?>">
                        Next Page <span class="material-symbols-outlined">arrow_forward</span>
                    </a>
                </div>
                <div>
                    Page <input type="number" id="page" value="<?php echo $page; ?>" min="1" max="<?php echo $total_pages; ?>" onchange="goToPage(this.value)"> of <span id="total_page"><?php echo $total_pages; ?></span>
                </div>
            </footer>
        </div>
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

        function editRow(id) {
            window.location.href = 'edit.php?type=bill&id=' + id;
        }

        function deleteRow(id) {
            if(confirm("Do You Really Want To Delete This Record?")) {
                window.location.href = 'delete.php?type=bill&id=' + id;
            } 
        }
        
        function goToPage(pageNum) {
            if (pageNum >= 1 && pageNum <= <?php echo $total_pages; ?>) {
                window.location.href = '?t=bill&g=prc&page=' + pageNum;
            }
        }
    </script>
</body>
</html>