<?php

include('inc/function.php');


checklogin();
$n = isset($_GET['t']) ? $_GET['t'] : '';
$g = isset($_GET['g']) ? $_GET['g'] : '';

$t = $n;
$con = dbCon();

// Check For Permission 
// echo "<pre>";
// print_r($_COOKIE);
// die;
$checkPermission = checkPermission($n . "_view");
// echo "checkPermission" . $checkPermission;
if (empty($checkPermission) || $checkPermission === 0) {
    // echo "You Don't have Permission to access this Page";
    // die;
}

if($n=='company'){redirect("?t=companies&g=prc");}

if (substr($t, -1) != 's') {
    $t = $t . 's';
}

if ($t == "payments-receiveds") {
    $t = "Payments-Received";
}
if ($t == "payments-mades") {
    $t = "Payments-Made";
}
if ($n == "eprinvoice") {
    $t = "EPR Invoices";
}
if ($n == "journals" || $n == "journal") {
    $t = "Manual Journal";
}
if ($n == "company" || $n == "companies") {
    $t = "Vendors";
}

$vim = "n";
if ($g == "sls") {
    $vim = "salesX";
}
if ($g == "prc") {
    $vim = "purchX";
}
if ($g == "ac") {
    $vim = "accX";
}
if ($g == "epr") {
    $vim = "eprX";
}
if ($g == "usr") {
    $vim = "userX";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <style>
        .manageX {
            color: #fff !important;
        }

        .<?php echo $t ?>X,
        .<?php echo $vim; ?>,
        .<?php echo $vim; ?>:hover {
            color: #fff !important;
            background: green;
        }
    </style>
    <style>
        .mainmenu {
            font-size: 100% !important;
        }

        #userTable_length select {
            padding: 8px 11px !important;
            background: green !important;
            color: #fff !important;
            font-size: 90% !important;
        }

        label,
        #userTable_wrapper * {
            color: #000;
        }

        .deleteBtn {
            color: red !important;
        }

        .<?php echo $n ?>Xbt {
            color: green !important;
            ciolor: #fff !important;
        }

        .table>tbody>tr>td,
        .table>tbody>tr>th,
        .table>tfoot>tr>td,
        .table>tfoot>tr>th,
        .table>thead>tr>td,
        .table>thead>tr>th {
            vertical-align: middle !important;
        }

.footer input {
  width: 77px !important;

}
        /* Style the table rows */
        tr:nth-child(even) {
          background-color: #f7f7f7 !important;
        }


    /* Add border-radius to every second row */
    tr:nth-child(even) td {
      position: relative;
      border-radius: 8px;
    }

    /* Add border-radius to the first and last cells of every second row */
    tr:nth-child(even) td:first-child {
      border-top-left-radius: 8px;
      border-bottom-left-radius: 8px;
    }

    tr:nth-child(even) td:last-child {
      border-top-right-radius: 8px;
      border-bottom-right-radius: 8px;
    }

    /* Handle the border-radius of the last row */
    tr:last-child td:first-child {
      border-bottom-left-radius: 8px;
    }

    tr:last-child td:last-child {
      border-bottom-right-radius: 8px;
    }

    .pagination-button-next:hover {
      text-decoration: none !important;
    }
    .pagination-button-prev:hover {
      text-decoration: none !important;
    }
    .add-button{
        margin-top: -48px !important;
    }
    </style>
    <style>
        /* Add this CSS to replace the down arrow with three dots */
        .dropdown-toggle::after {
            content: '\2026';
            display: inline-block;
            margin-top: -5px !important;
            margin-left: 5px;
            font-size: 26px;
            border-top: 0px !important;
        }

        .dropdown,
        .dropup {
            position: relative;
            display: inline-block !important;
        }
    </style>
</head>

