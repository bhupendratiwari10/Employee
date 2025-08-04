<?php 
include FULL_PATH.'/sub/epr/inc/function.php';
include "../../phpqrcode-master/qrlib.php";

$con = dbCon();

$pickupsid = $_GET['pid'];
// Encript And Decrypt Function

    $query = "Select * from zw_pickups where id = $pickupsid";
    $res = mysqli_query($con , $query);
    
    $data = mysqli_fetch_assoc($res);
    
    
    $state = $data['state']?$data['state']:'';
    
    $quantity = $data['net_quantity'] ? $data['net_quantity'] : 0;
    
    $clientId = $data['client'];
    $getNameByID = "Select id , customer_display_name from zw_customers where id = $clientId"; // Client Name
   
    $categoryName = "SELECT title FROM zw_pickup_categories WHERE id = '{$data['category']}'";
    $categoryQuery = mysqli_query($con , $categoryName);
    
    $categoryData = mysqli_fetch_assoc($categoryQuery);
    
    $category = $categoryData['title'];
    
    $res2 = mysqli_query($con , $getNameByID);
   
    $clientData = mysqli_fetch_assoc($res2);
    $cientName = $clientData['customer_display_name'];
    
    $new_url = "https://employee.tidyrabbit.com/sub/epr/inc/reports/eprpickups/pickup_certificate.php?pid=".$pickupsid;



$urlValue = "";
$outputPath = "../../certificate/QR/output.png"; // Specify the path where you want to save the QR code image


// New URL

generateQRCode($new_url, $outputPath);
  
 function generateQRCode($url, $outputPath)
{
    QRcode::png($url, $outputPath, QR_ECLEVEL_L, 10, 2);
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Certificate</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
</head>
<style>
body{background-image: url("https://employee.tidyrabbit.com/sub/epr/inc/certificate/images/2.png");background-position: center;background-repeat: no-repeat;background-size: cover;position: relative;margin: auto;

}
</style>
<body style="background-image: url('https://employee.tidyrabbit.com/sub/epr/inc/certificate/images/2.png');background-position: center;background-repeat: no-repeat;background-size: 102%;position: relative;margin: 0 auto;height:1050px;">
<div class="cert_back">
<div class="container-fluid">
    <div class="text-center"><img src="https://employee.tidyrabbit.com/sub/epr/inc/certificate/images/zw%20logo.png" alt="" style='width:18%;padding:11px;'></div>
    <div class="text-center"><h4 style='margin-bottom:0px;'>CERTIFICATE</h4><p style='font-size:76%;margin:0px 0px;'>OF DISPOSAL</p></div>
    <div class="text-center"><img src="QR/output.png" alt="" style="width:69px;"></div>
    <center><div class="text-center" style="width: 200px;color:#555;border: 1px solid;padding: 6px 0px;border-radius: 11px;transform: scale(0.69);">
        <small>Certificate# <span>12346789</span></small><br>
        <small>Invoice# <span><?php echo $data['epr_invoice']; ?></span></small>
    </div></center>
    
    <div class="text-center">
        <h6>This Certificate is ISSUED TO</h6>
        <h5 style = "color:orange"> M/S <?php echo $cientName?></h5>
        <p style='font-size:90%;'>This is to certify that we, Tidy Rabbit GLOBAL (P) LTD. , has successfully collected the following quantities of Post Consumer Laminate Waste in <b><?php echo $state?></b> from end users, as stated, to fullfill the Extended Producer Responsibility (EPR) obligation . The Waste has been collected for recycling during the period of 1 Febuary 2021 to 28 Febuary 2021, as it has been safely and completely disposed of in accordance with the PWM rules of 2016 or any subsequent amendments. We certify that mentioned quantity has not been accounted for or billed to any other entity.   </p>
    </div>

    <center style='font-size:51%;'>
        <div class="col-sm-6 text-center crt_inv"><table class = "table"><tr class ="table"><td>01.</td><td><b><?php echo $category?></b></td><td><b><?php echo $quantity?></b></td></tr></table></div>
        <div class="crt_foot"><div><p></p></div><div><img src="https://employee.tidyrabbit.com/sub/epr/inc/certificate/images/dummy-profile.jpg" alt="" width="70px" height="70px"></div><div><p><?php echo date('Y/m/d')?></p></div></div>
    </center>
    
</div>
</div>

</body>
</html>
