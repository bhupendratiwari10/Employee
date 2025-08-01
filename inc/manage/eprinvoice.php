

 <?php

$res = array();


    $limit = 10; // Number of items per page
    $page = isset($_GET['page']) ? $_GET['page'] : 1; // Current page
    $start = ($page - 1) * $limit; // Offset

    // Count total number of rows (for pagination)
    $count_query = "SELECT COUNT(*) as total FROM zw_epr_invoices";
    $count_result = $con->query($count_query);
    $count_row = $count_result->fetch_assoc();
    $total_rows = $count_row['total'];
    // Calculate total pages
    $total_pages = ceil($total_rows / $limit);


    $query = "SELECT * FROM zw_epr_invoices LIMIT $start, $limit";
    $con = dbCon();
    $res = mysqli_query($con, $query);



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EPR Invoice</title>
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
        /* padding: 20px 50px; */
        width: 100%;
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
        height: 60px;
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

    .modal .right .modal-dialog {
        position: fixed;
        margin: auto;
        width: 620px;
        right: 0;
        height: 100%;
        -webkit-transform: translate3d(0%, 0, 0);
        -ms-transform: translate3d(0%, 0, 0);
        -o-transform: translate3d(0%, 0, 0);
        transform: translate3d(0%, 0, 0);
    }

    .modal .right .fade .modal-dialog {
        -webkit-transition: opacity 0.3s linear, right 0.3s ease-out;
        -moz-transition: opacity 0.3s linear, right 0.3s ease-out;
        -o-transition: opacity 0.3s linear, right 0.3s ease-out;
        transition: opacity 0.3s linear, right 0.3s ease-out;
    }

    .modal.right.fade.right .modal-dialog {
        right: -10px;
    }

    .modal#trans_details .modal-dialog {
        margin-right: 0px !important;
        height: 100% !important;
        margin-top: 0px !important;
        margin-bottom: 0px;
    }

    .modal#trans_details .modal-content {
        height: 100% !important;
        overflow: auto;
    }

    .fade-right {
        animation: fadeInRight 1s ease-in-out;
    }
</style>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f7f7f7;
        margin: 0;
        padding: 0;
    }

    * {
        font-family: "Montserrat", sans-serif;
    }

    .subheading {
        color: #707070;
        text-transform: uppercase;
        font-size: 12px;
    }

    /*.payment-details-sidebar {
            background-color: #ffffff;
            width: 95%;
            padding: 20px 50px;
            border-left: 1px solid #e0e0e0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: absolute;
            top: 0;
            right: 0;
        }*/



    .back-arrow {
        transform: rotate(90deg);
    }

    .increased-font {
        font-size: 25px !important;
        margin-right: 5px;
    }

    .header .back-button {
        font-size: 24px;
        text-decoration: none;
        margin-right: 10px;
    }

    .header h2 {
        font-size: 25px;
        font-weight: 400;
        margin: 0;
    }

    .payment-summary {
        margin-top: 50px;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 5px;
        width: 100%;
    }

    .payment-summary p {
        margin: 0;
        padding: 2px 0;
    }

    .payment-icon {
        font-size: 50px !important;
        margin-bottom: 5px;
    }

    .amount-paid h1 {
        font-size: 32px;
        margin: 0;
    }

    .amount-paid p {
        font-size: 14px;
        color: #777;
        margin: 0;
    }

    .payment-id .badge {
        display: inline-block;
        background-color: #f0ad4e;
        color: black;
        padding: 5px 10px;
        border-radius: 3px;
        font-size: 14px;
        margin-top: 10px;
    }

    .payment-info,
    .payee-info {
        margin-top: 20px;
        text-align: left;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 4px;
    }

    .additional-info {
        display: flex;
        width: 100%;
        align-items: center;
        justify-content: space-between;
        margin-top: 40px;
    }

    .add-info-detail {
        display: flex;
        flex-direction: column;
        gap: 10px;

    }

    .payment-info p,
    .payee-info p,
    .additional-info p {
        margin: 0;
    }

    .payee-photo {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        display: block;
        margin: 10px auto;
    }

    .payment-details-table {
        margin-top: 30px;
        width: 100%;
    }

    .payment-details-table table {
        width: 100%;
        border-collapse: collapse;
    }

    .payment-details-table thead {
        background-color: #030303;
        color: white;
    }

    .payment-details-table th,
    .payment-details-table td {
        /* border: 1px solid #e0e0e0; */
        padding: 10px;
        text-align: center;
        font-size: 12px;
    }

    .notes {
        margin: 40px 0;
        display: flex;
        flex-direction: column;
        gap: 10px;
        padding: 0;
    }

    .notes p:first-child {
        font-weight: bold;
    }

    .files-attached {

        width: 100%;
        padding: 20px 20px;
    }

    .text-left {
        text-align: left !important;
    }

    .files-attached p {
        font-weight: bold;
    }

    .file-icons {
        border: 3px dashed #e0e0e0;
        border-radius: 20px;
        margin-top: 10px;
        padding: 40px;
    }

    .file-icons img {
        width: 60px;
        margin-right: 30px;
        color: #707070;
    }

    .arrow-pointer {
        cursor: pointer;
    }

    .form-control,
    input[type=text],
    input[type=number],
    input[type=tel],
    input[type=email],
    input[type=url],
    textarea,
    select {
        border-radius: 11px !important;
        /*! background-color: #dbdbdb !important; */
        color: #000 !important;
        border: 1px solid #6666665c !important;
        border-radius: 11px;
        font-size: 80%;
        padding: 0px 0px !important; 
        box-shadow: none !important
    }