<body class='row'>
    <?php 

    include('inc/views/header.php'); 
    if ($n == 'payments-received') { 
         include('inc/manage/payments-received.php');
    }else if ($n == 'invoice') { 
         include('inc/manage/invoice.php');
    }else if ($n == 'orders') { 
         include('inc/manage/orders.php');
    }else if ($n == 'items') { 
         include('inc/manage/items.php');
    }else if ($n == 'customer') { 
         include('inc/manage/customer.php');
    }else if ($n == 'quote') {  
         include('inc/manage/quotes.php');
    }else if ($n == 'companies') { 
         include('inc/manage/company.php');
    }else if ($n == 'expense') {  
         include('inc/manage/expense.php');
    }else if ($n == 'bill') {  
         include('inc/manage/bills.php');
    }else if ($n == 'payments-made') {  
         include('inc/manage/payments-made.php');
    }else if ($n == 'accounts') {  
         include('inc/manage/accounts.php');
    }else if ($n == 'journal') {  
         include('inc/manage/journal.php');
    }else if ($n == 'pickups') {  
         include('inc/manage/pickups.php');
    }else if ($n == 'eprinvoice') {  
         include('inc/manage/eprinvoice.php');
    }else if ($n == 'ulbs') {  
         include('inc/manage/ulbs.php');
    }else if ($n == 'categories') {  
         include('inc/manage/categories.php');
    }else{
    ?>
        <div class="container col-md" style='padding:5% 3%;background:#fff;transform:none!important;'>
            <a href='add.php?type=<?php echo $n; ?>' class='btn' style='float:right;padding: 9px 16px;border-radius: 12px;color: #fff;font-weight: 600;background: #0f6b2b;'>+ Add <!--<kl style='text-transform:capitalize;'><?php echo $t; ?></kl>--></a>
            <h3 style='font-weight:700;'>
                <lo class='d-none'>Manage</lo>
                <kl style='text-transform:capitalize;color:#000'><?php echo $t; ?></kl>
            </h3>
            <?php if ($n == "eprinvoice") {
                echo "<hr style='color:#000;'>";
            } ?>
            <hr>

            <?php
            if ($n == 'roles') {
                include('inc/manage/role.php');
            } elseif ($n == 'companies') {
                include('inc/manage/company.php');
            } elseif ($n == 'categories') {
                include('inc/manage/categories.php');
            } elseif ($n == 'customer') {
                include('inc/manage/customer.php');
            } elseif ($n == 'price') {
                include('inc/manage/price.php');
            } elseif ($n == 'items') {
                include('inc/manage/items.php');
            } elseif ($n == 'ulbs') {
                include('inc/manage/ulbs.php');
            } elseif ($n == 'user') {
                include('inc/manage/user.php');
            } elseif ($n == 'journal' || $n == 'journals') {
                include('inc/manage/journal.php');
            } elseif ($n == 'quote') {
                include('inc/manage/quotes.php');
            } elseif ($n == 'invoice') {
                include('inc/manage/invoice.php');
            } elseif ($n == 'bill') {
                include('inc/manage/bills.php');
            } elseif ($n == 'accounts') {
                include('inc/manage/accounts.php');
            } elseif ($n == 'pickups') {
                include('inc/manage/pickups.php');
            } elseif ($n == 'orders') {
                include('inc/manage/orders.php');
            } elseif ($n == 'payments-received') {
                include('inc/manage/payments-received.php');
            } elseif ($n == 'payments-made') {
                include('inc/manage/payments-made.php');
            } elseif ($n == 'expense') {
                include('inc/manage/expense.php');
            } elseif ($n == 'eprinvoice') {
                include('inc/manage/eprinvoice.php');
            } elseif ($n == 'profit-loss') {
                include('inc/manage/profit-loss.php');
            } elseif ($n == 'balance-sheet') {
                include('inc/manage/balance-sheet.php');
            } elseif ($n == 'cashflow') {
                include('inc/manage/cashflow.php');
            }
            ?>
        </div>
    <?php } ?>

    <script>
    $(document).ready(function() {
      $('#page').on('change', function() {
        var pageValue = $(this).val();
        var url = new URL(window.location.href);
        url.searchParams.set('page', pageValue);
        window.location.href = url.toString();
      });
    });
  </script>
</body>

</html>