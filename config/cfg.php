<?php
/*
    Site Config
*/
error_reporting(E_ERROR);
session_start();

// Version and basic cfg.
$appName    = "Reviive Shop";
$appDate    = "08/2024";
$appDir     = "";
$appIns     = "/var/www/reviive.andry6702.net";
$appSysInfP = "/code/a.out";

// Header items.
$headerItems = array(
    ["Home", "$appDir/home"],
    ["About", "$appDir/about"],
);

// LoginLogoutBS.
if(isset($_SESSION["user"]['username'])) {
    array_push($headerItems, ["Logout", "$appDir/logout"]);
} else {
    array_push($headerItems, ["Login", "$appDir/login"]);
}

// Messages.
$generalDieMsg = "
Yo, so like, the PHP script totally ghosted us 😭. It's majorly outta service, 
like it just gave up the ghost and dipped 🏃‍♂️💨. The code's acting sus and straight-up 
glitched out leaving us in a digital desert 🌵💔.<br>";

// Database Config.
$dbUser     = "";
$dbPass     = "";
$dbName     = "";
$dbHost     = "";
$dbPort     = ;
