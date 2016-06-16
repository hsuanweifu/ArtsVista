<?php
include_once('scripts/viff.php');

ini_set('max_execution_time', 1200); // 20 minutes

$viff		= new Viff();
$viff->scrapEvents();