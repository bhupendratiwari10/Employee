
        <div class="row col-12 m-0 p-0">
            
            <div class="col-lg-7 row" style=''>
                <div class='col-lg-8'>
                    <h1 style='font-weight:700;'>Hello <l style='text-transform:capitalize;'><?php echo $_COOKIE["username"]; ?></l>!</h1>
                    <h4>Welcome to ZW's Dashboard !</h4> <br>
                    
                </div>
            </div>
    
            <div class='row col-12 m-0 p-0'>
                <div class='col-md-9 row m-0 mb-3 p-0' style='transform:scale(0.98);box-shadow: 1px 11px 11px -6px #dbdbdb;border-radius: 8px;border: 1px solid #b2b2b24c;overflow:hidden;'>
                    <button class='col-md-3 col-6' style='border-radius:0px;background:none;color:green;border-top:3px solid green;'>
                        <i class='mi-currency-exchange' style='margin-right:8px;'></i>Financial Insight
                    </button>
                    <button class='col-md-3 col-6 jslink' data-href='dashboardy.php'  style='border-radius:0px;background:none;color:#000;border-top:3px solid #fff;'>
                        <i class='mi-eco' style='margin-right:8px;'></i>Green Insight
                    </button>
                </div>
                <div class='col-md-3 m-0 p-0'>
                    <input type='search' placeholder='Search anything here' style='transform:scale(0.96);width:100%;padding:8px 18px;border-radius:12px;border:1px solid #dbdbdb7c;box-shadow:5px 6px 8px -4px #c1c1c1;outline:none;'>
                    </div>
            </div>
            
            
            
            
            
            
            
            
            
            
            
            
            
            <div class='row col-12 m-0 mt-2' style='font-size:75%;'>
                <div style='' class='col-md-6 m-0 p-0 row'>
                    <div class='col-md-12 my-3 p-0 row' style='align-items: center;box-shadow: 1px 11px 11px -6px #dbdbdb;border-radius: 12px;border: 1px solid #b2b2b24c;overflow:hidden;'>
                        <div class='col-md-8 px-4 py-2' style='border-right:1px solid #dbdbdb;'>
                            <h5><b>Total Recievables</b></h5> <?php 
                            
                            $today = date('Y')."-".date('m')."-".date('d'); $tdue = 0; $tdone = 0 ;
                            $totalBalanceQuery = generalQuery("SELECT due_date, subTotal FROM `zw_invoices`"); if(!empty($totalBalanceQuery)){
                            while($row = mysqli_fetch_assoc($totalBalanceQuery)){ $newbal = $row['subTotal'];
                                if($row['due_date']>$today){$tdone = $tdone+$newbal;}else{$tdue = $tdue+$newbal;}
                            }} $totalinvoice = $tdone+$tdue; if(!empty($totalinvoice)){$inwper = $tdone/$totalinvoice; $inwper = $inwper*100;}  ?>

                            <div class='col-12 p-0 m-0 mt-3 mb-2' style='border-radius:5px;overflow:hidden;background:#e0e0e0;'><div style='width:<?php echo $inwper; ?>%;background:#ffc43b;padding:4px;'></div></div>
                            <p><small><b>Total Unpaid Invoices</b></small></p>
                        </div>
                        <div class='col-md-4 my-4 toing' style='text-align:center;'>
                            <h6><small style='font-size:69%;'>CURRENT</small> <b><?php echo $tdone; ?> ₹</b></h6><hr style='border-color:#777;'>
                            <h6><small style='font-size:69%;'>OVERDUE</small> <b><?php echo $tdue; ?> ₹</b></h6>
                        </div>
                    </div>
                    
                    <div class='col-md-12 mb-3 p-0 row' style='align-items: center;box-shadow: 1px 11px 11px -6px #dbdbdb;border-radius: 12px;border: 1px solid #b2b2b24c;overflow:hidden;'>
                        <div class='col-md-8 px-4 py-2' style='border-right:1px solid #dbdbdb;'>
                            <h5><b>Total Payables</b></h5> <?php $today = date('Y-m-d'); $ttdue = 0; $ttdone = 0; 
                            $totalBalanceQuery = generalQuery("SELECT due_date, subTotal FROM `zw_Bill`");  if(!empty($totalBalanceQuery)) {
                                while($row = mysqli_fetch_assoc($totalBalanceQuery)) { $newbal = $row['subTotal']; 
                                if($row['due_date'] > $today) { $ttdone += $newbal; } else { $ttdue += $newbal;} } } 
                                $totalbills = $ttdone + $ttdue;  if(!empty($totalbills)) { $blwper = ($ttdone / $totalbills) * 100;}
