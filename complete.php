<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete <?php echo $_GET['type']; ?></title>
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
echo "<div class='container col-md-10'  style='padding:2% 3%;background:#fff;border-radius:21px;margin-top:2%;transform:scale(0.96);font-size:84%;color:#000;'>";


if($type == 'pickups') {
   
    include('inc/complete/pickup.php');
 } 
   
?>