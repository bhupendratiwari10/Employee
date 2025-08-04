<?php
// Secure the ID parameter
$uid = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Query pickup data with prepared statement
$query = "SELECT * FROM `zw_pickups` WHERE id = ?";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, "i", $uid);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$res = mysqli_fetch_assoc($result);

$step = !empty($res['steps']) ? $res['steps'] : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $itemType = mysqli_real_escape_string($con, $_POST['item_type']);
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $sku = mysqli_real_escape_string($con, $_POST['sku']);
    $unit = mysqli_real_escape_string($con, $_POST['unit']);
    $hsnCode = mysqli_real_escape_string($con, $_POST['hsn_code']);
    
    if(isset($_POST['tax_preference'])){
        $taxPreference = mysqli_real_escape_string($con, $_POST['tax_preference']);
    }
    
    $sellingPrice = !empty($_POST['selling_price']) ? mysqli_real_escape_string($con, $_POST['selling_price']) : 0;
    $sellingPriceAccount = !empty($_POST['selling_price_account']) ? mysqli_real_escape_string($con, $_POST['selling_price_account']) : 0;
    $sellingPriceDescription = !empty($_POST['selling_price_description']) ? mysqli_real_escape_string($con, $_POST['selling_price_description']) : '';
    $costPrice = !empty($_POST['cost_price']) ? mysqli_real_escape_string($con, $_POST['cost_price']) : 0;
    $costPriceAccount = !empty($_POST['cost_price_account']) ? mysqli_real_escape_string($con, $_POST['cost_price_account']) : '';
    $gst_percentage = mysqli_real_escape_string($con, $_POST['gst_percentage']);
    $costPriceDescription = !empty($_POST['cost_price_description']) ? mysqli_real_escape_string($con, $_POST['cost_price_description']) : '';
    
    // Use prepared statement for update
    $query = "UPDATE zw_items SET 
              item_type = ?, 
              gst_percentage = ?, 
              name = ?, 
              sku = ?, 
              unit = ?, 
              hsn_code = ?, 
              tax_preference = ?, 
              selling_price = ?, 
              selling_price_account = ?, 
              selling_price_description = ?, 
              cost_price = ?, 
              cost_price_account = ?, 
              cost_price_description = ? 
              WHERE id = ?";
    
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "sssssssdssdssi", 
        $itemType, $gst_percentage, $name, $sku, $unit, $hsnCode, 
        $taxPreference, $sellingPrice, $sellingPriceAccount, 
        $sellingPriceDescription, $costPrice, $costPriceAccount, 
        $costPriceDescription, $uid
    );
    
    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Item Updated successfully.');</script>";
        header('Location: ' . PROJECT_URL . 'sub/epr/manage.php?t=items');
        exit();
    } else {
        echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
    }

    mysqli_close($con);
}
?>

<style>
  .box {
    height: 200px;
  }
  .image_section{
      height:400px; 
      width:400px; 
      border:2px solid #ddd;
      border-radius: 8px;
      padding: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
  }
  #image-preview,
  #pdf-preview,
  #file-preview,
  .file-preview {
    display: none;
    max-width: 100%;
    max-height: 100%;
  }
  .upload-section {
      text-align: center;
      width: 100%;
  }
  .buttons {
      margin-top: 20px;
  }
  .page {
      display: none;
  }
  .page:first-child {
      display: block;
  }
</style>

<h2>Complete Pickup</h2>
<form method="post" action="" enctype="multipart/form-data" id="multi-page-form">
  <!-- Page 1: Basic Information -->
  <div class="row g-3 page">
    <div class="col-md-6">
      <label class="form-label">Select Client</label>
      <select class="form-select" name="client" required>
        <option value="" disabled selected>Select a client</option>
        <?php optionPrintAdv("zw_customers WHERE customer_type!='ulb'", "id", "customer_display_name"); ?>
      </select>
    </div>

    <div class="col-md-6">
      <label class="form-label">Select P/O #</label>
      <select class='form-select' name='po' required>
        <option value="" disabled selected>Select a P/O #</option>
        <?php optionPrintAdvx("zw_orders", "id", "id", "#ZW-000R-"); ?>
      </select>
    </div>

    <div class="col-md-6">
      <label class="form-label">Pickup Date</label>
      <input class="form-control date" type="date" name="pickup_date" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">Select ULB</label>
      <select class='form-select' name='ulb' required>
        <option value="" disabled selected>Select a ULB</option>
        <?php optionPrintAdv("zw_ulb", "id", "title"); ?>
      </select>
    </div>

    <div class="col-md-6">
      <label class="form-label">Site Supervisor</label>
      <select class='form-select' name='supervisor'>
        <option value="" disabled selected>Select a Site Supervisor</option>
        <?php optionPrintAdv("zw_user WHERE user_role='3'", "id", "username"); ?>
      </select>
    </div>

    <div class="col-md-6">
      <label class="form-label">Truck Registration Number</label>
      <input class="form-control" type="text" name="truck_registration_number" placeholder="Enter truck registration number" required>
    </div>

    <div class="row">
      <div class="col-md-12 mt-3">
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
                  <input type="file" class="form-control-file image_upload_section" id="bridge_certificate" accept="image/*, .pdf" name="weigh_bridge_certificate_picture" required>
                  <div class="file-preview">
                    <img class="image-preview" id="bridge_certificate_preview" src="#" alt="Preview">
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
                <input type="date" class="form-control date" id="bridge_date" name="weight_bridge_certi_date" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="bridge_time">Time</label>
                <input type="time" class="form-control" id="bridge_time" name="weight_bridge_certi_time" required>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="buttons mt-5">
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
                  <input type="file" class="form-control-file image_upload_section" id="truck_picture" accept="image/*, .pdf" name="truck_picture" required>
                  <div class="file-preview">
                    <img class="image-preview" id="truck_picture_preview" src="#" alt="Preview">
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
                <input type="date" class="form-control date" id="truck_date" name="loaded_truck_pic_date" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="truck_time">Time</label>
                <input type="time" class="form-control" id="truck_time" name="loaded_truck_pic_time" required>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="buttons mt-5">
      <button type="button" class="btn btn-secondary prev-page">Previous</button>
      <button type="button" class="btn btn-primary next-page" data-step="3">Next</button>
    </div>
  </div>

  <!-- Continue with other pages following the same pattern... -->
  <!-- I'll show the script section with PROJECT_URL usage -->

