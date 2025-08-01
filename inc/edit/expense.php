<?php

//ini_set ('display_errors', 1);  ini_set ('display_startup_errors', 1);  error_reporting (E_ALL);

$qry = mysqli_query($con,"SELECT * FROM zw_expense WHERE id='$uid'"); 
$qvl = mysqli_fetch_assoc($qry);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['date'];
    $acc = $_POST['acc'];
    $type = $_POST['type'];
    $sac = $_POST['sac'];
    $amount = $_POST['amount'];
    $paid_throw = $_POST['paid_throw'];
    $vendor = $_POST['vendor'];
    $gst_treatment = $_POST['gst_treatment'];
    $vendor_gstin = $_POST['vendor_gstin'];
    $supply_source = isset($_POST['supply_source']) ? $_POST['supply_source'] : null;
    $supply_destination = $_POST['supply_destination'];
    $invoice_no = $_POST['invoice_no'];
    $customer_id = null;
    if(isset($_POST['customer_id'])){
    $customer_id = $_POST['customer_id'];
    }
    $bill_doc = uploadImage("bill_doc", "uploads/bill_doc");
    $notes = $_POST['notes'];

    $query = "UPDATE zw_expense SET 
  date = '$date',
  acc = '$acc',
  type = '$type',
  sac = '$sac',
  amount = '$amount',
  paid_throw = '$paid_throw',
  vendor = '$vendor',
  gst_treatment = '$gst_treatment',
  vendor_gstin = '$vendor_gstin',
  supply_source = '$supply_source',
  supply_destination = '$supply_destination',
  invoice_no = '$invoice_no',
  customer_id = '$customer_id',
  bill_doc = '$bill_doc',
  notes = '$notes'
WHERE id='$uid'";

    if(mysqli_query($con, $query)) {
        echo "<script>alert('Expense updated');</script>";redirect("manage.php?t=expense&g=prc");
    } else {
        echo "<script>alert('Expense updating Failed');</script>";
    }
}


?>
    <h2>Edit Expense</h2>
        <form method="post" action="" enctype="multipart/form-data">
            <div class="row g-2 m-2 align-items-center">
              <div class="col-sm-3">
                <label for="Date" class="col-form-label">Date *</label>
              </div>
              <div class="col-sm-9">
                <input type="date" id="Date" class="form-control" aria-describedby="date" value="<?php echo $qvl['date']; ?>" name="date" required>
              </div>
            </div>
            <div class="row g-2 m-2 align-items-center">
              <div class="col-sm-3">
                <label for="hsn_code" class="col-form-label">Expense Account *</label>
              </div>
              <div class="col-sm-9">
                <select class="form-control form-select" name="acc">
                    <option value="" disabled selected>Select an Expense Account</option>
                    <?php $q = mysqli_query($con,"SELECT * FROM zw_accounts WHERE account_type IN (SELECT id FROM zw_account_types WHERE collection='Expense')");
                         while($n=mysqli_fetch_assoc($q)){ $id = $n['id']; $name = $n['account_name']; if($id==$qvl['acc']){$nol = "selected";}else{$nol="";}
                             echo"<option value='$id' $nol>$name</option>";
                         }
                    ?>
                </select>
              </div>
            </div>
            <div class="row g-2 m-2 align-items-center">
              <div class="col-sm-3">
                <label for="hsn_code" class="col-form-label">Expense Type *</label>
              </div>
              <div class="col-sm-9">
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="type" id="inlineRadio1" value="Goods" <?php if($qvl['type'] == 'Goods' ){echo "checked";} ?> required>
                  <label class="form-check-label" for="inlineRadio1">Goods</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="type" id="inlineRadio2" value="Services" <?php if($qvl['type'] == 'Services' ){echo "checked";} ?> >
                  <label class="form-check-label" for="inlineRadio2">Service</label>
                </div>
              </div>
            </div>
            <div class="row g-2 m-2 align-items-center">
              <div class="col-sm-3">
                <label for="sac" class="col-form-label">HSN / SAC</label>
              </div>
              <div class="col-sm-9">
                <input type="text" id="sac" class="form-control" aria-describedby="HSN / SAC" name="sac" value="<?php echo $qvl['sac']; ?>" >
              </div>
            </div>
            <div class="row g-2 m-2 align-items-center">
              <div class="col-sm-3">
                <label for="amount" class="col-form-label">Amount *</label>
              </div>
              <div class="col-sm-9">
                <input type="number" step="0.01" id="amount" class="form-control" name="amount" required value="<?php echo $qvl['amount']; ?>" >
              </div>
            </div>
            <div class="row g-2 m-2 align-items-center">
              <div class="col-sm-3">
                <label for="amount" class="col-form-label">Paid Through *</label>
              </div>
              <div class="col-sm-9">
                <select class="form-control form-select" name="paid_throw" required>
                    <?php acOptions(); ?>
                </select>
              </div>
            </div>
            <div class="row g-2 m-2 align-items-center">
              <div class="col-sm-3">
                <label for="amount" class="col-form-label">Select Vendor </label>
              </div>
              <div class="col-sm-9">
                <select class="form-control form-select" name="vendor" >
                        <option value="" disabled selected>Select Vendor</option>
                        <?php optionPrintAdv("zw_company" ,"id","company_name", $qvl['vendor']); ?>
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
                <input type="text" id="vendor_gstin" class="form-control" name="vendor_gstin" required value="<?php echo $qvl['vendor_gstin']; ?>" >
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
                            echo "<option value='$stateName' "; if($stateName==$qvl['supply_destination']){echo "selected";} echo"> $stateName</option>";
                        }
                        ?>
                </select>
              </div>
            </div>
            <div class="row g-2 m-2 align-items-center">
              <div class="col-sm-3">
                <label for="invoice_no" class="col-form-label">Invoice No *</label>
              </div>
              <div class="col-sm-9">
                <input type="text" id="invoice_no" class="form-control" name="invoice_no" required value="<?php echo $qvl['invoice_no']; ?>">
              </div>
            </div>
            <div class="row g-2 m-2 align-items-center">
              <div class="col-sm-3">
                <label for="invoice_no" class="col-form-label">Notes</label>
              </div>
              <div class="col-sm-9">
                <textarea class="form-control" name="notes" rows="3"> <?php echo $qvl['notes']; ?> </textarea>
              </div>
            </div>
            <div class="row g-2 m-2 align-items-center">
              <div class="col-sm-3">
                <label for="amount" class="col-form-label">Select Customer</label>
              </div>
              <div class="col-sm-9">
               <select id="customer_id" class='form-control form-select' name="customer_id">
                    <option value="0"  selected>Select Customer</option>
                    <?php optionPrintAdv("zw_customers WHERE customer_type!='ulb'", "id", "customer_display_name", $qvl['customer_id']); ?>
                </select>
              </div>
            </div>
            <div class="row g-2 m-2 align-items-center">
              <div class="col-sm-3">
                <label for="invoice_no" class="col-form-label">Bill Doc.</label>
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