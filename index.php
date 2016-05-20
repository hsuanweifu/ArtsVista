<?php
include_once('scripts/straight.php');
include_once('scripts/ticketRocket.php');
include_once('scripts/brownpaper.php');
include_once('scripts/cineplex.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$cineplex = new Cineplex();
$cineplex->scrapEvents();

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