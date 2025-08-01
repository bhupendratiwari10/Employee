<?php

    $title = namebyAid($uid, "title", "zw_ulb");
    $monthly_waste = namebyAid($uid, "monthly_waste", "zw_ulb");
    $state = namebyAid($uid, "state", "zw_ulb");
    $district = namebyAid($uid, "district", "zw_ulb");
    $mrfs = namebyAid($uid, "mrfs", "zw_ulb");

    if (isset($_POST['title'])) {
        $con = dbCon();

        $title = mysqli_real_escape_string($con, $_POST['title']);
        $monthly_waste = mysqli_real_escape_string($con, $_POST['monthly_waste']);
        $phone = mysqli_real_escape_string($con, $_POST['phone']);
        $website = mysqli_real_escape_string($con, $_POST['website']);
        $desc = mysqli_real_escape_string($con, $_POST['desc']);
        
        $updateQuery = "UPDATE zw_ulb SET ";

        $updateData = array();
        if (!empty($title) && $title !== $title) {
            $updateData[] = "company_name = '$title'";
        }
        if (!empty($monthly_waste) && $monthly_waste !== $monthly_waste) {
            $updateData[] = "monthly_waste = '$monthly_waste'";
        }
        if (!empty($phone) && $phone !== $state) {
            $updateData[] = "company_phone = '$phone'";
        }
        if (!empty($website) && $website !== $district) {
            $updateData[] = "company_website = '$website'";
        }
        if (!empty($desc) && $desc !== $mrfs) {
            $updateData[] = "company_details = '$desc'";
        }

        if (!empty($updateData)) {
            $updateQuery .= implode(', ', $updateData);
            $updateQuery .= " WHERE id = $uid";

            if (mysqli_query($con, $updateQuery)) {
                echo "<script>location.reload();</script>";
            }
        }
    }

?>

    <h2>Edit ULB's</h2>
    <form action="?type=company&id=<?php echo $uid; ?>" method="post" class='row col-12'>
        <input class='col-6 mt-2' type="text" name="title" placeholder="Company Name" value="<?php echo $title; ?>" required><br><br>
        
        <input class='col-6 mt-2' type="text" name="monthly_waste" placeholder="Monthly Waste" value="<?php echo $monthly_waste; ?>" required><br><br>
        
        <input class='col-6 mt-2' type="tel" name="phone" placeholder="Company Phone" value="<?php echo $state; ?>" required><br><br>
        
        <input class='col-6 mt-2' type="url" placeholder="Company Website" name="website" value="<?php echo $district; ?>"><br><br>
        
        <label for="desc" style='margin-top:8px;'>More Details:</label>
        <textarea class='col-12 mt-2' placeholder="Company Desc" name="desc"><?php echo $mrfs; ?></textarea><br><br>
        
        
        <center><br><button class='btn btn-info' type="submit">Submit</button></center>
    </form>
</div>