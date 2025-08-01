<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Perform input validation and sanitization
    $date = $_POST['date'];
    $acc = $_POST['acc'];
    $type = $_POST['type'];
    $sac = $_POST['sac'];
    $amount = $_POST['amount'];
    $paid_throw = $_POST['paid_throw'];
    $vendor = isset($_POST['vendor']) ? $_POST['vendor'] : null; // Set vendor to NULL if not provided
    $gst_treatment = $_POST['gst_treatment'];
    $vendor_gstin = $_POST['vendor_gstin'];
    $supply_source = isset($_POST['supply_source']) ? $_POST['supply_source'] : null;
    $supply_destination = isset($_POST['supply_destination']) ? $_POST['supply_destination'] : null;
    $invoice_no = isset($_POST['invoice_no']) ? $_POST['invoice_no'] : null;
    $customer_id = isset($_POST['customer_id']) ? $_POST['customer_id'] : null; // Make customer selection optional
    $bill_doc = uploadImage("bill_doc", "uploads/bill_doc");
    $notes = $_POST['notes'];

    // Construct and execute SQL query
    $query = "INSERT INTO zw_expense 
                (date, acc, type, sac, amount, 
                 paid_throw, vendor, gst_treatment, vendor_gstin, supply_source, supply_destination, invoice_no, customer_id, bill_doc, 
                 notes) 
              VALUES 
                ('$date', '$acc', '$type', '$sac', '$amount', 
                 '$paid_throw', " . ($vendor !== null ? "'$vendor'" : "NULL") . ", '$gst_treatment', '$vendor_gstin', '$supply_source', ". ($supply_destination !== null ? "'$supply_destination'" : "NULL") .", ". ($invoice_no !== null ? "'$invoice_no'" : "NULL") .", '$customer_id', 
                 '$bill_doc', '$notes')";

    if (mysqli_query($con, $query)) {
        echo "<script>alert('Expense Added');</script>";
        redirect("manage.php?t=expense&g=prc");
    } else {
        echo "<script>alert('Expense Entry Failed');</script>";
    }
}


