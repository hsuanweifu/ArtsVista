<?php
include_once('scripts/cineplex.php');

ini_set('max_execution_time', 1200); // 20 minutes

$cineplex = new Cineplex();
$cineplex->scrapEvents();