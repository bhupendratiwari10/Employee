<?php 
// Include necessary files using FULL_PATH
include FULL_PATH.'/sub/epr/inc/function.php';
include FULL_PATH.'/sub/epr/inc/phpqrcode-master/qrlib.php';

// Get database connection
$con = dbCon();

// Secure the pickup ID parameter
$pickupsid = isset($_GET['pid']) ? intval($_GET['pid']) : 0;

if (!$pickupsid) {
    die("Invalid pickup ID");
}

// Get pickup data with prepared statement
$query = "SELECT * FROM zw_pickups WHERE id = ?";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, "i", $pickupsid);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    die("Pickup not found");
}

// Get related data
$state = !empty($data['state']) ? $data['state'] : 'N/A';
$quantity = !empty($data['net_quantity']) ? $data['net_quantity'] : 0;
$clientId = $data['client'];

// Get client name with prepared statement
$getNameByID = "SELECT id, customer_display_name FROM zw_customers WHERE id = ?";
$stmtClient = mysqli_prepare($con, $getNameByID);
mysqli_stmt_bind_param($stmtClient, "i", $clientId);
mysqli_stmt_execute($stmtClient);
$res2 = mysqli_stmt_get_result($stmtClient);
$clientData = mysqli_fetch_assoc($res2);
$clientName = $clientData['customer_display_name'];

// Get category name
$categoryId = isset($data['category']) ? intval($data['category']) : 0;
$categoryName = "SELECT title FROM zw_pickup_categories WHERE id = ?";
$stmtCategory = mysqli_prepare($con, $categoryName);
mysqli_stmt_bind_param($stmtCategory, "i", $categoryId);
mysqli_stmt_execute($stmtCategory);
$categoryResult = mysqli_stmt_get_result($stmtCategory);
$categoryData = mysqli_fetch_assoc($categoryResult);
$category = isset($categoryData['title']) ? $categoryData['title'] : 'General Waste';

// Generate certificate URL using PROJECT_URL
$certificate_url = PROJECT_URL . "sub/epr/inc/reports/eprpickups/pickup_certificate.php?pid=" . $pickupsid;

// Generate unique QR code filename
$qr_filename = "pickup_" . $pickupsid . "_" . date('YmdHis') . ".png";
$outputPath = FULL_PATH . "/sub/epr/certificate/QR/" . $qr_filename;
$qr_url_path = PROJECT_URL . "sub/epr/certificate/QR/" . $qr_filename;

// Create directory if it doesn't exist
$qr_dir = dirname($outputPath);
if (!file_exists($qr_dir)) {
    mkdir($qr_dir, 0755, true);
}

// Generate QR code
generateQRCode($certificate_url, $outputPath);

function generateQRCode($url, $outputPath) {
    QRcode::png($url, $outputPath, QR_ECLEVEL_L, 10, 2);
}

// Calculate date range (example: last 30 days)
$endDate = date('j F Y');
$startDate = date('j F Y', strtotime('-30 days'));

// Generate certificate number based on pickup ID
$certificateNumber = str_pad($pickupsid, 8, '0', STR_PAD_LEFT);
$invoiceNumber = !empty($data['epr_invoice']) ? $data['epr_invoice'] : 'N/A';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate of Disposal - <?php echo htmlspecialchars($clientName); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <style>
        body {
            background-image: url("<?php echo PROJECT_URL; ?>sub/epr/inc/certificate/images/2.png");
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            position: relative;
            margin: 0 auto;
            min-height: 1050px;
            padding: 20px;
        }
        
        .cert_back {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            padding: 30px;
            max-width: 800px;
            margin: 0 auto;
        }
        
        .certificate-header {
            margin-bottom: 20px;
        }
        
        .certificate-body {
            margin: 30px 0;
        }
        
        .certificate-info {
            border: 1px solid #555;
            border-radius: 11px;
            padding: 10px;
            margin: 20px auto;
            max-width: 250px;
        }
        
        .waste-table {
            margin: 30px auto;
            max-width: 500px;
        }
        
        .waste-table table {
            width: 100%;
        }
        
        .waste-table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        
        .signature-section {
            display: flex;
            justify-content: space-around;
            align-items: center;
            margin-top: 50px;
        }
        
        .signature-section img {
            border-radius: 50%;
            border: 2px solid #ddd;
        }
        
        .qr-code {
            margin: 20px 0;
        }
        
        @media print {
            body {
                background-image: none;
                background-color: white;
            }
            
            .cert_back {
                background-color: white;
                box-shadow: none;
            }
        }
    </style>
