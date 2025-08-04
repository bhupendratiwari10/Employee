<?php 
// Include files using FULL_PATH constant
include FULL_PATH.'/sub/epr/inc/function.php';
include FULL_PATH.'/sub/epr/inc/phpqrcode-master/qrlib.php';

// Set error reporting based on environment
if (defined('DEBUG_MODE') && DEBUG_MODE) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Encrypt And Decrypt Function
function encryptData($data, $key, $iv) {
    $cipherMethod = "AES-256-CBC";
    $options = 0;
    $encrypted = openssl_encrypt($data, $cipherMethod, $key, $options, $iv);
    return base64_encode($iv . $encrypted); // Include IV in the result
}

if (isset($_GET['url'])) {
    $con = dbCon();
    
    // Retrieve and decode the URL parameter
    $parentUrl = urldecode($_GET['url']);
    $parsed_url = parse_url($parentUrl);

    // Check if the query string is present
    if (isset($parsed_url['query'])) {
        // Parse the query string
        parse_str($parsed_url['query'], $query_params);

        // Check if 'id' parameter exists
        if (isset($query_params['id'])) {
            if(isset($_GET['flag'])){
                $id_value = base64_decode($query_params['id']);
            } else {
                $id_value = $query_params['id'];
            }
        } else {
            die("ID parameter is required");
        }
    } else {
        die("No query string in the URL.");
    }

    // Secure the ID value
    $id_value = intval($id_value);
    
    // Encode ID for URL
    $idencrypted = base64_encode($id_value);
    
    // Query pickup data
    $query = "SELECT * FROM zw_pickups WHERE id = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "i", $id_value);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($result);
    
    if (!$data) {
        die("Pickup not found");
    }
    
    $state = $data['state'] ? $data['state'] : '';
    $quantity = $data['net_quantity'] ? $data['net_quantity'] : 0;
    $clientId = $data['client'];
    
    // Get client name
    $getNameByID = "SELECT id, customer_display_name FROM zw_customers WHERE id = ?";
    $stmt2 = mysqli_prepare($con, $getNameByID);
    mysqli_stmt_bind_param($stmt2, "i", $clientId);
    mysqli_stmt_execute($stmt2);
    $res2 = mysqli_stmt_get_result($stmt2);
    $clientData = mysqli_fetch_assoc($res2);
    $cientName = $clientData['customer_display_name'];
    
    // Get category name
    $categoryQuery = "SELECT title FROM zw_pickup_categories WHERE id = ?";
    $stmt3 = mysqli_prepare($con, $categoryQuery);
    mysqli_stmt_bind_param($stmt3, "i", $data['category']);
    mysqli_stmt_execute($stmt3);
    $categoryResult = mysqli_stmt_get_result($stmt3);
    $categoryData = mysqli_fetch_assoc($categoryResult);
    $category = $categoryData['title'];

    // Build new URL using PROJECT_URL constant
    $parsed_url['path'] = '/sub/epr/inc/view/pickUptest.php';
    $parsed_url['query'] = http_build_query(['id' => $idencrypted]);
    
    // Use PROJECT_URL constant for the host
    $project_parts = parse_url(PROJECT_URL);
    $new_url = $project_parts['scheme'] . '://' . $project_parts['host'] . $parsed_url['path'] . '?' . $parsed_url['query'];

    // Generate QR code
    $outputPath = FULL_PATH . "/sub/epr/inc/certificate/QR/output_" . $id_value . ".png";
    $outputDir = dirname($outputPath);
    
    // Create directory if it doesn't exist
    if (!file_exists($outputDir)) {
        mkdir($outputDir, 0755, true);
    }
    
    generateQRCode($new_url, $outputPath);
    
    // Get relative path for QR code
    $qr_relative_path = str_replace(FULL_PATH, '', $outputPath);
    
} else {
    die("No URL parameter provided");
}

function generateQRCode($url, $outputPath) {
    QRcode::png($url, $outputPath, QR_ECLEVEL_L, 10, 2);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate - <?php echo htmlspecialchars($cientName); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <style>
        body {
            background-image: url("<?php echo PROJECT_URL; ?>sub/epr/inc/certificate/images/2.png");
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            position: relative;
            margin: auto;
            padding: 5% 5vw;
        }
        
        .cert_back {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
        }
        
        .crt_inv table {
            margin: 0 auto;
        }
        
        .crt_foot {
            display: flex;
            justify-content: space-around;
            align-items: center;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="cert_back">
        <div class="container-fluid">
            <!-- Logo using PROJECT_URL -->
            <div class="text-center">
                <img src="<?php echo PROJECT_URL; ?>sub/epr/inc/certificate/images/zw%20logo.png" alt="Tidy Rabbit Logo" style='width:18%;padding:11px;'>
            </div>
            
            <div class="text-center">
                <h4 style='margin-bottom:0px;'>CERTIFICATE</h4>
                <p style='font-size:76%;margin:0px 0px;'>OF DISPOSAL</p>
            </div>
            
            <!-- QR Code -->
            <div class="text-center">
                <img src="<?php echo PROJECT_URL . $qr_relative_path; ?>" alt="QR Code" style="width:69px;">
            </div>
            
            <center>
                <div class="text-center" style="width: 200px;color:#555;border: 1px solid;padding: 6px 0px;border-radius: 11px;transform: scale(0.69);">
                    <small>Certificate# <span><?php echo str_pad($id_value, 8, '0', STR_PAD_LEFT); ?></span></small><br>
                    <small>Invoice# <span><?php echo isset($data['invoice_id']) ? str_pad($data['invoice_id'], 9, '0', STR_PAD_LEFT) : 'N/A'; ?></span></small>
                </div>
            </center>
            
            <div class="text-center">
                <h6>This Certificate is ISSUED TO</h6>
                <h5 style="color:orange">M/S <?php echo htmlspecialchars($cientName); ?></h5>
                <p style='font-size:51%;'>
                    This is to certify that we, Tidy Rabbit India (P) LTD., has successfully collected the following quantities of Post Consumer Laminate Waste in 
                    <b><?php echo htmlspecialchars($state); ?></b> from end users, as stated, to fulfill the Extended Producer Responsibility (EPR) obligation. 
                    The Waste has been collected for recycling during the period of <?php echo date('j F Y', strtotime($data['pickup_date'])); ?> to <?php echo date('j F Y'); ?>, 
                    as it has been safely and completely disposed of in accordance with the PWM rules of 2016 or any subsequent amendments. 
                    We certify that mentioned quantity has not been accounted for or billed to any other entity.
                </p>
            </div>

            <center style='font-size:51%;'>
                <div class="col-sm-6 text-center crt_inv">
                    <table class="table">
                        <tr class="table">
                            <td>01.</td>
                            <td><b><?php echo htmlspecialchars($category); ?></b></td>
                            <td><b><?php echo htmlspecialchars($quantity); ?> KG</b></td>
                        </tr>
                    </table>
                </div>
                
                <div class="crt_foot">
                    <div><p></p></div>
                    <div>
                        <img src="<?php echo PROJECT_URL; ?>sub/epr/inc/certificate/images/dummy-profile.jpg" alt="Signature" width="70px" height="70px">
                    </div>
                    <div>
                        <p><?php echo date('d/m/Y'); ?></p>
                    </div>
                </div>
            </center>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>