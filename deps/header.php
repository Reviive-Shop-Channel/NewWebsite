<?php
/* Header file for Reviive shop. */
?>
<html data-bs-theme="dark">
</html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link
        rel="stylesheet"
        href="cascade/main.css"
    >

    <!-- Nav -->
    <nav class="z-1 navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">
                <?php echo $appName; ?>
            </span>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <!-- Main Content for Navibar -->
                    <?php foreach($headerItems as $hdIt) { ?>
                        <li class="nav-item">
                            <a class="nav-link <?php if($_SERVER['REQUEST_URI'] == $hdIt[1]) { echo "Active"; } ?>" aria-current="page" href="<?php echo $hdIt[1] ?>"><?php echo $hdIt[0] ?></a>
                        </li>
                    <?php } ?>
                    <?php if(isset($_SESSION['user'])) { ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Account
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?php echo("$appDir"); ?>/settings">Settings</a></li>
                        </ul>
                    </li>
                    <?php if($_SESSION['user']['isAdmin']) { ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        System
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?php echo("$appDir"); ?>/home">Users</a></li>
                            <li><a class="dropdown-item" href="<?php echo("$appDir"); ?>/home">Telemetry</a></li>
                            <li><a class="dropdown-item" href="<?php echo("$appDir"); ?>/admin-status">System Status</a></li>
                        </ul>
                    </li>
                    <?php } ?>
                    <?php } ?>
                </ul>
                <div class="d-flex">
                    <audio controls loop data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Background Music">
                    <source src="https://reviive.andry6702.net/sfx/main_bgm_shop.mp3" type="audio/mpeg">
                    Your browser does not support the audio tag.
                    </audio>
                <div>
            </div>
        </div>
    </nav>
    <script>
        var promise = document.querySelector('audio').play();

        if (promise !== undefined) {
        promise.then(_ => {
            // Autoplay started!
        }).catch(error => {
            // Autoplay was prevented.
            // Show a "Play" button so that user can start playback.
            console.error("One does not simply, Autoplay video.");
        });
        }
        // Tooltip Script
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>
</head>