<?php


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Handle other form data here
  $client = $_POST["client"];
  $po = $_POST["po"];
  $pickup_date = $_POST["date"];
  $ulb = $_POST["ulb"];
  $supervisor = $_POST["supervisor"];
  $truck_registration_number = $_POST["truck"];

  // Handle file uploads
  $truckPicture = uploadImage("truck_picture", "uploads/truck");
  $loadedTruckPicture = uploadImage("loaded_truck_picture", "uploads/truck_loaded");
  $weighBridgeCertificatePicture = uploadImage("weigh_bridge_certificate_picture", "uploads/weigh");
  $loadedWeighBridgeCertificatePicture = uploadImage("loaded_weigh_bridge_certificate_picture", "uploads/weigh_loaded");
  $recyclingCertificatePicture = uploadImage("recycling_certificate_picture", "uploads/recycle_cert");
  $lorryBill = uploadImage("lorry_bill", "uploads/lorry");

  // Insert data into the zw_pickup table using mysqli_query and the predefined $con connection
  $sql = "INSERT INTO zw_pickups (client, po, pickup_date, ulb, supervisor, truck_registration_number, truck_picture, loaded_truck_picture, weigh_bridge_certificate_picture, loaded_weigh_bridge_certificate_picture, recycling_certificate_picture, lorry_bill)
            VALUES ('$client', '$po', '$pickup_date', '$ulb', '$supervisor', '$truck_registration_number', '$truckPicture', '$loadedTruckPicture', '$weighBridgeCertificatePicture', '$loadedWeighBridgeCertificatePicture', '$recyclingCertificatePicture', '$lorryBill')";

  if (mysqli_query($con, $sql)) {
    // Successfully inserted into the database
    alert("Data inserted successfully.");
  } else {
    // Error occurred while inserting
    echo "Error: " . mysqli_error($con);
  }

  // Redirect or show a success message to the user
}



?>

<style>
  .box {
    height: 200px;
    background-color: black;
  }
  .image_section{
      height:400px; width:400px; border:2px solid;
  }
  #image-preview,
  #pdf-preview,
  #file-preview ,.file-preview {
    display: none;
  }
