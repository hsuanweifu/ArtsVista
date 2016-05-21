<?php
ini_set('max_execution_time', 900); // 15 minutes

include_once('scripts/straight.php');
include_once('scripts/ticketRocket.php');
include_once('scripts/eventbrite.php');
include_once('scripts/ticketfly.php');
include_once('scripts/vso.php');
include_once('scripts/viff.php');



//$straight = new Straight();
//$straight->scrapEvents();

//$ticketRocket = new TicketRocket();
//$ticketRocket->scrapEvents();

//$ticketfly	= new Ticketfly();
//$ticketfly->scrapEvents();

//$vso		= new Vso();
//$vso->scrapEvents();

$viff		= new Viff();
$viff->scrapEvents();

