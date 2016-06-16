<?php
include_once('scripts/brownpaper.php');

ini_set('max_execution_time', 1200); // 20 minutes

$brownpaper = new Brownpaper();
$brownpaper->scrapEvents();