<?php

$id = $_GET['id']; $query = "SELECT * FROM zw_epr_po WHERE id='$id' LIMIT 1";  $result = mysqli_query($con, $query);

while ($row = mysqli_fetch_assoc($result)) {
    
    $cid = $row['customer_id'];

echo"
    
    <div class='col-12 row' style='margin-top:5%; padding:2vh 5vw;padding-bottom:8vh'>

        <div class='row col-12'>
            <div class='col-md-6 order-md-2'>
                <img src='assets/zwnewlogo.png' class='img-fluid col-6' style='float:right;'>
            </div>
    
            <div class='col-md-6  order-md-1'>
                <h1 style='font-size:451%;'>Tax Invoice</h1>
                <h4 style='margin-left:11px;'>INVOICE # INV-$id</h4>
            </div>
        </div>
        
        
        
        
        
        
        
        
        <div class='col-12' style='margin-top:51px;'></div>
        <div class='col-md-6'>
            <h3>Balance Due</h3>
            <h1 style='font-size:351%;'>₹ <b id='totaln'>351</b></h1>
        </div>
        <div class='col-md-6'>
            <p style='float:right;' class='col-md-6'>
                Head Quarters :<br>
                #5&7, Ground Floor, Ramakrishna Nagar,
                Muthialpet, Puducherry 605 003
            </p>
        </div>
        
        
        
        
        
        
        
        <div class='col-12' style='margin-top:76px;'></div>
        <div class='col-md-9' style='margin-bottom:26px;'>
            <h5><b style='color:#555;'>Invoice Date :</b> ".$row['invoice_date']."</h5>
            <h5><b style='color:#555;'>Due Date :</b> ".$row['due_date']."</h5>
            <h5><b style='color:#555;'>P.O. :</b> #ZW-000R-".$row['po_id']."</h5>
            <h5><b style='color:#555;'>Terms :</b> ".$row['terms']."</h5>
        </div>
        <div class='col-md-3'>
            <p style='' class='col'>
                <b>Bill To</b>:<br>
                ".namebyAid($cid,"customer_display_name","zw_customers")."<br>
                ".namebyAid($cid,"billing_address","zw_customers")."
            </p>
        </div>
        
        
        
        
        
        <div class='col-12' style='margin-top:121px;'></div>
        
        
        <div class='col-md-12 row m-0' style='background:#dbdbdb;color:green;font-size:121%;padding:11px 21px;border-radius:11px;'>
            <div class='col-md-1'>#</div>
            <div class='col-md-3'>Item & Description</div>
            <div class='col-md-2'>Category</div>
            <div class='col-md-2'>State</div>
            <div class='col-md-1'>Quantity</div>
            <div class='col-md-1'>Rate</div>
            <div class='col-md-1'>GST%</div>
            <div class='col-md-1'>Amount</div>
        </div>";
        
        $queriy = "SELECT * FROM zw_epr_invoice_items WHERE invoice_id='$id'";  $resulit = mysqli_query($con, $queriy); $nn = 0; $tt = 0;
        while($vk=mysqli_fetch_assoc($resulit)){ $nn = $nn+1; 
        $itid = $vk['item_id']; 
        $qq = $vk['quantity']; 
        $category = $vk['category']; 
        $states = $vk['states'];
        $gst = $vk['gst']; 
        $rr = $vk['rate']; 
        $prc=namebyAid($itid,"selling_price","zw_items"); $tlt = $qq*$rr;
            echo"<div class='col-md-12 row' style='margin:5px 0px;'>"; $tlt2 = $tlt2+$tlt;
                echo"<div class='col-md-1'>$nn</div>";
                echo"<div class='col-md-3'>".namebyAid($itid,"name","zw_items")."</div>";
                echo"<div class='col-md-2'>".$category."</div>";
                echo"<div class='col-md-2'>".namebyAid($states,"name","zw_states")." </div>";
                echo"<div class='col-md-1'>".$qq."</div>";
                echo"<div class='col-md-1'>".$rr." ₹</div>";
                echo"<div class='col-md-1'>".$gst."%</div>";
                echo"<div class='col-md-1'>".$tlt." ₹</div>";
            echo"</div>";
        }
        
    
    $fnlprc = $tlt2;
    
    echo"<br><br><br>"."<div class='col-md-8'></div><div class='col'><h4><small>Discount: ₹ $ds</small></h4><small style='font-weight:600;'>Original Price: ₹ $tlt2</small></small><hr><h2>Sub Total : ₹ $fnlprc </h2></div>";
    
        
    
    echo"</div>";
    
    echo"<script>$('#totaln').text('$fnlprc');</script>";
    
    
}


?>
