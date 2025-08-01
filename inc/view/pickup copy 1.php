<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

if(!empty($_GET['id'])){
    $id = $_GET['id'];
    // Select Query
    $query = "Select * from zw_pickups where id = $id";
    $res = mysqli_query($con , $query);
    $data = mysqli_fetch_assoc($res);
    $statusArray = ['Pickup Initiated' , 'Truck Departed to Weigh Bridge' , 'Truck at Weigh Bridge' , 'Truck Arrived at MRF' , 'Loading In Progress' , 'Truck Loaded' , 'Truck at Weigh Bridge' , 'In Transit For Disposal' , 'SuccessFully Disposed' , 'Successfully Endorsed By ULB'];
    $imageArray = ['' , 'weigh_bridge_certificate_picture' , 'loaded_truck_picture' , 'loaded_truck_picture' , 'loaded_weigh_bridge_certificate_picture' , 'truck_receipt' , 'recycling_certificate_picture' , 'ulb_endorsement_copy']; // Empty is For Those Steps where image is not available
    
    $dateArrayStepWise = ['pickup_date' , 'weight_bridge_certi_date' , 'loaded_truck_pic_date' , 'loaded_truck_picture_date' , 'loaded_weigh_bridge_certificate_date' , 'truck_receipt_date' , 'recycling_certificate_date'  , 'ulb_endorsement_copy_date'];
    
    $timeArray = ['time_str','weight_bridge_certi_time' , 'loaded_truck_pic_time' , 'loaded_truck_picture_time' , 'loaded_weigh_bridge_certificate_time','truck_receipt_time' , 'recycling_certificate_time' ,  'ulb_endorsement_copy_time'];
    $step = $data['steps'];
    
}


?>
<style>
    .box{
        padding: 19px 0px;
    border: 2px solid;
    width: 97%;
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
</style>
<h2>View Pickup Order</h2>
<div class = "row">
    <div class = "col-md-2">Date</div>
    <div class = "col-md-2">Time</div>
    <div class = "col-md-2">Record</div>
</div>
 
<?php 
for($i = 0;$i<$step;$i++){
?>
<div class = "row box">
    <div class = "col-md-2"><?php echo  $data[$dateArrayStepWise[$i]]?></div>
    <div class = "col-md-2"><?php echo date("H:i", strtotime($data[$timeArray[$i]]))?></div>
    <div class = "col-md-5"><?php echo $statusArray[$i]?></div>
    <?php 
    if(!empty($imageArray[$i] && !empty($data[$imageArray[$i]]))){
    ?>
    <!--<img id="image" src="your_image.jpg" alt="Image">-->
    <div class = "col-md-1"><button class = "btn-primary view-image-button" data-src = "<?php echo $data[$imageArray[$i]]?>"><i class="mi-eye-fill"></i></button></div>
    <div class = "col-md-1"> <button class = "download-image-button" data-src = "<?php echo $data[$imageArray[$i]]?>"><i class="mi-file_download"></i></button></div>
    <?php }?>
</div>
<?php }?>

<!-- The Modal -->
    <div id="imageModal" class="modal">
        <span class="close" onclick="closeModal()">&times;</span>
        <img class="modal-content" id="image">
    </div>


<script>
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
            modal.style.display = "none";
        }
        
        
        
    </script>