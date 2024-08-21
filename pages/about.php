<?php
// About page.
include("../config/cfg.php");
require_once("$appIns$appDir/deps/pageMaker.php");
ob_start();
?>

<h1>About <?php echo $appName; ?></h1>
<p><?php echo "\"$appName\" Version: $appDate" ?></p>
<hr>
<p>The Revive Shop Channel is a Wii shop revival that focuses on preserving the past.
Nintendo shut down the Wii Shop Channel in 2019, and we expected the games to be brought to the NX/NS.
Instead, they left all of the WiiWare and Virtual Console games to rot.
That is why we are determined to revive the shop in order to bring back all those nostalgic games for the younger and older generations,
Furthermore, we are committed to this project because taking down games is not a sustainable
process, and is synonymous with "wiping away history",
We believe that games should be preserved and not wiped away,
therefore we have created the "Reviive Shop Channel" to bring back and preserve all those amazing WiiWare and Virtual Console
games that were previously
lost to time thanks to Nintendo's greedy hands.</p>
<hr>
<h1>Our Developers:</h1>
<div class="row">
  <div class="col-sm-6 mb-3 mb-sm-0">
    <div class="card subglass">
      <div class="card-body">
        <h5 class="card-title">ChrisPlayzYT</h5>
        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
      </div>
    </div>
  </div>
  <div class="col-sm-6 mb-2">
    <div class="card subglass">
      <div class="card-body">
        <h5 class="card-title">Thom</h5>
        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
      </div>
    </div>
  </div>
  <div class="col-lg-6 mb-2">
    <div class="card subglass">
      <div class="card-body">
        <h5 class="card-title">Wabagg123</h5>
        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
      </div>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="card subglass">
      <div class="card-body">
        <h5 class="card-title">Dakotath</h5>
        <p class="card-text">Web Developer.</p>
        <!-- <a href="#" class="btn btn-glass">Go somewhere</a> -->
      </div>
    </div>
  </div>
</div>
<hr>
<h1>Server Info</h1>
<iframe src="<?php echo $appDir; ?>/phpinfo" style="width: 100%; height: 300px;"></iframe>
<hr>
<h1>Commit log</h1>
<textarea style="width: 100%; height: 300px;"><?php echo shell_exec("git log --oneline"); ?></textarea>

<?php
makePage(ob_get_clean(), "About");