<?php

//ini_set('display_errors', 1);ini_set('display_startup_errors', 1);error_reporting(E_ALL); $con = dbCon();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $itemType = mysqli_real_escape_string($con, $_POST['item-type']);
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $sku = mysqli_real_escape_string($con, $_POST['sku']);
    $unit = mysqli_real_escape_string($con, $_POST['unit']);
    $hsnCode = mysqli_real_escape_string($con, $_POST['hsn_code']);
    $taxPreference = mysqli_real_escape_string($con, $_POST['tax_preference']);
    $sellingPrice = mysqli_real_escape_string($con, $_POST['selling_price']);
    $sellingPriceAccount = mysqli_real_escape_string($con, $_POST['selling_price_account']);
    $sellingPriceDescription = mysqli_real_escape_string($con, $_POST['selling_price_description']);
    $costPrice = mysqli_real_escape_string($con, $_POST['cost_price']);
    $costPriceAccount = mysqli_real_escape_string($con, $_POST['cost_price_account']);
    $costPriceDescription = mysqli_real_escape_string($con, $_POST['cost_price_description']);
    $gst_percentage = mysqli_real_escape_string($con, $_POST['gst_percentage']);  
    if(null==$gst_percentage){ $gst_percentage='0';}

    // SQL query to insert data into the table
     $query = "INSERT INTO zw_items (item_type, name, sku, unit, hsn_code, tax_preference, selling_price, selling_price_account, selling_price_description, cost_price, cost_price_account, cost_price_description, gst_percentage)
              VALUES ('$itemType', '$name', '$sku', '$unit', '$hsnCode', '$taxPreference', '$sellingPrice', '$sellingPriceAccount', '$sellingPriceDescription', '$costPrice', '$costPriceAccount', '$costPriceDescription','$gst_percentage')";

    if (mysqli_query($con, $query)) {
        echo "<script>alert('Item added successfully.');</script>";redirect("manage.php?t=items");
      
    } else {
        echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
    }
    
    echo $query;
    mysqli_close($con);
  
}
?>

<h2>Add Item</h2>
<form method="post" class='row' action="">

    <div class='col-md-6'>
        <small class='col-12 text-danger' for="item-type">Item Type: *</small><br>
        <input type="radio" name="item-type" value="Goods" id="goods" required>
        <small class='col-12' for="goods">Goods</small>
        <input type="radio" name="item-type" value="Services" id="services">
        <small class='col-12' for="services">Services</small>
    </div>
    <div class='col-md-6'>
        <small class='col-12 text-danger'>Tax Preference: *</small><br>
        <input type="radio" name="tax_preference" value="Taxable" id="taxable" required>
        <small class='col-12' for="taxable">Taxable</small>
        <input type="radio" name="tax_preference" value="Non-Taxable" id="non-taxable">
        <small class='col-12' for="non-taxable">Non-Taxable</small>
    </div>
    

    <div class='col-md-8'>
        <small class='col-12' for="name">Name:</small>
        <input  class="form-control" type="text" name="name" id="name" required>
    </div>
    <div class='col-md-4'>
        <small class='col-12' for="hsn_code">HSN Code:</small>
        <input  class="form-control" type="text" name="hsn_code" id="hsn_code">
    </div>
    
    
    <div class='col-md-4'>
        <small class='col-12' for="sku">SKU:</small>
        <input  class="form-control" type="text" name="sku" id="sku">
    </div>
    <div class='col-md-4'>
        <small class='col-12 text-danger' for="unit">Unit: *</small>
        <input  class="form-control" type="text" name="unit" id="unit" required>
    </div>
    <div class='col-md-4'>
        <small class='col-12 text-danger' for="gst_percentage">GST Percentage: *</small>
        <input  class="form-control" type="number" name="gst_percentage" id="gst_percentage" required>
    </div>
    
    
    <div class='col-12 mt-3 mb-2 row'>
        <div class='col-md-6'><input type='checkbox' id='en_sell'> Selling Information</div>
        <div class='col-md-6'><input type='checkbox' id='en_purc'> Purchase Information</div>
    </div>
    
    
    <div class='col-md-6' id='sellsec'>
        <small class='col-12' for="selling_price">Selling Price: *</small>
        <input  class="form-control" type="number" name="selling_price" id="selling_price">
    
        <small class='col-12' for="selling_price_account">Selling Price Account: *</small>
        <select  class="form-control" name="selling_price_account" id="selling_price_account">
           <?php acOptionsAdv(NULL,'1'); ?>
        </select>
        <small class='col-12' for="selling_price_description">Selling Price Description:</small>
        <textarea class="form-control" name="selling_price_description" id="selling_price_description" rows="4"></textarea>
    </div>
    
    
    <div class='col-md-6' id='costsec'>
        <small class='col-12' for="cost_price">Cost Price: *</small>
        <input  class="form-control" type="number" name="cost_price" id="cost_price">
    
        <small class='col-12' for="cost_price_account">Cost Price Account: *</small>
        <select  class="form-control" type="text" name="cost_price_account" id="cost_price_account">    
            <?php acOptionsAdv(NULL,'23'); ?>
        </select>
    
        <small class='col-12' for="cost_price_description">Cost Price Description:</small>
        <textarea class="form-control" name="cost_price_description" id="cost_price_description" rows="4"></textarea>
    </div>
    <div class='col-md-12'>
        <button type="submit">Submit</button>
    </div>
</form>






<script>
document.addEventListener('DOMContentLoaded', function() {
    const sellingCheckbox = document.getElementById('en_sell');
    const purchaseCheckbox = document.getElementById('en_purc');

    const sellingSection = document.getElementById('sellsec');
    const purchaseSection = document.getElementById('costsec');

    // Enable or disable inputs in Selling Information
    sellingCheckbox.addEventListener('change', function() {
        const inputs = sellingSection.querySelectorAll('input, select');
        const smalls = sellingSection.querySelectorAll('small');

        inputs.forEach(input => {
            input.disabled = !this.checked; // Enable or disable based on checkbox
            if (input.type !== "textarea") {
                input.required = this.checked; // Add required if checkbox is checked and it's not a textarea
            }
        });

        smalls.forEach(small => {
            small.classList.toggle('text-danger', this.checked); // Toggle text-warning class based on checkbox
        });
    });

    // Enable or disable inputs in Purchase Information
    purchaseCheckbox.addEventListener('change', function() {
        const inputs = purchaseSection.querySelectorAll('input, select');
        const smalls = purchaseSection.querySelectorAll('small');

        inputs.forEach(input => {
            input.disabled = !this.checked; // Enable or disable based on checkbox
            if (input.type !== "textarea") {
                input.required = this.checked; // Add required if checkbox is checked and it's not a textarea
            }
        });

        smalls.forEach(small => {
            small.classList.toggle('text-warning', this.checked); // Toggle text-warning class based on checkbox
        });
    });

    // Initialize disabled state on load based on checkbox initial state
    sellingCheckbox.dispatchEvent(new Event('change'));
    purchaseCheckbox.dispatchEvent(new Event('change'));
});
</script>