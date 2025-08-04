<?php
include('inc/function.php'); 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}; 
checklogin();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<?php

$ulbWaste = generalQuery("SELECT (SUM(monthly_waste)/1000)*3000 as total FROM `zw_ulb`"); // Waste Worker Calculator
$totalUlbWasteWorker = 0;
if(!empty($ulbWaste)){
  $row = mysqli_fetch_assoc($ulbWaste) ;
  $totalUlbWasteWorker = $row['total'];
}


// Queries for profit and loss 
$getIncomeAccountType = generalQuery("SELECT id FROM `zw_account_types` WHERE title LIKE '%Income%' or title LIKE '%income%'");
$getExpensesAccountType =  generalQuery("SELECT id FROM `zw_account_types` WHERE title LIKE '%Expenses%' or title LIKE '%expenses%'");
if(mysqli_num_rows($getIncomeAccountType) > 0){
    $tempArrayIncome = [];
    while($row = mysqli_fetch_assoc($getIncomeAccountType)){
        $tempArrayIncome[] = $row['id'];
    }
    $idsStringIncome = implode(',' , $tempArrayIncome);
    $totalBalanceQuery = generalQuery("SELECT SUM(closing_balance) as closing_balance  FROM `zw_accounts` WHERE account_type IN($idsStringIncome)");
    // Month Wise Total Sum
    $totalMonthWiseIncome = generalQuery("SELECT YEAR(time_str) as year, MONTH(time_str) as month,SUM(closing_balance) as income_amount FROM zw_accounts WHERE account_type IN ($idsStringIncome) AND time_str >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH) GROUP BY YEAR(time_str), MONTH(time_str) ORDER BY year DESC, month DESC");
    
    // print_r($totalMonthWiseIncome);
    if(!empty($totalBalanceQuery)){
        while($row = mysqli_fetch_assoc($totalBalanceQuery)){
            $closingBalanceIncome = $row['closing_balance'];
        }
    }
}

if(!empty($getExpensesAccountType)){
if(mysqli_num_rows($getExpensesAccountType) > 0){
    $tempArrayExpense = [];
    while($row = mysqli_fetch_assoc($getExpensesAccountType)){
        $tempArrayExpense[] = $row['id'];
    }
    $idsStringExpense = implode(',' , $tempArrayExpense);
     $totalBalanceQuery = generalQuery("SELECT SUM(closing_balance) as closing_balance FROM `zw_accounts` WHERE account_type IN($idsStringExpense)");
     // Month Wise Expense 
     $totalMonthWiseExpense = generalQuery("SELECT  YEAR(time_str) as year, MONTH(time_str) as month,SUM(closing_balance) as expense_amount FROM zw_accounts WHERE account_type IN ($idsStringExpense) AND time_str >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH) GROUP BY YEAR(time_str), MONTH(time_str) ORDER BY year DESC, month DESC");
     if(!empty($totalBalanceQuery)){
        while($row = mysqli_fetch_assoc($totalBalanceQuery)){
            $closingBalanceExpense = $row['closing_balance'];
        }
    }
}
}



if(!empty($totalMonthWiseIncome)){
    $monthWiseArrayDataIncome = [];
    
    while($row = mysqli_fetch_assoc($totalMonthWiseIncome)){
     $monthNumber = (int)$row['month'];
     if ($monthNumber >= 1 && $monthNumber <= 12) {
        // Use the date() function to get the month name
        $monthName = date('M', mktime(0, 0, 0, $monthNumber, 1, 2000));
        
    }
      //$month = date('M' , strtotime($month));
    $monthWiseArrayDataIncome[] = [$monthName .  " " . $row['year'] , $row['income_amount']];
    }
    }
    
    
    if(!empty($totalMonthWiseExpense)){
    $monthWiseArrayDataExpense = [];
    
    while($row = mysqli_fetch_assoc($totalMonthWiseExpense)){
       $monthNumber = (int)$row['month'];
     if ($monthNumber >= 1 && $monthNumber <= 12) {
        // Use the date() function to get the month name
        $monthName = date('M', mktime(0, 0, 0, $monthNumber, 1, 2000));
        
    }
    //   $monthWiseArrayDataExpense['year'] = $row['year'];
    //   $monthWiseArrayDataExpense['closing_balance'] = $row['expense_amount'];
      $monthWiseArrayDataExpense[] =  [$monthName .  " " . $row['year'], $row['expense_amount']];
    }
    }
    
    
    // Combine arrays based on date month
