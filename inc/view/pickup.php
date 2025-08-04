<?php 
// Only show errors in development mode
if (defined('DEBUG_MODE') && DEBUG_MODE) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Secure the ID parameter
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if (!$id) {
    echo "<div class='alert alert-danger'>Invalid pickup ID</div>";
    exit();
}

// Get pickup data with prepared statement
$query = "SELECT * FROM zw_pickups WHERE id = ?";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    echo "<div class='alert alert-danger'>Pickup not found</div>";
    exit();
}

// Status arrays
$newStatusArray = [
    ['Pickup Initiated', 'Truck Departed to Weigh Bridge'],
    'Truck at Weigh Bridge',
    'Truck Arrived at MRF',
    'Loading In Progress',
    'Truck Loaded',
    'Truck at Weigh Bridge',
    'In Transit For Disposal',
    'Successfully Disposed',
    'Successfully Endorsed By ULB'
];

// Image fields corresponding to each step
$imageArray = [
    '',
    'weigh_bridge_certificate_picture',
    'truck_picture',
    '',
    'loaded_truck_picture',
    'loaded_weigh_bridge_certificate_picture',
    'truck_receipt',
    'recycling_certificate_picture',
    'ulb_endorsement_copy'
];

// Date fields for each step
$dateArrayStepWise = [
    'pickup_date',
    'weight_bridge_certi_date',
    'loaded_truck_pic_date',
    'loaded_truck_pic_date',
    'loaded_truck_picture_date',
    'loaded_weigh_bridge_certificate_date',
    'truck_receipt_date',
    'recycling_certificate_date',
    'ulb_endorsement_copy_date'
];

// Time fields for each step
$timeArray = [
    'time_str',
    'weight_bridge_certi_time',
    'loaded_truck_pic_time',
    'loaded_truck_pic_time',
    'loaded_truck_picture_time',
    'loaded_weigh_bridge_certificate_time',
    'truck_receipt_time',
    'recycling_certificate_time',
    'ulb_endorsement_copy_time'
];

$step = isset($data['steps']) ? intval($data['steps']) : 0;
if ($step > 8) {
    $step = 8;
}

// Get the current URL for certificate generation
$protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https://' : 'http://';
$currentUrl = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

// Function to get image URL
function getImageUrl($imagePath) {
    if (!empty($imagePath)) {
        // Check if it's already a full URL
        if (filter_var($imagePath, FILTER_VALIDATE_URL)) {
            return $imagePath;
        }
        // Otherwise, prepend PROJECT_URL
        return PROJECT_URL . 'sub/epr/' . $imagePath;
    }
    return '';
}
?>

<style>
    .pickup-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 20px;
    }
    
    .box {
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        margin-bottom: 10px;
        background-color: #f8f9fa;
        transition: all 0.3s ease;
    }
    
    .box:hover {
        background-color: #e9ecef;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.8);
        z-index: 1000;
    }
    
    .modal-content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        max-width: 90%;
        max-height: 90%;
        border-radius: 5px;
    }
    
    .modal-close {
        position: absolute;
        top: 20px;
        right: 40px;
        color: white;
        font-size: 35px;
        font-weight: bold;
        cursor: pointer;
        background: rgba(0,0,0,0.5);
        border: none;
        border-radius: 5px;
        padding: 5px 15px;
    }
    
    .modal-close:hover {
        background: rgba(0,0,0,0.8);
    }
    
    .content {
        display: flex;
        gap: 30px;
    }
    
    .view {
        flex: 1;
    }
    
    .certificate-section {
        flex: 0 0 520px;
    }
    
    .date, .time, .status {
        font-size: 14px;
    }
    
    .view-image-button, .download-image-button {
        padding: 6px 12px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        transition: all 0.3s ease;
    }
    
    .view-image-button {
        color: white !important;
        background: #ff8c00;
    }
    
    .view-image-button:hover {
        background: #ff7700;
    }
    
    .download-image-button {
        color: white !important;
        background: #28a745;
    }
    
    .download-image-button:hover {
        background: #218838;
    }
    
    iframe {
        border: 1px solid #ddd;
        border-radius: 5px;
        width: 100%;
        height: 700px;
    }
    
    .status-link {
        color: #007bff;
        text-decoration: none;
    }
    
    .status-link:hover {
        text-decoration: underline;
    }
    
    .header-row {
        background-color: #343a40;
        color: white;
        padding: 10px;
        margin-bottom: 15px;
        border-radius: 5px;
        font-weight: bold;
    }
    
    .no-image {
        color: #6c757d;
    }
    
    @media (max-width: 1200px) {
        .content {
            flex-direction: column;
        }
        
        .certificate-section {
            flex: 1;
            max-width: 100%;
        }
    }
