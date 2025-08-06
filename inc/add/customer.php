<?php

 ini_set ('display_errors', 1);  
ini_set ('display_startup_errors', 1);  
error_reporting (E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assuming DB connection ($con) and uploadImage() are already available

    // Sanitize function
    function sanitize($value, $con) {
        return mysqli_real_escape_string($con, trim($value));
    }

    // Sanitize and collect form values
    $customerType = sanitize($_POST['customer-type'], $con);
    $firstName = sanitize($_POST['first-name'], $con);
    $lastName = sanitize($_POST['last-name'], $con);
    $companyName = sanitize($_POST['company-name'], $con);
    $customerDisplayName = sanitize($_POST['customer-display-name'], $con);
    $customerEmail = sanitize($_POST['customer-email'], $con);
    $customerPhone = sanitize($_POST['customer-phone'], $con);
    $workPhone = sanitize($_POST['work-phone'], $con);
    $mobile = sanitize($_POST['mobile'], $con);
    $pan = sanitize($_POST['pan'], $con);
    $openingBalance = sanitize($_POST['opening-balance'], $con);
    $currency = sanitize($_POST['currency'], $con);
    $billingAddress = sanitize($_POST['billing-address'], $con);
    $shippingAddress = sanitize($_POST['shipping-address'], $con);
    $paymentTerms = sanitize($_POST['payment-terms'], $con);
    $enablePortal = isset($_POST['enable-portal']) ? 1 : 0;
    $username = isset($_POST['username']) ? sanitize($_POST['username'], $con) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    $pfp = uploadImage("pfp", "uploads/customer_pfp");

    $hashedPassword = $enablePortal ? password_hash($password, PASSWORD_DEFAULT) : '';

    // Build query
    $query = "INSERT INTO zw_customers (
                customer_type, first_name, last_name, profile_pic, company_name, customer_display_name, 
                customer_email, customer_phone, work_phone, mobile, pan, opening_balance, currency, 
                billing_address, shipping_address, payment_terms, enable_portal, username, password
              ) VALUES (
                '$customerType', '$firstName', '$lastName', '$pfp', '$companyName', '$customerDisplayName',
                '$customerEmail', '$customerPhone', '$workPhone', '$mobile', '$pan', '$openingBalance',
                '$currency', '$billingAddress', '$shippingAddress', '$paymentTerms', '$enablePortal',
                '$username', '$hashedPassword'
              )";

    // Execute
    if (mysqli_query($con, $query)) {
        echo "<script>alert('Customer Added');</script>";
        echo "<script>window.location.href='manage.php?t=customer';</script>";
    } else {
        echo "<script>alert('Customer Entry Failed');</script>";
        error_log("MySQL Error: " . mysqli_error($con)); // Log error for debugging
    }
}
?>

    <h2>Add Customer</h2>
        <form method="post" action="" enctype="multipart/form-data">
            <div class="row g-3">
               <div class="col-md-12">
                    <label class="form-label">Customer Type</label>
                    <div class='row col-12'>
                        <div class="form-check col">
                            <input name="customer-type" class="form-check-input" type="radio" value="epr" required>
                            <label class="form-check-label">EPR Client</label>
                        </div>
                        <div class="form-check col">
                            <input name="customer-type" class="form-check-input" type="radio" value="business">
                            <label class="form-check-label">Business</label>
                        </div>
                        <div class="form-check col">
                            <input name="customer-type" class="form-check-input" type="radio" value="individual">
                            <label class="form-check-label">Individual</label>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <input class="form-control" type="text" name="first-name" placeholder="First Name">
                </div>
                
                <div class="col-md-4">
                    <input class="form-control" type="text" name="last-name" placeholder="Last Name">
                </div>
                
                <div class="col-md-4">
                    <input class="form-control" type="text" name="company-name" placeholder="Company Name">
                </div>
                
                <div class="col-md-6">
                    <input class="form-control" type="text" name="customer-display-name" required placeholder="Customer Display Name">
                </div>
                
                <div class="col-md-6">
                    <input class="form-control" type="email" name="customer-email" placeholder="Customer Email">
                </div>
                
                <div class="col-md-4">
                    <input class="form-control" type="tel" name="customer-phone" placeholder="Customer Phone">
                </div>
                
                <div class="col-md-4">
                    <input class="form-control" type="tel" name="work-phone" placeholder="Work Phone">
                </div>
                
                <div class="col-md-4">
                    <input class="form-control" type="tel" name="mobile" placeholder="Mobile">
                </div>
                
                <div class="col-md-6"><small>Profile Picture</small><br>
                    <input class="form-control" type="file" name="pfp" placeholder="Profile Pic">
                </div>
                
                <div class="col-md-6"><small>Enter Your PAN</small><br>
                    <input class="form-control" type="text" name="pan" placeholder="PAN">
                </div>
                
                <div class="col-md-6">
                    <label class="form-label">Opening Balance</label>
                    <input class="form-control" type="number" name="opening-balance" placeholder="Opening Balance">
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
                        <textarea class="form-control" name="billing-address"></textarea>
                    </div>
                </div>

                <!-- Shipping Address -->
                <div class="col-md-6">
                    <p>Shipping Address</p>
                    <div class="mb-3">
                        <textarea class="form-control" name="shipping-address"></textarea>
                    </div>
                </div>

                <div class="col-md-6">
                    <input class="form-control" type="text" name="payment-terms" placeholder="Payment Terms">
                </div>
                
                <div class="col-md-6">
                    <div class="form-check">
                        <input name="enable-portal" id="enable-portal" class="form-check-input" type="checkbox">
                        <label class="form-check-label">Allow portal access for this customer</label>
                    </div>
                </div>
                
                <div class="row mt-2">
                <div class="col-md-6 enableportalDiv">
                    <p>Username</p>
                    <input class="form-control" type="text" name="username"  id="username" placeholder="username">
                </div>
                <div class="col-md-6 enableportalDiv">
                    <p>Password</p>
                    <input class="form-control" type="text" name="password" id="password" placeholder="Password">
                </div>
                </div>
                <div class="col-md-6 mt-3">
                    <button class="btn btn-primary" type="submit">Submit</button>
                </div>



            </div>
        </form>
        
        <script>
$(document).ready(function() {
  
   $('.enableportalDiv').hide();
  
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