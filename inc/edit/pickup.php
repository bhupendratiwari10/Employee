<?php
// Only show errors in development mode
if (defined('DEBUG_MODE') && DEBUG_MODE) {
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Secure the ID parameter
$uid = isset($_GET['id']) ? intval($_GET['id']) : 0;

if (!$uid) {
    header('Location: ' . PROJECT_URL . 'sub/epr/manage.php?t=pickups');
    exit();
}

// Get pickup data with prepared statement
$query = "SELECT * FROM `zw_pickups` WHERE id = ?";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, "i", $uid);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$res = mysqli_fetch_assoc($result);

if (!$res) {
    echo "<script>alert('Pickup not found');</script>";
    echo "<script>window.location.href = '" . PROJECT_URL . "sub/epr/manage.php?t=pickups';</script>";
    exit();
}

$step = !empty($res['steps']) ? intval($res['steps']) : 0;

// Define base URL for images
$imageBaseUrl = PROJECT_URL . 'sub/epr/';

// Function to get image URL
function getImageUrl($imagePath) {
    global $imageBaseUrl;
    if (!empty($imagePath) && file_exists(FULL_PATH . '/sub/epr/' . $imagePath)) {
        return $imageBaseUrl . $imagePath;
    }
    return '';
}
?>

<style>
    .form-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }
    
    .box {
        height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .image_section {
        height: 400px; 
        width: 400px; 
        border: 2px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
        background-color: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .image-preview {
        width: 383px;
        height: 316px;
        object-fit: contain;
        border-radius: 4px;
    }
    
    .file-preview {
        text-align: center;
    }
    
    .page {
        display: none;
        min-height: 500px;
    }
    
    .page:first-child {
        display: block;
    }
    
    .buttons {
        margin-top: 30px;
    }
    
    .form-label {
        font-weight: 600;
        margin-bottom: 5px;
    }
    
    .upload-section label {
        display: block;
        margin-bottom: 10px;
        font-weight: 600;
    }
    
    .btn {
        padding: 10px 20px;
        margin-right: 10px;
    }
    
    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }
    
    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #004085;
    }
</style>

