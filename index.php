<?php
include_once('scripts/straight.php');
include_once('scripts/ticketRocket.php');
include_once('scripts/eventful.php');

/*
$straight = new Straight();
$straight->scrapEvents();
*/

/*
$TicketRocket = new TicketRocket();
$TicketRocket->scrapEvents();
*/

$brownpaper = new Brownpaper();
$brownpaper->scrapEvents();

//$straight->storeEvents();
/*
for ($i = 0; $i < 3; $i++){
	$html= file_get_html('http://www.straight.com/listings/arts?page='.$i.'&text=');
	foreach($html->find('article.teaser') as $article){
		foreach($article->find('div.date-plate') as $date){
			echo $date->innertext;
			echo '<br>';
		}
		foreach($article->find('img') as $image){
			echo 'http:'.$image->src;			
			echo '<br>';
		}
		foreach($article->find('h1 a') as $title){
			echo $title->innertext;
			echo '<br>';
		}
		foreach($article->find('p.event--venue') as $location){
			echo $location->innertext;
			echo '<br>';
		}
		foreach($article->find('p.event-day') as $end_date){
			echo $end_date->innertext;
			echo '<br>';
		}
		echo '<br>';
	}
}*/