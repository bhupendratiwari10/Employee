<?php
include('inc/function.php'); 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}; 
checklogin();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/vanilla-calendar-pro/build/vanilla-calendar.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/vanilla-calendar-pro/build/vanilla-calendar.min.js" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script><script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  
    <style>
    .dashX{color:#fff!important;background:green;} #statsx div{background:#0000001c;color:#333;align-items:center;transform:scale(0.84);padding:11px 5px;border-radius:18px;}
    cb i{font-size:221%;background:#178a29;color:#fff;padding:16px;border-radius:18px;display:inline;transform:scale(0.9);aspect-ratio:1/1;}
    bx{padding:0;text-indent: 16px;display:block;margin:0!important;} bx p{font-size:80%;}
    .col-1 {width: 80px; !important}
    .toing h5 k{transform:scale(0.69)!important;}
    </style>
</head>
<body class='row'>
    <?php include('inc/views/header.php'); ?>
    <div class="container col-md" style='padding:5% 3%;background:#f3f3f3;transform:none!important;'>
        <?php
            include('inc/views/dash_green.php');
        ?>