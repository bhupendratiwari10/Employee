<?php 

include('inc/function.php'); if (session_status() === PHP_SESSION_NONE) {
    session_start();
}; checklogin(); $con = dbCon();$type = $_GET['type'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title> ZW India | <?php echo "Add ".$type; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-print-css/css/bootstrap-print.min.css" media="print">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Alata&amp;family=Ubuntu&amp;family=Poppins&amp;display=swap">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>*{font-family:poppins;} h1,h2,h3,h4,h5,h6{font-family:Alata;}</style>
</head>
<body>
 
<?php

if($type=='invoice'){
    include('inc/print/invoice.php');
}else if($type=='eprinvoice'){
    include('inc/print/eprinvoice.php');
}else if($type=='orders'){
    include('inc/print/order.php');
}else if($type=='quote'){
    include('inc/print/quote.php');
}else if($type=='chartaccount'){
    include('inc/print/chartaccount.php');
}


?>