</style>
</head>


<body>
    <div class="container col-md" style='padding:0% 3%;background:#fff;transform:none!important;margin-bottom: 20px;'>
        <div class="payment-received-container">
            <header class="header">
                <div class="heading">
                    <div class="material-symbols-rounded increasedFont">
                        account_balance_wallet
                    </div>
                    <h1>EPR Invoice</h1>

                </div>
                <a href='add.php?type=eprinvoice' style='float:right;padding: 9px 16px;border-radius: 12px;color: #fff;font-weight: 600;background: #0f6b2b;' class="add-button">+ Add</a>
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
                            <div class="th-data">Invoice# <span class="filter"><button class="arrow-up" onclick="sortTable(1, 'asc')">▲</button><button class="arrow-down" onclick="sortTable(1, 'desc')">▼</button></span></div>
                        </th>
                         <th>
                            <div class="th-data">Customer <span class="filter"><button class="arrow-up" onclick="sortTable(2, 'asc')">▲</button><button class="arrow-down" onclick="sortTable(2, 'desc')">▼</button></span></div>
                        </th>
                        <th>
                            <div class="th-data">Due Date <span class="filter"><button class="arrow-up" onclick="sortTable(3, 'asc')">▲</button><button class="arrow-down" onclick="sortTable(3, 'desc')">▼</button></span></div>
                        </th>
                        <th>
                            <div class="th-data">Status <span class="filter"><button class="arrow-up" onclick="sortTable(4, 'asc')">▲</button><button class="arrow-down" onclick="sortTable(4, 'desc')">▼</button></span></div>
                        </th>
                        <th>
                            <div class="th-data">Amount <span class="filter"><button class="arrow-up" onclick="sortTable(4, 'asc')">▲</button><button class="arrow-down" onclick="sortTable(4, 'desc')">▼</button></span></div>
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
                           if($row['status'] == "1"){$row['status'] ="Unpaid";}else{$row['status'] ="Paid";}
                           $row['invoice_date']= date('d/m/Y',strtotime($row['invoice_date']));
                           $row['due_date']= date('d/m/Y',strtotime($row['due_date']));
                    ?>

                        <tr>
                            
                            <td> <?php echo $row['invoice_date']; ?></td>
                            <td><a href="print.php?type=eprinvoice&id=<?php echo $row['id']; ?>" ><?php echo $row['invoice_id']; ?></a></td>
                            <td><?php echo $row['customer_name']; ?> </td>
                            <td><?php echo $row['due_date']; ?></td>
                            <td><?php echo $row['status']; ?></td>
                            <td><?php echo $row['subTotal']; ?></td>

                            <td><span class="more-options"
                                    onclick="togglePopup(this)">...</span>
                                <div class="popup-menu">
                                    <div class="popup-item edit"
                                       onclick="editRow(<?php echo $row['id']; ?>)" ><span
                                            class="material-symbols-outlined">
                                            edit_square
                                        </span> Edit</div>
                                    <div class="popup-item delete"
                                        ><a class="i-tag" href="delete.php?id=<?php echo $row['id']; ?>&type=eprinvoice"><span
                                            class="material-symbols-outlined">
                                            delete
                                        </span></a>
                                        Delete</div>
                                </div>
                                
                            </td>
                        </tr>
                    <?php } ?>
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
                Page <input type="number" id="page" value="<?php echo $page; ?>" min="1" max="<?php echo $total_pages; ?>"> of <span id="total_page"><?php echo $total_pages; ?></span>
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

        function editRow(element) {
            location = "edit.php?id="+element+"&type=eprinvoice";
        }

        function deleteRow(element) {
        window.location.href = 'delete.php?type=eprinvoice&id=' + element;        
    }

    </script>


</body>

</html>