<?php
include_once('/master.php');

// web scrapper for straight.com
class Straight extends Master{
	function __construct() { 
		parent::__construct('http://www.straight.com/listings/arts?page=', '&text=', 0);
	}
	
	public function scrapEvents(){
		$htmlCode 	= $this->getHtmlCode();
		$eventArray	= array();

		while(count($htmlCode->find('article.teaser')) != 0){
			foreach($htmlCode->find('article.teaser') as $article){
				$event			= new Event();
				// Going into the secondary (detailed) page
				$detailUrl		= $this->returnHrefOrNull($article->find('h1 a', 0), 'http://www.straight.com', '');;
				$detailHtmlCode	= file_get_html($detailUrl);
				$longAddress	= $this->returnInnertextOrNull($detailHtmlCode->find('div.content-main header span a', 0), '', '') . ' '
								. $this->returnInnertextOrNull($detailHtmlCode->find('div.content-main header span span[itemprop=\'address\']', 0), '', '');
				// event model variables
				$title 			= $this->returnInnertextOrNull($article->find('h1 a', 0), '', '');
				$subtitle		= null;
				$category		= $this->returnInnertextOrNull($article->find('p.isawyou--details a', 0), '', '');
				$subcategory	= null;
				$description	= $this->returnInnertextOrNull($detailHtmlCode->find('p', 0), '', '') . ' -www.straight.com';
				$picture 		= $this->returnSrcOrNull($article->find('img', 0), 'http:', '');
				$videoUrl		= null;
				$startDate		= $this->returnInnertextOrNull($article->find('div.date-plate', 0), '', '');
				$endDate		= $this->returnInnertextOrNull($article->find('p.event-day', 0), '', '');
				$startTime		= null;
				$address		= $this->explodeAddress($longAddress, 0);
				$city			= $this->explodeAddress($longAddress, 1);
				$province		= 'British Columbia';
				$ticketUrl		= $this->returnHrefOrNull($detailHtmlCode->find('div.event--links small a.button', 0), '', '');
				$ticketPrice	= $this->returnInnertextOrNull($detailHtmlCode->find('section.box span', 0), '', '');
				// store in event model
				$event->setTitle($title);
				$event->setSubtitle($subtitle);
				$event->setCategory($category);
				$event->setSubCategory($subcategory);
				$event->setDescription($description);
				$event->setPicture($picture);
				$event->setVideoUrl($videoUrl);
				$event->setStartDate($startDate);
				$event->setEndDate($endDate);
				$event->setStartTime($startTime);
				$event->setAddress($address);
				$event->setCity($city);
				$event->setProvince($province);
				$event->setTicketUrl($ticketUrl);
				$event->setTicketPrice($ticketPrice);
				// store event into array
				array_push($eventArray, $event);
			}
			$this->nextPage();
			$htmlCode 	= $this->getHtmlCode();
		}
		$this->setEventArray($eventArray);
		$this->storeEvents();
	}
	public function explodeAddress($longAddress, $i){
		if($i == 0){
			return explode(',', $longAddress)[0];
		}
		else if(count(explode(',', $longAddress)) > 1)
		{
			return explode(',', $longAddress)[1];
		}else 
		{
			return null;
		}
	}
}
