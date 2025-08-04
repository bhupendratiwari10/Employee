
        <div class="row col-12 m-0 p-0">
            
            <div class="col-7 row" style=''>
                <div class='col-8'>
                    <h1 style='font-weight:700;'>Hello <l style='text-transform:capitalize;'><?php echo $_COOKIE["username"]; ?></l>!</h1>
                    <h4>Welcome to ZW's Dashboard !</h4> <br>
                    
                </div>
            </div>
    
            <div class='row col-12 m-0 p-0'>
                <div class='col-md-9 row m-0 p-0' style='box-shadow: 1px 11px 11px -6px #dbdbdb;border-radius: 8px;border: 1px solid #b2b2b24c;overflow:hidden;'>
                    <button class='col-md-3 col-6 jslink' data-href='dashboard.php' style='border-radius:0px;background:none;color:#000;border-top:3px solid #fff;'>
                        <i class='mi-currency-exchange' style='margin-right:8px;'></i>Financial Insight
                    </button>
                    <button class='col-md-3 col-6' style='border-radius:0px;background:none;color:green;border-top:3px solid green;'>
                        <i class='mi-eco' style='margin-right:8px;'></i>Green Insight
                    </button>
                </div>
                <div class='col-md-3'>
                    <input type='search' placeholder='Search anything here' style='width:93%;padding:8px 18px;border-radius:12px;border:1px solid #dbdbdb7c;box-shadow:5px 6px 8px -4px #c1c1c1;outline:none;'>
                    </div>
            </div>
            
            
            
            
            
            
            
            
            
            
    <?php $plasticQuery = generalQuery("SELECT id FROM `zw_pickup_categories` WHERE title LIKE 'Plastic%' or title LIKE 'plastic%'"); if(!empty($plasticQuery)){
            $categories = []; while($row = mysqli_fetch_assoc($plasticQuery)) { $categories[] = $row['id']; } } if (!empty($categories)) {
            $where = ' WHERE category IN (' . implode(', ', $categories) . ') and steps >= 8';} else { $where = '';}
            
            $totalWasteData = generalQuery("SELECT SUM(net_quantity) FROM `zw_pickups`" . $where); // print_r($totalWasteData);die;
            if(!empty($totalWasteData)){ $totalWaste = mysqli_fetch_assoc($totalWasteData); $totalWaste = $totalWaste['SUM(net_quantity)']; $totalWasteTon = $totalWaste / 1000; }else{
            $totalWaste = 0; } ?>
            
            
            <div class='row col-12 m-0 mt-2' style='font-size:75%;'>
                <div style='' class='col-md-7 m-0 p-0 row'>
                    <div class='col-md-12 my-3 pt-4 px-4 row' style='transform:scale(0.98);align-items: center;box-shadow: 1px 11px 11px -6px #dbdbdb;border-radius: 12px;border: 1px solid #b2b2b24c;overflow:hidden;'>
                          
                                <div class='d-block'><h2 class='m-0'><b>Plastic Prevented</b></h2><small style="color:gray;">From Entering the Environment</small></div>
                                <div class='col-12 row'>
                                    <div class="col-12" style="align-items:center;"><font style="font-size:576%;font-weight:800;margin-right: 11px;"><?php echo $totalWasteTon; ?></font><b>Tonnes</b></div>
                                    <div class='col-4' style="display: flex;flex-direction: column;justify-content: flex-end;"><b style='color:#57be87;font-size:176%'><i class='mi-arrow-up-circle-fill'></i> 15%</b></div><div class='col'></div>
                                    <div class='col-7'><div id='chart-5' class='col-12'></div>
                                </div>
                                </div>
                                
                    </div>
                </div>
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                <div style='' class='col-md-5 m-0 p-0 pt-3 py-3 row'>
                    <div class='px-3 pb-1 col-md-6 pt-4' style='transform:scale(0.97);box-shadow: 1px 11px 11px -6px #dbdbdb;border-radius: 12px;border: 1px solid #b2b2b24c;overflow:hidden;display: flex;flex-direction: column;justify-content: space-around;background:#fff;color:#000;'>
                        <div class='d-block'><h4 class='m-0'><b>EPR Pickups</b></h4><small style="color:gray;">Yet to be done this month</small></div>
                   <?php
