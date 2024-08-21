<?php
// Signup page for Reviive. - Dakotath
include("../config/cfg.php");
include("$appIns$appDir/deps/dbhandler.php");
include("$appIns$appDir/deps/pageMaker.php");
include("$appIns$appDir/deps/utils.php");
include("$appIns$appDir/deps/gauth.php");

// Google Authenticator.
$ga = new PHPGangsta_GoogleAuthenticator();

// Database.
$db = new DBHandler("$dbHost", "$dbUser", "$dbPass", "$dbName", $dbPort);

// Errors.
$hasProblem = false;
$problemText = "Success!";

// Modals.
$acntMakeModal = false;

// Password Options.
$options = [
    'cost' => 11
];

// Get vars.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username  = htmlSpecialChars($_POST['un']);  // Username
    $passwordA = htmlSpecialChars($_POST['pa']);  // Password
    $passwordB = htmlSpecialChars($_POST['pb']);  // Password confirm.

    // Check that passwords are the same.
    if($passwordA != $passwordB) {
        $hasProblem = true;
        $problemText = "Passwords do not match.";
    }

    // Check strength.
    $pstren = checkPasswordStrength($passwordA);
    if($pstren[0]) { // Password strength ok.
        // Check to see if user exusts.
        $usrExists = $db->checkUserExists($username);
        if($usrExists) {
            $hasProblem = true;
            $problemText = "Username ($username) already exists.";
        }

        // Carry on.
        if(!$hasProblem) {
            // Create user.
            $authSecret = $ga->createSecret();  // Create secret key for Google Authenticator.
            $passwordC = password_hash("$passwordA", PASSWORD_BCRYPT, $options);  // Hash password

            // These are just placeholders. Users will have to request 2FA and generate keys there.
            $rA = password_hash($ga->createSecret(), PASSWORD_BCRYPT, $options);  // Recov A
            $rB = password_hash($ga->createSecret(), PASSWORD_BCRYPT, $options);  // Recov B
            $rC = password_hash($ga->createSecret(), PASSWORD_BCRYPT, $options);  // Recov C
            
            // Query the database.
            $sql = "INSERT INTO users (
                        username, pass,
                        hasOtp, otpSecret, otpRecoveryA, otpRecoveryB, otpRecoveryC
                    ) VALUES (
                        \"$username\", \"$passwordC\",
                        0, \"$authSecret\", \"$rA\", \"$rB\", \"$rC\"
                    );";
            $result = $db->query($sql);

            // Telemetry.
            $db->doTelemetry("$username"." (Signup)", "Signed Up");

            // Display modal.
            $acntMakeModal = true;
        }
    } else {
        $problemText = $pstren[1];
        $hasProblem = true;
    }

    // Telemetry logging.
    if($hasProblem) {
        $full_path = $_SERVER['SCRIPT_NAME'];
        $filename = basename($full_path);
        $db->doTelemetry("Unknown Dumbass", "Caused an error in ".$filename. " nL".__LINE__);
        $db->doTelemetry("Unknown Dumbass"." (Continued)", $problemText);
    }
}

// Start the read of the data.
ob_start();
?>

<form method="POST" class="container-sm d-flex flex-column mb-3">
    <div class="mb-3">
        <label for="usernameInput" class="form-label">Username</label>
        <input type="username" class="form-control" name="un" id="usernameInput" aria-describedby="unp">
        <div id="unp" class="form-text"><?php if($hasProblem) { echo($problemText); } ?></div>
    </div>
    <div class="mb-3">
        <label for="piA" class="form-label">Password</label>
        <input type="password" name="pa" class="form-control" id="piA">
    </div>
    <div class="mb-3">
        <label for="piB" class="form-label">Confirm Password</label>
        <input type="password" name="pb" class="form-control" id="piB">
    </div>
    <button type="submit" class="btn btn-primary btn-glass">Submit</button>
</form>
<?php
// Make the page using gathered data.
makePage(ob_get_clean(), "Sign Up");

if($acntMakeModal) {
    ?>
        <!-- Account created dialog -->
        <div class="modal fade modal-dialog-centered" id="acntCreationOk" tabindex="-1" aria-labelledby="acntInfo" area-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="acntInfo">Success!</h1>
                    </div>
                    <div class="modal-body">
                        Please wait, Redirecting you to login page...
                    </div>
                    <div class="modal-footer"></div>
                </div>
            </div>
        </div>
        <script>
        var thething = new bootstrap.Modal(document.getElementById("acntCreationOk"), {});
        document.onreadystatechange = function () {
            thething.show();
        };
        setTimeout(function () {
            window.location.href = "<?php echo($appDir); ?>/login";
        }, 1000);
        </script>
    <?php
}