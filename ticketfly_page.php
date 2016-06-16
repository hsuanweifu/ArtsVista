<?php
include_once('scripts/ticketfly.php');

ini_set('max_execution_time', 1200); // 20 minutes

$ticketfly	= new Ticketfly();
$ticketfly->scrapEvents();