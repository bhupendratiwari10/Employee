<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class='row'>

<?php 

include('inc/function.php');    if (session_status() === PHP_SESSION_NONE) {
    session_start();
};    checklogin();         $con = dbCon();


if(isset($_GET['id'])) {    $uid = $_GET['id']; }
if(isset($_GET['type'])) {  $type = $_GET['type']; }

include('inc/views/header.php');
echo "<div class='container col-md-10' style='padding:5% 3%;background:#fff;border-radius:21px;margin-top:1%;transform:scale(0.96);color:#333;'>";

if($type == 'pickups') {
    include('inc/view/pickup.php');
    echo"<title>View Pickup</title>";
 }elseif ($type == 'chartaccount') {
     include('inc/view/chartaccount.php');
    echo"<title>View Account</title>";
  }elseif ($type == 'bank') {
     include('inc/view/bank.php');
    echo"<title>View Bank Account</title>";
  }elseif ($type == 'journal') {
     include('inc/view/journal.php');
    echo"<title>View Journal</title>";
  }
//  die;
// if($type == 'user') {
//     include('inc/edit/user.php');
//  } elseif ($type == 'role') {
//     include('inc/edit/role.php');
//  }  elseif ($type == 'company') {
//     include('inc/edit/company.php');
//  } elseif ($type == "items"){
//   include('inc/edit/items.php');
//  } elseif ($type == "customer"){
//   include('inc/edit/customer.php');
//  } elseif($type == 'quote'){
//   include('inc/edit/quote.php');
//  } elseif($type == 'invoice'){
//   include('inc/edit/invoice.php');
//  } elseif($type == "bill"){
//   include('inc/edit/bills.php');
//  }elseif($type == "ulbs"){
//   include('inc/edit/ulbs.php');
//  }elseif($type == "orders"){
//   include('inc/edit/orders.php');
//  }
// elseif($type == "payments-received"){
//   include('inc/edit/payments-received.php');
//  }
// elseif($type == "payments-made"){
//   include('inc/edit/payments-made.php');
//  }
// elseif($type == "expense"){
//   include('inc/edit/expense.php');
//  }
// elseif($type == "convert_in_invoice"){
//   include('inc/edit/convert_in_invoice.php');
//  }
?>