<?php

// ptest - Dakotath
$p2h = $_GET['pass'];
$options = [
    'cost' => 10
];
$hash = password_hash("$p2h", PASSWORD_BCRYPT, $options);

if (password_verify("testp", $hash)) {
    echo 'Password is valid!';
} else {
    echo 'Invalid password.';
}