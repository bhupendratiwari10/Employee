<?php 
include "/home/zwindia/public_html/sub/epr/inc/function.php";
include "/home/zwindia/public_html/sub/epr/inc/phpqrcode-master/qrlib.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);




// Encript And Decrypt Function




// Example usage
function encryptData($data, $key, $iv) {
    $cipherMethod = "AES-256-CBC";
    $options = 0;

    $encrypted = openssl_encrypt($data, $cipherMethod, $key, $options, $iv);

    return base64_encode($iv . $encrypted); // Include IV in the result
}



if (isset($_GET['url'])) {
    $con = dbCon();
    // Retrieve the value of the 'url' parameter
    // echo "<pre>";print_r($_GET);die;
    $parentUrl = urldecode($_GET['url']);
    
    $parsed_url = parse_url($parentUrl);

     // Check if the query string is present
     if (isset($parsed_url['query'])) {
         // Parse the query string
        parse_str($parsed_url['query'], $query_params);

        // Check if 'id' parameter exists
    if (isset($query_params['id'])) {
        if(isset($_GET['flag'])){
            $id_value = base64_decode($query_params['id']);
        }else{
        $id_value = $query_params['id'];
        }
       
    } else {
        return "id Value Must be there";
    }
} else {
    echo "No query string in the URL.";
}
  
  
  
    // echo "<pre>";print_r($explodedValue);die;
    // $idString = $explodedValue[1];
    
    // $idArray = explode('=' , $parentUrl);
    
    
    // $encryptionKey = "&Axj26@3_HEWQDhn+x1j6AKPPy8muwpH"; // Change this to a strong, secret key
    // $iv = openssl_random_pseudo_bytes(16); // Initialization Vector (IV)
    // // $iv should be stored or transmitted along with the encrypted data
    // $encryptedData = encryptData($id_value, $encryptionKey, $iv);

    $idencrypted =base64_encode($id_value);
    // echo $idencrypted;die;
    // Now $parentUrl contains the URL of the parent document
    // echo "Parent Document URL: $parentUrl";die;
     $query = "Select * from zw_pickups where id = $id_value";
    //  echo $query;die;
    // echo $query;die;
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
//   echo "<pre>"; print_r($clientData);die;
    $cientName = $clientData['customer_display_name'];
    
    
   

 // Parse the query string
    parse_str($parsed_url['query'], $query_params);

    // Replace the 'id' parameter with a new value
    $query_params['id'] = $idencrypted;
    
    $parsed_url['path'] = '/sub/epr/inc/view/pickUptest.php';

        // Rebuild the modified URL
        // $modified_url = http_build_url($parsed_url);

    // Reconstruct the URL with the updated query string
   $parsed_url['query'] = http_build_query(['id' => $idencrypted]);
    $new_url = $parsed_url['scheme'] . '://' . $parsed_url['host'] . $parsed_url['path'] . '?' . $parsed_url['query'];

    // echo $parsed_url['scheme'] . " " . $parsed_url['host'] . " ".  $parsed_url['path'] . " ".  $parsed_url['query'];die;
   




$urlValue = "";
$outputPath = "QR/output.png"; // Specify the path where you want to save the QR code image


// New URL

generateQRCode($new_url, $outputPath);
    
    
    
} else {
    echo "No URL parameter provided";
}

 function generateQRCode($url, $outputPath)
{
    QRcode::png($url, $outputPath, QR_ECLEVEL_L, 10, 2);
}
// if(!empty($_GET['id'])){
//     echo "hjk";die;
//     $id = $_GET['id'];
//     // Select Query
   