<div class="form-container">
    <h2>Edit Pickup</h2>
    <form method="post" action="" enctype="multipart/form-data" id="multi-page-form">
        <!-- Page 1: Basic Information -->
        <div class="row g-3 page">
            <div class="col-md-6">
                <label class="form-label">Select Client</label>
                <select class="form-select" name="client" required>
                    <option value="" disabled>Select a client</option>
                    <?php optionPrintAdv("zw_customers WHERE customer_type!='ulb'", "id", "customer_display_name", $res['client']); ?>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Select P/O #</label>
                <select class='form-select' name='po' required>
                    <option value="" disabled>Select a P/O #</option>
                    <?php optionPrintAdvx("zw_orders", "id", "id", "#ZW-000R-", $res['po']); ?>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Pickup Date</label>
                <input class="form-control date" type="date" name="pickup_date" 
                       value="<?php echo htmlspecialchars($res['pickup_date']); ?>" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Select ULB</label>
                <select class='form-select' name='ulb' required>
                    <option value="" disabled>Select a ULB</option>
                    <?php optionPrintAdv("zw_ulb", "id", "title", $res['ulb']); ?>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Site Supervisor</label>
                <select class='form-select' name='supervisor'>
                    <option value="">Select a Site Supervisor</option>
                    <?php optionPrintAdv("zw_user WHERE user_role='3'", "id", "username", $res['supervisor']); ?>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Truck Registration Number</label>
                <input class="form-control" type="text" name="truck_registration_number" 
                       placeholder="Enter truck registration number" 
                       value="<?php echo htmlspecialchars($res['truck_registration_number']); ?>" required>
            </div>

            <div class="row buttons">
                <div class="col-md-12">
                    <button type="button" class="btn btn-primary next-page" data-step="1">Next</button>
                </div>
            </div>
        </div>

        <!-- Page 2: Weigh Bridge Certificate (Empty) -->
        <div class="page">
            <h3>Weigh Bridge Certificate (Empty)</h3>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="image_section">
                            <div class="box">
                                <div class="form-group">
                                    <div class="upload-section">
                                        <label for="bridge_certificate">Upload Weigh Bridge Certificate (Empty)</label>
                                        <input type="file" class="form-control-file image_upload_section" 
                                               id="bridge_certificate" accept="image/*, .pdf" 
                                               name="weigh_bridge_certificate_picture">
                                        <div class="file-preview">
                                            <img class="image-preview" id="bridge_certificate_preview" 
                                                 src="<?php echo getImageUrl($res['weigh_bridge_certificate_picture']); ?>" 
                                                 alt="Preview" <?php echo empty($res['weigh_bridge_certificate_picture']) ? 'style="display:none;"' : ''; ?>>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="bridge_date">Date</label>
                                    <input type="date" class="form-control date" id="bridge_date" 
                                           value="<?php echo htmlspecialchars($res['weight_bridge_certi_date']); ?>" 
                                           name="weight_bridge_certi_date" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="bridge_time">Time</label>
                                    <input type="time" class="form-control" id="bridge_time" 
                                           value="<?php echo htmlspecialchars($res['weight_bridge_certi_time']); ?>" 
                                           name="weight_bridge_certi_time" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="buttons">
                <button type="button" class="btn btn-secondary prev-page">Previous</button>
                <button type="button" class="btn btn-primary next-page" data-step="2">Next</button>
            </div>
        </div>

        <!-- Page 3: Truck Picture -->
        <div class="page">
            <h3>Truck Picture</h3>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="image_section">
                            <div class="box">
                                <div class="form-group">
                                    <div class="upload-section">
                                        <label for="truck_picture">Upload Truck Picture</label>
                                        <input type="file" class="form-control-file image_upload_section" 
                                               id="truck_picture" accept="image/*, .pdf" name="truck_picture">
                                        <div class="file-preview">
                                            <img class="image-preview" id="truck_picture_preview" 
                                                 src="<?php echo getImageUrl($res['truck_picture']); ?>" 
                                                 alt="Preview" <?php echo empty($res['truck_picture']) ? 'style="display:none;"' : ''; ?>>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="truck_date">Date</label>
                                    <input type="date" class="form-control date" id="truck_date" 
                                           value="<?php echo htmlspecialchars($res['loaded_truck_pic_date']); ?>" 
                                           name="loaded_truck_pic_date" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="truck_time">Time</label>
                                    <input type="time" class="form-control" id="truck_time" 
                                           name="loaded_truck_pic_time" 
                                           value="<?php echo htmlspecialchars($res['loaded_truck_pic_time']); ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="buttons">
                <button type="button" class="btn btn-secondary prev-page">Previous</button>
                <button type="button" class="btn btn-primary next-page" data-step="3">Next</button>
            </div>
        </div>

        <!-- Continue with other pages following the same pattern... -->
        <!-- Page 4: Loaded Truck Picture -->
        <div class="page">
            <h3>Loaded Truck Picture</h3>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="image_section">
                            <div class="box">
                                <div class="form-group">
                                    <div class="upload-section">
                                        <label for="loaded_truck_picture">Loaded Truck Picture</label>
                                        <input type="file" class="form-control-file image_upload_section" 
                                               id="loaded_truck_picture" accept="image/*, .pdf" 
                                               name="loaded_truck_picture">
                                        <div class="file-preview">
                                            <img class="image-preview" id="loaded_truck_preview" 
                                                 src="<?php echo getImageUrl($res['loaded_truck_picture']); ?>" 
                                                 alt="Preview" <?php echo empty($res['loaded_truck_picture']) ? 'style="display:none;"' : ''; ?>>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="loaded_truck_picture_date">Date</label>
                                    <input type="date" class="form-control date" id="loaded_truck_picture_date" 
                                           name="loaded_truck_picture_date" 
                                           value="<?php echo htmlspecialchars($res['loaded_truck_picture_date']); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="loaded_truck_picture_time">Time</label>
                                    <input type="time" class="form-control" id="loaded_truck_picture_time" 
                                           name="loaded_truck_picture_time" 
                                           value="<?php echo htmlspecialchars($res['loaded_truck_picture_time']); ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="buttons">
                <button type="button" class="btn btn-secondary prev-page">Previous</button>
                <button type="button" class="btn btn-primary next-page" data-step="4">Next</button>
            </div>
        </div>

        <!-- Page 5: Weigh Bridge Certificate (Loaded) -->
        <div class="page">
            <h3>Weigh Bridge Certificate (Loaded)</h3>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="image_section">
                            <div class="box">
                                <div class="form-group">
                                    <div class="upload-section">
                                        <label for="bridge_certificate_loaded">Upload Weigh Bridge Certificate (Loaded)</label>
                                        <input type="file" class="form-control-file image_upload_section" 
                                               id="bridge_certificate_loaded" accept="image/*, .pdf" 
                                               name="loaded_weigh_bridge_certificate_picture">
                                        <div class="file-preview">
                                            <img class="image-preview" id="bridge_certificate_loaded_preview" 
                                                 src="<?php echo getImageUrl($res['loaded_weigh_bridge_certificate_picture']); ?>" 
                                                 alt="Preview" <?php echo empty($res['loaded_weigh_bridge_certificate_picture']) ? 'style="display:none;"' : ''; ?>>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="bridge_date_loaded">Date</label>
                                    <input type="date" class="form-control date" id="bridge_date_loaded" 
                                           name="loaded_weigh_bridge_certificate_date" 
                                           value="<?php echo htmlspecialchars($res['loaded_weigh_bridge_certificate_date']); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="bridge_time_loaded">Time</label>
                                    <input type="time" class="form-control" id="bridge_time_loaded" 
                                           name="loaded_weigh_bridge_certificate_time" 
                                           value="<?php echo htmlspecialchars($res['loaded_weigh_bridge_certificate_time']); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="bridge_time_loaded_netQuantity">Net Quantity (KG)</label>
                                    <input type="number" class="form-control" id="bridge_time_loaded_netQuantity" 
                                           name="net_quantity" value="<?php echo htmlspecialchars($res['net_quantity']); ?>" 
                                           step="0.01" min="0" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="buttons">
                <button type="button" class="btn btn-secondary prev-page">Previous</button>
                <button type="button" class="btn btn-primary next-page" data-step="5">Next</button>
            </div>
        </div>

        <!-- Remaining pages continue with same pattern... -->
        <!-- I'll show the final page and script updates -->

        <!-- Page 8: ULB Endorsement -->
        <div class="page">
            <h3>ULB Endorsement Copy</h3>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="image_section">
                            <div class="box">
                                <div class="form-group">
                                    <div class="upload-section">
                                        <label for="ulb_endorsement_copy">ULB Endorsement Copy</label>
                                        <input type="file" class="form-control-file image_upload_section" 
                                               id="ulb_endorsement_copy" accept="image/*, .pdf" 
                                               name="ulb_endorsement_copy">
                                        <div class="file-preview">
                                            <img class="image-preview" id="ulb_endorsement_copy_preview" 
                                                 src="<?php echo getImageUrl($res['ulb_endorsement_copy']); ?>" 
                                                 alt="Preview" <?php echo empty($res['ulb_endorsement_copy']) ? 'style="display:none;"' : ''; ?>>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ulb_endorsement_copy_date">Date</label>
                                    <input type="date" class="form-control date" id="ulb_endorsement_copy_date" 
                                           name="ulb_endorsement_copy_date" 
                                           value="<?php echo htmlspecialchars($res['ulb_endorsement_copy_date']); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ulb_endorsement_copy_time">Time</label>
                                    <input type="time" class="form-control" id="ulb_endorsement_copy_time" 
                                           name="ulb_endorsement_copy_time" 
                                           value="<?php echo htmlspecialchars($res['ulb_endorsement_copy_time']); ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="buttons">
                <button type="button" class="btn btn-secondary prev-page">Previous</button>
                <button type="button" class="btn btn-primary" data-type='submit' data-step="8">Update Pickup</button>
            </div>
        </div>
    </form>
