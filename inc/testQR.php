<?php

// Include the QRcode library
require 'phpqrcode-master/qrlib.php';

// Function to generate a dynamic QR code with a URL value
function generateQRCode($url, $outputPath)
{
    QRcode::png($url, $outputPath, QR_ECLEVEL_L, 10, 2);
}

// Example usage
$urlValue = "https://zwindia.in/sub/epr/view.php?type=pickups&id=84";
$outputPath = "output.png"; // Specify the path where you want to save the QR code image

generateQRCode($urlValue, $outputPath);

echo "QR code generated successfully at $outputPath";