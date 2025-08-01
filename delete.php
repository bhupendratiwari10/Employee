<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "inc/function.php"; // Include your database connection file

$uid = $_GET["id"]; $type = $_GET['type']; $con = dbCon();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete <?php echo $type; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
    .dashX{color:#fff!important;} #statsx div{background:#0000003c;color:#fff;align-items:center;transform:scale(0.84);padding:11px 5px;border-radius:18px;}
    cb i{font-size:221%;background:#178a29;color:#fff;padding:16px;border-radius:18px;display:inline;transform:scale(0.9);aspect-ratio:1/1;}
    bx{padding:0;text-indent: 16px;display:block;margin:0!important;} bx p{font-size:80%;}
    .btnx{margin:10px;padding:11px 21px;display:inline-block;text-decoration:none;background:#222;transform:scale(0.84);color:#fff;border-radius:8px;}
    </style>
</head>
<body class='row'>
    <?php include('inc/views/header.php'); ?>
    <div class="container col-md-10" style='padding:5% 3%;'>
        <center>
                
            <div class='col-md-4' style='padding: 76px 21px;border-radius: 21px;background: #dbdbdb;padding-bottom: 36px;'>    
                <h2 style='font-weight:600;text-transform:capitalize;'>Delete <?php echo $type; ?> Record</h2>
                <p style='font-size:12px;'>Do you really want to procceed ? This action can not be undone.</p>
                
                <?php
                if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["id"])) {
                    
                    
                    if (empty($_GET['confirm'])){ 
                echo '<a class="btnx" style="background:#ff0027;" href="?id='.$uid.'&type='. $type .'&confirm=confirm">Confirm</a>';
                echo '<a class="btnx" onclick="history.back()"> Cancel</a>';
                exit();}
                
                    if($type=='company'){$query = "DELETE FROM zw_company WHERE id = '$uid'";}
                    
                    //if($type=='customer'){$query = "DELETE FROM zw_customers WHERE id = '$uid'";}
                    
                    if($type=='customer'){$query = "UPDATE zw_customers set status=0 WHERE id = '$uid'";}
                    
                    if($type=='invoice'){$query2 = "DELETE FROM zw_invoices WHERE id = '$uid'";
                        mysqli_query($con, $query2);
                        $query = "DELETE FROM zw_invoice_items WHERE invoice_id = '$uid'";
                    }
                    if($type=='eprinvoice'){
                        $query2 = "DELETE FROM zw_epr_invoices WHERE id = '$uid'";
                        mysqli_query($con, $query2);
                        $query = "DELETE FROM zw_epr_invoice_items WHERE invoice_id = '$uid'";
                        mysqli_query($con, $query);
                    }
                    if($type=='bill'){ $query2 = "DELETE FROM zw_Bill WHERE id = '$uid'";
                        mysqli_query($con, $query2);
                        $query = "DELETE FROM zw_Bill_items WHERE bill_id = '$uid'";
                    }
                    
                    if($type=='items'){$query = "DELETE FROM zw_items WHERE id = '$uid'";}
                    
                    if($type=='orders'){
                        $query = "DELETE FROM zw_epr_po WHERE id = '$uid'";
                        mysqli_query($con, $query);
                        $query = "DELETE FROM zw_epr_po_items WHERE invoice_id = '$uid'";
                    }
                    
                    if($type=='journal'){$query = "DELETE FROM zw_journal WHERE id = '$uid'";
                        mysqli_query($con, $query);
                        $query = "DELETE FROM zw_journal_items WHERE journal_id = '$uid'";
                    }
                    
                    if($type=='pickups'){$query = "DELETE FROM zw_pickups WHERE id = '$uid'";}
                    
                    if($type=='price'){$query = "DELETE FROM zw_price WHERE id = '$uid'";}
                    
                    if($type=='role'){$query = "DELETE FROM zw_user_roles WHERE id = '$uid'"; $type='roles&g=usr';}
                
                    if($type=='ulbs'){$query = "DELETE FROM zw_ulb WHERE id = '$uid'";}
                
                    if($type=='user'){$query = "DELETE FROM zw_user WHERE id = '$uid'";}
                    if($type=='quote'){$query = "DELETE FROM zw_Quote WHERE id = '$uid'";
                        mysqli_query($con, $query);
                        $query = "DELETE FROM zw_Quote_items WHERE id = '$uid'";
                    }
                    if($type == 'payments-made'){$query = "DELETE FROM zw_payment_made WHERE id = '$uid'";}
                    if($type == 'categories'){$query = "DELETE FROM zw_pickup_categories WHERE id = '$uid'";}
                    if($type == 'expense'){$query = "DELETE FROM zw_expense WHERE id = '$uid'";}
                    if($type == 'accounts'){$query = "DELETE FROM zw_accounts WHERE id = '$uid'";}
                    if($type == 'payments-received'){$query = "DELETE FROM zw_payment_made WHERE id = '$uid'";}
                    
                    if (mysqli_query($con, $query)) {
                        //if($type == "customer"){$typex = "customers";}else{$typex = $type;}
                        redirect("manage.php?t=$type"); 
                    } else {
                        alert("Sorry, There was an Error");
                    }
                
                    
                    
                } else {
                    echo "Invalid request.";
                }
                
                mysqli_close($con);
                ?>
            </div>    
        </center>
    </div>
</body>