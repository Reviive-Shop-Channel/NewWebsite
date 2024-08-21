<?php
include("../config/cfg.php");
include("$appIns$appDir/deps/dbhandler.php");

// Check for session
session_start();
if(isset($_SESSION['user'])) {
    // Connect to the database.
    $db = new DBHandler("$dbHost", "$dbUser", "$dbPass", "$dbName", $dbPort);

    // Telemetry.
    $db->doTelemetry($_SESSION['user']['username'], "Logged out");

    // Logout.
    unset($_SESSION['user']);
}

// Go home.
header("Location: $appDir/home");