</style>
<h2>Add Pickups</h2>
<form method="post" action="" enctype="multipart/form-data" id="multi-page-form">
  <div class="row g-3 page">
    <div class="col-md-6">
      <select class="form-select" name="client" required>
        <option value="" disabled selected>Select a client</option>
        <?php optionPrintAdv("zw_customers WHERE customer_type!='ulb'", "id", "customer_display_name"); ?>
      </select>
    </div>

    <div class="col-md-6">
      <select class='form-select' name='po' required>
        <option value="" disabled selected>Select a P/O #</option>
        <?php optionPrintAdvx("zw_orders", "id", "id", "#ZW-000R-"); ?>
      </select>
    </div>

    <div class="col-md-6">
      <input class="form-control date" type="date" name="date" placeholder="Pickup Date" required>
    </div>

    <div class="col-md-6">
      <select class='form-select' name='ulb' required>
        <option value="" disabled selected>Select a ULB</option>
        <?php optionPrintAdv("zw_customers WHERE customer_type='ulb'", "id", "customer_display_name"); ?>
      </select>
    </div>

    <div class="col-md-6">
      <select class='form-select' name='supervisor' required>
        <option value="" disabled selected>Select a Site Supervisor</option>
        <?php optionPrintAdv("zw_user WHERE user_role='3'", "id", "username"); ?>
      </select>
    </div>

    <div class="col-md-6">
      <input class="form-control" type="text" name="truck" placeholder="Truck Registration Number" required>
    </div>

   
    <div class="row">
      <div class="col-md-1 mt-3">
        <button class="btn btn-primary next-page">Next</button>
      </div>
      <!--<div class="col-md-1 mt-3">-->
      <!--    <button class="btn btn-primary" type="reset"></button>-->
      <!--</div>-->
    </div>
  </div>

  <div class="page">
    <!--<h2>Page 2</h2>-->

    <div class="col-md-12">
      <div class="row">
        <div class="col-md-6 image_section" style="">
          <div class="box">
            <div class="form-group">
              <div class="upload-section">
                <label for="truck_picture">Upload Truck Picture</label>
        <input type="file" class="form-control-file image_upload_section" id="truck_picture" accept="image/*, .pdf" name="truck_picture">
        <div class="file-preview">
          <img class="image-preview" id="truck_picture_preview" src="#" alt="Preview">
          <!--<embed class="pdf-preview" id="pdf_preview" src="#" type="application/pdf" width="100%" height="500px">-->
        </div>

              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="input2">Date</label>
                <input type="date" class="form-control date" id="truck_date" name="truck_date">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="input3">Time</label>
                <input type="time" class="form-control" id="truck_time" name="truck_time">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class = "buttons mt-5" >
           <button class="btn btn-primary prev-page">Previous</button>
            <button class="btn btn-primary next-page">Next</button>
   </div>
  </div>

   <div class="page">
    <!--<h2>Page 2</h2>-->

    <div class="col-md-12">
      <div class="row">
        <div class="col-md-6 image_section">
          <div class="box">
            <div class="form-group">
              <div class="upload-section">
               
                <label for="truck_picture">Upload Weigh Bridge Certificate</label>
        <input type="file" class="form-control-file image_upload_section" id="bridge_certificate" accept="image/*, .pdf" name="bridge_certificate">
        <div class="file-preview">
          <img class="image-preview" id="bridge_certificate_preview" src="#" alt="Preview">
          <!--<embed class="pdf-preview" id="pdf_preview" src="#" type="application/pdf" width="100%" height="500px">-->
        </div>
        
        
        
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="input2">Date</label>
                <input type="date" class="form-control date" id="bridge_date" name="bridge_date">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="input3">Time</label>
                <input type="time" class="form-control" id="bridge_time" name="bridge_time">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
           <div class = "buttons mt-5" >
           <button class="btn btn-primary prev-page">Previous</button>
            <button class="btn btn-primary next-page">Next</button>
   </div>
  </div>
  
  
   <div class="page">
    <!--<h2>Page 2</h2>-->

    <div class="col-md-12">
      <div class="row">
        <div class="col-md-6 image_section">
          <div class="box">
            <div class="form-group">
              <div class="upload-section">
              
              
              
               <label for="loaded_truck_picture">Loaded Truck Picture</label>
        <input type="file" class="form-control-file image_upload_section" id="loaded_truck_picture" accept="image/*, .pdf" name="loaded_truck_picture">
        <div class="file-preview">
          <img class="image-preview" id="loaded_truck_preview" src="#" alt="Preview">
          <!--<embed class="pdf-preview" id="pdf_preview" src="#" type="application/pdf" width="100%" height="500px">-->
        </div>
        
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="input2">Date</label>
                <input type="date" class="form-control date" id="loaded_truck_picture_date" name="loaded_truck_picture_date">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="input3">Time</label>
                <input type="time" class="form-control" id="loaded_truck_picture_time" name="loaded_truck_picture_time">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
 <div class = "buttons mt-5" >
           <button class="btn btn-primary prev-page">Previous</button>
            <button class="btn btn-primary next-page">Next</button>
   </div>
  </div>
  
  
   <div class="page">
    <!--<h2>Page 2</h2>-->

    <div class="col-md-12">
      <div class="row">
        <div class="col-md-6 image_section">
          <div class="box">
            <div class="form-group">
              <div class="upload-section">
                  
            
                
                <label for="bridge_certificate_loaded">Upload Weigh Bridge Certificate Loaded</label>
        <input type="file" class="form-control-file image_upload_section" id="bridge_certificate_loaded" accept="image/*, .pdf" name="bridge_certificate_loaded">
        <div class="file-preview">
          <img class="image-preview" id="bridge_certificate_loaded_preview" src="#" alt="Preview">
          <!--<embed class="pdf-preview" id="pdf_preview" src="#" type="application/pdf" width="100%" height="500px">-->
        </div>
                
                
                
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="input2">Date</label>
                <input type="date" class="form-control date" id="bridge_date_loaded" name="bridge_date_loaded">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="input3">Time</label>
                <input type="time" class="form-control" id="bridge_time_loaded" name="bridge_time_loaded">
              </div>
            </div>
             <div class="col-md-6">
              <div class="form-group">
                <label for="input3">Net Quantity</label>
                <input type="number" class="form-control" id="bridge_time_loaded_netQuantity" name="bridge_time_loaded_netQuantity">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
 <div class = "buttons mt-5" >
           <button class="btn btn-primary prev-page">Previous</button>
            <button class="btn btn-primary next-page">Next</button>
   </div>
  </div>
  
  
   <div class="page">
    <!--<h2>Page 2</h2>-->

    <div class="col-md-12">
      <div class="row">
        <div class="col-md-6 image_section">
          <div class="box">
            <div class="form-group">
              <div class="upload-section">
                
                
                
              
                
                 <label for="truck_receipt">Upload Weigh Bridge Certificate Loaded</label>
        <input type="file" class="form-control-file image_upload_section" id="truck_receipt" accept="image/*, .pdf" name="truck_receipt">
        <div class="file-preview">
          <img class="image-preview" id="truck_receipt_preview" src="#" alt="Preview">
         
        </div>
                
                
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="input2">Date</label>
                <input type="date" class="form-control date" id="truck_receipt_date" name="truck_receipt_date">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="input3">Time</label>
                <input type="time" class="form-control" id="truck_receipt_time" name="truck_receipt_time">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
            <div class = "buttons mt-5" >
           <button class="btn btn-primary prev-page">Previous</button>
            <button class="btn btn-primary next-page">Next</button>
   </div>
  </div>
  
  
  
  <div class="page">
    <!--<h2>Page 2</h2>-->

    <div class="col-md-12">
      <div class="row">
        <div class="col-md-6 image_section">
          <div class="box">
            <div class="form-group">
              <div class="upload-section">
               
               
                
                <label for="recycling_certificate">Recycling/Coprocessing
