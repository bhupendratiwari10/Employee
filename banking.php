<?php
include('inc/function.php'); if (session_status() === PHP_SESSION_NONE) {
    session_start();
}; checklogin();
$n = isset($_GET['t']) ? $_GET['t'] : '';
$checkPermission = checkPermission($n . "_view");
// echo "checkPermission" . $checkPermission;
if (empty($checkPermission) || $checkPermission === 0) {
    // echo "You Don't have Permission to access this Page";
    // die;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">   
    <style>
    .bankX{color:#fff!important;background:green;} #statsx div{background:#0000003c;color:#fff;align-items:center;transform:scale(0.84);padding:11px 5px;border-radius:18px;}
    cb i{font-size:221%;background:#4A01C0;color:#fff;padding:16px;border-radius:18px;display:inline;transform:scale(0.9);aspect-ratio:1/1;}
    bx{padding:0;text-indent: 16px;display:block;margin:0!important;} bx p{font-size:80%;}
    
    #userTable_filter, #userTable_length, #userTable_info, #userTable_paginate{display:none;}
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
    <?php include('inc/views/header.php'); ?>
    <div class="container col-md-10" style='padding:5% 3%;background:#fff;'>
        
        <div class='row col-12'>
            <div class='col-md-9'>
            <h2>Banking Overview</h2>
            <p>Manage & track your transactions</p><div style='font-size:80%;'>
                <a href='add.php?type=accounts&atype=9' style='font-size:84%;background:orange;' class='btn'>Add Credit Card</a>
                <a href='add.php?type=accounts&atype=4' style='font-size:84%;' class='btn btn-dark'>Add Bank</a>
            </div>
            
        </div>
        <hr style='margin-top:21px;'>
        
                    <div class='row col-12' style='color:#000!important;'>
                <table id="userTable" class="table">
                    <thead>
                        <tr>
                            <th>Account Details</th>
                            <th>Balance</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- User data will be loaded here using jQuery -->
                    </tbody>
                </table>
            </div>

            <script src="assets/manage.php?file=accountsx"></script>      
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        
    </div>