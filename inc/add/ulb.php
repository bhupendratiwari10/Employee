<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $monthly_waste = $_POST["monthly_waste"];
    $state = $_POST["state"];
    $district = $_POST["district"];
    $mrfs = $_POST["mrfs"];

    $sql = "INSERT INTO zw_ulb (title, monthly_waste, state, district, mrfs, time_str) VALUES ('$title', '$monthly_waste', '$state', '$district', '$mrfs', CURRENT_TIMESTAMP)";
    
    if (mysqli_query($con, $sql)) {alert("Data inserted successfully.");} else {echo "Error: " . mysqli_error($con);}
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add ULB Data</title>
</head>
<body>
    <h2>Add ULB Data</h2>
    <form method="post" class="row" action="">
        <div class="col-md-12">
            <label for="title">Title:</label>
            <input class="form-control" type="text" id="title" name="title" required>
        </div>
        <div class="col-md-6">
            <label for="monthly_waste">Monthly Waste:</label>
            <input class="form-control" type="text" id="monthly_waste" name="monthly_waste" required>
        </div>
        <div class="col-md-6">
            <label for="state">State:</label>
            <select class="form-control" id="state" name="state" required>
                <option value="" disabled selected>Select a state</option>
                <?php optionPrintAdv("zw_states", "name", "name"); ?>
            </select>
        </div>
        <div class="col-md-6">
            <label for="district">District:</label>
            <input class="form-control" type="text" id="district" name="district" required>
        </div>
        <div class="col-md-6">
            <label for="mrfs">MRFS:</label>
            <input class="form-control" type="text" id="mrfs" name="mrfs" required>
        </div>
        
        
        <div class="col-md-12"><br>
            <button class="btn btn-primary" type="submit">Submit</button>
        </div>
    </form>
</body>
</html>