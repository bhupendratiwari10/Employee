<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $roleType = $_POST['role-type'];
    $name = $_POST['name'];
    $itemId = $_POST['item'];
    $itemRate = $_POST['itemrate'];
    $description = $_POST['description'];

    $query = "INSERT INTO zw_price (role, name, item_id, item_rate, description) 
              VALUES ('$roleType', '$name', '$itemId', '$itemRate', '$description')";

    if(mysqli_query($con, $query)) {
        echo "<script>alert('Price Added');</script>";
    } else {
        echo "<script>alert('Price Entry Failed');</script>";
    }
}



?>
    <h2>Add Price</h2>
        <form method="post" action="">
            <div class="row g-3">
               <div class="col-md-12">
                     <div class="form-check col-md-4">
                <label class="form-check-label">Account</label>
                <select class="form-select" name="role-type" required>
                    <option value="">Select Role Type</option>
                    <?php optionPrint("zw_user_roles"); ?>
                </select>
                            
                        </div>
                </div>
                
                <div class="col-md-4">
                <input class="form-control" type="text" name="name" placeholder="Pricing title">
                </div>

                <div class="col-md-4">
                <select class='form-select' name='item' required>
                    <?php optionPrintAdv("zw_items","id","name"); ?>
                </select>
                </div>

                 <div class="col-md-4">
                    <input class="form-control" type="text" name="itemrate" placeholder="Item Rate">
                </div>
                
                <div class="col-md-4">
                    <input class="form-control" type="text" name="description" placeholder="Description">
                </div>
                
                </div>
                <div class ="row">
                <div class="col-md-1 mt-3">
                    <button class="btn btn-primary" type="submit">Submit</button>
                </div>
                <div class="col-md-1 mt-3">
                    <button class="btn btn-primary" type="reset">Reset</button>
                </div>
                </div>


            </div>
        </form>