</form>

<script>
// Define the host name using PROJECT_URL constant
const hostName = "<?php echo rtrim(PROJECT_URL, '/'); ?>";
let request = true;

$(document).ready(function () {
    const today = new Date();
    const yyyy = today.getFullYear();
    const mm = String(today.getMonth() + 1).padStart(2, '0');
    const dd = String(today.getDate()).padStart(2, '0');
    const formattedDate = `${yyyy}-${mm}-${dd}`;
    
    // Set today's date as default for all date inputs
    $('.date').val(formattedDate);
    
    const $form = $("#multi-page-form");
    const $pages = $form.find(".page");
    const $nextButtons = $form.find(".next-page");
    const $prevButtons = $form.find(".prev-page");
    let submit = false;
    let currentPage = <?php echo intval($step); ?>;

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
            alert("Please Fill All Required Fields");
            request = false;
            return false;
        }
        else{
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
            if(currentPage == <?php echo intval($step); ?>){
                return false;
            }
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
let cropper = null;

fileInputs.forEach(function (fileInput, index) {
    fileInput.addEventListener("change", function () {
        const selectedFile = fileInput.files[0];
        
        if (selectedFile) {
            const reader = new FileReader();
            
            if (cropper) {
                cropper.destroy();
            }
            
            reader.onload = function (event) {
                const imagePreview = imagePreviews[index];
                const filePreview = filePreviews[index];
                
                if (selectedFile.type.startsWith("image/")) {
                    imagePreview.style.display = "block";
                    imagePreview.style.width = "383px";
                    imagePreview.style.height = "316px";
                    imagePreview.src = event.target.result;
                    
                    // Initialize Cropper.js based on index
                    let aspectRatio;
                    if(index == 0 || index == 3 || index == 4){
                        aspectRatio = NaN;
                    } else if(index == 1 || index == 2){
                        aspectRatio = 1;
                        $('.cropper-view-box, .cropper-face').css('border-radius', '50%');
                    } else {
                        aspectRatio = 1/1.41;
                    }
                    
                    cropper = new Cropper(imagePreview, {
                        aspectRatio: aspectRatio,
                        viewMode: index == 1 || index == 2 ? 1 : 0,
                        autoCropArea: index == 1 || index == 2 ? 1 : 0,
                        crop: function(event) {
                            console.log("Image cropped");
                            const canvasData = cropper.getCroppedCanvas().toDataURL(selectedFile.type);
                            filePreview.style.display = "block";
                            filePreview.src = canvasData;
                        }
                    });
                } 
                filePreview.style.display = "block";
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
        if ($.trim($(this).val()) === '') {
            allFieldsAreValid = false;
            $(this).addClass('is-invalid'); // Add visual feedback
            return false;
        } else {
            $(this).removeClass('is-invalid');
        }
    });

    return allFieldsAreValid;
}

// Ajax submission
$(".next-page").click(function () {
    if(checkRequiredField($(this)) != true){
        return false;
    }
    if(request == false){
        return false;
    }
    
    let updateId = <?php echo intval($_GET['id']); ?>;
    let page = $(this).closest('.page');
    let formData = new FormData();
    let imageData = [];
    
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
            console.log(steps);
            if (steps === 8) {
                window.location.href = hostName + "/sub/epr/manage.php?t=pickups";
            }
            updateId = result;
        },
        error: function(xhr, status, error) {
            console.error("Ajax error:", error);
            alert("An error occurred. Please try again.");
        }
    });
});
</script>

<!-- Include Cropper.js library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">