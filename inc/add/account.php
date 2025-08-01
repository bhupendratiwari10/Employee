<?php
$atype = $_GET['atype'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $accountType = $_POST["account_type"];
    $accountName = $_POST["account_name"];
    $_accountName = mysqli_real_escape_string($con,$accountName);
    
    $accountCode = $_POST["account_code"];
    $accountCurrency = $_POST["account_currency"];
    $bankName = $_POST["bank_name"];
    $ifsc = $_POST["ifsc"];
    $description = $_POST["description"];
    $banklogo = uploadImage("acclogo", "uploads/acc_img");
    
    $sql = "INSERT INTO zw_accounts (account_type, account_name, profile_pic, account_code, account_currency, bank_name, ifsc, description)
            VALUES ('$accountType', '$_accountName', '$banklogo', '$accountCode', '$accountCurrency', '$bankName', '$ifsc', '$description')";
    
    //echo $sql;
    
    if (mysqli_query($con, $sql)) {
         alert("Account inserted successfully.");
         redirect("manage.php?t=accounts&g=ac");
    } else {
         alert("Error: " . mysqli_error($con));
    }
}

?>

<h2>Add Account</h2>
<form method="post" action="" enctype="multipart/form-data">
    <div class="row g-3">
        <div class="col-md-6">
            <label for="account_type">Account Type</label>
            <select class="form-select" name="account_type" required>
                <?php if(empty($atype)){ ?><option value="" disabled selected>Select an Account Type</option><?php } ?>
                <?php acTypes($atype); ?>
            </select>
        </div>
        <div class="col-md-6">
            <label for="account_name">Account Name</label>
            <input class="form-control" type="text" name="account_name" required>
        </div>
        <div class="col-md-6">
            <label for="account_code">Account Code</label>
            <input class="form-control" type="text" name="account_code">
        </div>
        <div class="col-md-6">
            <label for="account_currency">Account Currency</label>
            <input class="form-control" type="text" name="account_currency" value="INR">
        </div>
        <div class="col-md-6 d-none">
            <label for="bank_name">Bank Name</label>
            <input class="form-control" type="text" name="bank_name" >
        </div>
        <div class="col-md-6">
            <label for="acclogo">Account Logo</label>
            <input class="form-control" type="file" name="acclogo" >
        </div>
        <div class="col-md-6 d-none">
            <label for="ifsc">IFSC</label>
            <input class="form-control" type="text" name="ifsc">
        </div>
        <div class="col-md-6">
            <label for="description">Description</label>
            <textarea class="form-control" name="description" rows="3"></textarea>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2 mt-3">
            <button class="btn btn-primary" type="submit">Submit</button>
        </div>
        <div class="col-md-1 mt-3">
            <button class="btn btn-primary" type="reset">Reset</button>
        </div>
    </div>
</form>
</body>