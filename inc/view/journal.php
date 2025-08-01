<?php 

if(!empty($_GET['id'])){
    $id = $_GET['id'];
    $query = "Select * from zw_journal where id = $id";
    $res = mysqli_query($con , $query);
    $data = mysqli_fetch_assoc($res);
    $date = $data['date'];
    $title = $data['title'];
    $desc = $data['notes'];
    $balance = $data['total'];
}


?>

<div class='' style='float:right;'>
    <a href='edit.php?type=journal&id=<?php echo $id; ?>' class='d-inline-block btn btn-success'>Edit</a>
    <a href='delete.php?type=journal&id=<?php echo $id; ?>' class='d-inline-block btn btn-danger'>Delete</a>
</div>    
<div class='box' style='margin-bottom: 28px;padding-bottom: 28px;border-bottom: 1px dashed;'>
    <div class='col-12 row'>
        <div class='col-md-8'>
            <h2>Journal</h2>
            <p><?php echo $title; ?></p>
        </div>
        <div class='col-md-4'>
            <p>Date : <k><?php echo $date; ?></k></p>
            <p>Amount : ₹ <k><?php echo $balance; ?></k></p>
        </div>
    </div><br>
    
    <small> <b>Description:</b> <br>
        <p><?php echo $desc; ?></p>
    </small>
</div>

    <br><h6>Recent Transactions</h6><br>
    
    <?php
    
    echo"<div class='col-12 p-0 m-0 row' style='color:green;'>";
            echo"<div class='col-md-4'>Account</div>";
            echo"<div class='col-md'>Contact</div>";
            echo"<div class='col-md'>Debits</div>";
            echo"<div class='col-md'>Credits</div>";
        echo"</div><hr>";
    $tt = 0;
    
    $kl = mysqli_query($con,"SELECT * FROM `zw_journal_items` WHERE journal_id='$id'");
    while($nala = mysqli_fetch_assoc($kl)){ $accid = $nala['account_id']; $desx = $nala['description']; $cntc = $nala['contact'];
        $debit = $nala['debit']; $credit = $nala['credit'];
        if($ptype=='made'){$tt = $tt-$inrval; $ac = "Vendor: ".namebyAid($nala['vendor_id'], "company_name", "zw_company");}    
        if($ptype=='received'){$tt = $tt+$inrval; $ac = "Account: ".namebyAid($nala['deposit_to'], "account_name", "zw_accounts");}    
        
        
        echo"<div class='col-12 p-0 m-0 row' style='color:#333;'>";
            echo"<div class='col-md-4'>".namebyAid($accid, "account_name", "zw_accounts")."</div>";
            echo"<div class='col-md'>".namebyAid($cntc, "customer_display_name", "zw_customers")."</div>";
            echo"<div class='col-md'>₹ $debit</div>";
            echo"<div class='col-md'>₹ $credit</div>";
        echo"</div><hr>";

    }