?>

                            <div class='col-12 p-0 m-0 mt-3 mb-2' style='border-radius:5px;overflow:hidden;background:#e0e0e0;'><div style='width:<?php echo $blwper; ?>%;background:#ffc43b;padding:4px;'></div></div>
                            <p><small><b>Total Unpaid Bills</b></small></p>
                        </div>
                        <div class='col-md-4 my-4 toing' style='text-align:center;'>
                            <h6><small style='font-size:69%;'>CURRENT</small> <b><?php echo $ttdone; ?> ₹</b></h6><hr style='border-color:#777;'>
                            <h6><small style='font-size:69%;'>OVERDUE</small> <b><?php echo $ttdue; ?> ₹</b></h6>
                        </div>
                    </div>
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    <div class='col-12 py-4 mb-3 row' style='align-items: center;box-shadow: 1px 11px 11px -6px #dbdbdb;border-radius: 12px;border: 1px solid #b2b2b24c;overflow:hidden;'>
                        <br><br><h4><b class='px-3'>Income vs Expenses</b></h4><br>
                        <div id="Leguchart" style="" class="col-12"></div>
                    </div> <?php  $q = "SELECT SUM(amount) AS amount, DATE(date) AS expense_date FROM `zw_expense` GROUP BY MONTH(date) LIMIT 6"; $q2 = mysqli_query(dbcon(), $q); 
                    $p = "SELECT SUM(subTotal) AS amount, DATE(invoice_date) AS invoice_date FROM `zw_invoices` GROUP BY MONTH(invoice_date) LIMIT 6"; $p2 = mysqli_query(dbcon(), $p); ?>
                    <script> var expenseCategories = [];var expenseData = [];var incomeData = []; <?php while($c = mysqli_fetch_assoc($q2)) { ?> expenseCategories.push('<?php echo date('M - Y', strtotime($c['expense_date'])); ?>'); expenseData.push(<?php echo $c['amount']; ?>); <?php } ?> <?php while($dc = mysqli_fetch_assoc($p2)) { ?> incomeData.push(<?php echo $dc['amount']; ?>); <?php } ?>
                    
                    var options = { animations: { enabled: true, easing: 'easeinout', speed: 800, animateGradually: { enabled: true,  delay: 150 },
                    dynamicAnimation: { enabled: true, speed: 350 } }, chart: { height: "250", type: 'bar' }, xaxis: { categories: expenseCategories },
                    series: [ { name: "Income", color: '#ffa500', data: incomeData }, { name: "Expense", color: '#57be87', data: expenseData }]};
                    var chart = new ApexCharts(document.querySelector("#Leguchart"), options); chart.render(); </script>
 
                    </div>
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                <div style='' class='col-md-6 m-0 p-0 py-2 row'>
                    
                    <div class='col-6 m-0 px-3' style='transform:scale(0.95);box-shadow: 1px 11px 11px -6px #dbdbdb;border-radius: 12px;border: 1px solid #b2b2b24c;overflow:hidden;'>
                        <br><h5><b>Top Expenses</b></h5><br>
                        <div id="donutchart" style="" class="m-0 p-0 col-12"></div>
                    </div> <?php  $q = "SELECT * FROM `zw_accounts` WHERE account_type='17' ORDER BY closing_balance DESC LIMIT 5"; $qk = mysqli_query(dbCon(), $q);  ?>
                    <script> var closingBalances = []; var accountNames = []; <?php while($kl = mysqli_fetch_assoc($qk)) { ?> closingBalances.push(<?php echo $kl['closing_balance']; ?>);
                    accountNames.push('<?php echo $kl['account_name']; ?>'); <?php } ?> var options = { animations: { enabled: true, easing: 'easeinout',  speed: 800, 
                    animateGradually: { enabled: true, delay: 150 }, dynamicAnimation: { enabled: true, speed: 350 }  }, 
                    chart: { type: 'donut' }, dataLabels: { enabled: false }, legend: { show: false }, series: closingBalances, labels: accountNames };
                    var chart = new ApexCharts(document.querySelector("#donutchart"), options); chart.render(); </script>

                    
                    
                    
                    
                    <div class='col-6 m-0 p-0' style='transform:scale(0.95);box-shadow: 1px 11px 11px -6px #dbdbdb;border-radius: 12px;border: 1px solid #b2b2b24c;overflow:hidden;'>
                        <button style='float:right;color:#000;background:none;font-size:251%;padding:0px;margin:0px 21px;'>...</button><br>
                        <div style="display:flex;flex-direction: column;align-items: center;width: 100%;">
                            <img src="<?php echo valByVal('username', $_COOKIE["username"], 'user_image', 'zw_user') ?>" class="col-7" style="aspect-ratio:1/1;object-fit:cover;border-radius:1001px;transform:scale(0.9);">
                            <h5 style='margin:0px 0px;'><l style="text-transform:capitalize;"><?php echo $_COOKIE["username"]; ?></l></h5>
                            <p style='margin:0px 0px;color:gray;'><small>CTO - Tiddy Rabbit</small></p><br>
                        </div>
                        <div style='background:#000;padding:18px 11px;'></div>
                    </div>
                    
                    
                    
                    
                    
                    
                
                
                
                
            <?php 
            
            $getIncomeAccountType = generalQuery("SELECT id FROM `zw_account_types` WHERE title LIKE '%Income%' or title LIKE '%income%'");if(mysqli_num_rows($getIncomeAccountType) > 0){
            $tempArrayIncome = [];while($row = mysqli_fetch_assoc($getIncomeAccountType)){$tempArrayIncome[] = $row['id'];}$idsStringIncome = implode(',' , $tempArrayIncome);
            $totalBalanceQuery = generalQuery("SELECT SUM(closing_balance) as closing_balance  FROM `zw_accounts` WHERE account_type IN($idsStringIncome)");
            if(!empty($totalBalanceQuery)){while($row = mysqli_fetch_assoc($totalBalanceQuery)){$closingBalanceIncome = $row['closing_balance'];}}}   ?>

    
                    
                    
                    
                    
                <div class='col-md-12 m-0 p-0 py-2 row' style=''>
                    <div class='px-3 mx-0 mb-2 pt-4 pb-0 col-md-6' style='transform:scale(0.95);box-shadow: 1px 11px 11px -6px #dbdbdb;border-radius: 12px;border: 1px solid #b2b2b24c;overflow:hidden;display: flex;flex-direction: column;justify-content: space-around;aspect-ratio: 1 / 0.56;'>
                        <div class='d-block'><h5><b>Revenue</b></h5>
                        <h3 style='font-weight:800;'><?php echo $closingBalanceIncome; ?> ₹</h3></div>
                        <div class='col-12 m-0 p-0 row'>
                            <div class='col-5' style="display: flex;flex-direction: column;justify-content: flex-end;"><b style='color:#57be87;'><i class='mi-arrow-up-circle-fill'></i> 15%</b></div><div class='col'></div>
                            <div class='col-5'><div id='chart-5' class='col-12'></div></div>
                        </div>
                    </div>
                    <div class='px-3 mb-2 pt-4 col-md-6' style="transform:scale(0.95);background:url('assets/img/debit.png');background-size: cover;border-radius: 12px;overflow:hidden;padding-bottom:101px;aspect-ratio: 1 / 0.65;"> <?php $ds = mysqli_query(dbCon(),"SELECT SUM(closing_balance) as closing_balance FROM `zw_accounts` WHERE account_type IN(SELECT id FROM zw_account_types WHERE title='BANK');"); $ksd = mysqli_fetch_assoc($ds); $bankbal = $ksd['closing_balance']; ?> 
                    <b style='display:block;color:#fff;font-size:201%;margin-top:25px!important;margin-left:76px;'>₹ <?php echo $bankbal; ?></b>
                    </div>
                </div>
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                    

                <div class='col-md-12 p-0 m-0 row' style=''>
                    
                    <div class='px-3 pt-4 pb-0 col-md-6' style='transform:scale(0.95);box-shadow: 1px 11px 11px -6px #dbdbdb;border-radius: 12px;border: 1px solid #b2b2b24c;overflow:hidden;display: flex;flex-direction: column;justify-content: space-around;aspect-ratio: 1 / 0.63;'>
                        <div class='d-block'><h5><b>Expenses</b></h5>
                        <?php $expq = mysqli_query(dbCon(),"SELECT sum(amount) as amount FROM zw_expense"); $rxxow = mysqli_fetch_assoc($expq);$extbal = $rxxow['amount'];  ?>
                        <h3 style='font-weight:800;'><?php echo $extbal;?> ₹</h3></div>
                        <div class='col-12 m-0 p-0 row'>
                            <div class='col-5' style="display: flex;flex-direction: column;justify-content: flex-end;"><b style='color:orange;'><i class='mi-arrow-up-circle-fill'></i> 15%</b></div><div class='col'></div>
                            <div class='col-5'><div id='chart-6' class='col-12'></div></div>
                        </div>
                    </div>
                    
                    <div class='px-3 pt-4 m-0 pb-0 col-md-6' style='transform:scale(0.95);box-shadow: 1px 11px 11px -6px #dbdbdb;border-radius: 12px;border: 1px solid #b2b2b24c;overflow:hidden;display: flex;flex-direction: column;justify-content: space-around;'>
                        <div class='d-block'><h5><b>Profit</b></h5>
                        <h3 style='font-weight:800;'><?php echo $closingBalanceIncome-$extbal; ?> ₹</h3></div>
                        <div class='col-12 m-0 p-0 row'>
                            <div class='col-5' style="display: flex;flex-direction: column;justify-content: flex-end;"><b style='color:#57be87;'><i class='mi-arrow-up-circle-fill'></i> 15%</b></div><div class='col'></div>
                            <div class='col-5'><div id='chart-7' class='col-12'></div></div>
                        </div>
                    </div>
                </div>
                    
                </div>
            </div>
            
            
            
            
            
            
            
            
            
            
            
            
            
            
          
            <div class='col-md-3 m-0 p-0 my-2  row' style=''>
                <div class='px-3 pt-4 pb-0 mb-3 col-md-12' style='box-shadow: 1px 11px 11px -6px #dbdbdb;border-radius: 12px;border: 1px solid #b2b2b24c;overflow:hidden;display: flex;flex-direction: column;justify-content: space-around;'>
                    <div class='d-block'><h5><b>Customers</b></h5>
                    <h3 style='font-weight:800;'><?php echo countRows('zw_customers'); ?> +</h3></div>
                    <div class='col-12 m-0 p-0 row'>
                            <div class='col-5' style="display: flex;flex-direction: column;justify-content: flex-end;"><b style='color:#57be87;'><i class='mi-arrow-up-circle-fill'></i> 15%</b></div><div class='col'></div>
                            <div class='col-5'><div id='chart-8' class='col-12'></div></div>
                    </div>
                </div>
                <div class='px-3 pt-4 pb-0 mb-2 col-md-12' style='box-shadow: 1px 11px 11px -6px #dbdbdb;border-radius: 12px;border: 1px solid #b2b2b24c;overflow:hidden;display: flex;flex-direction: column;justify-content: space-around;'>
                    <div class='d-block'><h5><b>Top Customers</b></h5></div>
                    <div class='col-12 m-0 pt-2 pb-3 row'>
                        <center><?php $aaq = "SELECT * FROM `zw_customers` ORDER BY `total_revenue` DESC LIMIT 1"; $bbq = mysqli_query(dbCon(),$aaq); $ccq = mysqli_fetch_assoc($bbq);?> 
                            <img src='<?php echo $ccq['profile_pic']; ?>' class='col-6'><br>
                            <b><?php echo $ccq['company_name']; ?></b><br>
                            <small>Revenue <?php echo $ccq['total_revenue']; $con = dbCon(); ?> INR</small>
                        </center>
                    </div>
                </div>
            </div>
            
            
            
            
            <div class='col-md-6 mb-2 my-0 mx-0 py-4 row' style='transform:scale(0.95);align-items: center;box-shadow: 1px 11px 11px -6px #dbdbdb;border-radius: 12px;border: 1px solid #b2b2b24c;overflow:hidden;'>
                <br><br><h4><b class='px-3'>Cash Flow</b></h4><br>
                <div id="cashflow" style="" class="m-0 p-0 col-12"></div>
                
                
                <?php
