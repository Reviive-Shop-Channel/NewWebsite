<?php

// Change the user's username.
function changeUsername($newUsername) {
    include("../config/cfg.php");
    require_once("$appIns$appDir/deps/dbhandler.php");

    // Database.
    $dbs = new DBHandler("$dbHost", "$dbUser", "$dbPass", "$dbName", $dbPort);

    // Format username.
    $fNewUser = htmlspecialchars($newUsername);

    // Check for session.
    if(isset($_SESSION['user'])) {
        // Validate that the username isn't already taken.
        $uNowExists = checkUserExists($fNewUser);
        if($uNowExists) {
            // TODO: Implement error message for "username exists".
            /**
             * If the username exists, I want the failure reported back to the database
             * telling which user tried renaming to who. This will be used to verify
             * for any SQL injection attempts, and to see whos trolling us.
             */
        }

        // Quickly grab the old username so that we can update it.
        $oldUsername = $_SESSION['user']['username'];

        // Change username.
        $_SESSION['user']['username'] = $fNewUser;

        // Send the changes to the database.
        if(!$dbs->updateUserInfo($oldUsername, $_SESSION['user'])) {
            echo("Die");
        }
    }
}

// Change the user's password.
function changePassword($newPassword, $oldPassword) {
    include("../config/cfg.php");
    require_once("$appIns$appDir/deps/dbhandler.php");

    // Format the old password and new password.
    $fNewPass = htmlspecialchars($newPassword);
    $fOldPass = htmlspecialchars($oldPassword);

    // Database.
    $dbs = new DBHandler("$dbHost", "$dbUser", "$dbPass", "$dbName", $dbPort);

    // Password options.
    $options = ['cost' => 11];

    // Check for session.
    if(isset($_SESSION['user'])) {
        // Obtain the user's current password hash.
        $uHashThen = $_SESSION['user']['pass'];

        // Verify old password.
        if(password_verify("$fOldPass", $uHashThen)) {
            // Hash up a new password.
            $uHashNow = password_hash("$fNewPass", PASSWORD_BCRYPT, $options);

            // Set it in the session.
            $_SESSION['pass'] = $uHashNow;

            // Push the changes into the database.
            if(!$dbs->updateUserInfo($_SESSION['user']['username'], $_SESSION['user'])) {
                echo("Die");
            }
        } else {
            // TODO: Implement invalid request warning.
            /**
             * If the user fails to change their password, we should also log the telemetry
             * back into the database. That way we can spot if bots are trying to force their
             * way in, or if someone legit forgot their password.
             */
        }
    }
}

?>
<h1>Account settings:</h1>