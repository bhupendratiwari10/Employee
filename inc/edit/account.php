<?php


$qry = mysqli_query($con,"SELECT * FROM zw_accounts WHERE id='$uid'"); 
$qvl = mysqli_fetch_assoc($qry);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $accountType = $_POST["account_type"];
    $accountName = $_POST["account_name"];
    $accountCode = $_POST["account_code"];
    $accountCurrency = $_POST["account_currency"];
    $bankName = $_POST["bank_name"];
    $ifsc = $_POST["ifsc"];
    $logo = uploadImage("acclogo", "uploads/acc_img");
    $description = $_POST["description"];
    
    $sql = "UPDATE zw_accounts SET account_type = '$accountType', account_name = '$accountName', profile_pic = '$logo', account_code = '$accountCode', account_currency = '$accountCurrency', bank_name = '$bankName', ifsc = '$ifsc', description = '$description' WHERE id = $uid";
    
    if (mysqli_query($con, $sql)) {
         alert("Account Updated successfully.");
         redirect("manage.php?t=accounts&g=ac");
    } else {
         alert("Error: " . mysqli_error($con));
    }
}

?>

<h2>Edit Account</h2>
<form method="post" action="" enctype="multipart/form-data">
    <div class="row g-3">
        <div class="col-md-6">
            <label for="account_type">Account Type</label>
            <select class="form-select" name="account_type" required>
                <?php acTypes($qvl['account_type']); ?>
            </select>
        </div>
        <div class="col-md-6">
            <label for="account_name">Account Name</label>
            <input class="form-control" type="text" name="account_name" value="<?php echo $qvl['account_name']; ?>" required>
        </div>
        <div class="col-md-6">
            <label for="account_code">Account Code</label>
            <input class="form-control" type="text" name="account_code" value="<?php echo $qvl['account_code']; ?>" >
        </div>
        <div class="col-md-6">
            <label for="account_currency">Account Currency</label>
            <input class="form-control" type="text" name="account_currency" value="<?php $cur = $qvl['account_currency']; if(empty($cur)){ echo "INR";}else{echo $cur;} ?>" required>
        </div>
        <div class="col-md-6 d-none">
            <label for="bank_name">Bank Name</label>
            <input class="form-control" type="text" name="bank_name" value="<?php echo $qvl['bank_name']; ?>" >
        </div>
        <div class="col-md-6">
            <label for="acclogo">Account Logo</label>
            <input class="form-control" type="file" name="acclogo" >
        </div>
        <div class="col-md-6">
            <label for="ifsc">IFSC</label>
            <input class="form-control" type="text" name="ifsc" value="<?php echo $qvl['ifsc']; ?>" >
        </div>
        <div class="col-md-6">
            <label for="description">Description</label>
            <textarea class="form-control" name="description" rows="3"><?php echo $qvl['description']; ?></textarea>
        </div>
    </div>
    <div class="row">
        <div class="col-md-1 mt-3">
            <button class="btn btn-primary" type="submit">Submit</button>
        </div>
        <div class="col-md-1 mt-3">
            <button class="btn btn-primary" type="reset">Reset</button>
        </div>
    </div>
</form>
</body>