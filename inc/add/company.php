<?php

if(isset($_POST['title'])){
        
        $name = $_POST['name'];
        $title = $_POST['title'];
        $contact = $_POST['contact'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $website = $_POST['website'];
        $desc = $_POST['desc'];
        $remarks = $_POST['remarks'];
        $logo = uploadImage("pfp", "uploads/vendor_img");
        
        $query = "INSERT INTO zw_company (company_name, vendor_display_name, vendor_contact, company_email, pfp, company_phone, company_website, company_details, remarks) 
                  VALUES ('$name', '$title', '$contact', '$email', '$logo', '$phone', '$website', '$desc', '$remarks')";
        if(mysqli_query($con,$query)){alert("Vendor Added"); redirect("manage.php?t=companies&g=prc");}else{alert("Vendor Entry Failed");}
        
    }


?>

    <h2>Add Vendor</h2><br>
    
        <form method="post" action="" enctype="multipart/form-data">
            <div class="row g-3">
                <div class="col-6 form-group">
                  <input class="form-control" type="text" name="name" placeholder="Name" >
                </div>
                
                <div class="col-6 form-group">
                  <input class="form-control" type="file" name="pfp" placeholder="Logo">
                </div>
                
                <div class="col-6 form-group">
                  <input class="form-control" type="text" name="title" placeholder="Vendor Display Name" required>
                </div>
                
                <div class="col-6 form-group">
                  <input class="form-control" type="text" name="contact" placeholder="Primary Contact" >
                </div>
                
                <div class="col-4 form-group">
                  <input class="form-control" type="email" name="email" placeholder="Email" >
                </div>
                
                <div class="col-4 form-group">
                  <input class="form-control" type="tel" name="phone" placeholder="Phone" >
                </div>
                
                <div class="col-4 form-group">
                  <input class="form-control" type="url" placeholder="Website" name="website">
                </div>
                
                <div class="form-group">
                  <label for="desc" style="margin-top: 8px;">More Details:</label>
                  <textarea class="form-control col-12" placeholder="Description" name="desc"></textarea>
                </div>
                
                <div class="form-group col-12">
                  <input class="form-control" placeholder="Remarks" type="text" name="remarks">
                </div>
                
                <center><br><button class="btn btn-info" type="submit">Submit</button></center>

            </div>
        </form>