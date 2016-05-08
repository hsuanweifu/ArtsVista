<?php
include_once('/master.php');

// web scrapper for straight.com
class Straight extends Master{
	function __construct() { 
		parent::__construct('http://www.straight.com/listings/arts?page=', '&text=', 0);
	}
	
	public function scrapEvents(){
		$htmlCode = $this->getHtmlCode();
		$eventArray;
		foreach($htmlCode->find('article.teaser') as $article){
			$title 		= $this->returnInnertextOrNull($article->find('h1 a', 0));
			$subtitle;
			$category	= $this->returnInnertextOrNull($article->find('p.isawyou--details a', 0));
			$subcategory;
			$description;
			$picture 	= $this->returnSrcOrNull($article->find('img', 0));
			$videoUrl;
			$startDate	= $this->returnInnertextOrNull($article->find('div.date-plate', 0));
			$endDate	= $this->returnInnertextOrNull($article->find('p.event-day', 0));
			$startTime;
			$address	= $this->returnInnertextOrNull($article->find('p.event--venue', 0));
			$city;
			$province;
			$ticketUrl;
			$ticketPrice;
			$category;
			echo $startDate;
			echo '<br>';
			echo 'http:'.$picture;
			echo '<br>';
			echo $title;
			echo '<br>';
			echo $address;
			echo '<br>';
			echo $endDate;
			echo '<br>';
			echo $category;
			echo '<br>';
			echo '<br>';
		}
	}
}