$combinedArray = array();
 if(!empty($monthWiseArrayDataIncome)){
foreach ($monthWiseArrayDataIncome as $item) {
    list($yearMonth, $value) = $item;
    $combinedArray[$yearMonth] = array($yearMonth, $value, 0);
}
}

if(!empty($monthWiseArrayDataExpense)){
foreach ($monthWiseArrayDataExpense as $item) {
    list($yearMonth, $value) = $item;
    if (isset($combinedArray[$yearMonth])) {
        $combinedArray[$yearMonth][2] = $value;
    } else {
        $combinedArray[$yearMonth] = array($yearMonth, 0, $value);
    }

}
}

// Optionally, convert the associative array to a numeric array
$combinedArray = array_values($combinedArray);

// Print the result
// print_r($combinedArray);


$plasticQuery = generalQuery("SELECT id FROM `zw_pickup_categories` WHERE title LIKE 'Plastic%' or title LIKE 'plastic%'");
if(!empty($plasticQuery)){
    
    // $i = 0; // first row;
    $categories = [];
  while($row = mysqli_fetch_assoc($plasticQuery)) {
      $categories[] = $row['id'];
//       if($i == 0){
//       $where.= $row['id'];
//       }
//       else{
//       $where.= ' or category = ' .$row['id'];
//       }
//       $i++;
//   }
}
}

if (!empty($categories)) {
    $where = ' WHERE category IN (' . implode(', ', $categories) . ') and steps >= 8';
} else {
    $where = ''; // No categories found, set WHERE to an empty string
}


// Total Waste Collection Data
$totalWasteData = generalQuery("SELECT SUM(net_quantity) FROM `zw_pickups`" . $where);
// print_r($totalWasteData);die;
if(!empty($totalWasteData)){
$totalWaste = mysqli_fetch_assoc($totalWasteData);
$totalWaste = $totalWaste['SUM(net_quantity)'];

// Weight in tons
$totalWasteTon = $totalWaste / 1000;
}
else{
   $totalWaste = 0; 
}


// Recent PickUP Query  chart
$recentPickUPData = "SELECT * FROM `zw_pickups` WHERE time_str >= CURRENT_DATE - INTERVAL 30 day  and steps >= 8";
$recentPickUPData = generalQuery($recentPickUPData); // Query Chart
// echo "<pre>";print_r($recentPickUPData); 
// Recent Pickup Table 
$recentPickUPTable = "SELECT * FROM `zw_pickups` WHERE  steps >= 8 order by id desc limit 5";
$recentPickUPTable = generalQuery($recentPickUPTable); // Query Chart

$recentPickChartArray = [];
// $recentPickDataQuantity = [];
if(mysqli_num_rows($recentPickUPData) >= 1 ){
while($pickDates = mysqli_fetch_assoc($recentPickUPData)){
    $date = date('d-m-Y' , strtotime($pickDates['time_str']));
    $recentPickChartArray[$date] =$pickDates['net_quantity'] / 1000;
}
}