// Assuming `mysqli` connection is established elsewhere

$qcf = "SELECT
  SUM(CASE WHEN payment_type = 'received' AND deposited_to IN (SELECT id FROM zw_accounts WHERE account_type = '3' OR account_type = '4') THEN payment_made ELSE 0 END) AS payments_received,
  SUM(CASE WHEN payment_type = 'made' AND paid_through IN (SELECT id FROM zw_accounts WHERE account_type = '3' OR account_type = '4') THEN payment_made ELSE 0 END) AS payments_made,
  SUM(CASE WHEN paid_throw IN (SELECT id FROM zw_accounts WHERE account_type = '3' OR account_type = '4') THEN amount ELSE 0 END) AS expenses,
  SUM(CASE WHEN account_id IN (SELECT id FROM zw_accounts WHERE account_type = '3' OR account_type = '4') THEN debit END) AS journal_debit,
  SUM(CASE WHEN account_id IN (SELECT id FROM zw_accounts WHERE account_type = '3' OR account_type = '4') THEN credit END) AS journal_credit,
  MONTH(payment_date) AS month,
  YEAR(payment_date) AS year
FROM `zw_payment_made`
  LEFT JOIN `zw_expense` ON MONTH(payment_date) = MONTH(date)
  LEFT JOIN `zw_journal_items` ON MONTH(payment_date) = MONTH(date)