// Get total quantity from zw_epr_po_items
$mq = mysqli_query(dbCon(), "
    SELECT SUM(quantity)/12 AS total 
    FROM `zw_epr_po_items` 
    WHERE MONTH(time_str) <= MONTH(NOW()) 
      AND YEAR(time_str) = YEAR(NOW())
");
$val = mysqli_fetch_assoc($mq);
$totalpord = $val['total'] ?? 0; // Default to 0 if null

// Get total net_quantity from zw_pickups
$mqq = mysqli_query(dbCon(), "
    SELECT SUM(net_quantity) AS total 
    FROM `zw_pickups` 
    WHERE MONTH(time_str) = MONTH(NOW()) 
      AND net_quantity != '' 
      AND YEAR(time_str) = YEAR(NOW())
");
$val2 = mysqli_fetch_assoc($mqq);
$totalpkup = $val2['total'] ?? 0; // Default to 0 if null

// Safely calculate percentage
if ($totalpord > 0) {
    $pkttl = round(($totalpkup / $totalpord) * 100);
} else {
    $pkttl = 0; // Avoid division by zero
}
?>

                    <div id='vcartX'></div>
                    
                    <script>
var options = {
  chart: {
    height: 220,
    type: "radialBar",
  },
  series: [<?php echo $pkttl; ?>],
  colors: ["#57be87"],
  plotOptions: {
    radialBar: {
      hollow: {
        margin: 15,
        size: "70%"
      },
      track: {
        background: '#c3c3c3'
      },
      dataLabels: {
        name: {
          show: false,
        },
        value: {
          fontSize: "30px",
          fontWeight: "630",
          color: "#57be87",
          show: true
        }
      }
    }
  },
  stroke: {
    lineCap: "butt"
  },
  labels: ["Progress"]
};

var chart = new ApexCharts(document.querySelector("#vcartX"), options);

chart.render();

                    </script>
                        
                        <center><p><small style="color:gray;"><?php echo round($totalpkup/1000,2); ?> Ton collected of <?php echo round($totalpord/1000,2); ?> Tons</small></p></center>
                    </div>
                    <div class='col-md-6 m-0 p-0' style='transform:scale(0.97);box-shadow: 1px 11px 11px -6px #dbdbdb;border-radius: 12px;border: 1px solid #b2b2b24c;overflow:hidden;'>
                        <button style='float:right;color:#000;background:none;font-size:251%;padding:0px;margin:0px 21px;'>...</button><br>
                        <div style="display:flex;flex-direction: column;align-items: center;width: 100%;">
                            <img src="<?php echo valByVal('username', $_COOKIE["username"], 'user_image', 'zw_user') ?>" class="col-8" style="aspect-ratio:1/1;object-fit:cover;border-radius:1001px;transform:scale(0.9);">
                            <h5 style='margin:0px 0px;'><l style="text-transform:capitalize;"><?php echo $_COOKIE["username"]; ?></l></h5>
                            <p style='margin:0px 0px;color:gray;'><small>CTO - Tidy Rabbit</small></p><br>
                        </div>
                        <div style='background:#000;padding:21px 11px;'></div>
                    </div>
                    </div>
                 </div>   
                 
                 
                    
            <div class='row col-12 m-0 mt-2' style='font-size:75%;'>
                
                <div class='col-7 row m-0 p-0 row'>
                    <div class='m-0 px-3 pt-2 pb-0 mb-2 col-md-5' style='transform:scale(0.95);box-shadow: 1px 11px 11px -6px #dbdbdb;border-radius: 12px;border: 1px solid #b2b2b24c;overflow:hidden;display: flex;flex-direction: column;justify-content: space-around;'>
                        <div class='d-block'><h5 class='m-0'><b>Sustainibility Vanguard</b></h5></div>
                        <div class='col-12 m-0 pt-0 pb-3 row'>
                            <center>
                                <img src='assets/img/aaa.png' class='col-6 pb-2'><br>
                                <b>Godrage Agro Products</b><br>
                                <small>Revenue 1,22,222 INR</small>
                            </center>
                        </div>
                    </div>
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    <?php $ulbWaste = generalQuery("SELECT (SUM(monthly_waste)/1000)*3000 as total FROM `zw_ulb`"); $totalUlbWasteWorker = 0; if(!empty($ulbWaste)){ 
                        $row = mysqli_fetch_assoc($ulbWaste) ; $totalUlbWasteWorker = $row['total']; } ?>
                    
                    <div class='col-md-7 mb-2 p-0 px-3 pt-4' style='transform:scale(0.95);align-items: center;box-shadow: 1px 11px 11px -6px #dbdbdb;border-radius: 12px;border: 1px solid #b2b2b24c;overflow:hidden;'>
                                
                                <div class='d-block'><h5 style='font-weight:800;' class='m-0'>Waste Workers Professionalised</h6><small style="color:gray;">For enhanced & dignified livelihood</small></div><br>
                                <div class='d-flex'><h1><?php echo round($totalUlbWasteWorker); ?> +</h1><b></b></div>
                                <div class='col-12 row'>
                                    <div class='col-4' style="display: flex;flex-direction: column;justify-content: flex-end;"><b style='color:#57be87;font-size:176%'>
                                          <i class='mi-arrow-up-circle-fill'></i> 27%%</b></div>
                                    <div class='col'></div>
                                    <div class='col-7'><div id='chart-6' class='col-12'></div>
                                </div>
                                </div>
            
                    </div>
                    
                    
                    
                    
                    
                </div>
                
                
                
                
                
                
                
                
                
                <div class='col-md-5 row m-0 p-0'>
                    <div class='col-md-4 row mt-2 mb-3'>
                        <button class='col-md-12 col-6' style='aspect-ratio:1/1;transform:scale(0.95);border-radius:11px;background:#57be87d9;'><k style='display:block;font-size:501%;padding:11px;aspect-ratio:1/1;border-radius:111px;border:3px dotted #fff;transform:scale(0.69);'>+</k></button>
                        <button class='col-md-12 col-6' style='aspect-ratio:1/1;transform:scale(0.95);border-radius:11px;background:orange;'><k style='display:block;font-size:501%;padding:11px;aspect-ratio:1/1;border-radius:111px;border:3px dotted #fff;transform:scale(0.69);'>+</k></button>
                    </div>
                    
                 <div class='col-md-8'>
                    <div class='px-3 py-3 m-0 mt-2 col-md-12' style='box-shadow: 1px 11px 11px -6px #dbdbdb;border-radius: 12px;border: 1px solid #b2b2b24c;overflow:hidden;display: flex;flex-direction: column;justify-content: space-around;'>
                        <div class='d-block'><h5><b>Account Watchlist</b></h5></div><br>
                            
                    <?php $aaq = "SELECT * FROM `zw_accounts` WHERE closing_balance!='' LIMIT 6"; $bbq = mysqli_query(dbCon(),$aaq); while($ccq = mysqli_fetch_assoc($bbq)){?>
                        <k style='' class='mfb my-2'><b style='float:right;'><?php echo $ccq['closing_balance']; ?> ₹</b><small><?php echo $ccq['account_name']; ?></small> </k>
                        <hr style='margin:0px 0px;'>
                    <?php } ?>
                        </div>
                    </div>
                </div>


            
            </div>
        </div> 
        
        <div class='col-md-12 row m-0 p-0'>
            <div class='col-md-8 row'>
                <div class='col-12 mb-2' style='box-shadow: 1px 11px 11px -6px #dbdbdb;border-radius: 12px;border: 1px solid #b2b2b24c;overflow:hidden;display: flex;flex-direction: column;justify-content: space-around;transform:scale(0.95);'><br><h3 class='m-0'>EPR Pickup Consolitted</h3><p><small>Target vs Achievement</small></p><br>
                     <div id="cashflow" style="" class="m-0 p-0 col-12"></div>
                </div>
                
                <div class='col-12 m-0 p-0 row'>
                    <div class='col-md-8 pt-3 pb-2' style='box-shadow: 1px 11px 11px -6px #dbdbdb;border-radius: 12px;border: 1px solid #b2b2b24c;overflow:hidden;display: flex;flex-direction: column;justify-content: space-around;transform:scale(0.95);'>
                        <h5 class='m-0'>Ecomap</h5> <small>EPR Pickups</small>
                         <div id="ecomap" style="" class="m-0 p-0 col-12"></div>
                    </div>
                    <div class='col-md-4 pt-3 pb-2' style='box-shadow: 1px 11px 11px -6px #dbdbdb;border-radius: 12px;border: 1px solid #b2b2b24c;overflow:hidden;display: flex;flex-direction: column;justify-content: space-around;transform:scale(0.95);'>
                        <h5 class='m-0'>Heatmap</h5> <small>EPR Pickups</small><br>
                        <?php
                        
                                $n = 1; 
                                $currentDate = date("d-m-Y"); // Today's Date
                                $c1='orange'; $c2='#00FF00'; $c3='#000000'; echo"<div style='' class='col-12 m-0 p-0'>";
                                while(30>$n){
                                    echo"<button style='aspect-ratio:1/1;padding: 14px;margin: 1px;border-radius:8px;width:11px;border:1px solid #999;' title='$n' class='lolip'></button>";  
                                    $n++; 
                                } echo"</div>";
                                
                                
                            
                            ?>
                        
                    </div>
                </div>    
            </div>
            <div class='col-md-4'>
                <div class='col-12 px-4 py-4 mb-4' style='box-shadow: 1px 11px 11px -6px #dbdbdb;border-radius: 12px;border: 1px solid #b2b2b24c;overflow:hidden;display: flex;flex-direction: column;justify-content: space-around;'>
                    <h4 class='m-0'>EPR Pickups</h4><p><small>Target vs Audience</small></p><br>
                    <div id="cartNg" style="" class="m-0 p-0 col-12"></div><br><br>
                    <div id="cartNgl" style="" class="m-0 p-0 col-12"></div><br>
                </div>
            </div>
        </div>
    
    
    
    
    <script>
    options = {
        chart: {
          height: 176,
          type: "treemap",
        },
        series: [
          {
            data: [
              {
                x: "New Delhi",
                y: 218,
              },
              {
                x: "Kolkata",
                y: 149,
              },
              {
                x: "Mumbai",
                y: 184,
              },
              {
                x: "Lucknow",
                y: 105,
              },
              {
                x: "Ahmedabad",
                y: 255,
              },
              {
                x: "Bangaluru",
                y: 84,
              },
              {
                x: "Pune",
                y: 31,
              },
              {
                x: "Chennai",
                y: 70,
              }
            ],
          },
        ]
      }
      var charti5 = new ApexCharts(document.querySelector("#ecomap"), options);
        charti5.render();
    
    
        
        var options5 = {
          series: [{
          data: [25, 66, 41, 89, 63, 66, 41, 89, 63, 66, 41, 89]
        }],
          chart: {
          height: "111",
          type: 'bar',
          sparkline: {
            enabled: true
          }
        },
        plotOptions: {
          bar: {
            columnWidth: '80%'
          }
        },
        labels: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
        fill: {
             colors: ['#57be87', '#E91E63', '#9C27B0']
        },xaxis: {
          crosshairs: {
            width: 1
          },
        },
        tooltip: {
          fixed: {
            enabled: false
          },
          x: {
            show: false
          },
          y: {
            title: {
              formatter: function (seriesName) {
                return ''
              }
            }
          },
          marker: {
            show: false
          }
        }
        };

        var chart5 = new ApexCharts(document.querySelector("#chart-5"), options5);
        chart5.render();
        
        var options6 = {
           series: [{
          data: [25, 66, 41, 89, 63, 66, 41, 89, 63, 66, 41, 89]
        }],
          chart: {
          height: "121",
          type: 'bar',
          sparkline: {
            enabled: true
          }
        },
        plotOptions: {
          bar: {
            columnWidth: '80%'
          }
        },
        labels: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
        fill: {
          colors: ["#ffa500"]
        },xaxis: {
          crosshairs: {
            width: 1
          },
        },
        tooltip: {
          fixed: {
            enabled: false
          },
          x: {
            show: false
          },
          y: {
            title: {
              formatter: function (seriesName) {
                return ''
              }
            }
          },
          marker: {
            show: false
          }
        }
        };

        var chart6 = new ApexCharts(document.querySelector("#chart-6"), options6);
        chart6.render();
        
    </script>
    <script>
               
    </script>
    
    <script>
         var options = {
          series: [
          {
            name: 'Actual',
            data: [
              {
                x: '2011',
                y: 1292,
                goals: [
                  {
                    name: 'Expected',
                    value: 1400,
                    strokeHeight: 5,
                    strokeColor: '#ffa500'
                  }
                ]
              },
              {
                x: '2012',
                y: 4432,
                goals: [
                  {
                    name: 'Expected',
                    value: 5400,
                    strokeHeight: 5,
                    strokeColor: '#ffa500'
                  }
                ]
              },
              {
                x: '2013',
                y: 5423,
                goals: [
                  {
                    name: 'Expected',
                    value: 5200,
                    strokeHeight: 5,
                    strokeColor: '#ffa500'
                  }
                ]
              },
              {
                x: '2014',
                y: 6653,
                goals: [
                  {
                    name: 'Expected',
                    value: 6500,
                    strokeHeight: 5,
                    strokeColor: '#ffa500'
                  }
                ]
              },
              {
                x: '2015',
                y: 8133,
                goals: [
                  {
                    name: 'Expected',
                    value: 6600,
                    strokeHeight: 13,
                    strokeWidth: 0,
                    strokeLineCap: 'round',
                    strokeColor: '#ffa500'
                  }
                ]
              },
              {
                x: '2016',
                y: 7132,
                goals: [
                  {
                    name: 'Expected',
                    value: 7500,
                    strokeHeight: 5,
                    strokeColor: '#ffa500'
                  }
                ]
              },
              {
                x: '2017',
                y: 7332,
                goals: [
                  {
                    name: 'Expected',
                    value: 8700,
                    strokeHeight: 5,
                    strokeColor: '#ffa500'
                  }
                ]
              },
              {
                x: '2018',
                y: 6553,
                goals: [
                  {
                    name: 'Expected',
                    value: 7300,
                    strokeHeight: 2,
                    strokeDashArray: 2,
                    strokeColor: '#ffa500'
                  }
                ]
              }
            ]
          }
        ],
          chart: {
          height: 350,
          type: 'bar'
        },
        plotOptions: {
          bar: {
            columnWidth: '60%'
          }
        },
        colors: ['#00E396'],
        dataLabels: {
          enabled: false
        },
        legend: {
          show: true,
          showForSingleSeries: true,
          customLegendItems: ['Actual', 'Expected'],
          markers: {
            fillColors: ['#00E396', '#775DD0']
          }
        }
        };

        var chart = new ApexCharts(document.querySelector("#cashflow"), options);
        chart.render();
        
        
        
        
        
        
        
        
        
         var optionsx = {
          series: [
          {
            name: 'Actual',
            data: [
              {
                x: '2011',
                y: 1292,
                goals: [
                  {
                    name: 'Expected',
                    value: 1400,
                    strokeHeight: 5,
                    strokeColor: '#57be87'
                  }
                ]
              },
              {
                x: '2012',
                y: 4432,
                goals: [
                  {
                    name: 'Expected',
                    value: 5400,
                    strokeHeight: 5,
                    strokeColor: '#57be87'
                  }
                ]
              },
              {
                x: '2013',
                y: 5423,
                goals: [
                  {
                    name: 'Expected',
                    value: 5200,
                    strokeHeight: 5,
                    strokeColor: '#57be87'
                  }
                ]
              },
              {
                x: '2014',
                y: 6653,
                goals: [
                  {
                    name: 'Expected',
                    value: 6500,
                    strokeHeight: 5,
                    strokeColor: '#57be87'
                  }
                ]
              },
              {
                x: '2015',
                y: 8133,
                goals: [
                  {
                    name: 'Expected',
                    value: 6600,
                    strokeHeight: 13,
                    strokeWidth: 0,
                    strokeLineCap: 'round',
                    strokeColor: '#57be87'
                  }
                ]
              },
              {
                x: '2016',
                y: 7132,
                goals: [
                  {
                    name: 'Expected',
                    value: 7500,
                    strokeHeight: 5,
                    strokeColor: '#57be87'
                  }
                ]
              },
              {
                x: '2017',
                y: 7332,
                goals: [
                  {
                    name: 'Expected',
                    value: 8700,
                    strokeHeight: 5,
                    strokeColor: '#57be87'
                  }
                ]
              },
              {
                x: '2018',
                y: 6553,
                goals: [
                  {
                    name: 'Expected',
                    value: 7300,
                    strokeHeight: 2,
                    strokeDashArray: 2,
                    strokeColor: '#57be87'
                  }
                ]
              }
            ]
          }
        ],
          chart: {
          height: 201,
          type: 'bar'
        },
        plotOptions: {
          bar: {
            columnWidth: '75%'
          }
        },
        colors: ["#ffa500"],
        dataLabels: {
          enabled: false
        }
        };

        var chart = new ApexCharts(document.querySelector("#cartNgl"), optionsx);
        chart.render();

        </script>
        <script>
                var options1 = {
  chart: {
    height: 280,
    type: "radialBar",
  },
  series: [66, 74, 47, 65],
  plotOptions: {
    radialBar: {
      dataLabels: {
        name: {
          show: false,
        },total: {
          show: true
        }, value: {
          fontSize: "30px",
          fontWeight: "630",
          color: "#57be87",
          show: true
        }
      }
    }
  },
  labels: ['TEAM A', 'TEAM B', 'TEAM C', 'TEAM D']
};

new ApexCharts(document.querySelector("#cartNg"), options1).render();
            
        </script>