</style>

<div class="pickup-container">
    <h2>PICKUP DETAILS</h2>
    <hr>
    
    <div class="content">
        <div class="view">
            <div class="row header-row">
                <div class="col-md-2">Date</div>
                <div class="col-md-2">Time</div>
                <div class="col-md-5">Status</div>
                <div class="col-md-3">Actions</div>
            </div>
            
            <?php 
            for ($i = 0; $i < $step; $i++) {
                // Get time value
                $time = '';
                if (!empty($data[$timeArray[$i]])) {
                    $time = date("H:i", strtotime($data[$timeArray[$i]]));
                }
                
                // Get date value
                $date = '';
                if (!empty($data[$dateArrayStepWise[$i]])) {
                    $date = date('d-m-Y', strtotime($data[$dateArrayStepWise[$i]]));
                }
                
                // Handle array status (multiple statuses for same step)
                if (is_array($newStatusArray[$i])) {
                    foreach ($newStatusArray[$i] as $statusText) {
                        renderStatusRow($i, $date, $time, $statusText, $imageArray, $data);
                    }
                } else {
                    renderStatusRow($i, $date, $time, $newStatusArray[$i], $imageArray, $data);
                }
            }
            
            function renderStatusRow($index, $date, $time, $statusText, $imageArray, $data) {
                ?>
                <div class="row box">
                    <div class="col-md-2 date"><?php echo htmlspecialchars($date); ?></div>
                    <div class="col-md-2 time"><?php echo htmlspecialchars($time); ?></div>
                    <div class="col-md-5 status">
                        <?php if (!empty($imageArray[$index]) && !empty($data[$imageArray[$index]])): ?>
                            <a href="<?php echo htmlspecialchars(getImageUrl($data[$imageArray[$index]])); ?>" 
                               target="_blank" class="status-link">
                                <?php echo htmlspecialchars($statusText); ?>
                            </a>
                        <?php else: ?>
                            <?php echo htmlspecialchars($statusText); ?>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-3">
                        <?php if (!empty($imageArray[$index]) && !empty($data[$imageArray[$index]])): ?>
                            <button class="view-image-button" 
                                    data-src="<?php echo htmlspecialchars(getImageUrl($data[$imageArray[$index]])); ?>" 
                                    title="View">
                                <i class="fa fa-eye"></i> View
                            </button>
                            <button class="download-image-button" 
                                    data-src="<?php echo htmlspecialchars(getImageUrl($data[$imageArray[$index]])); ?>" 
                                    title="Download">
                                <i class="fa fa-download"></i> Download
                            </button>
                        <?php else: ?>
                            <span class="no-image">No image available</span>
                        <?php endif; ?>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
        
        <div class="certificate-section">
            <h4>Certificate Preview</h4>
            <iframe src="<?php echo PROJECT_URL; ?>sub/epr/inc/certificate/pickup_certificate.php?url=<?php echo urlencode($currentUrl); ?>" 
                    frameborder="0"></iframe>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="modal">
    <button type="button" class="modal-close" onclick="closeModal()">&times;</button>
    <img class="modal-content" id="modalImage" alt="Document Preview">
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
$(document).ready(function() {
    // View image button click
    $(".view-image-button").click(function() {
        var imageSrc = $(this).data("src");
        viewImage(imageSrc);
    });
    
    // Download image button click
    $(".download-image-button").click(function() {
        var imageSrc = $(this).data("src");
        downloadImage(imageSrc);
    });
    
    // Close modal when clicking outside the image
    $("#imageModal").click(function(e) {
        if (e.target.id === "imageModal") {
            closeModal();
        }
    });
    
    // Close modal with Escape key
    $(document).keydown(function(e) {
        if (e.key === "Escape") {
            closeModal();
        }
    });
});

// Function to view the image in modal
function viewImage(src) {
    var modal = document.getElementById("imageModal");
    var image = document.getElementById("modalImage");
    
    modal.style.display = "block";
    image.src = src;
}

// Function to download the image
function downloadImage(src) {
    // Extract filename from URL
    var filename = src.split('/').pop();
    if (!filename) {
        filename = 'download';
    }
    
    // Create temporary anchor element
    var link = document.createElement("a");
    link.href = src;
    link.download = filename;
    link.style.display = "none";
    
    // Add to body, click, and remove
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

// Function to close the modal
function closeModal() {
    document.getElementById("imageModal").style.display = "none";
    document.getElementById("modalImage").src = "";
}
</script>