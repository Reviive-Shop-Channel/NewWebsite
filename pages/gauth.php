<?php
include("../config/cfg.php");
include("$appIns$appDir/deps/gauth.php");

$ga = new PHPGangsta_GoogleAuthenticator();
$secret = $_GET['sec'];

$qrCodeUrl = $ga->getQRCodeGoogleUrl('ReviiveShop', $secret);
echo "Google Charts URL for the QR-Code: ".$qrCodeUrl."<br>";
echo "<img src=\"$qrCodeUrl\"></img>";