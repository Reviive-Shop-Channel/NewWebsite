<?php
// utils.php - Dakotath
include("../config/cfg.php");

// Pwd strength
function checkPasswordStrength($pwd) {
    // Return array.
    $returnArray = array(false, "errmsg");
    $problem = false;

    if (strlen($pwd) < 8) {
        $returnArray[1] = "Password must be 8 characters or more.";
        $problem = true;
    }

    if (!preg_match("#[0-9]+#", $pwd)) {
        $returnArray[1] = "Password must include at least one number!";
        $problem = true;
    }

    if (!preg_match("#[a-zA-Z]+#", $pwd)) {
        $returnArray[1] = "Password must include at least one letter!";
        $problem = true;
    }

    if (preg_match_all("/[\W_]/", $pwd) < 1) {
        $returnArray[1] = "Password must include at least one symbol!";
        $problem = true;
    }

    if(!$problem) {
        $returnArray[0] = true;
    }

    return $returnArray;
}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }

    return $randomString;
}