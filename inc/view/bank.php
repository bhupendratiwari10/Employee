<?php 

if(!empty($_GET['id'])){
    $id = $_GET['id'];
    $query = "Select * from zw_accounts where id = $id";
    $res = mysqli_query($con , $query);
    $data = mysqli_fetch_assoc($res);
    $atype = $data['account_type'];
    $actype = namebyAid($atype, "title", "zw_account_types");
    $title = $data['account_name'];
    $desc = $data['description'];
    $balance = $data['closing_balance'];
}


?>

<div class='' style='float:right;'>
    <a href='edit.php?type=accounts&id=<?php echo $id; ?>' class='d-inline-block btn btn-success'>Edit</a>
    <a href='delete.php?type=accounts&id=<?php echo $id; ?>' class='d-inline-block btn btn-danger'>Delete</a>
</div>    
<div class='box' style='margin-bottom: 28px;padding-bottom: 28px;border-bottom: 1px dashed;'>
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
    
    echo"<div class='col-12 p-0 m-0 row' style='color:green;'>";
            echo"<div class='col-md-2'>Date</div>";
            echo"<div class='col-md-3'>Transaction Details</div>";
            echo"<div class='col-md'>Type</div>";
            echo"<div class='col-md'>Deposits</div>";
            echo"<div class='col-md'>Withdrawl</div>";
        echo"</div><hr>";
    $tt = 0;
    
    /*$kl = mysqli_query($con,"SELECT * FROM `zw_payment_made` WHERE paid_through='$id' OR deposit_to='$id'");
    while($nala = mysqli_fetch_assoc($kl)){ $pyid = $nala['id']; $inrval = $nala['payment_made'];
        $date = $nala['payment_date']; $ptype = $nala['payment_type'];
        
        if($atype==14){$ptype='made';}
        
        $acy = namebyAid($nala['vendor_id'], "company_name", "zw_company");
        $acx = namebyAid($nala['deposit_to'], "account_name", "zw_accounts");
        
        if($ptype=='made'){$tt = $tt+$inrval; if(!empty($acy)){$ac="Vendor: ".$acy;}else{$ac="Account: ".$acx;} }    
        if($ptype=='received'){$tt = $tt-$inrval;if(!empty($acx)){$ac="Account: ".$acx;}else{$ac="Vendor: ".$acy;} }
        
        if($atype==14){$tt = str_replace("-","",$tt);}
        
        echo"<div class='col-12 p-0 m-0 row' style='color:#333;'>";
            echo"<div class='col-md-2'>".str_replace("00:00:00", "", $date)."</div>";
            echo"<div class='col-md-3'>$ac</div>";
            echo"<div class='col-md'>".$nala['payment_mode']."</div>";
            echo"<div class='col-md'>";if($ptype=='received'){echo "₹ ".$inrval;}echo"</div>";
            echo"<div class='col-md'>";if($ptype=='made'){echo "₹ ".$inrval;}echo"</div>";
        echo"</div><hr>";
    }*/ 
    
    $kl = mysqli_query($con,"SELECT * FROM `zw_payment_made` WHERE paid_through='$id'");
    while($nala = mysqli_fetch_assoc($kl)){ $pyid = $nala['id']; $inrval = $nala['payment_made'];
        $date = $nala['payment_date']; $ptype = $nala['payment_type'];
        
        if($atype==14){$ptype='made';}
        
        $acy = namebyAid($nala['vendor_id'], "company_name", "zw_company");
        $acx = namebyAid($nala['deposit_to'], "account_name", "zw_accounts");
        $tt = $tt-$inrval;
        
        if($atype==14){$tt = str_replace("-","",$tt);}
        
        
        echo"<div class='col-12 p-0 m-0 row' style='color:#333;'>";
            echo"<div class='col-md-2'>".str_replace("00:00:00", "", $date)."</div>";
            echo"<div class='col-md-3'>$ac</div>";
            echo"<div class='col-md'>".$nala['payment_mode']."</div>";
            echo"<div class='col-md'>";if($ptype=='received'){echo "₹ ".$inrval;}echo"</div>";
            echo"<div class='col-md'>";if($ptype=='made'){echo "₹ ".$inrval;}echo"</div>";
        echo"</div><hr>"; 
    } 
    
    $kl = mysqli_query($con,"SELECT * FROM `zw_payment_made` WHERE deposit_to='$id'");
    while($nala = mysqli_fetch_assoc($kl)){ $pyid = $nala['id']; $inrval = $nala['payment_made'];
        $date = $nala['payment_date']; $ptype = $nala['payment_type'];
        $tt = $tt+$inrval;
        
        echo"<div class='col-12 p-0 m-0 row' style='color:#333;'>";
            echo"<div class='col-md-2'>".str_replace("00:00:00", "", $date)."</div>";
            echo"<div class='col-md-3'>$ac</div>";
            echo"<div class='col-md'>".$nala['payment_mode']."</div>";
            echo"<div class='col-md'>";if($ptype=='received'){echo "₹ ".$inrval;}echo"</div>";
            echo"<div class='col-md'>";if($ptype=='made'){echo "₹ ".$inrval;}echo"</div>";
        echo"</div><hr>";
    } 
    
    
    
    
    $kil = mysqli_query($con,"SELECT * FROM `zw_expense` WHERE paid_throw='$id'");
    while($naila = mysqli_fetch_assoc($kil)){ $pyid = $naila['id']; $inrvall = $naila['amount'];
        $date = $naila['date'];$vendor = namebyAid($naila['vendor'], "company_name", "zw_company");
        $customer = namebyAid($naila['customer_id'], "account_name", "zw_accounts");
        if($customer==0){$aic = "Vendor: $vendor";}else{$aic = "Account: $customer";}
        
        echo"<div class='col-12 p-0 m-0 row' style='color:#333;'>";
            echo"<div class='col-md-2'>".str_replace("00:00:00", "", $date)."</div>";
            echo"<div class='col-md-3'>$aic </div>";
            echo"<div class='col-md'>Expense</div>";
            echo"<div class='col-md'></div>";
            echo"<div class='col-md'>₹ $inrvall</div>";
        echo"</div><hr>";
        $tt = $tt-$inrvall;
    } 
    
    $kil = mysqli_query($con,"SELECT * FROM `zw_expense` WHERE acc='$id'");
    while($naila = mysqli_fetch_assoc($kil)){ $pyid = $naila['id']; $inrvall = $naila['amount'];
        $date = $naila['date'];$vendor = namebyAid($naila['vendor'], "company_name", "zw_company");
        $customer = namebyAid($naila['customer_id'], "account_name", "zw_accounts");
        if($customer==0){$aic = "Vendor: $vendor";}else{$aic = "Account: $customer";}
        echo"<div class='col-12 p-0 m-0 row' style='color:#333;'>";
            echo"<div class='col-md-2'>".str_replace("00:00:00", "", $date)."</div>";
            echo"<div class='col-md-3'>$aic </div>";
            echo"<div class='col-md'>Expense</div>";
            echo"<div class='col-md'>₹ $inrvall</div>";
            echo"<div class='col-md'></div>";
        echo"</div><hr>";
        $tt = $tt+$inrvall;
    }
    
    
    
    
    $kils = mysqli_query($con,"SELECT * FROM `zw_journal_items` WHERE account_id='$id'");
    while($nala = mysqli_fetch_assoc($kils)){ $pyid = $nala['id']; $debit = $nala['debit']; $credit = $nala['credit'];
        $date = substr($nala['time_str'],0,11);$customer = namebyAid($nala['contact'], "customer_display_name", "zw_customers");
        $aic = "Contact: $customer";
        
        echo"<div class='col-12 p-0 m-0 row' style='color:#333;'>";
            echo"<div class='col-md-2'>".str_replace("00:00:00", "", $date)."</div>";
            echo"<div class='col-md-3'>$aic </div>";
            echo"<div class='col-md'>Manual Journal</div>";
            echo"<div class='col-md'>₹ $debit</div>";
            echo"<div class='col-md'>₹ $credit</div>";
        echo"</div><hr>";
        $tt= $tt+$debit; $tt= $tt-$credit;
    }
    
    
    if($balance!=$tt){mysqli_query($con,"UPDATE zw_accounts SET closing_balance='$tt' where id = $id");}
    echo"<script>$('#ttl').text('$tt');</script>";