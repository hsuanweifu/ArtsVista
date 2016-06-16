<?php
include_once('scripts/vso.php');

ini_set('max_execution_time', 1200); // 20 minutes

$vso		= new Vso();
$vso->scrapEvents();