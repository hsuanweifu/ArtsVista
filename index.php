<?php
ini_set('max_execution_time', 900); // 15 minutes

include_once('scripts/straight.php');
include_once('scripts/ticketRocket.php');
include_once('scripts/eventbrite.php');
include_once('scripts/ticketfly.php');
include_once('scripts/vso.php');
include_once('scripts/viff.php');
include_once('scripts/brownpaper.php');
include_once('scripts/cineplex.php');
include_once('scripts/seatgeek.php');

echo 'Will take up to 30 minutes to scrap certain sites<br>';
echo '<a class="button" href="brownpaper_page.php">Brown Paper</a><br>';
echo '<a class="button" href="cineplex_page.php">Cineplex</a><br>';
echo '<a class="button" href="straight_page.php">Georgia Straight</a><br>';
echo '<a class="button" href="seatgeek_page.php">Seatgeak</a><br>';
echo '<a class="button" href="ticketfly_page.php">Ticketfly</a><br>';
echo '<a class="button" href="ticketRocket_page.php">TicketRocket</a><br>';
echo '<a class="button" href="viff_page.php">VIFF</a><br>';
echo '<a class="button" href="vso_page.php">VSO</a><br>';



//$straight = new Straight();
//$straight->scrapEvents();

//$ticketRocket = new TicketRocket();
//$ticketRocket->scrapEvents();

//$ticketfly	= new Ticketfly();
//$ticketfly->scrapEvents();

//$vso		= new Vso();
//$vso->scrapEvents();

//$viff		= new Viff();
//$viff->scrapEvents();

//$cineplex = new Cineplex();
//$cineplex->scrapEvents();

