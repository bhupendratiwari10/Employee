<?php
include('inc/function.php'); if (session_status() === PHP_SESSION_NONE) {
    session_start();
}; checklogin(); $con = dbCon();$type = $_GET['type']; updateAccounts();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title> Tidy Rabbit | <?php echo "Add ".$type; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
 
    
</head>
<body class='row'>
    <?php include('inc/views/header.php'); $nordo=0;//Hide Account recivables and Payable ?>
    <?php
$n = isset($_GET['type']) ? $_GET['type'] : '';

?>
<div class="container col-md-10" style='padding:2% 3%;background:#fff;border-radius:21px;margin-top:2%;transform:scale(0.96);font-size:84%;color:#000;'>
<style>input,textarea{margin:6px 0px;border-radius:11px;} .col-6{transform:scale(0.96);} .col-12{transform:scale(0.98);}</style>
<style>.custom-table {background-color: black;color: white; }   .custom-table th,   .custom-table td {border-color: white;}</style>
<?php

if($type=='companies'){ 

    include('inc/add/company.php');
    
}elseif($type=='accounts'){ 

    include('inc/add/account.php');
    
} elseif ($type=='roles'){ 
    
    include('inc/add/role.php');

} elseif ($type=='categories'){ 
    
    include('inc/add/category.php');
    
}elseif ($type=='customer'){ 
    
    include('inc/add/customer.php');
    
} elseif ($type=='user'){ 
    
    include('inc/add/user.php');
    
}elseif ($type=='journal' || $type=='journals'){ 
    
    include('inc/add/journal.php');
    
}elseif ($type=='items'){ 
    
    include('inc/add/items.php');
    
}elseif ($type=='expense'){ 
    
    include('inc/add/expense.php');
    
}elseif ($type=='price'){ 
    
    include('inc/add/price.php');
    
}elseif ($type=='pickups'){ 
    
    include('inc/add/pickup.php');
    
}elseif ($type=='ulbs'){ 
    
    include('inc/add/ulb.php');
    
}elseif ($type=='invoice'){ 
    
    include('inc/add/invoice.php');
 
}elseif ($type=='orders'){ 

    include('inc/add/order.php');
 
}elseif ($type=='quote'){ 
    
	include('inc/add/addQuote.php');
 
}elseif ($type=='bill'){ $nordo=1;
    
	include('inc/add/addBill.php');
}
elseif ($type=='payments-received'){ 
    
	include('inc/add/payments-received.php');
}
elseif ($type=='payments-made'){ 
    
	include('inc/add/payments-made.php');
}
elseif ($type=='eprinvoice'){ 
    
	include('inc/add/eprinvoice.php');
}elseif ($type=='billx'){ 
    
	include('inc/add/addBill.old.php');
}


echo '<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>';

?>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>