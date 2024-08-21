<?php

// Pagemaker - Dakotath.
function makePage($pageData, $pageTitle, $fancy=true) {
    // Make a page.
    include("../config/cfg.php");
    include("$appIns$appDir/deps/header.php");
    require_once("$appIns$appDir/deps/console.php");
    require_once("$appIns$appDir/deps/dbhandler.php");

    // Database.
    $db = new DBHandler("$dbHost", "$dbUser", "$dbPass", "$dbName", $dbPort);

    // Update user info.
    if(isset($_SESSION['user'])) {
        // Update DB.
        $_SESSION['user'] = $db->getUserInfo($_SESSION['user']['username']);

        // Check for ban.
        if($_SESSION['user']['isBanned']) {
            header("Location: $appDir/banned");
        }
    }

    // Debug.
    $_logger = new DTUBEConLogger(__FILE__);

    $_logger->log("Making page for: '$pageTitle'.");
    ?>
        <title><?php echo("$appName - $pageTitle"); ?></title>
        <body>
            <?php if($fancy) { ?>
            <div class="position-absolute top-50 start-50 translate-middle h-75 mh-75 z-0" style="overflow: auto; width: 80%;">
                <div class="card text-center glass">
                    <div class="card-body">
                        <?php echo $pageData; ?>
                    </div>
                </div>
            </div>
            <?php } else { ?>
                <?php echo $pageData; ?>
            <?php } ?>
        </body>
    <?php
    $_logger->log("Made a page for: '$pageTitle'.");
}