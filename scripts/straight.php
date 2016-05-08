<?php
include_once('/master.php');

// web scrapper for straight.com
class Straight extends Master{
	function __construct() { 
		parent::__construct('http://www.straight.com/listings/arts?page=', '&text=', 0);
	}
	
	public function scrapEvents(){
		$event		= new Event();
		$htmlCode 	= $this->getHtmlCode();
		$eventArray;
		foreach($htmlCode->find('article.teaser') as $article){
			$title 		= $this->returnInnertextOrNull($article->find('h1 a', 0), '', '');
			$subtitle	= null;
			$category	= $this->returnInnertextOrNull($article->find('p.isawyou--details a', 0), '', '');
			$subcategory= null;
			$description;
			$picture 	= $this->returnSrcOrNull($article->find('img', 0), 'http:', '');
			$videoUrl	= null;
			$startDate	= $this->returnInnertextOrNull($article->find('div.date-plate', 0), '', '');
			$endDate	= $this->returnInnertextOrNull($article->find('p.event-day', 0), '', '');
			$startTime	= null;
			$address;
			$city;
			$province;
			$ticketUrl;
			$ticketPrice;
			// Going into the secondary (detailed) page
			$detailUrl		= 'http://www.straight.com' . $this->returnHrefOrNull($article->find('h1 a', 0), '', '');;
			$detailHtmlCode	= file_get_html($detailUrl);
			$longAddress	= $this->returnInnertextOrNull($detailHtmlCode->find('div.content-main header span a', 0), '', '') . ' '
							. $this->returnInnertextOrNull($detailHtmlCode->find('div.content-main header span span[itemprop=\'address\']', 0), '', '');
			$description	= $this->returnInnertextOrNull($detailHtmlCode->find('p', 0), '', '');
			$ticketUrl		= $this->returnHrefOrNull($detailHtmlCode->find('div.event--links small a.button', 0), '', '');
			$ticketPrice	= $this->returnInnertextOrNull($detailHtmlCode->find('section.box span', 0), '', '');

			///////////////////
			echo $startDate;
			echo '<br>';
			echo $picture;
			echo '<br>';
			echo $title;
			echo '<br>';
			//echo $address;
			echo '<br>';
			echo $endDate;
			echo '<br>';
			echo $category;
			echo '<br>';
			echo $detailUrl;
			echo '<br>';
			echo $description;
			echo '<br>';
			echo $longAddress;
			echo '<br>';
			echo $ticketUrl;
			echo '<br>';
			echo $ticketPrice;
			echo '<br>';
			echo '-------------------------------------------------------------<br>';
		}
	}
}
