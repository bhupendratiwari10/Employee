<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

$uid = $_GET['id'];
$query =  "SELECT * FROM `zw_pickups` where id = $uid";
$data = mysqli_query($con , $query);
$res = mysqli_fetch_assoc($data);
if(!empty($res['steps'])){
$step = $res['steps'];
}else{
    $step = 0;
}
$step = 0;

$domainName = $_SERVER['SERVER_NAME'];

 

?>

<style>
  .box {
    height: 200px;
    /*background-color: black;*/
  }
  .image_section{
      height:400px; width:400px; border:2px solid;
  }
  #image-preview,
  #pdf-preview,
  #file-preview ,.file-preview {
    /*display: none;*/
  }
  .image-preview{
      width:383px;
      height:316px;
  }
</style>
<h2>Edit Pickup</h2>
<form method="post" action="" enctype="multipart/form-data" id="multi-page-form">
  <div class="row g-3 page">
    <div class="col-md-6">
      <select class="form-select" name="client" required>
        <option value="" disabled selected>Select a client</option>
        <?php optionPrintAdv("zw_customers WHERE customer_type!='ulb'", "id", "customer_display_name" , $res['client']); ?>
      </select>
    </div>

    <div class="col-md-6">
      <select class='form-select' name='po' required>
        <option value="" disabled selected>Select a P/O #</option>
        <?php optionPrintAdvx("zw_orders", "id", "id", "#ZW-000R-" , $res['po']); ?>
      </select>
    </div>

    <div class="col-md-6">
      <input class="form-control date" type="date" name="pickup_date" placeholder="Pickup Date" value = "<?php echo $res['pickup_date']?>" required>
    </div>

    <div class="col-md-6">
      <select class='form-select' name='ulb' required>
        <option value="" disabled selected>Select a ULB</option>
        <?php optionPrintAdv("zw_ulb ", "id", "title" , $res['ulb']); ?>
      </select>
    </div>

    <div class="col-md-6">
      <select class='form-select' name='supervisor'>
        <option value="" disabled selected>Select a Site Supervisor</option>
        <?php optionPrintAdv("zw_user WHERE user_role='3'", "id", "username" , $res['supervisor']); ?>
      </select>
    </div>

    <div class="col-md-6">
      <input class="form-control" type="text" name="truck_registration_number" placeholder="Truck Registration Number" value= "<?php echo $res['truck_registration_number']?>" required>
    </div>

   
    <div class="row">
      <div class="col-md-1 mt-3">
        <button class="btn btn-primary next-page" data-step="1">Next</button>
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
        <div class="col-md-6 image_section">
          <div class="box">
            <div class="form-group">
              <div class="upload-section">
               
                <label for="truck_picture">Upload Weigh Bridge Certificate (Empty)</label>
        <input type="file" class="form-control-file image_upload_section" id="bridge_certificate" accept="image/*, .pdf" name="weigh_bridge_certificate_picture"  required>
        <div class="file-preview">
          <img class="image-preview" id="bridge_certificate_preview" src = "<?php echo $res['weigh_bridge_certificate_picture']?>" alt="Preview">
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
                <input type="date" class="form-control date" id="bridge_date" value = "<?php echo $res['weight_bridge_certi_date']?>" name="weight_bridge_certi_date" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="input3">Time</label>
                <input type="time" class="form-control" id="bridge_time" value = "<?php echo $res['weight_bridge_certi_time']?>"  name="weight_bridge_certi_time" required>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
           <div class = "buttons mt-5" >
           <button class="btn btn-primary prev-page">Previous</button>
            <button class="btn btn-primary next-page" data-step="2">Next</button>
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
        <input type="file" class="form-control-file image_upload_section" id="truck_picture" accept="image/*, .pdf" name="truck_picture" required>
        <div class="file-preview">
          <img class="image-preview" id="truck_picture_preview" src = "<?php echo $res['truck_picture']?>" alt="Preview">
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
                <input type="date" class="form-control date" id="truck_date" value = "<?php echo $res['loaded_truck_pic_date']?>"  name="loaded_truck_pic_date" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="input3">Time</label>
                <input type="time" class="form-control" id="truck_time" name="loaded_truck_pic_time" value = "<?php echo $res['loaded_truck_pic_time']?>"  required>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class = "buttons mt-5" >
           <button class="btn btn-primary prev-page">Previous</button>
            <button class="btn btn-primary next-page" data-step="3">Next</button>
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
        <input type="file" class="form-control-file image_upload_section" id="loaded_truck_picture" value = "<?php echo $domainName.'/sub/epr/'.$res['loaded_truck_picture']?>" accept="image/*, .pdf" name="loaded_truck_picture" required>
        <div class="file-preview">
          <img class="image-preview" id="loaded_truck_preview" src = "<?php echo $res['weigh_bridge_certificate_picture']?>" alt="Preview">
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
                <input type="date" class="form-control date" id="loaded_truck_picture_date" name="loaded_truck_picture_date" value = "<?php echo $res['loaded_truck_picture_date']?>" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="input3">Time</label>
                <input type="time" class="form-control" id="loaded_truck_picture_time" name="loaded_truck_picture_time" value = "<?php echo $res['loaded_truck_picture_time']?>" required>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
 <div class = "buttons mt-5" >
           <button class="btn btn-primary prev-page">Previous</button>
            <button class="btn btn-primary next-page" data-step="4">Next</button>
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
                  
            
                
                <label for="bridge_certificate_loaded">Upload Weigh Bridge Certificate (Loaded)</label>
        <input type="file" class="form-control-file image_upload_section" id="bridge_certificate_loaded" value = "<?php echo $domainName.'/sub/epr/'.$res['loaded_weigh_bridge_certificate_picture']?>"  accept="image/*, .pdf" name="loaded_weigh_bridge_certificate_picture" required>
        <div class="file-preview">
          <img class="image-preview" id="bridge_certificate_loaded_preview" src = "<?php echo $res['weigh_bridge_certificate_picture']?>" alt="Preview">
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
                <input type="date" class="form-control date" id="bridge_date_loaded" name="loaded_weigh_bridge_certificate_date" value = "<?php echo $res['loaded_weigh_bridge_certificate_date']?>" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="input3">Time</label>
                <input type="time" class="form-control" id="bridge_time_loaded" name="loaded_weigh_bridge_certificate_time"  value = "<?php echo $res['loaded_weigh_bridge_certificate_time']?>" required>
              </div>
            </div>
             <div class="col-md-6">
              <div class="form-group">
                <label for="input3">Net Quantity</label>
                <input type="number" class="form-control" id="bridge_time_loaded_netQuantity" name="net_quantity"  value = "<?php echo $res['net_quantity']?>"  required>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
 <div class = "buttons mt-5" >
           <button class="btn btn-primary prev-page">Previous</button>
            <button class="btn btn-primary next-page" data-step="5">Next</button>
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
                
                
                
              
                
                 <label for="truck_receipt">Truck Receipt</label>
        <input type="file" class="form-control-file image_upload_section" id="truck_receipt" accept="image/*, .pdf" name="truck_receipt" value = "<?php echo $domainName.'/sub/epr/'.$res['truck_receipt']?>" required>
        <div class="file-preview">
          <img class="image-preview" id="truck_receipt_preview" src = "<?php echo $res['truck_receipt']?>" alt="Preview">
         
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
                <input type="date" class="form-control date" id="truck_receipt_date" name="truck_receipt_date" value = "<?php echo $res['truck_receipt_date']?>" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="input3">Time</label>
                <input type="time" class="form-control" id="truck_receipt_time" name="truck_receipt_time" value = "<?php echo $res['truck_receipt_time']?>" required>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
            <div class = "buttons mt-5" >
           <button class="btn btn-primary prev-page">Previous</button>
            <button class="btn btn-primary next-page" data-step="6">Next</button>
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
        <input type="file" class="form-control-file image_upload_section" id="recycling_certificate" accept="image/*, .pdf" name="recycling_certificate_picture" value = "<?php echo $domainName.'/sub/epr/'.$res['recycling_certificate_picture']?>" required>
        <div class="file-preview">
          <img class="image-preview" id="recycling_certificate_preview" src = "<?php echo $res['recycling_certificate_picture']?>" alt="Preview">
         
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
                <input type="date" class="form-control date" id="recycling_certificate_date" name="recycling_certificate_date" value = "<?php echo $res['recycling_certificate_date']?>" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="input3">Time</label>
                <input type="time" class="form-control" id="recycling_certificate_time" name="recycling_certificate_time" value = "<?php echo $res['recycling_certificate_time']?>" required>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
            <div class = "buttons mt-5" >
           <button class="btn btn-primary prev-page">Previous</button>
            <button class="btn btn-primary next-page" data-step="7">Next</button>
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
        <input type="file" class="form-control-file image_upload_section" id="ulb_endorsement_copy" accept="image/*, .pdf" name="ulb_endorsement_copy" value = "<?php echo $domainName.'/sub/epr/'.$res['ulb_endorsement_copy']?>" required>
        <div class="file-preview">
          <img class="image-preview" id="ulb_endorsement_copy_preview" src = "<?php echo $res['ulb_endorsement_copy']?>" alt="Preview">
         
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
                <input type="date" class="form-control date" id="ulb_endorsement_copy_date" name="ulb_endorsement_copy_date" value = "<?php echo $res['ulb_endorsement_copy_date']?>" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="input3">Time</label>
                <input type="time" class="form-control" id="ulb_endorsement_copy_time" name="ulb_endorsement_copy_time"  value = "<?php echo $res['ulb_endorsement_copy_time']?>" required>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
            <div class = "buttons mt-5" >
           <button class="btn btn-primary prev-page">Previous</button>
            <button class="btn btn-primary" type="submit" data-type = 'submit' data-step="8">Update</button>
   </div>
  </div>

