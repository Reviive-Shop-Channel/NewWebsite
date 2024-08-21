<?php
// admin-status.php - 2024 Dakotath
include("../config/cfg.php");
include("$appIns$appDir/deps/dbhandler.php");
include("$appIns$appDir/deps/header.php");

// Helper.
function human_filesize($bytes, $decimals = 2) {
    $size = array('B','kB','MB','GB','TB','PB','EB','ZB','YB');
    $factor = floor((strlen($bytes) - 1) / 3);
    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
}

// Check for an administrive admin user session.
if(isset($_SESSION['user'])) {
    // Check for Admin perms.
    if($_SESSION['user']['isAdmin']) {
        $mTotal = (int)shell_exec("$appIns$appDir$appSysInfP -mt");
        $mFree = (int)shell_exec("$appIns$appDir$appSysInfP -mf");
        $mUsed = $mTotal - $mFree;
        $mFPerc = number_format(($mFree / $mTotal) * 100, 2);
        $mUPerc = number_format(($mUsed / $mTotal) * 100, 2);
        ?>
            <div class="container glass">
                <h1>System Status:</h1>
                <hr>
                <?php
echo("Total bytes: ".human_filesize($mTotal)."<br>");
echo("Free bytes: ".human_filesize($mFree)." ($mFPerc%)<br>");
echo("Used bytes: ".human_filesize($mUsed)." ($mUPerc%)<br>");
                ?>
                <label for="sysRamUsage">Server RAM Usage:</label>
                <div class="progress" role="progressbar" id="sysRamUsage" aria-valuenow="<?php echo($mUsed); ?>" aria-valuemin="0" aria-valuemax="<?php echo($mTotal); ?>">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" style="width: <?php echo("$mUPerc%") ?>;">RAM</div>
                </div>
                <br>
            </div>
        <?php
    } else {
        ?>
            <h1>GET THE FUCK OUT OF HERE <?php echo($_SESSION['user']['username']); ?></h1>
        <?php
    }
} else {
    ?>
        <h1>You're not logged in.</h1>
    <?php
}