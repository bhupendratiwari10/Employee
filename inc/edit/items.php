<?php
  $query =  "SELECT * FROM `zw_items` where id = $uid";
$data = mysqli_query($con , $query);
$res = mysqli_fetch_assoc($data);
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
    // SQL query to insert data into the table
      $query = "Update  zw_items set item_type = '$itemType', gst_percentage = '$gst_percentage', name = '$name', sku = '$sku', unit = '$unit', hsn_code = '$hsnCode', tax_preference = '$taxPreference', selling_price = '$sellingPrice', selling_price_account = '$sellingPriceAccount', selling_price_description = '$sellingPriceDescription', cost_price = '$costPrice', cost_price_account = '$costPriceAccount', cost_price_description = '$costPriceDescription' where id = $uid";
    if (mysqli_query($con, $query)) {
        echo "<script>alert('Item Updated successfully.');</script>";redirect("manage.php?t=items");
    } else {
        echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
    }

    mysqli_close($con);
}
?>
<h2>Edit Item</h2>
<form method="post" class='row' action="">

    <div class='col-md-6'>
        <small class='col-12' for="item-type">Item Type:</small><br>
        <input type="radio" name="item_type" value="Goods" id="goods" <?php echo ($res['item_type'] == "Goods") ? "checked" : ""; ?> >
        <small class='col-12' for="goods">Goods</small>
        <input type="radio" name="item_type" value="Services" id="services" <?php echo ($res['item_type'] == "Services") ? "checked" : ""; ?> >
        <small class='col-12' for="services">Services</small>
    </div>
    <div class='col-md-6'>
        <small>Tax Preference:</small><br>
        <input type="radio" name="tax_preference" value="Taxable" id="taxable" checked>
        <small class='col-12' for="taxable">Taxable</small>
        <input type="radio" name="tax_preference" value="Non-Taxable" id="non-taxable">
        <small class='col-12' for="non-taxable">Non-Taxable</small>
    </div>
    

    <div class='col-md-8'>
        <small class='col-12' for="name">Name:</small>
        <input  class="form-control" type="text" name="name" id="name" value = "<?php echo $res['name']?>" required>
    </div>
    
    <div class='col-md-4'>
        <small class='col-12' for="gst_percentage">GST Percentage:</small>
        <input  class="form-control" type="number" name="gst_percentage" id="gst_percentage" value = "<?php echo $res['gst_percentage']?>">
    </div>
    
    
    <div class='col-md-4'>
        <small class='col-12' for="sku">SKU:</small>
        <input  class="form-control" type="text" name="sku" id="sku" value ="<?php echo $res['sku']?>" required>
    </div>
    <div class='col-md-4'>
        <small class='col-12' for="unit">Unit:</small>
        <input  class="form-control" type="text" name="unit" id="unit" value ="<?php echo $res['unit']?>" required>
    </div>
    <div class='col-md-4'>
        <small class='col-12' for="hsn_code">HSN Code:</small>
        <input  class="form-control" type="text" name="hsn_code" id="hsn_code" value ="<?php echo $res['hsn_code']?>" required>
    </div>
    
    
    <div class='col-12 mt-4 mb-2 row'>
        <div class='col-md-6'><input type='checkbox' id='en_sell'> Selling Information</div>
        <div class='col-md-6'><input type='checkbox' id='en_purc'> Purchase Information</div>
    </div>
    
    
    <div class='col-md-6' id='sellsec'>
        <small class='col-12' for="selling_price">Selling Price:</small>
        <input  class="form-control" type="number" name="selling_price" id="selling_price" value ="<?php echo $res['selling_price']?>" required>
    
        <small class='col-12' for="selling_price_account">Selling Price Account:</small>
        <select  class="form-control" name="selling_price_account" id="selling_price_account" required>
            <option  disabled>Selling Price Account</option>
            <?php optionPrintAdv("zw_accounts","id","account_name" , $res['selling_price_account']); ?>
        </select>
    
        <small class='col-12' for="selling_price_description">Selling Price Description:</small>
        <textarea class="form-control" name="selling_price_description" id="selling_price_description" rows="4" ><?php echo $res['selling_price_description']?></textarea>
    </div>
    
    
    <div class='col-md-6' id='costsec'>
        <small class='col-12' for="cost_price">Cost Price:</small>
        <input  class="form-control" type="number" name="cost_price" id="cost_price" value = "<?php echo $res['cost_price']?>">
    
        <small class='col-12' for="cost_price_account">Cost Price Account:</small>
        <select  class="form-control" type="text" name="cost_price_account" id="cost_price_account" value = "<?php echo $res['cost_price_account']?>">    
        <option  disabled>Cost Price Account</option>
            <?php optionPrintAdv("zw_accounts","id","account_name" ,$res['cost_price_account']); ?>
        </select>
        
        <small class='col-12' for="cost_price_description">Cost Price Description:</small>
        <textarea class="form-control" name="cost_price_description" id="cost_price_description" rows="4" > <?php echo $res['cost_price_description']?> </textarea>
    </div>
    <div class='col-md-12'>
        <button type="submit">Submit</button>
    </div>
</form>
</div>





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