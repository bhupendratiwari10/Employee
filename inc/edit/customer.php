<?php


  $query =  "SELECT * FROM `zw_customers` where id = $uid";
$data = mysqli_query($con , $query);
$res = mysqli_fetch_assoc($data);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customerType = isset($_POST['customer-type']) ? $_POST['customer-type'] : '';
    $firstName = isset($_POST['first-name']) ? $_POST['first-name'] : '';
    $lastName = isset($_POST['last-name']) ? $_POST['last-name'] : '';
    $companyName = isset($_POST['company-name']) ? $_POST['company-name'] : '';
    $customerDisplayName = isset($_POST['customer-display-name']) ? $_POST['customer-display-name'] : '';
    $customerEmail = isset($_POST['customer-email']) ? $_POST['customer-email'] : '';
    $customerPhone = isset($_POST['customer-phone']) ? $_POST['customer-phone'] : '';
    $workPhone = isset($_POST['work-phone']) ? $_POST['work-phone'] : '';
    $mobile = isset($_POST['mobile']) ? $_POST['mobile'] : '';
    $pan = isset($_POST['pan']) ? $_POST['pan'] : '';
    $pfp = uploadImage("pfp", "uploads/customer_pfp"); 
    $openingBalance = isset($_POST['opening-balance']) ? $_POST['opening-balance'] : '';
    $currency = isset($_POST['currency']) ? $_POST['currency'] : '';
    $billingAddress = isset($_POST['billing-address']) ? $_POST['billing-address'] : '';
    $shippingAddress = isset($_POST['shipping-address']) ? $_POST['shipping-address'] : '';
    $paymentTerms = isset($_POST['payment-terms']) ? $_POST['payment-terms'] : '';
    $enablePortal = isset($_POST['enable-portal']) ? 1 : 0;
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
	if (!empty($password)) {
            $query = "Update zw_customers set 
                customer_type ='$customerType', first_name ='$firstName', last_name ='$lastName', company_name ='$companyName', customer_display_name = '$customerDisplayName', 
                 customer_email ='$customerEmail', customer_phone ='$customerPhone', work_phone ='$workPhone', mobile ='$mobile', pan ='$pan', opening_balance ='$openingBalance', currency ='$currency', 
                 billing_address ='$billingAddress', profile_pic='$pfp', shipping_address ='$shippingAddress', payment_terms ='$paymentTerms', enable_portal ='$enablePortal', username ='$username', password ='$hashedPassword' where id = $uid";
        }else{
        	$query = "Update zw_customers set 
                customer_type ='$customerType', first_name ='$firstName', last_name ='$lastName', company_name ='$companyName', customer_display_name = '$customerDisplayName', 
                 customer_email ='$customerEmail', customer_phone ='$customerPhone', work_phone ='$workPhone', mobile ='$mobile', pan ='$pan', opening_balance ='$openingBalance', currency ='$currency', 
                 billing_address ='$billingAddress', profile_pic='$pfp', shipping_address ='$shippingAddress', payment_terms ='$paymentTerms', enable_portal ='$enablePortal', username ='$username' where id = $uid";
        }
    
              

    if(mysqli_query($con, $query)) {
        //  echo "<script>location.reload();</script>";
        echo "<script>alert('Customer Updated SuccessFully');</script>";
      redirect("manage.php?t=customer");
      
    } else {
        echo "<script>alert('Customer Entry Failed');</script>";
    }
}
?>
<h2>Edit Customer</h2>
        <form method="post" action="" enctype="multipart/form-data">
            <div class="row g-3">
               <div class="col-md-12">
                    <label class="form-label">Customer Type</label>
                    <div class='row col-12'>
                        <div class="form-check col">
                            <input name="customer-type" class="form-check-input" <?php if($res['customer_type']=='epr'){ echo 'checked'; } ?> type="radio" value="epr">
                            <label class="form-check-label">EPR Client</label>
                        </div>
                        <div class="form-check col">
                            <input name="customer-type" <?php if($res['customer_type']=='business'){ echo 'checked'; } ?> class="form-check-input" type="radio" value="business">
                            <label class="form-check-label">Business</label>
                        </div>
                        <div class="form-check col">
                            <input name="customer-type" <?php if($res['customer_type']=='individual'){ echo 'checked'; } ?> class="form-check-input" type="radio" value="individual">
                            <label class="form-check-label">Individual</label>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <input class="form-control" type="text" name="first-name" placeholder="First Name" value = "<?php echo $res['first_name']?>">
                </div>
                
                <div class="col-md-4">
                    <input class="form-control" type="text" name="last-name" placeholder="Last Name" value = "<?php echo $res['last_name']?>">
                </div>
                
                <div class="col-md-4">
                    <input class="form-control" type="text" name="company-name" placeholder="Company Name" value = "<?php echo $res['company_name']?>">
                </div>
                
                <div class="col-md-6">
                    <input class="form-control" type="text" name="customer-display-name" placeholder="Customer Display Name" required value = "<?php echo $res['customer_display_name']?>">
                </div>
                
                <div class="col-md-6">
                    <input class="form-control" type="email" name="customer-email" placeholder="Customer Email" value = "<?php echo $res['customer_email']?>">
                </div>
                
                <div class="col-md-4">
                    <input class="form-control" type="tel" name="customer-phone" placeholder="Customer Phone" value = "<?php echo $res['customer_phone']?>">
                </div>
                
                <div class="col-md-4">
                    <input class="form-control" type="tel" name="work-phone" placeholder="Work Phone" value = "<?php echo $res['work_phone']?>">
                </div>
                
                <div class="col-md-4">
                    <input class="form-control" type="tel" name="mobile" placeholder="Mobile" value = "<?php echo $res['mobile']?>">
                </div>
                
                <div class="col-md-6"><small>Profile Pic</small><br>
                    <input class="form-control" type="file" name="pfp" placeholder="Profile Pic">
                </div>

                <div class="col-md-6"><small>PAN</small><br>
                    <input class="form-control" type="text" name="pan" placeholder="PAN" value = "<?php echo $res['pan']?>">
                </div>
                
                <div class="col-md-6">
                    <label class="form-label">Opening Balance</label>
                    <input class="form-control" type="number" name="opening-balance" placeholder="Opening Balance" value = "<?php echo $res['opening_balance']?>">
                </div>
                
                <div class="col-md-6">
                    <label class="form-label">Currency</label>
                    <select class="form-select" name="currency">
                        <option value="INR">INR</option>
                        <option value="USD">USD</option>
                        <option value="EUR">EUR</option>
                    </select>
                </div>
                
            <div class="row mt-2">
                <!-- Billing Address -->
                <div class="col-md-6">
                    <p>Billing Address</p>
                    <div class="mb-3">
                        <textarea class="form-control" name="billing-address" ><?php echo $res['billing_address']?></textarea>
                    </div>
                </div>

                <!-- Shipping Address -->
                <div class="col-md-6">
                    <p>Shipping Address</p>
                    <div class="mb-3">
                        <textarea class="form-control" name="shipping-address" ><?php echo $res['shipping_address']?></textarea>
                    </div>
                </div>

                <div class="col-md-6">
                    <input class="form-control" type="text" name="payment-terms" placeholder="Payment Terms" value = "<?php echo $res['payment_terms']?>">
                </div>
                
                <div class="col-md-6">
                    <div class="form-check">
                        <input name="enable-portal" id="enable-portal" class="form-check-input" <?php if($res['enable_portal']==1){ echo 'checked'; } ?> type="checkbox">
                        <label class="form-check-label">Allow portal access for this customer</label>
                    </div>
                </div>
                </div>
                <div class="row mt-2">
                <div class="col-md-6 enableportalDiv">
                   <p>Username</p>
                    <input class="form-control" type="text" name="username"  id="username" placeholder="username" value = "<?php echo $res['username']?>">
                </div>
                <div class="col-md-6 enableportalDiv">
                     <p>Password</p>
                    <input class="form-control" type="text" name="password" id="password" placeholder="Leave it Empty if you don't want to change it">
                </div>
                <div class="col-md-6 mt-3">
                    <button class="btn btn-primary" type="submit">Submit</button>
                </div>


            </div>
        </form>
</div>

<script>
$(document).ready(function() {
  <?php if($res['enable_portal']==1){ ?>
    $('.enableportalDiv').show();
   <?php }else{ ?>
   $('.enableportalDiv').hide();
   <?php } ?>
    // Handle checkbox click
    $('#enable-portal').click(function() {
      // Toggle the visibility of the div based on checkbox state
      $('.enableportalDiv').toggle();

      // Make the text field required or not based on checkbox state
      $('#username').prop('required', $(this).is(':checked'));
      $('#password').prop('required', $(this).is(':checked'));
    });
  });
</script>