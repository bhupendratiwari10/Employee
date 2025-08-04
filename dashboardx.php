<?php
include('inc/function.php'); 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}; 
checklogin();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
    .dashX{color:#fff!important;} #statsx div{background:#0000001c;color:#333;align-items:center;transform:scale(0.84);padding:11px 5px;border-radius:18px;}
    cb i{font-size:221%;background:#178a29;color:#fff;padding:16px;border-radius:18px;display:inline;transform:scale(0.9);aspect-ratio:1/1;}
    bx{padding:0;text-indent: 16px;display:block;margin:0!important;} bx p{font-size:80%;}
    </style>
</head>
<body class='row'>
    <?php include('inc/views/header.php'); ?>
    <div class="container col-md-10" style='padding:5% 3%;'>
        <h1 style='font-weight:700;'>Hello <l style='text-transform:capitalize;'><?php echo $_COOKIE["username"]; ?></l>!</h1>
        <h4>Welcome to The Tidy Rabbit Dashboard</h4> <hr>
        <div class='row col-12 m-0 p-0' id='statsx'>
            <div class='col-md col-12 row'><cb class='col-3'><i class='mi-person-fill'></i></cb><bx class='col'><h2><?php echo countRows('zw_user'); ?></h2><p> Platform Users</p></bx></div>
            <div class='col-md col-12 row'><cb class='col-3'><i class='mi-th-large'></i></cb><bx class='col'><h2><?php echo countRows('zw_items'); ?></h2><p> Total Items</p></bx></div>
            <div class='col-md col-12 row'><cb class='col-3'><i class='mi-filter_tilt_shift'></i></cb><bx class='col'><h2><?php echo countRows('zw_ulb'); ?></h2><p> ULBs</p></bx></div>
            <div class='col-md col-12 row'><cb class='col-3'><i class='mi-superpowers'></i></cb><bx class='col'><h2><?php echo countRows('zw_customers'); ?></h2><p> Customers</p></bx></div>
            <div class='col-md col-12 row'><cb class='col-3'><i class='mi-shopping-cart'></i></cb><bx class='col'><h2><?php echo countRows('zw_orders'); ?></h2><p> Purchase Orders</p></bx></div>
        </div>
        
        <div class='row col-12 m-0 p-0'>
            <div class='col-md-4 row mt-5' style='padding:21px 11px;border-radius:11px;background:#0000001c;transform:scale(0.93);'>
                <box class='col-12'>Pickup Chart <hr style='border-color:#000;margin:10px 0px;'></box>
                <?php
                    $n = 0; $m = date('M'); $y = date('Y');    while(30>$n){   $n = $n+1; 
                    $c1='#178a29'; $c2='#ffffff'; $c3='#60e174'; $r = rand(1,3); if($r==1){$bc=$c1;} if($r==2){$bc=$c2;} if($r==3){$bc=$c3;} 
                    
                        echo"<box style='aspect-ratio:1/1;border-radius:8px;transform:scale(0.76);background:$bc;' title='$n $m $y' class='col-2'></box>";
                    
                        
                    }
                
                ?>
            </div>
            <div class="col-md-6 mt-5" style='padding:21px 11px;border-radius:11px;background:#0000001c;transform:scale(0.93);'>
                <box class='col-12'>Bills Chart <hr style='border-color:#000;margin:10px 0px;'></box>
                <canvas id="myChart"></canvas>
            </div>
        </div>
    </div>
              <script>
        $(document).ready(function () {
  $.ajax({
    type: "POST", // You can change this to 'GET' if it's appropriate
    url: "inc/ajax.php", // Replace with the URL of your PHP script
    data: {type:"bill"}, // Send the selected customer ID as data
    dataType: "json", // Set the expected data type
    success: function (response) {
      //response = JSON.parse(response);
     // Extract the data from the response and convert it into the format needed for the chart
      const labels = response.map((item) => item.month);
      const dataValues = response.map((item) => parseInt(item.total_amount));

      // Call the createChart function with the updated data
      createChart(labels, dataValues);
      
    },
    error: function (xhr, status, error) {
      // Handle errors here
      console.error(xhr.responseText); // Log the error message to the console
    },
  });
});
function createChart(labels, dataValues) {

  const ctx = document.getElementById("myChart").getContext("2d");

  // Update the chart's data with the received data
  const data = {
    labels: labels,
    datasets: [
      {
        label: "Monthly Amount (INR)",
        data: dataValues, // Use the data received from the AJAX response
        backgroundColor: [
          "rgba(255, 99, 132, 0.2)",
          "rgba(255, 159, 64, 0.2)",
          "rgba(255, 205, 86, 0.2)",
          "rgba(75, 192, 192, 0.2)",
          "rgba(54, 162, 235, 0.2)",
          "rgba(153, 102, 255, 0.2)",
          "rgba(201, 203, 207, 0.2)",
        ],
        borderColor: [
          "rgb(255, 99, 132)",
          "rgb(255, 159, 64)",
          "rgb(255, 205, 86)",
          "rgb(75, 192, 192)",
          "rgb(54, 162, 235)",
          "rgb(153, 102, 255)",
          "rgb(201, 203, 207)",
        ],
        borderWidth: 1,
      },
    ],
  };

  const config = {
    type: "bar",
    data: data,
    options: {
      scales: {
        y: {
          beginAtZero: true,
        },
      },
    },
  };

  // Create the chart or update the existing chart with the new data
   const myChart = new Chart(ctx, config);
}
              </script>
</body>
</html>
