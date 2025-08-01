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
$checkPermission = checkPermission($n."_view");
// echo "checkPermission" . $checkPermission;
if(empty($checkPermission) || $checkPermission === 0){
    echo "You Don't have Permission to access this Page";
    die;
}
if (substr($t, -1) != 's') {
    $t = $t . 's';
}

if($n == "eprinvoice"){
	$t = "EPR Reports";
    $title = "EPR Reports";
}

$vim = "n";
if($g=="sls"){$vim="salesX";}
if($g=="prc"){$vim="purchX";}
if($g=="ac"){$vim="accX";}
if($g=="epr"){$vim="eprX";}
if($g=="usr"){$vim="userX";}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <style>.manageX{color:#fff!important;} .<?php echo $t?>X, .<?php echo $vim; ?>, .<?php echo $vim; ?>:hover{color:#fff!important;background:green;}</style>
    <style> .mainmenu{font-size:100%!important;}
    #userTable_length select{padding:8px 11px!important;background:green!important;color:#fff!important;font-size:90%!important;}
    label, #userTable_wrapper * {
	    color: #000 ;
	}
	.deleteBtn{
	color: red !important;
	}
	.<?php echo $n?>Xbt{
        color: green!important;
        ciolor: #fff!important;
	}
	
	.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
	  vertical-align: middle !important;
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
    .dropdown, .dropup {
	    position: relative;
	    display: inline-block !important;
	}
    

  </style>
</head>
<body class='row'>
    <?php include('inc/views/header.php'); ?>
    <div class="container col-md" style='padding:5% 3%;background:#fff;transform:none!important;'>
       
        <h3 style='font-weight:700;'><lo class='d-none'>Reports</lo> <kl style='text-transform:capitalize;color:#000'><?php echo $t; ?></kl></h3>
        <?php if($n == "eprinvoice"){ echo "<hr style='color:#000;'>"; }?>
        <hr>
       			
        <?php
        if ($n == 'eprinvoice') {
            include('inc/reports/eprinvoices.php');
        }
        ?>
    </div>
</body>
</html>