</div>

<script>
// Use PROJECT_URL from PHP
const hostName = "<?php echo rtrim(PROJECT_URL, '/'); ?>";
let request = true;

$(document).ready(function () {
    const $form = $("#multi-page-form");
    const $pages = $form.find(".page");
    const $nextButtons = $form.find(".next-page");
    const $prevButtons = $form.find(".prev-page");
    let submit = false;
    let currentPage = <?php echo intval($step); ?>;
    
    // Start from the beginning for editing
    currentPage = 0;

    function showPage(pageIndex, submit = false) {
        $pages.hide();
        $pages.eq(pageIndex).show();
        if(submit == true){
            window.location.href = hostName + "/sub/epr/manage.php?t=pickups";
        }
    }

    $nextButtons.on("click", function (e) {
        e.preventDefault();
        let submit = false;
        let type = $(this).data('type');
        if(typeof type !== 'undefined'){
            submit = true;
        }
        
        let verify = checkRequiredField($(this));
        if(verify == false){
            alert("Please fill all required fields");
            request = false;
            return false;
        } else {
            request = true;
        }
        
        if (currentPage < $pages.length - 1) {
            currentPage++;
            showPage(currentPage, submit);
        }
    });

    $prevButtons.on("click", function (e) {
        e.preventDefault();
        if (currentPage > 0) {
            currentPage--;
            showPage(currentPage, submit);
        }
    });

    showPage(currentPage, submit);
});

