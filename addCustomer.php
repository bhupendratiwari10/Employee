<?php
include('inc/function.php'); if (session_status() === PHP_SESSION_NONE) {
    session_start();
}; checklogin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Information Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="row">
    <?php include('inc/views/header.php'); ?>
    <div class="container col-10 mt-4" style=" padding:21px 5%">
        <h2 class="text-center mb-4">Customer Information Form</h2>
        <form>
            <div class="row g-3">
               <div class="col-md-12">
                    <label class="form-label">Customer Type</label>
                    <div class="form-check">
                        <input name="customer-type" class="form-check-input" type="radio" value="ulb">
                        <label class="form-check-label">ULB</label>
                    </div>
                    <div class="form-check">
                        <input name="customer-type" class="form-check-input" type="radio" value="business">
                        <label class="form-check-label">Business</label>
                    </div>
                    <div class="form-check">
                        <input name="customer-type" class="form-check-input" type="radio" value="individual">
                        <label class="form-check-label">Individual</label>
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
                    <input class="form-control" type="text" name="customer-display-name" placeholder="Customer Display Name">
                </div>
                <div class="col-md-6">
                    <input class="form-control" type="email" name="customer-email" placeholder="Customer Email">
                </div>
                <div class="col-md-6">
                    <input class="form-control" type="tel" name="customer-phone" placeholder="Customer Phone">
                </div>
                <div class="col-md-6">
                    <input class="form-control" type="tel" name="work-phone" placeholder="Work Phone">
                </div>
                <div class="col-md-6">
                    <input class="form-control" type="tel" name="mobile" placeholder="Mobile">
                </div>
                <div class="col-12">
                    <label class="form-label">Other Details</label>
                    <textarea class="form-control" name="address" rows="4" placeholder="Address"></textarea>
                </div>
                
   
                <div class="col-md-6">
                    <input class="form-control" type="text" name="pan" placeholder="PAN">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Currency</label>
                    <select class="form-select" name="currency">
                        <option value="INR">INR</option>
                        <option value="USD">USD</option>
                        <option value="EUR">EUR</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <input class="form-control" type="number" name="opening-balance" placeholder="Opening Balance">
                </div>
                <div class="col-md-6">
                    <input class="form-control" type="text" name="payment-terms" placeholder="Payment Terms">
                </div>
                <div class="col-12">
                    <div class="form-check">
                        <input name="enable-portal" class="form-check-input" type="checkbox">
                        <label class="form-check-label">Allow portal access for this customer</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Portal Language</label>
                    <select class="form-select" name="portal-language">
                        <option value="english">English</option>
                        <option value="spanish">Spanish</option>
                        <option value="french">French</option>
                    </select>
                </div>
<div class="row g-3">
                <!-- Billing Address -->
                <div class="col-md-6">
                    <h3>Billing Address</h3>
                    <div class="mb-3">
                        <label class="form-label">Attention</label>
                        <input class="form-control" type="text" name="billing-attention">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Country / Region</label>
                        <select class="form-select" name="billing-country">
                            <option value="country1">Country 1</option>
                            <option value="country2">Country 2</option>
                            <option value="country3">Country 3</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Street 1</label>
                        <input class="form-control" type="text" name="billing-street1">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Street 2</label>
                        <input class="form-control" type="text" name="billing-street2">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">City</label>
                        <input class="form-control" type="text" name="billing-city">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">State</label>
                        <select class="form-select" name="billing-state">
                            <option value="state1">State 1</option>
                            <option value="state2">State 2</option>
                            <option value="state3">State 3</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Zip Code</label>
                        <input class="form-control" type="text" name="billing-zip">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input class="form-control" type="tel" name="billing-phone">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Fax</label>
                        <input class="form-control" type="tel" name="billing-fax">
                    </div>
                </div>

                <!-- Shipping Address -->
                <div class="col-md-6">
                    <h3>Shipping Address</h3>
                    <div class="mb-3">
                        <label class="form-label">Copy billing address</label>
                        <input class="form-check-input" type="checkbox" name="copy-billing-address">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Attention</label>
                        <input class="form-control" type="text" name="shipping-attention">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Country / Region</label>
                        <select class="form-select" name="shipping-country">
                            <option value="country1">Country 1</option>
                            <option value="country2">Country 2</option>
                            <option value="country3">Country 3</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Street 1</label>
                        <input class="form-control" type="text" name="shipping-street1">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Street 2</label>
                        <input class="form-control" type="text" name="shipping-street2">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">City</label>
                        <input class="form-control" type="text" name="shipping-city">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">State</label>
                        <select class="form-select" name="shipping-state">
                            <option value="state1">State 1</option>
                            <option value="state2">State 2</option>
                            <option value="state3">State 3</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Zip Code</label>
                        <input class="form-control" type="text" name="shipping-zip">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input class="form-control" type="tel" name="shipping-phone">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Fax</label>
                        <input class="form-control" type="tel" name="shipping-fax">
                    </div>
                </div>
                <div class="col-md-6">
                    <button class="btn btn-primary" type="submit">Submit</button>
                </div>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>