</form>




<script>
let request = true;
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
  let submit = false;
  let currentPage = "<?php echo $step?>";
  console.log('currentPage' , currentPage );

  function showPage(pageIndex , submit = false) {
    $pages.hide();
    $pages.eq(pageIndex).show();
    if(submit == true){
        window.location.href = "https://employee.tidyrabbit.com/sub/epr/manage.php?t=pickups";
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
      
      showPage(currentPage , submit);
    }
  });

  $prevButtons.on("click", function (e) {
    e.preventDefault();
    if (currentPage > 0) {
        if(currentPage == "<?php echo $step ?>"){
            return false;
        }
      currentPage--;
      showPage(currentPage , submit);
    }
  });

  showPage(currentPage , submit);
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
  
  
//   Function For checking Required Fields
function checkRequiredField(nextButton) {
    let page = nextButton.closest('.page');
    let allFieldsAreValid = true;

    page.find('input[required], select[required]').each(function() {
        if ($.trim($(this).val()) === '') {
            allFieldsAreValid = false;
            return false; // Exit the loop early since we found an invalid field
        }
    });

    return allFieldsAreValid;
}

  
</script>
<script>
    let flag = 0;
    
    // let steps = 1;
    
    $(".next-page").click(function () {
        if(checkRequiredField($(this)) != true){
            return false;
        }
    if(request == false){
        return false;
    }
    let updateId = "<?php echo $_GET['id']?>";
    let page = $(this).closest('.page');
    let formData = new FormData();
    let imageData = [];
    // Iterate through inputs and add non-file input values to formData
    page.find('input').each(function () {
        if ($(this).attr('type') !== 'file') {
            let value = $(this).val();
            formData.append($(this).attr('name'), $(this).val());
        }
    });

    // Iterate through file inputs and add files to formData
    page.find('input[type="file"]').each(function () {
        if ($(this)[0].files.length > 0) {
            let inputName = $(this).attr('name');
            let file = $(this)[0].files[0];
            formData.append('imageData',file);
            formData.append('imageName' , inputName);
            let imageDetails = {'imageInput' : inputName , 'imageData' :  file};
            imageData.push(imageDetails);
            // 
        }

    });

    formData.append('key', 'pickup');

    // Iterate through selects and add select input values to formData
    page.find('select').each(function () {
        formData.append($(this).attr('name'), $(this).val());
    });
   const steps = parseInt($(this).data('step'));
    formData.append('flag', steps);
    formData.append('id', updateId);
    formData.append('steps', steps);
    console.log('imageData :::: ' , imageData);
    // formData.append('imageData',imageData);
    console.log(imageData);
    // var jsonData = JSON.stringify(formData);
    // console.log(jsonData);

    $.ajax({
        url: "inc/ajax.php",
        type: "post",
        data: formData,
        contentType: false, // Set to false when sending FormData
        processData: false, // Set to false when sending FormData
        success: function (result) {
            // result = JSON.parse(result);
            updateId = result;
            // steps++;
            flag++;
        }
    });
});

</script>