?>
    <h2>Add Expense</h2>
        <form method="post" action="" enctype="multipart/form-data">
            <div class="row g-2 m-2 align-items-center">
              <div class="col-sm-3">
                <label for="Date" class="col-form-label">Date *</label>
              </div>
              <div class="col-sm-9">
                <input type="date" id="Date" class="form-control" aria-describedby="date" name="date" required>
              </div>
            </div>
            <div class="row g-2 m-2 align-items-center">
              <div class="col-sm-3">
                <label for="acc" class="col-form-label">Expense Account *</label>
              </div>
              <div class="col-sm-9">
                <select class="form-control form-select item_account" name="acc" required>
                    <option value="" disabled selected>Select an Expense Account</option>
                    <?php $q = mysqli_query($con,"SELECT * FROM zw_accounts WHERE account_type IN (SELECT id FROM zw_account_types WHERE collection='Expense') AND id!='83' AND id!='84'");
                         while($n=mysqli_fetch_assoc($q)){ $id = $n['id']; $name = $n['account_name'];
                             echo"<option value='$id'>$name</option>";
                         }
                    ?>
                </select>
              </div>
            </div>
            <div class="row g-2 m-2 align-items-center">
              <div class="col-sm-3">
                <label for="type" class="col-form-label">Expense Type *</label>
              </div>
              <div class="col-sm-9"> 
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="type" id="inlineRadio1" value="Goods" checked required>
                  <label class="form-check-label" for="inlineRadio1">Goods</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="type" id="inlineRadio2" value="Services">
                  <label class="form-check-label" for="inlineRadio2">Service</label>
                </div>
              </div>
            </div>
            <div class="row g-2 m-2 align-items-center">
              <div class="col-sm-3">
                <label for="sac" class="col-form-label">HSN / SAC</label>
              </div>
              <div class="col-sm-9">
                <input type="text" id="sac" class="form-control" aria-describedby="HSN / SAC" name="sac">
              </div>
            </div>
            <div class="row g-2 m-2 align-items-center">
              <div class="col-sm-3">
                <label for="amount" class="col-form-label">Amount *</label>
              </div>
              <div class="col-sm-9">
                <input type="number" step="0.01" id="amount" class="form-control" name="amount" required>
              </div>
            </div>
            <div class="row g-2 m-2 align-items-center">
              <div class="col-sm-3">
                <label for="paid_throw" class="col-form-label">Paid Through *</label>
              </div>
              <div class="col-sm-9">
                <select class="form-control form-select" name="paid_throw" required>
                    <?php acOptions('paid_throw'); ?>
                </select>
              </div>
            </div>
            <div class="row g-2 m-2 align-items-center">
              <div class="col-sm-3">
                <label for="vendor" class="col-form-label">Select Vendor </label>
              </div>
              <div class="col-sm-9">
                <select class="form-control form-select" name="vendor">
                        <option value=" " disabled selected>Select Vendor</option>
                        <?php optionPrintAdv("zw_company" ,"id","company_name"); ?>
                </select>
              </div>
            </div>
            <div class="row g-2 m-2 align-items-center">
              <div class="col-sm-3">
                <label for="gst_treatment" class="col-form-label">GST Treatment *</label>
              </div>
              <div class="col-sm-9">
                <select id="gst_treatment" class="form-control" name="gst_treatment" required>
                    <?php gstTreatmentOptions(); ?>
                </select>
              </div>
            </div>
            <div class="row g-2 m-2 align-items-center">
              <div class="col-sm-3">
                <label for="vendor_gstin" class="col-form-label">Vendor GSTIN</label>
              </div>
              <div class="col-sm-9">
                <input type="text" id="vendor_gstin" class="form-control" name="vendor_gstin" required>
              </div>
            </div>
            <div class="row g-2 m-2 align-items-center">
              <div class="col-sm-3">
                <label for="supply_source" class="col-form-label">Source Of Supply </label>
              </div>
              <div class="col-sm-9">
                <select class="form-control form-select" name="supply_source">
                        <option value="" disabled>Select a Source Of Supply</option>
                        <?php
                        $indianStates = array(
                            "Andhra Pradesh", "Arunachal Pradesh", "Assam", "Bihar", "Chhattisgarh",
                            "Goa", "Gujarat", "Haryana", "Himachal Pradesh", "Jharkhand",
                            "Karnataka", "Kerala", "Madhya Pradesh", "Maharashtra", "Manipur",
                            "Meghalaya", "Mizoram", "Nagaland", "Odisha", "Puducherry", "Punjab",
                            "Rajasthan", "Sikkim", "Tamil Nadu", "Telangana", "Tripura",
                            "Uttar Pradesh", "Uttarakhand", "West Bengal"
                        );
                        foreach ($indianStates as $stateName) {
                            echo "<option value='$stateName' "; if($stateName=="Puducherry"){echo "selected";} echo"> $stateName</option>";
                        }
                        ?>
                </select>
              </div>
            </div>
            <div class="row g-2 m-2 align-items-center">
              <div class="col-sm-3">
                <label for="supply_destination" class="col-form-label">Destination Of Supply </label>
              </div>
              <div class="col-sm-9">
                <select class="form-control form-select" name="supply_destination">
                        <option value="" disabled selected>Select a Destination Of Supply</option>
                        <?php
                        $indianStates = array(
                            "Andhra Pradesh", "Arunachal Pradesh", "Assam", "Bihar", "Chhattisgarh",
                            "Goa", "Gujarat", "Haryana", "Himachal Pradesh", "Jharkhand",
                            "Karnataka", "Kerala", "Madhya Pradesh", "Maharashtra", "Manipur",
                            "Meghalaya", "Mizoram", "Nagaland", "Odisha", "Puducherry", "Punjab",
                            "Rajasthan", "Sikkim", "Tamil Nadu", "Telangana", "Tripura",
                            "Uttar Pradesh", "Uttarakhand", "West Bengal"
                        );
                        foreach ($indianStates as $stateName) {
                            echo "<option value='$stateName'>$stateName</option>";
                        }
                        ?>
                </select>
              </div>
            </div>
            <div class="row g-2 m-2 align-items-center">
              <div class="col-sm-3">
                <label for="invoice_no" class="col-form-label">Invoice No </label>
              </div>
              <div class="col-sm-9">
                <input type="text" id="invoice_no" class="form-control" name="invoice_no">
              </div>
            </div>
            <div class="row g-2 m-2 align-items-center">
              <div class="col-sm-3">
                <label for="notes" class="col-form-label">Notes</label>
              </div>
              <div class="col-sm-9">
                <textarea class="form-control" name="notes" rows="3"></textarea>
              </div>
            </div>
            <div class="row g-2 m-2 align-items-center">
              <div class="col-sm-3">
                <label for="customer_id" class="col-form-label">Select Customer</label>
              </div>
              <div class="col-sm-9">
               <select id="customer_id" class='form-control form-select' name="customer_id">
                    <option value="0"  selected>Select Customer</option>
                    <?php optionPrintAdv("zw_customers WHERE customer_type!='ulb'", "id", "customer_display_name"); ?>
                </select>
              </div>
            </div>
            <div class="row g-2 m-2 align-items-center">
              <div class="col-sm-3">
                <label for="bill_doc" class="col-form-label">Receipts</label>
              </div>
              <div class="col-sm-9">
                <input class="form-control" type="file" name="bill_doc" id="formFile">
              </div>
            </div>
            <div class="row">
                <div class="col-md-6 mt-3">
                    <button class="btn btn-primary" type="submit">Submit</button>
                </div>
            </div>
        </form>