<?php 

if(!empty($_GET['id'])){
    $id = $_GET['id'];
    $query = "Select * from zw_accounts where id = $id";
    $res = mysqli_query($con , $query);
    $data = mysqli_fetch_assoc($res);
    $actype = namebyAid($data['account_type'], "title", "zw_account_types");
    $title = $data['account_name'];
    $desc = $data['description'];
}


?>
<div class='col-12 row' style='margin-top:5%; padding:2vh 5vw;padding-bottom:8vh'>
    
<div class='box row' style='margin-bottom: 28px;padding-bottom: 28px;border-bottom: 1px dashed;'>
    <div class='col-12 row'>
        <div class='col-md-8'>
            <h2><?php echo $title; ?></h2>
            <p><?php echo $actype; ?></p>
        </div>
        <div class='col-md-4'>
            <p>CLOSING BALANCE</p>
            <h2 style='color:green'>₹ <k id='ttl'>2500</k></h2>
        </div>
    </div><br>
    
    <small> <b>Description:</b> <br>
        <p><?php echo $desc; ?></p>
    </small>
</div>

    <br><h6>Recent Transactions</h6><br>
    
    <?php
    
    echo"<div class='col-12 m-0 row' style='color:green;padding:11px 0px;border-bottom:1px solid green;'>";
            echo"<div class='col-md-2'>Date</div>";
            echo"<div class='col-md-3'>Transaction Details</div>";
            echo"<div class='col-md'>Payment Mode</div>";
            echo"<div class='col-md'>Debit</div>";
            echo"<div class='col-md'>Credit</div>";
        echo"</div>";
    $tt = 0;
    
    $kl = mysqli_query($con,"SELECT * FROM `zw_payment_made` WHERE paid_through='$id' OR deposit_to='$id'");
    while($nala = mysqli_fetch_assoc($kl)){ $pyid = $nala['id']; $inrval = $nala['payment_made'];
        $date = $nala['payment_date']; $ptype = $nala['payment_type'];
        if($ptype=='made'){$tt = $tt-$inrval; $ac = "Vendor: ".namebyAid($nala['vendor_id'], "company_name", "zw_company");}    
        if($ptype=='received'){$tt = $tt+$inrval; $ac = "Account: ".namebyAid($nala['deposit_to'], "account_name", "zw_accounts");}    
        
        
        echo"<div class='col-12 m-0 row' style='color:#333;padding:11px 0px;border-bottom:1px solid #dbdbdb;'>";
            echo"<div class='col-md-2'>".str_replace("00:00:00", "", $date)."</div>";
            echo"<div class='col-md-3'>$ac</div>";
            echo"<div class='col-md'>".$nala['payment_mode']."  $pyid</div>";
            echo"<div class='col-md'>";if($ptype=='made'){echo "₹ ".$inrval;}echo"</div>";
            echo"<div class='col-md'>";if($ptype=='received'){echo "₹ ".$inrval;}echo"</div>";
        echo"</div>";
    }
    
    echo"<script>$('#ttl').text('$tt');</script>";
    
echo"</div>";