</head>
<body>
    <div class="cert_back">
        <div class="container-fluid">
            <!-- Logo -->
            <div class="text-center certificate-header">
                <img src="<?php echo PROJECT_URL; ?>sub/epr/inc/certificate/images/zw%20logo.png" 
                     alt="Tidy Rabbit Logo" style="width: 180px;">
            </div>
            
            <!-- Certificate Title -->
            <div class="text-center">
                <h2 style="margin-bottom: 5px; font-weight: bold;">CERTIFICATE</h2>
                <p style="font-size: 18px; margin: 0;">OF DISPOSAL</p>
            </div>
            
            <!-- QR Code -->
            <div class="text-center qr-code">
                <img src="<?php echo $qr_url_path; ?>" alt="QR Code" style="width: 100px;">
            </div>
            
            <!-- Certificate Info -->
            <div class="certificate-info">
                <small><strong>Certificate #:</strong> <?php echo htmlspecialchars($certificateNumber); ?></small><br>
                <small><strong>Invoice #:</strong> <?php echo htmlspecialchars($invoiceNumber); ?></small>
            </div>
            
            <!-- Certificate Body -->
            <div class="text-center certificate-body">
                <h5>This Certificate is ISSUED TO</h5>
                <h3 style="color: #ff8c00; margin: 20px 0;">
                    M/S <?php echo htmlspecialchars($clientName); ?>
                </h3>
                <p style="font-size: 14px; line-height: 1.8; text-align: justify; margin: 0 auto; max-width: 700px;">
                    This is to certify that we, <strong>Tidy Rabbit India (P) LTD.</strong>, have successfully collected 
                    the following quantities of Post Consumer Laminate Waste in <strong><?php echo htmlspecialchars($state); ?></strong> 
                    from end users, as stated, to fulfill the Extended Producer Responsibility (EPR) obligation. 
                    The waste has been collected for recycling during the period from 
                    <strong><?php echo $startDate; ?></strong> to <strong><?php echo $endDate; ?></strong>, 
                    and has been safely and completely disposed of in accordance with the PWM Rules of 2016 
                    and any subsequent amendments. We certify that the mentioned quantity has not been 
                    accounted for or billed to any other entity.
                </p>
            </div>
            
            <!-- Waste Details Table -->
            <div class="waste-table">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="15%">S.No.</th>
                            <th width="55%">Category</th>
                            <th width="30%">Quantity (KG)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>01.</td>
                            <td><strong><?php echo htmlspecialchars($category); ?></strong></td>
                            <td><strong><?php echo number_format($quantity, 2); ?></strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Signature Section -->
            <div class="signature-section">
                <div class="text-center">
                    <img src="<?php echo PROJECT_URL; ?>sub/epr/inc/certificate/images/dummy-profile.jpg" 
                         alt="Authorized Signature" width="80" height="80">
                    <p style="margin-top: 10px;"><strong>Authorized Signatory</strong></p>
                </div>
                <div class="text-center">
                    <p style="font-size: 16px;"><strong><?php echo date('d/m/Y'); ?></strong></p>
                    <p>Date of Issue</p>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-print functionality (optional)
        // window.onload = function() {
        //     window.print();
        // };
    </script>
</body>
</html>