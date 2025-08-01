<?php 
// include "../function.php";
// echo "Current File Path: " . __FILE__;
// echo "Current Directory: " . dirname(__FILE__);

error_reporting(E_ALL);
ini_set('display_errors', 1);

if(!empty($_GET['id'])){
    $id = $_GET['id'];
    // Select Query
    $query = "Select * from zw_pickups where id = $id";
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
iframe {
    border: 1px solid black;
    margin: 2px;
}
.container.col-md-10{
  padding: 7px 20px !important;
}
</style>
<h2>PICKUP</h2>
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
        $time = $data[$timeArray[$i]] ? date("H:i", strtotime($data[$timeArray[$i]])) : '';
    }
    
    if(is_array($newStatusArray[$i])){
        foreach($newStatusArray[$i] as $newStatusarray){
            ?>
            <div class = "row box">
    <div class = "col-md-2 date"><?php echo  $dateArrayStepWise[$i] ? date('d-m-y', strtotime($data[$dateArrayStepWise[$i]])) : '';?></div>
    <div class = "col-md-2 time"><?php echo $time?></div>
    <div class = "col-md-5 status">
    <?php if (!empty($imageArray[$i]) && !empty($data[$imageArray[$i]])): ?>
        <a href="<?php echo $data[$imageArray[$i]]?>" target="_blank"><?php echo $newStatusarray?></a>
    <?php else: ?>
        <?php echo $newStatusarray; ?>
    <?php endif; ?>
    
    </div>
    <?php 
    if(!empty($imageArray[$i] && !empty($data[$imageArray[$i]]))){
    ?>
    <!--<img id="image" src="your_image.jpg" alt="Image">-->
    <div class = "col-md-1"><button class = "btn-primary view-image-button" data-src = "<?php echo $data[$imageArray[$i]]?>" title="view"><i class="mi-eye-fill"></i></button></div>
    <div class = "col-md-1"> <button class = "download-image-button" data-src = "<?php echo $data[$imageArray[$i]]?>" title="download"><i class="mi-file_download"></i></button></div>
    <?php }?>
</div>
            <?php
        }
    }
    else{
        ?>
        <div class = "row box">
    <div class = "col-md-2 date"><?php echo $data[$dateArrayStepWise[$i]] ? date('d-m-y', strtotime($data[$dateArrayStepWise[$i]])) : '';?></div>
    <div class = "col-md-2 time"><?php echo $time?></div>
    <div class = "col-md-5 status">
    <?php if (!empty($imageArray[$i]) && !empty($data[$imageArray[$i]])): ?>
        <a href="<?php echo $data[$imageArray[$i]]?>" target="_blank"><?php echo $newStatusArray[$i]?></a>
    <?php else: ?>
        <?php echo $newStatusarray; ?>
    <?php endif; ?>
    </div>
    <?php 
    if(!empty($imageArray[$i] && !empty($data[$imageArray[$i]]))){
    ?>
    <!--<img id="image" src="your_image.jpg" alt="Image">-->
    <div class = "col-md-1"><button class = "btn-primary view-image-button" data-src = "<?php echo $data[$imageArray[$i]]?>" title="view"><i class="mi-eye-fill"></i></button></div>
    <div class = "col-md-1"> <button class = "download-image-button" data-src = "<?php echo $data[$imageArray[$i]]?>" title="download"><i class="mi-file_download"></i></button></div>
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
    <!--<button id = "downloadButton" data-src = "https://zwindia.in/sub/epr/inc/certificate/pickup_certificate.php?url=<?php echo urlencode($parentUrl);?>"><i class="mi-file_download"></i></button>-->
    <iframe  src="https://employee.tidyrabbit.com/sub/epr/inc/certificate/pickup_certificate.php?url=<?php echo urlencode($parentUrl);?>" width="500px" height="600px" frameborder="0"></iframe>
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
        viewImage(dataSrc);
    });
    $(".download-image-button").click(function() {
        var dataSrc = $(this).data("src");
        // Now you have the data-src value, you can use it in your viewImage function
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