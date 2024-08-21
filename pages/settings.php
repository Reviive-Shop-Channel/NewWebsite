<?php
// User settings page for Reviive - Dakotath.
include("../config/cfg.php");
require_once("$appIns$appDir/deps/pageMaker.php");
require_once("$appIns$appDir/deps/dbhandler.php");
require_once("$appIns$appDir/deps/console.php");
require_once("$appIns$appDir/deps/gauth.php");

$logger = new DTUBEConLogger(__FILE__);

// Database.
$db = new DBHandler("$dbHost", "$dbUser", "$dbPass", "$dbName", $dbPort);

// Google Authenticator.
$ga = new PHPGangsta_GoogleAuthenticator();

// Start session.
session_start();
if(!isset($_SESSION['user']['username'])) {
    header("Location: $appDir/home");
}

// Page to display.
$pageDisp = "acnt";

// Check for current page.
if(isset($_GET['page'])) {
    $pageDisp = htmlspecialchars($_GET['page']);
}

// Helper.
function isActiv($pd, $pge) {
    if(!strcmp($pd, htmlspecialchars($pge))) {
        echo("active");
    } else {
        echo("text-white");
    }
}

ob_start();
?>
<link rel="stylesheet" type="text/css"  href="cascade/main.css"/>
<div class="container-fluid subglass">
    <div class="row">
      <div class="sidebar d-flex flex-column flex-shrink-0 p-3 text-bg-dark h-75 glass">
        <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
          <svg class="bi pe-none me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
          <span class="fs-4">Settings</span>
        </a>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
          <li class="nav-item">
            <a href="?page=acnt" class="nav-link <?php isActiv($pageDisp, "acnt"); ?>" aria-current="page">
              <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#account"></use></svg>
              Account
            </a>
          </li>
          <li>
            <a href="?page=2fa" class="nav-link <?php isActiv($pageDisp, "2fa"); ?>">
              <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#speedometer2"></use></svg>
              2FA
            </a>
          </li>
          <li>
            <a href="#" class="nav-link text-white">
              <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#table"></use></svg>
              Account Activity
            </a>
          </li>
        </ul>
        <hr>
      </div>
      <div class="content">
      <hr>
        <!-- PHP To display page data -->
        <?php
            if($pageDisp == "acnt") {
                include("$appIns$appDir/internal/settings/acnt.php");
            } elseif($pageDisp == "2fa") {
                include("$appIns$appDir/internal/settings/2fa.php");
            }
        ?>
      </div>
    </div>
  </div>

<?php
makePage(ob_get_clean(), "User Settings", true);