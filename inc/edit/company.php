<?php

    $prevTitle = namebyAid($uid, "vendor_display_name", "zw_company");
    $prevcontact = namebyAid($uid, "vendor_contact", "zw_company");
    $prevName = namebyAid($uid, "company_name", "zw_company");
    $prevEmail = namebyAid($uid, "company_email", "zw_company");
    $prevPhone = namebyAid($uid, "company_phone", "zw_company");
    $prevWebsite = namebyAid($uid, "company_website", "zw_company");
    $prevDesc = namebyAid($uid, "company_details", "zw_company");
    $prevRemarks = namebyAid($uid, "remarks", "zw_company");

    if (isset($_POST['title'])) {
        $con = dbCon();

        $title = mysqli_real_escape_string($con, $_POST['title']);
        $name = mysqli_real_escape_string($con, $_POST['name']);
        $contact = mysqli_real_escape_string($con, $_POST['contact']);
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $phone = mysqli_real_escape_string($con, $_POST['phone']);
        $website = mysqli_real_escape_string($con, $_POST['website']);
        $desc = mysqli_real_escape_string($con, $_POST['desc']);
        $remarks = mysqli_real_escape_string($con, $_POST['remarks']);
        $logo = uploadImage("pfp", "uploads/vendor_img");
        
        if(!empty($logo)){ $soy = "pfp = '$logo',";}

        $updateQuery = "UPDATE zw_company SET vendor_display_name = '$title', vendor_contact = '$contact', company_name = '$name', $soy company_email = '$email', company_phone = '$phone', company_website = '$website', company_details = '$desc', remarks = '$remarks' WHERE id=$uid";

            if (mysqli_query($con, $updateQuery)) {
                redirect("manage.php?t=companies&g=prc");
            }
    }

?>

    <h2>Edit Vendor</h2>

        <form action="" method="post" class="row g-3" enctype="multipart/form-data">

            <div class="col-6 form-group">
              <input class="form-control" type="text" name="name" placeholder="Name" value="<?php echo $prevName; ?>" >
            </div>
    
            <div class="col-6 form-group">
              <input class="form-control" type="file" name="pfp" placeholder="Logo">
            </div>
            
            <div class="col-6 form-group">
              <input class="form-control" type="text" name="title" placeholder="Vendor Display Name" value="<?php echo $prevTitle; ?>" required>
            </div>
            
            <div class="col-6 form-group">
              <input class="form-control" type="text" name="contact" placeholder="Primary Contact" value="<?php echo $prevcontact; ?>">
            </div>
            
          
          <div class="col-4 form-group">
            <input class="form-control" type="email" name="email" placeholder=" Email" value="<?php echo $prevEmail; ?>" required>
          </div>
        
          <div class="col-4 form-group">
            <input class="form-control" type="tel" name="phone" placeholder=" Phone" value="<?php echo $prevPhone; ?>" required>
          </div>
        
          <div class="col-4 form-group">
            <input class="form-control" type="url" placeholder=" Website" name="website" value="<?php echo $prevWebsite; ?>">
          </div>
        
          <div class="form-group">
            <label for="desc" style="margin-top: 8px;">More Details:</label>
            <textarea class="form-control col-12" placeholder=" Desc" name="desc"><?php echo $prevDesc; ?></textarea>
          </div>
        
          <div class="form-group col-12">
            <input class="form-control" placeholder=" Remarks" type="text" name="remarks" value="<?php echo $prevRemarks; ?>">
          </div>
        
          <center><br><button class="btn btn-info" type="submit">Submit</button></center>
        </form>

</div>