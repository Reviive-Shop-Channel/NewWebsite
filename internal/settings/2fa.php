<?php

// Functions.
function set2fa($val = 0) {
    include("../config/cfg.php");
    require_once("$appIns$appDir/deps/dbhandler.php");

    // Database.
    $dbs = new DBHandler("$dbHost", "$dbUser", "$dbPass", "$dbName", $dbPort);

    // Log action.
    $dbs->doTelemetry($_SESSION['user']['username'], "Set 2FA: $val");

    // Check for session.
    if(isset($_SESSION['user'])) {
        $_SESSION['user']['hasOtp'] = $val;
        if(!$dbs->updateUserInfo($_SESSION['user']['username'], $_SESSION['user'])) {
            $db->doTelemetry($_SESSION['user']['username'], "Caused an error in ".basename(__FILE__). " nL".__LINE__);
            echo("Die");
        }
    }
}

function reset2fa() {
    include("../config/cfg.php");
    require_once("$appIns$appDir/deps/dbhandler.php");
    require_once("$appIns$appDir/deps/gauth.php");

    // Password Options.
    $options = [
        'cost' => 11
    ];

    // Database.
    $dbs = new DBHandler("$dbHost", "$dbUser", "$dbPass", "$dbName", $dbPort);

    // Log action.
    $dbs->doTelemetry($_SESSION['user']['username'], "Reset 2FA codes");

    // Google Authenticator.
    $ga = new PHPGangsta_GoogleAuthenticator();

    // Reset the codes.
    $uS = $ga->createSecret();  // Recov A
    $rA = $ga->createSecret();  // Recov A
    $rB = $ga->createSecret();  // Recov B
    $rC = $ga->createSecret();  // Recov C
    
    // Encryped.
    $eA = password_hash($rA, PASSWORD_BCRYPT, $options);  // Recov A
    $eB = password_hash($rB, PASSWORD_BCRYPT, $options);  // Recov B
    $eC = password_hash($rC, PASSWORD_BCRYPT, $options);  // Recov C

    // Set them.
    $_SESSION['user']['otpSecret'] = $uS;
    $_SESSION['user']['otpRecoveryA'] = $eA;
    $_SESSION['user']['otpRecoveryB'] = $eB;
    $_SESSION['user']['otpRecoveryC'] = $eC;

    // Update em.
    if(!$dbs->updateUserInfo($_SESSION['user']['username'], $_SESSION['user'])) {
        $db->doTelemetry($_SESSION['user']['username'], "Caused an error in ".__FILE__. " nL".__LINE__);
        echo("Die");
    }

    // Please kill me already.
    if(isset($_SESSION['user'])) {
        ?>
        <script>alert('SAVE THESE RECOVERY CODES: <?php echo("$rA, $rB, $rC"); ?>.');</script>
        <?php
    }
}

// Check for change.
if(isset($_GET['action'])) {
    // Check action.
    switch($_GET['action']) {
        case "dis2fa":
            set2fa(0);
            break;
        case "en2fa":
            set2fa(1);
            break;
        case "rgenRcovCodes":
            reset2fa();
            break;    
    }
}

?>
<style>
.secretImage {
    filter: blur(10px);
}
.secretImage:hover {
    filter: blur(0px);
}
</style>
<script>
    function doaction(action) {
        let url = window.location.href + "&action=" + action;
        window.location.href = url;
    }
</script>
<h1>2 Factor Authentication</h1>
<div class="container">
    <input type="checkbox" class="form-check-input" id="enable2fa" <?php if($_SESSION['user']['hasOtp']) { echo("checked"); } ?>/>
    <label class="form-check-label" for="enable2fa">
        Enable 2FA
    </label>
    <br>
    <!-- If user has 2fa on, Show them their code. -->
    <hr>
    <?php
        if($_SESSION['user']['hasOtp']) {
            $qrCodeUrl = $ga->getQRCodeGoogleUrl('ReviiveShop', $_SESSION['user']['otpSecret']);
            ?>
            <h3>Reset your 2FA:</h3>
            <button class="btn btn-danger" onclick="doaction('rgenRcovCodes');">Regen 2FA Codes</button>
            <h3>Your 2FA Code:</h3>
            <?php
            echo "<img src=\"$qrCodeUrl\" class=\"secretImage\"></img>";
        }
    ?>
</div>

<?php
// Generate dynamic script to handle stuff.

// Main script.
if(isset($_SESSION['user'])) {
?>

<script>
// 2FA Event listener.
var otpEnable = document.getElementById("enable2fa");
otpEnable.addEventListener('change', function() {
  if (this.checked) {
    console.log("Checkbox is checked..");
    doaction("en2fa");
  } else {
    console.log("Checkbox is not checked..");
    doaction("dis2fa");
  }
});
</script>

    <?php
}