$finalMonthArray = array_unshift($combinedArray, array('Month', 'Income', 'Expenses'));
$combinedArray = json_encode($combinedArray);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  
    <style>
    .dashX{color:#fff!important;background:green;} #statsx div{background:#0000001c;color:#333;align-items:center;transform:scale(0.84);padding:11px 5px;border-radius:18px;}
    cb i{font-size:221%;background:#178a29;color:#fff;padding:16px;border-radius:18px;display:inline;transform:scale(0.9);aspect-ratio:1/1;}
    bx{padding:0;text-indent: 16px;display:block;margin:0!important;} bx p{font-size:80%;}
    .col-1 {width: 80px; !important}
    #chart_div{
        height:300px;
        width:700px !important;
        background:#fff;
    }
    </style>
</head>
<body class='row'>
    <?php include('inc/views/header.php'); ?>
    <div class="container col-md" style='padding:5% 3%;background:#f3f3f3;margin-top:-5vh;'>

        <div class="row col-12">
            
            <div class="col-7 row" style=''>
                <div class='col-8'>
                    <h1 style='font-weight:700;'>Hello <l style='text-transform:capitalize;'><?php echo $_COOKIE["username"]; ?></l>!</h1>
                    <h4>Welcome to Tidy Rabbit Dashboard !</h4> <br>
                
                    <div class="card px-5 py-5" style=''>
                        <h2><?php echo number_format($totalWasteTon , 2);?> Tons</h2> of Plastic Prevented From Entering The Environment
                    </div>
                        
                </div>
                <div class='col-4'>
                    <div class="card px-4 py-5" style=''>
                        <h2><?php echo number_format($totalUlbWasteWorker , 2)?>+ Waste Workers</h2>  professionalized for enhanced and dignified livlihood.
                    </div>
                </div>
            </div>
            
            <div class="col-5 card px-5 py-5" style='transform:scale(0.9);background:#fff;'>
               <p>P&L</p>
               <?php 
               $profitLoss = 0;
               $color = "green";
               $closingBalanceIncome = $closingBalanceIncome ?? 0;
               $closingBalanceExpense = $closingBalanceExpense ?? 0;
            //   if(!empty($closingBalanceIncome) && !empty($closingBalanceExpense)){
                $profitLoss = $closingBalanceIncome - $closingBalanceExpense;
                if($profitLoss >= 0){
                    $color = "green";
                }
                else{
                   $color = "red"; 
                }
            //   }
               ?>
               <h1 style='font-size:555%;color:<?php echo $color?>'><?php echo $profitLoss ? $profitLoss : 0;?></h1>
               <hr><div class='row'>
               <h4 class='col-6 text-success'><?php echo $closingBalanceIncome ? $closingBalanceIncome : 0;?> Sales</h4>  <h4 class='col-6 text-danger'><?php echo $closingBalanceExpense ? $closingBalanceExpense : 0;?> Expense</h4></div>
            </div>
        </div>


        <div class='col-12 row'>
            <div class='row col-7 m-0 p-0'>
                    <div class='col-12 border row mt-3' style='padding:21px 11px;border-radius:11px;background:#fff;transform:scale(0.96);'>
                        <box class='col-12'>Pickup Chart <hr style='border-color:#000;margin:10px 0px;'></box>
                        <?php
                            $n = 0; 
                            $currentDate = date("d-m-Y"); // Today's Date
                            // $thirtyDaysBefore = date("Y-m-d", strtotime("-30 days", strtotime($currentDate))); // Thirty days before date
                            $c1='orange'; $c2='#00FF00'; $c3='#000000'; 
                            while(30>$n)
                            {
                            // print_r($recentPickChartArray);die; 
                            $date = 30 - $n;
                            $DaysBeforeDate = date("d-m-Y", strtotime("-$date days", strtotime($currentDate)));
                            if(array_key_exists($DaysBeforeDate , $recentPickChartArray)){
                                $net_Quantity = $recentPickChartArray[$DaysBeforeDate];
                                if($net_Quantity > 0 && $net_Quantity < 10){
                                  $bc =   $c1;
                                }
                                else if($net_Quantity > 10){
                                    $bc =   $c2;
                                }
                                else{
                                    $bc =   $c3; 
                                }
                            }
                            else {
                                $net_Quantity = 0;
                                $bc = $c3;
                            }
                            
                            
                                echo"<box style='aspect-ratio:1/1;border-radius:8px;transform:scale(0.76);border:1px solid #999;background:$bc;' title='$DaysBeforeDate' class='col-1'></box>";
                                 $n++; 
                            }
                            
                            
                        
                        ?>
                    </div>
                    <!--<div class="col-md-6 mt-5" style='padding:21px 11px;border-radius:11px;background:#0000001c;transform:scale(0.93);'>-->
                    <!--    <box class='col-12'>Bills Chart <hr style='border-color:#000;margin:10px 0px;'></box>-->
                    <!--    <canvas id="myChart"></canvas>-->
                    <!--</div>-->
            </div>
            <div class='col-5  m-0 p-0'>
                <div class='col-12 row border mt-3' style='padding:21px 11px;border-radius:11px;background:#fff;transform:scale(0.96);'>
                    <box class='col-12'>Recent Pickups <hr style='border-color:#000;margin:10px 0px;'></box><table>
                    <?php while($row = mysqli_fetch_assoc($recentPickUPTable)){
                    ?>
                    <tr><td><?php echo date('d-m-Y', strtotime($row['time_str']))?></td>
                    <td>ZW-PK-00<?php echo $row['id']?></td>
                    <td>ULB <?php echo $row['ulb']?></td>
                    <td><a href = 'view.php?type=pickups&id=<?php echo $row['id'];?>'><i class="mi-eye-fill"></i></a></td>
                    </tr>
                    <?php } ?>
                </table></div>
            </div>
            
        </div>
    <!------------- Cahs flow ----------------->
     	<div class='col-12 row'>
            
            <div class='col-12 border row mt-3' style='padding:21px 11px;border-radius:11px;background:#fff;transform:scale(0.96);'>
                <box class='col-12'>Cash Flow Statement <hr style='border-color:#000;margin:10px 0px;'></box>
                <!--<div class="col-8" style="height: 400px;" id="cash_flow_chart_div"></div>-->
                 <div id="chart_div"></div>
                <div class="col-4" style='padding:21px 11px;background:#fff;'>
           			<h4>Incoming</h4>
            		<p><?php echo $closingBalanceIncome?> +</p>
            		<br>
            		<h4>Outgoing</h4>
            		<p><?php echo $closingBalanceExpense?> -</p>
            		<br>
            		<h5>Cash as on <?= date('d-m-Y')?> </h5>
            		<p><?php echo $closingBalanceIncome - $closingBalanceExpense ?></p>
            	</div>

            </div>
                   
           
                
        </div>

        <div class='col-12 row'>
            <div class='row col-7 m-0 p-0'>
                    <div class='col-12 border row mt-3' style='padding:21px 11px;border-radius:11px;background:#fff;transform:scale(0.96);'>
                        <box class='col-12'>Income & Expenses <hr style='border-color:#000;margin:10px 0px;'></box>
                               <div id="income_expenses_dual_x_div" style="width: 550px; height: 350px;"></div>

                    </div>
                   
            </div>
            <div class='col-5 m-0 p-0'>
                <div class='col-12 row border mt-3' style='padding:21px 11px;border-radius:11px;background:#fff;transform:scale(0.96);'>
                    <box class='col-12'>Top Expenses <hr style='border-color:#000;margin:10px 0px;'></box>
                    	<div id="top_expenses_piechart" style="width: 300px; height: 250px;"></div>

                </div>
            </div>
            
        </div>
            
    </div>
    <!--<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>-->
    <script>
    	
    	google.charts.load('current', {'packages':['corechart', 'piechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
  var data = google.visualization.arrayToDataTable([
    ['Expenses', 'Top Expenses'],
    ['Work',     11],
    ['Eat',      2],
    ['Commute',  2],
    ['Watch TV', 2],
    ['Sleep',    7]
  ]);

  var options = {
    title: 'Top Expenses',
    is3D: true, // Add this line if you want a 3D pie chart
  };

  var chart = new google.visualization.PieChart(document.getElementById('top_expenses_piechart'));

  chart.draw(data, options);
}


    </script>

    <script>
    	google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawStuff);

      function drawStuff() {
         let values = <?php echo $combinedArray; ?>;
         //console.log(values)
        var data = new google.visualization.arrayToDataTable(values);

        var options = {
          width: 550,
          
          bars: 'verticle', // Required for Material Bar Charts.
          series: {
            // 0: { axis: 'income' }, // Bind series 0 to an axis named 'distance'.
            // 1: { axis: 'expenses' } // Bind series 1 to an axis named 'brightness'.
          },
          axes: {
    x: {
      income: { label: 'parsecs' },
      expenses: { side: 'top', label: 'apparent magnitude' }
    },
    y: {
      income: {
        label: 'Income',
        ticks: [0, 50000, 100000, 500000], // Customize the tick values based on your requirements
        // gridlines: { count: 5 } // Adjust the gridlines count
      },
      expenses: {
        label: 'Expenses',
        ticks:  [0, 50000, 100000, 500000], // Customize the tick values based on your requirements
        // gridlines: { count: 5 } // Adjust the gridlines count
      }
    }
  }
        };

      var chart = new google.charts.Bar(document.getElementById('income_expenses_dual_x_div'));
      chart.draw(data, options);
    };
    </script>
    <script>

//      	google.charts.load('current', {packages: ['corechart', 'line']});
// 		google.charts.setOnLoadCallback(drawBasic);

// 	function drawBasic() {

//       var data = new google.visualization.DataTable();
//       data.addColumn('number', 'X');
//       data.addColumn('number', 'Time');

//       data.addRows([
//         [0, 0],   [1, 10],  [2, 23],  [3, 17],  [4, 18],  [5, 9],
//         [6, 11],  [7, 27],  [8, 33],  [9, 40],  [10, 32], [11, 35],
//         [12, 30], [13, 40], [14, 42], [15, 47], [16, 44], [17, 48],
//         [18, 52], [19, 54], [20, 42], [21, 55], [22, 56], [23, 57],
//         [24, 60], [25, 50], [26, 52], [27, 51], [28, 49], [29, 53],
//         [30, 55], [31, 60], [32, 61], [33, 59], [34, 62], [35, 65],
//         [36, 62], [37, 58], [38, 55], [39, 61], [40, 64], [41, 65],
//         [42, 63], [43, 66], [44, 67], [45, 69], [46, 69], [47, 70],
//         [48, 72], [49, 68], [50, 66], [51, 65], [52, 67], [53, 70],
//         [54, 71], [55, 72], [56, 73], [57, 75], [58, 70], [59, 68],
//         [60, 64], [61, 60], [62, 65], [63, 67], [64, 68], [65, 69],
//         [66, 70], [67, 72], [68, 75], [69, 80]
//       ]);

//       var options = {
//         hAxis: {
//           title: 'Time'
//         },
//         vAxis: {
//           title: ''
//         }
//       };

//       var chart = new google.visualization.LineChart(document.getElementById('cash_flow_chart_div'));

//       chart.draw(data, options);
//     }


//         $(document).ready(function () {
//   $.ajax({
//     type: "POST", // You can change this to 'GET' if it's appropriate
//     url: "inc/ajax.php", // Replace with the URL of your PHP script
//     data: {type:"epr"}, // Send the selected customer ID as data
//     dataType: "json", // Set the expected data type
//     success: function (response) {
//       //response = JSON.parse(response);
//      // Extract the data from the response and convert it into the format needed for the chart
//       const labels = response.map((item) => item.month);
//       const dataValues = response.map((item) => parseInt(item.total_amount));

//       // Call the createChart function with the updated data
//       createChart(labels, dataValues);
      
//     },
//     error: function (xhr, status, error) {
//       // Handle errors here
//       console.error(xhr.responseText); // Log the error message to the console
//     },
//   });
// });
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


// New Line Chart
$(document).ready(function(){
  google.charts.load('current', {
  packages: ['corechart', 'line']
});
google.charts.setOnLoadCallback(drawBackgroundColor);

function drawBackgroundColor() {
  var data = new google.visualization.DataTable();
  data.addColumn('number', 'X');
  data.addColumn('number', 'Dogs');

  data.addRows([
    [0, 0],
    [1, 10],
    [2, 23],
    [3, 17],
    [4, 18],
    [5, 9],
    [6, 11],
    [7, 27],
    [8, 33],
    [9, 40],
    [10, 32],
    [11, 35],
    [12, 30],
    [13, 40],
    [14, 42],
    [15, 47],
    [16, 44],
    [17, 48],
    [18, 52],
    [19, 54],
    [20, 42],
    [21, 55],
    [22, 56],
    [23, 57],
    [24, 60],
    [25, 50],
    [26, 52],
    [27, 51],
    [28, 49],
    [29, 53],
    [30, 55],
    [31, 60],
    [32, 61],
    [33, 59],
    [34, 62],
    [35, 65],
    [36, 62],
    [37, 58],
    [38, 55],
    [39, 61],
    [40, 64],
    [41, 65],
    [42, 63],
    [43, 66],
    [44, 67],
    [45, 69],
    [46, 69],
    [47, 70],
    [48, 72],
    [49, 68],
    [50, 66],
    [51, 65],
    [52, 67],
    [53, 70],
    [54, 71],
    [55, 72],
    [56, 73],
    [57, 75],
    [58, 70],
    [59, 68],
    [60, 64],
    [61, 60],
    [62, 65],
    [63, 67],
    [64, 68],
    [65, 69],
    [66, 70],
    [67, 72],
    [68, 75],
    [69, 80]
  ]);

  var options = {
    hAxis: {
      title: 'Time'
    },
    vAxis: {
      title: 'Popularity'
    },
    backgroundColor: '#fff'
  };

  var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
  chart.draw(data, options);
}
});

              </script>
</body>
</html>