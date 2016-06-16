<?php
include_once('scripts/seatgeek.php');

ini_set('max_execution_time', 1200); // 20 minutes

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$seatgeek = new Seatgeek();
$seatgeek->scrapEvents();