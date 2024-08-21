<?php
// Home page.
include("../config/cfg.php");
include("$appIns$appDir/deps/pageMaker.php");
include("$appIns$appDir/deps/console.php");

// Debug.
$logger = new DTUBEConLogger(__FILE__);

ob_start();
?>

<script src="script/coolwords.js"></script>
<img src="images/rsclogo.png" style="width: 128px;"><hr>
<h5 style="white-space: nowrap;" class="word"></h5>
<hr>
<h5 class="card-title">Special title treatment</h5>
<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
<a href="#" class="btn btn-glass">Go somewhere</a>

<?php
makePage(ob_get_clean(), "Home");