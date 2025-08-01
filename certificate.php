<?php 

include('inc/function.php'); if (session_status() === PHP_SESSION_NONE) {
    session_start();
}; checklogin(); $con = dbCon();$type = $_GET['type'];

?>

<?php

if($type=='cnc'){
    include('inc/certificate/carbon_neutral.php');
}else if($type=='epr'){
    include('inc/print/quote.php');
}else if($type=='pickup'){
    include('inc/certificate/pickup_certificate.php');
}


?>