Certificate</label>
        <input type="file" class="form-control-file image_upload_section" id="recycling_certificate" accept="image/*, .pdf" name="recycling_certificate">
        <div class="file-preview">
          <img class="image-preview" id="recycling_certificate_preview" src="#" alt="Preview">
         
        </div>
                
                
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="input2">Date</label>
                <input type="date" class="form-control date" id="recycling_certificate_date" name="recycling_certificate_date">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="input3">Time</label>
                <input type="time" class="form-control" id="recycling_certificate_time" name="recycling_certificate_time">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
            <div class = "buttons mt-5" >
           <button class="btn btn-primary prev-page">Previous</button>
            <button class="btn btn-primary next-page">Next</button>
   </div>
  </div>
  
  
  
  <div class="page">
    <!--<h2>Page 2</h2>-->

    <div class="col-md-12">
      <div class="row">
        <div class="col-md-6 image_section">
          <div class="box">
            <div class="form-group">
              <div class="upload-section">
                
                
                
               
                
                 <label for="ulb_endorsement_copy">ULB Endorsement Copy</label>
        <input type="file" class="form-control-file image_upload_section" id="ulb_endorsement_copy" accept="image/*, .pdf" name="ulb_endorsement_copy">
        <div class="file-preview">
          <img class="image-preview" id="ulb_endorsement_copy_preview" src="#" alt="Preview">
         
        </div>
                
                
                
                
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="input2">Date</label>
                <input type="date" class="form-control date" id="ulb_endorsement_copy_date" name="ulb_endorsement_copy_date">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="input3">Time</label>
                <input type="time" class="form-control" id="ulb_endorsement_copy_time" name="ulb_endorsement_copy_time">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
            <div class = "buttons mt-5" >
           <button class="btn btn-primary prev-page">Previous</button>
            <button class="btn btn-primary" type="submit">Submit</button>
   </div>
  </div>

</form>




<script>
$(document).ready(function () {
    
    
    const today = new Date();

        // Format the date as YYYY-MM-DD
        const yyyy = today.getFullYear();
        const mm = String(today.getMonth() + 1).padStart(2, '0'); // Months are 0-based
        const dd = String(today.getDate()).padStart(2, '0');

        // Combine the formatted parts and set it as the input value
        const formattedDate = `${yyyy}-${mm}-${dd}`;
        document.getElementsByClassName("date").value = formattedDate;
    
    
    
    
  const $form = $("#multi-page-form");
  const $pages = $form.find(".page");
  const $nextButtons = $form.find(".next-page");
  const $prevButtons = $form.find(".prev-page");
  let currentPage = 0;

  function showPage(pageIndex) {
    $pages.hide();
    $pages.eq(pageIndex).show();
  }

  $nextButtons.on("click", function (e) {
    e.preventDefault();
    if (currentPage < $pages.length - 1) {
      currentPage++;
      showPage(currentPage);
    }
  });

  $prevButtons.on("click", function (e) {
    e.preventDefault();
    if (currentPage > 0) {
      currentPage--;
      showPage(currentPage);
    }
  });

  showPage(currentPage);
});

// Image preview functionality for each section
const fileInputs = document.querySelectorAll(".image_upload_section");
const imagePreviews = document.querySelectorAll(".image-preview");
// const pdfPreviews = document.querySelectorAll(".pdf-preview");
const filePreviews = document.querySelectorAll(".file-preview");

fileInputs.forEach(function (fileInput, index) {
  fileInput.addEventListener("change", function () {
    const selectedFile = fileInput.files[0];

    if (selectedFile) {
      const reader = new FileReader();

      reader.onload = function (event) {
        const imagePreview = imagePreviews[index];
        // const pdfPreview = pdfPreviews[index];
        const filePreview = filePreviews[index];

        if (selectedFile.type.startsWith("image/")) {
          imagePreview.style.display = "block";
          imagePreview.style.width = "383px"; // Set your desired width
          imagePreview.style.height = "316px"; // Set your desired height

        //   pdfPreview.style.display = "none";
          imagePreview.src = event.target.result;
        } 
        filePreview.style.display = "block";
      };

      reader.readAsDataURL(selectedFile);
    } 
    // else {
    //   const imagePreview = imagePreviews[index];
    // //   const pdfPreview = pdfPreviews[index];
    //   const filePreview = filePreviews[index];

    //   imagePreview.style.display = "none";
    // //   pdfPreview.style.display = "none";
    //   filePreview.style.display = "none";
    // }
  });
});
  
</script>