// Image preview functionality
const fileInputs = document.querySelectorAll(".image_upload_section");
const imagePreviews = document.querySelectorAll(".image-preview");
const filePreviews = document.querySelectorAll(".file-preview");

fileInputs.forEach(function (fileInput, index) {
    fileInput.addEventListener("change", function () {
        const selectedFile = fileInput.files[0];

        if (selectedFile) {
            const reader = new FileReader();

            reader.onload = function (event) {
                const imagePreview = imagePreviews[index];
                const filePreview = filePreviews[index];

                if (selectedFile.type.startsWith("image/")) {
                    imagePreview.style.display = "block";
                    imagePreview.src = event.target.result;
                    filePreview.style.display = "block";
                }
            };

            reader.readAsDataURL(selectedFile);
        }
    });
});

// Function for checking required fields
function checkRequiredField(nextButton) {
    let page = nextButton.closest('.page');
    let allFieldsAreValid = true;

    page.find('input[required], select[required]').each(function() {
        if ($.trim($(this).val()) === '' && !$(this).is('[type="file"]')) {
            allFieldsAreValid = false;
            $(this).addClass('is-invalid');
            return false;
        } else {
            $(this).removeClass('is-invalid');
        }
    });

    return allFieldsAreValid;
}

// Handle AJAX submission
$(".next-page, button[data-type='submit']").click(function () {
    if(checkRequiredField($(this)) != true){
        return false;
    }
    if(request == false){
        return false;
    }
    
    let updateId = <?php echo intval($uid); ?>;
    let page = $(this).closest('.page');
    let formData = new FormData();
    
    // Collect form data
    page.find('input').each(function () {
        if ($(this).attr('type') !== 'file') {
            formData.append($(this).attr('name'), $(this).val());
        }
    });

    // Handle file uploads
    page.find('input[type="file"]').each(function () {
        if ($(this)[0].files.length > 0) {
            let inputName = $(this).attr('name');
            let file = $(this)[0].files[0];
            formData.append('imageData', file);
            formData.append('imageName', inputName);
        }
    });

    formData.append('key', 'pickup');
    
    // Add select values
    page.find('select').each(function () {
        formData.append($(this).attr('name'), $(this).val());
    });
    
    const steps = parseInt($(this).data('step'));
    formData.append('flag', steps);
    formData.append('id', updateId);
    formData.append('steps', steps);

    $.ajax({
        url: hostName + "/sub/epr/inc/ajax.php",
        type: "post",
        data: formData,
        contentType: false,
        processData: false,
        success: function (result) {
            console.log("Step " + steps + " saved successfully");
            if (steps === 8) {
                alert("Pickup updated successfully!");
                window.location.href = hostName + "/sub/epr/manage.php?t=pickups";
            }
        },
        error: function(xhr, status, error) {
            console.error("Ajax error:", error);
            alert("An error occurred. Please try again.");
        }
    });
});
</script>

<style>
/* Additional validation styles */
.is-invalid {
    border-color: #dc3545 !important;
}
</style>