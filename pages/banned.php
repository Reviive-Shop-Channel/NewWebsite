<?php

// Banned page - Dakotath
include("../config/cfg.php");
include("$appIns$appDir/deps/dbhandler.php");

// Database.
$db = new DBHandler("$dbHost", "$dbUser", "$dbPass", "$dbName", $dbPort);

// Is there a session?
if(isset($_SESSION['user'])) {
    // Update DB.
    $_SESSION['user'] = $db->getUserInfo($_SESSION['user']['username']);

    // Check for ban.
    if($_SESSION['user']['isBanned']) {
        ?>
            <h1>You're banned</h1>
            <hr>
            <p>Looks like your banned</p>
            <p>If you think this is a mistake, <a href="<?php echo("$appDir") ?>/logout">Log Out</a>, and try again.
        <?php
    } else {
        ?>
            <h1>Bro get outta here, your not banned (yet).</h1>
        <?php
    }
} else {
    ?>
        <h1>Bro 💀</h1>
        <hr>
        <p>Your not even logged in dude. Why are you like this?</p>
    <?php
}