WHERE YEAR(payment_date) = $currentYear AND MONTH(payment_date) <= $currentMonth
GROUP BY YEAR(payment_date), MONTH(payment_date)
ORDER BY YEAR(payment_date) DESC, MONTH(payment_date) DESC
LIMIT 12";


$result = mysqli_query($con, $qcf);

$seriesData = [];
$months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

// Initialize all months with 0
for ($i = 0; $i < 12; $i++) {
  $seriesData[$i] = [
    'payments_received' => 0,
    'payments_made' => 0,
    'expenses' => 0,
    'journal_net' => 0,
  ];
}

while ($row = mysqli_fetch_assoc($result)) {
  $month = intval($row['month']) - 1;
  $seriesData[$month] = [
    'payments_received' => $seriesData[$month]['payments_received'] + floatval($row['payments_received']),
    'payments_made' => $seriesData[$month]['payments_made'] + floatval($row['payments_made']),
    'expenses' => $seriesData[$month]['expenses'] + floatval($row['expenses']),
    'journal_net' => $seriesData[$month]['journal_net'] + floatval($row['journal_net']),
  ];
}

// Calculate cash flow for each month
for ($i = 0; $i < 12; $i++) {
  $seriesData[$i]['cashflow'] = $seriesData[$i]['payments_received'] - 
                                 ($seriesData[$i]['payments_made'] + abs($seriesData[$i]['journal_net']) + $seriesData[$i]['expenses']);
}
?>
<script>
  var options = {
    chart: {
      height: 280,
      type: "area"
    },
    dataLabels: {
      enabled: false
    },
    series: [{
      name: "Cash Flow",
      data: <?php echo json_encode(array_column($seriesData, 'cashflow')); ?>
    }],
    fill: {
      type: "gradient",
      gradient: {
        shadeIntensity: 1,
        opacityFrom: 0.7,
        opacityTo: 0.9,
        stops: [0, 90, 100]
      }
    },
    xaxis: {
      categories: <?php echo json_encode($months); ?>
    }
  };

  var chart = new ApexCharts(document.querySelector("#cashflow"), options);
  chart.render();
