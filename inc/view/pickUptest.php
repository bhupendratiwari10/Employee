<script src="https://employee.tidyrabbit.com/sub/epr/assets/js/jquery.js"></script>
<link rel="stylesheet" href="https://employee.tidyrabbit.com/sub/epr/assets/css/melticon.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Alata&amp;family=Ubuntu&amp;family=Poppins&amp;display=swap">
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-print-css/css/bootstrap-print.min.css" media="print">

<style>*{font-family:Poppins;} h1,h2{font-family:Alata;} small,p{font-family:ubuntu;}  body{background:#fff;color:#222;} label, #userTable_wrapper *{color:#333;}</style>
<style>button{background:#0000005c;color:#fff;padding:6px 12px;border:0;outline:none;border-radius:4px;}</style>

<?php 
// include "../function.php";
// echo "Current File Path: " . __FILE__;
// echo "Current Directory: " . dirname(__FILE__);

error_reporting(E_ALL);
ini_set('display_errors', 1);



// function encryptData($data, $key, $iv) {
//     $cipherMethod = "AES-256-CBC";
//     $options = 0;

//     // Encrypt the data
//     $encrypted = openssl_encrypt($data, $cipherMethod, $key, $options, $iv);

//     if ($encrypted === false) {
//         throw new Exception('Encryption failed: ' . openssl_error_string());
//     }

//     return base64_encode($encrypted);
// }

// Function to decrypt the data
function decryptData($data, $key) {
    $cipherMethod = "AES-256-CBC";
    $options = 0;

    $decodedData = base64_decode($data);
    $iv = substr($decodedData, 0, 16); // Extract IV from the decoded data
    $dataToDecrypt = substr($decodedData, 16); // Extract data to decrypt

    // Decrypt the data
    $decrypted = openssl_decrypt($dataToDecrypt, $cipherMethod, $key, $options, $iv);

    if ($decrypted === false) {
        throw new Exception('Decryption failed: ' . openssl_error_string());
    }

    return $decrypted;
}
// // Example usage
// $encryptionKey = "&Axj26@3_HEWQDhn+x1j6AKPPy8muwpH"; // Change this to a strong, secret key
// $iv = openssl_random_pseudo_bytes(16); // Initialization Vector (IV)

// $originalData = "Hello, world!";
// echo "Original Data: $originalData\n";

// try {
//     // Encrypt the data
//     $encryptedData = encryptData($originalData, $encryptionKey, $iv);
//     echo "Encrypted Data: $encryptedData\n";

//     // Decrypt the data
//     $decryptedData = decryptData($encryptedData, $encryptionKey, $iv);
//     echo "Decrypted Data: $decryptedData\n";
// } catch (Exception $e) {
//     echo "Error: " . $e->getMessage() . "\n";
// }







// function dbCon(){
    $con = mysqli_connect("localhost","zwindia_root","UEws49t2iM@EhAa","zwindia_software");
    
//     function decryptData($data, $key, $iv) {
        
//     $cipherMethod = "AES-256-CBC";
//     $options = 0;

//     // $decrypted = openssl_decrypt(base64_decode($data), $cipherMethod, $key, $options, $iv);
//     // echo $decrypted;die;
//     // return $decrypted;
//     $decrypted = openssl_decrypt(base64_decode($data), $cipherMethod, $key, $options, $iv);

//     if ($decrypted === false) {
//         throw new Exception('Decryption failed: ' . openssl_error_string());
//     }

//     return $decrypted;
// }
    //mysqli_set_charset($con,"utf-8");
    // return $con;
// }

if(!empty($_GET['id'])){
    $id = base64_decode($_GET['id']);
    // echo $id;
    // Select Query
    // $encryptionKey = "&Axj26@3_HEWQDhn+x1j6AKPPy8muwpH"; // Change this to a strong, secret key
    // $idTest = decryptData($id , $encryptionKey);
    // echo $idTest;die;
    $query = "Select * from zw_pickups where id = $id";
    // echo $query;die;
    $res = mysqli_query($con , $query);
    $data = mysqli_fetch_assoc($res);
    // $statusArray = ['Pickup Initiated' , 'Truck Departed to Weigh Bridge' , 'Truck at Weigh Bridge' , 'Truck Arrived at MRF' , 'Loading In Progress' , 'Truck Loaded' , 'Truck at Weigh Bridge' , 'In Transit For Disposal' , 'SuccessFully Disposed' , 'Successfully Endorsed By ULB'];
    $newStatusArray = [array('Pickup Initiated' , 'Truck Departed to Weigh Bridge') ,'Truck at Weigh Bridge' , 'Truck Arrived at MRF' , 'Loading In Progress' , 'Truck Loaded' , 'Truck at Weigh Bridge' , 'In Transit For Disposal' , 'SuccessFully Disposed' , 'Successfully Endorsed By ULB' ];
    $imageArray = ['' , 'weigh_bridge_certificate_picture' , 'truck_picture' , '', 'loaded_truck_picture' , 'loaded_weigh_bridge_certificate_picture' , 'truck_receipt' , 'recycling_certificate_picture' , 'ulb_endorsement_copy']; // Empty is For Those Steps where image is not available
    
    $dateArrayStepWise = ['pickup_date' , 'weight_bridge_certi_date' , 'loaded_truck_pic_date' ,'loaded_truck_pic_date' ,  'loaded_truck_picture_date' , 'loaded_weigh_bridge_certificate_date' , 'truck_receipt_date' , 'recycling_certificate_date'  , 'ulb_endorsement_copy_date'];
    
    $timeArray = ['time_str','weight_bridge_certi_time' , 'loaded_truck_pic_time' , 'loaded_truck_pic_time' , 'loaded_truck_picture_time' , 'loaded_weigh_bridge_certificate_time','truck_receipt_time' , 'recycling_certificate_time' ,  'ulb_endorsement_copy_time'];
    $step = $data['steps'];
    if($step > 8){
        $step = 8;
    }
    
}


?>
<style>
    .box {
    padding: 19px 0px;
    border: 2px solid;
    /*width: 52%;*/
    margin-top: 3px;
}
    /* Styles for the modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 1;
        }

        /* Styles for the modal content (the image) */
        .modal-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            max-width: 80%;
            max-height: 80%;
        }
/*    .content {*/
  /*overflow: hidden; */
/*}*/

.view {
  float: left;
  width: 50.33%; /* Set the width to divide the container into equal parts */
  box-sizing: border-box; /* Include padding and border in the box's total width */
}
.iframe{
    margin-left:50px !important;
}
.date , .time , .status {
    font-size:14px;
}
.view-image-button{
    padding: 8px;
    color: orange!important;
    background: white;
}
.download-image-button{
    padding: 8px;
    color: green!important;
    background: white;
}
</style>
<h2>VIEW PICKUP</h2>
<hr>
<div class = "content">
<div class = "container view">
<div class = "row">
    <div class = "col-md-2">Date</div>
    <div class = "col-md-2">Time</div>
    <div class = "col-md-2">Record</div>
</div>
 
<?php 
// echo $step;die;
for($i = 0;$i<$step;$i++){
    
    if($data[$timeArray[$i]] == null || $data[$timeArray[$i]] == ''){
        $time = '';
    }
    else{
        $time = date("H:i", strtotime($data[$timeArray[$i]]));
    }
    
    if(is_array($newStatusArray[$i])){
        foreach($newStatusArray[$i] as $newStatusarray){
            ?>
            <div class = "row box">
    <div class = "col-md-2 date"><?php echo  date('d-m-y', strtotime($data[$dateArrayStepWise[$i]]));?></div>
    <div class = "col-md-2 time"><?php echo $time?></div>
    <div class = "col-md-5 status"><?php echo $newStatusarray?></div>
    <?php 
    if(!empty($imageArray[$i] && !empty($data[$imageArray[$i]]))){
    ?>
    <!--<img id="image" src="your_image.jpg" alt="Image">-->
    <div class = "col-md-1"><button class = "btn-primary view-image-button" data-src = "<?php echo $data[$imageArray[$i]]?>"><i class="mi-eye-fill"></i></button></div>
    <div class = "col-md-1"> <button class = "download-image-button" data-src = "<?php echo $data[$imageArray[$i]]?>"><i class="mi-file_download"></i></button></div>
    <?php }?>
</div>
            <?php
        }
    }
    else{
        ?>
        <div class = "row box">
    <div class = "col-md-2 date"><?php echo date('d-m-y', strtotime($data[$dateArrayStepWise[$i]]));?></div>
    <div class = "col-md-2 time"><?php echo $time?></div>
    <div class = "col-md-5 status"><?php echo $newStatusArray[$i]?></div>
    <?php 
    if(!empty($imageArray[$i] && !empty($data[$imageArray[$i]]))){
    ?>
    <!--<img id="image" src="your_image.jpg" alt="Image">-->
    <div class = "col-md-1"><button class = "btn-primary view-image-button" data-src = "<?php echo $data[$imageArray[$i]]?>"><i class="mi-eye-fill"></i></button></div>
    <div class = "col-md-1"> <button class = "download-image-button" data-src = "<?php echo $data[$imageArray[$i]]?>"><i class="mi-file_download"></i></button></div>
    <?php }?>
</div>
   <?php }
    
?>

<?php }?>
</div>
<div id="downloadContent" class = "container" style="
    /* margin-left: 110px; */
    width: 24px;">
    <div class = "iframe" >
        <?php
    // Get the current URL of the parent document
    $parentUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    ?>
    <!--<button id = "downloadButton" data-src = "https://employee.tidyrabbit.com/sub/epr/inc/certificate/pickup_certificate.php?url=<?php echo urlencode($parentUrl);?>"><i class="mi-file_download"></i></button>-->
    <iframe  src="https://employee.tidyrabbit.com/sub/epr/inc/certificate/pickup_certificate.php?url=<?php echo urlencode($parentUrl);?>&flag=true" width="500px" height="3000px" frameborder="0"></iframe>
    </div>
    
</div>
</div>
<!-- The Modal -->
    <div id="imageModal" class="modal">
        <button type="button" class="btn btn-secondary" id="partner_cncl_btn2" data-dismiss="modal"onclick="closeModal()">&times;</button>
        <img class="modal-content" id="image">
    </div>

 
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
function generatePDF(content) {
      // Create a new jsPDF instance
      var pdf = new jsPDF();

      // Generate PDF from HTML
      pdf.html(content, {
        callback: function(pdf) {
          // Save the PDF as a file
          pdf.save('output.pdf');
        }
      });
    }
$(document).ready(function() {
   
    $(".view-image-button").click(function() {
        var dataSrc = $(this).data("src");
        // Now you have the data-src value, you can use it in your viewImage function
        dataSrc = "https://employee.tidyrabbit.com/sub/epr/"+dataSrc;
        viewImage(dataSrc);
    });
    $(".download-image-button").click(function() {
        var dataSrc = $(this).data("src");
        // Now you have the data-src value, you can use it in your viewImage function
        	dataSrc = "https://employee.tidyrabbit.com/sub/epr/"+dataSrc;
        downloadImage(dataSrc);
    });
});
        // Function to view the image in a new tab
        function viewImage(src) {
            var imageSrc =src;
            
             // Get references to the modal and the image
        var modal = document.getElementById("imageModal");
        var image = document.getElementById("image");
        // When the "View" button is clicked, display the modal
            modal.style.display = "block";
            image.src = imageSrc;
       
            // window.open(imageSrc, "_blank");
        }

        // Function to trigger the image download
        function downloadImage(src) {
            
            var imageSrc = src;
// Get the file extension
var fileExtension = imageSrc.split('.').pop();

// Convert to lowercase (optional, for consistency)
fileExtension = fileExtension.toLowerCase();
            // Create an anchor element to trigger the download
            var link = document.createElement("a");
            link.href = imageSrc;
            link.download = "image."+fileExtension;
            link.click();
        }
        // Function to close the modal
        function closeModal() {
            // alert("aa gaya");
            $('#imageModal').hide(); 
        }
        
        
         $('#downloadButton').click(function() {
	      // Get the HTML content
	      var url = $(this).data("src");
	     // var url = 'https://example.com';
		console.log(url);
	      // Fetch HTML content from the URL
	      $.get(url, function(data) {
		// Create a new jsPDF instance
		var pdf = new html2pdf();

		// Generate PDF from HTML content
		pdf.from(data).outputPdf('dataurlnewwindow');

	      });

	 });

    </script>