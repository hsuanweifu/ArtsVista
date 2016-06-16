<?php
include_once('scripts/straight.php');

ini_set('max_execution_time', 1200); // 20 minutes

$straight = new Straight();
$straight->scrapEvents();