</script>




            <div class='row col-12 m-0 p-0'>
                <div class='col'><small style='font-size:51%;font-weight:600;'>Cash on 01 March 2023</small><br><b style='font-size:111%;'> ₹ 10,000</b></div> 
                <div class='col'><small style='font-size:76%;font-weight:600;color:green;'>Incoming</small><br><b style='font-size:111%;'> ₹ 10,000</b></div>
                <div class='col'><small style='font-size:76%;font-weight:600;color:orange;'>Outgoing</small><br><b style='font-size:111%;'> ₹ 10,000</b></div>
                <div class='col'><small style='font-size:76%;font-weight:600;color:gray;'>Cash as of today</small><br><b style='font-size:111%;'> ₹ 10,000</b></div>
            </div>
            </div>
            
            <div class='col-md-3 p-0 row mm-0' style=''>
                <div class='px-3 pt-4 pb-3 col-md-12' style='transform:scale(0.9);box-shadow: 1px 11px 11px -6px #dbdbdb;border-radius: 12px;border: 1px solid #b2b2b24c;overflow:hidden;display: flex;flex-direction: column;justify-content: space-around;'>
                    <div class='d-block'><h5><b>Banks</b></h5></div>
                    <?php $aaq = "SELECT * FROM `zw_accounts` WHERE account_type='4' LIMIT 2"; $bbq = mysqli_query(dbCon(),$aaq); while($ccq = mysqli_fetch_assoc($bbq)){?>
                        <div class='col-12 m-0 p-0 row'>
                            <div style='' class='col-3'><img src='<?php echo $ccq['profile_pic']; ?>' class="col-12"></div>
                            <div style='' class='col-6'><small><?php echo $ccq['account_name']; ?></small><br><B><?php echo $ccq['closing_balance']; ?> ₹</B></div>
                            <div style='' class='col-3'><h3 class='mi-link'></h3></div>
                        </div><hr style='margin:0px 0px;'>
                    <?php } ?>
                            
                </div>
                <div class='px-3 pt-4 pb-0 mb-2 col-md-12' style='transform:scale(0.9);box-shadow: 1px 11px 11px -6px #dbdbdb;border-radius: 12px;border: 1px solid #b2b2b24c;overflow:hidden;display: flex;flex-direction: column;justify-content: space-around;'>
                    <div class='d-block'><h5><b>Account Watchlist</b></h5></div>
                
                    
                    <?php $aaq = "SELECT * FROM `zw_accounts` WHERE closing_balance!='' LIMIT 4"; $bbq = mysqli_query(dbCon(),$aaq); while($ccq = mysqli_fetch_assoc($bbq)){?>
                        <k style='font-size:69%;' class='mfb my-2'><b style='float:right;'><?php echo $ccq['closing_balance']; ?> ₹</b><small><?php echo $ccq['account_name']; ?></small> </k>
                        <hr style='margin:0px 0px;'>
                    <?php } ?>
                        
                </div>
            </div>
            
            
            
            
            
            
            
            
            
            
            
            
            
        <div class='col-12 m-0 p-0 row'>     
        
            <div class='col-md-3 m-0 p-0 row' style=''>
                <div class='px-3 pt-4 pb-3 col-md-12' style='box-shadow: 1px 11px 11px -6px #dbdbdb;border-radius: 12px;border: 1px solid #b2b2b24c;overflow:hidden;display: flex;flex-direction: column;justify-content: space-around;background:#57be87;color:#fff;'>
                    <div class='d-block'><h4><b>Progress</b></h4></div>
                    
                    <div id='vcart'></div>
                                                
                </div>
            </div>


            
            
            <div class='col-md-3 m-0 mmy-4 row' style=''>
                <div class='px-3 pt-4 pb-3 col-md-12' style='box-shadow: 1px 11px 11px -6px #dbdbdb;border-radius: 12px;border: 1px solid #b2b2b24c;overflow:hidden;display: flex;flex-direction: column;justify-content: space-around;background:#fff;color:#000;'>
                    <div class='d-block'><h4><b>Pickups</b></h4></div>
                    <?php $mq = mysqli_query(dbCon(), "SELECT SUM(quantity)/12 AS total FROM `zw_epr_po_items` WHERE MONTH(time_str) <= MONTH(NOW()) AND YEAR(time_str) = YEAR(NOW());");
                    $val = mysqli_fetch_assoc($mq); $totalpord = $val['total']; $mqq = mysqli_query(dbCon(), "SELECT SUM(net_quantity) AS total FROM `zw_pickups` WHERE MONTH(time_str) = MONTH(NOW()) AND net_quantity!='' AND YEAR(time_str) = YEAR(NOW());"); $val2 = mysqli_fetch_assoc($mqq); $totalpkup = $val2['total']; $pkttl = round(($totalpkup/$totalpord)*100); ?>

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
                            
                </div>
            </div>



            
            
            <div class='col-md-3 p-0 m-0 row' style='background:#0f172a;box-shadow: 1px 11px 11px -6px #dbdbdb;border-radius: 12px;border: 1px solid #b2b2b24c;'>
                       <div id="calendar" ></div>
                        <script>
                          document.addEventListener('DOMContentLoaded', () => {
                            const options = {
                                settings: {
                                    visibility: {
                                        theme: 'dark'
                                    }
                                }
                            };
                            const calendar = new VanillaCalendar('#calendar', options);
                            calendar.init();
                        });
                        </script>
                </div>
            </div>




            
            </div>
        </div> 
    </div>
    
    
    
    
    <script>
        
        var options5 = {
          series: [{
          data: [25, 66, 41, 89, 63]
        }],
          chart: {
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
        labels: [1, 2, 3, 4, 5],
        colors: ["#57be87"],
        xaxis: {
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
          data: [25, 66, 41, 89, 63]
        }],
          chart: {
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
        labels: [1, 2, 3, 4, 5],
        colors: ["#ffa500"],
        xaxis: {
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
        
        var options7 = {
          series: [{
          data: [25, 66, 41, 89, 63]
        }],
          chart: {
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
        labels: [1, 2, 3, 4, 5],
        colors: ["#57be87"],
        xaxis: {
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

        var chart7 = new ApexCharts(document.querySelector("#chart-7"), options7);
        chart7.render();
        
        var options8 = {
          series: [{
          data: [25, 66, 41, 89, 63]
        }],
          chart: {
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
        labels: [1, 2, 3, 4, 5],
        colors: ["#57be87"],
        xaxis: {
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

        var chart8 = new ApexCharts(document.querySelector("#chart-8"), options8);
        chart8.render();
    </script>
            
                        
                        
                        <script>
var options = {
  chart: {
    height: 220,
    type: "radialBar",
  },
  series: [67],
  colors: ["#ffffff"],
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
          color: "#fff",
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

var chart = new ApexCharts(document.querySelector("#vcart"), options);

chart.render();

                    </script>