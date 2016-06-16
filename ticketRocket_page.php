<?php
include_once('scripts/ticketRocket.php');

ini_set('max_execution_time', 1200); // 20 minutes

$ticketRocket = new TicketRocket();
$ticketRocket->scrapEvents();