//     // $statusArray = ['Pickup Initiated' , 'Truck Departed to Weigh Bridge' , 'Truck at Weigh Bridge' , 'Truck Arrived at MRF' , 'Loading In Progress' , 'Truck Loaded' , 'Truck at Weigh Bridge' , 'In Transit For Disposal' , 'SuccessFully Disposed' , 'Successfully Endorsed By ULB'];
//     // $newStatusArray = [array('Pickup Initiated' , 'Truck Departed to Weigh Bridge') ,'Truck at Weigh Bridge' , array('Truck Arrived at MRF' , 'Loading In Progress') , 'Truck Loaded' , 'Truck at Weigh Bridge' , 'In Transit For Disposal' , 'SuccessFully Disposed' , 'Successfully Endorsed By ULB' ];
//     // $imageArray = ['' , 'weigh_bridge_certificate_picture' , 'loaded_truck_picture' , 'loaded_truck_picture' , 'loaded_weigh_bridge_certificate_picture' , 'truck_receipt' , 'recycling_certificate_picture' , 'ulb_endorsement_copy']; // Empty is For Those Steps where image is not available
    
//     // $dateArrayStepWise = ['pickup_date' , 'weight_bridge_certi_date' , 'loaded_truck_pic_date' , 'loaded_truck_picture_date' , 'loaded_weigh_bridge_certificate_date' , 'truck_receipt_date' , 'recycling_certificate_date'  , 'ulb_endorsement_copy_date'];
    
//     // $timeArray = ['time_str','weight_bridge_certi_time' , 'loaded_truck_pic_time' , 'loaded_truck_picture_time' , 'loaded_weigh_bridge_certificate_time','truck_receipt_time' , 'recycling_certificate_time' ,  'ulb_endorsement_copy_time'];
//     // $step = $data['steps'];
    
    
    
// } 



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
body{background-image: url("https://zwindia.in/sub/epr/inc/certificate/images/2.png");background-position: center;background-repeat: no-repeat;background-size: cover;position: relative;margin: auto;

}
</style>
<body style="padding:5% 5vw; background-image: url('https://zwindia.in/sub/epr/inc/certificate/images/2.png');background-position: center;background-repeat: no-repeat;background-size: 102%;position: relative;margin: auto;">
<div class="cert_back">
<div class="container-fluid">
    <div class="text-center"><img src="https://zwindia.in/sub/epr/inc/certificate/images/zw%20logo.png" alt="" style='width:18%;padding:11px;'></div>
    <div class="text-center"><h4 style='margin-bottom:0px;'>CERTIFICATE</h4><p style='font-size:76%;margin:0px 0px;'>OF DISPOSAL</p></div>
    <div class="text-center"><img src="QR/output.png" alt="" style="width:69px;"></div>
    <center><div class="text-center" style="width: 200px;color:#555;border: 1px solid;padding: 6px 0px;border-radius: 11px;transform: scale(0.69);">
        <small>Certificate# <span>12346789</span></small><br>
        <small>Invoice# <span>123456789</span></small>
    </div></center>
    
    <div class="text-center">
        <h6>This Certificate is ISSUED TO</h6>
        <h5 style = "color:orange"> M/S <?php echo $cientName?></h5>
        <p style='font-size:51%;'>This is to certify that we, ZW GLOBAL (P) LTD. , has successfully collected the following quantities of Post Consumer Laminate Waste in <b><?php echo $state?></b> from end users, as stated, to fullfill the Extended Producer Responsibility (EPR) obligation . The Waste has been collected for recycling during the period of 1 Febuary 2021 to 28 Febuary 2021, as it has been safely and completely disposed of in accordance with the PWM rules of 2016 or any subsequent amendments. We certify that mentioned quantity has not been accounted for or billed to any other entity.   </p>
    </div>

    <center style='font-size:51%;'>
        <div class="col-sm-6 text-center crt_inv"><table class = "table"><tr class ="table"><td>01.</td><td><b><?php echo $category?></b></td><td><b><?php echo $quantity?></b></td></tr></table></div>
        <div class="crt_foot"><div><p></p></div><div><img src="https://zwindia.in/sub/epr/inc/certificate/images/dummy-profile.jpg" alt="" width="70px" height="70px"></div><div><p><?php echo date('Y/m/d')?></p></div></div>
    </center>
    
</div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>