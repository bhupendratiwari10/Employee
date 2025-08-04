<?php 
// Get the type variable (assuming it's set somewhere in your code)
$type = isset($type) ? $type : 'Certificate';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tidy Rabbit India | <?php echo "Add ".$type; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-print-css/css/bootstrap-print.min.css" media="print">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Alata&amp;family=Ubuntu&amp;family=Poppins&amp;display=swap">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        * {
            font-family: poppins;
        }
        .al {
            font-family: Alata;
        }
    </style>
</head>
<?php 
    // Secure the ID parameter
    $uid = isset($_GET['id']) ? intval($_GET['id']) : 0;
    
    // Get database connection
    $con = dbCon();
    
    // Prepare and execute query (using prepared statement for security)
    $query = "SELECT * FROM `zw_invoices` WHERE id = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "i", $uid);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $res = mysqli_fetch_assoc($result);
    
    // Check if invoice exists
    if (!$res) {
        die("Invoice not found");
    }
?>
<body style="margin:0;padding:176px 5%;background: url('<?php echo PROJECT_URL; ?>sub/epr/assets/img/cert_bg.jpeg');margin:0px;background-size: 102%;background-repeat:no-repeat;">
    <center>
        <!-- Logo using PROJECT_URL constant -->
        <img src='<?php echo PROJECT_URL; ?>assets/logo.svg' style='width:176px;margin-bottom:48px;'>
        
        <h3 style='letter-spacing:6px;'>- CARBON NEUTRAL -</h3>
        <h1 style='font-size:420%;margin-bottom:76px;'><b>CERTIFICATE</b></h1>
        
        <h4 style='letter-spacing:6px;'>THIS CERTIFICATE IS AWARDED TO</h4>
        <h1 style='font-size:420%;margin-bottom:36px;color:royalblue;'>
            <?php echo namebyAid($res['customer_id'], "customer_display_name", "zw_customers"); ?>
        </h1>
        
        <h5 class='col-8' style='line-height:29px;word-spacing:6px;color:#555;'>
            The waste collected by Tidy Rabbit at your premise on <b><?php echo htmlspecialchars($res['invoice_date']); ?></b> 
            has been appropriately and environmentally responsibly disposed of via one of our authorized recycling partners
        </h5>
        
        <div class='col-10 row' style='margin-top:88px;'>
            <div class='col-4' style='display:flex;flex-direction: column;flex-wrap:wrap;justify-content:center;align-content:center;'>
                <img src='<?php echo PROJECT_URL; ?>assets/johnsign.png' style='width:60%;margin-bottom:8px;'>
                <h1>John Doe</h1>
                <h5>Manager</h5>
            </div>
            <div class='col-4'>
                <img src='<?php echo PROJECT_URL; ?>assets/zwsigil.png' style='width:176px;margin:21px 0px;'>
            </div>
            <div class='col-4' style='display:flex;flex-direction: column;flex-wrap:wrap;justify-content:center;'>
                <h4><?php echo date('d/m/Y'); ?></h4>
                <h5>Date</h5>
            </div>
        </div>
    </center>
</body>
</html>