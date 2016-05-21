<?php
include_once('/master.php');

// web scrapper for ticketrocket.co
class Vso extends Master
{
    function __construct()
    {
        parent::__construct('http://www.vancouversymphony.ca/calendar/2016/', '/', 5);
    }

    public function scrapEvents()
    {
        $htmlCode 	= $this->getHtmlCode();
		$eventArray	= array();
		do{
			foreach($htmlCode->find('#big-calendar table tr[valign] td a') as $article){
				$event			= new Event();
				$detailUrl		= $this->returnHrefOrNull($article, 'http://www.vancouversymphony.ca', '');;
				$detailHtmlCode	= file_get_html($detailUrl);
				///////////////////
				$title 			= $this->returnInnertextOrNull($detailHtmlCode->find('div.gutter3 h1', 0), '', '');
				$subtitle		= null;//$this->returnInnertextOrNull($detailHtmlCode->find('div.event-titles h3', 0), '', '');
				$category		= 'not present';
				$subcategory	= null;
				$description	= $this->returnInnertextOrNull($detailHtmlCode->find('div.gutter3 p.p1', 0), '', ' -Vancouver Symphony Orchestra');
				$picture 		= null;//$this->returnSrcOrNull($detailHtmlCode->find('img.photo', 0), 'http:', '');
				$videoUrl		= null;
				$startDate		= 'difficult to scrap';//$this->returnInnertextOrNull($detailHtmlCode->find('div[id=performance-holder]', 1), '', '');
				$endDate		= 'difficult to scrap';
				$startTime		= 'difficult to scrap';//$this->returnInnertextOrNull($detailHtmlCode->find('p.event-start-time span', 0), '', '');
				$address		= 'difficult to scrap';//$this->returnInnertextOrNull($detailHtmlCode->find('h5.venue a', 0), '', '') . ' ' . $this->returnInnertextOrNull($detailHtmlCode->find('p.city-state span.street-address', 0), '', '');
				$city			= 'Vancouver';//$this->returnInnertextOrNull($detailHtmlCode->find('p.city-state span.locality', 0), '', '');
				$province		= 'British Columbia';//$this->returnInnertextOrNull($detailHtmlCode->find('p.city-state span.region', 0), '', '');
				$postalCode		= null;//$this->returnInnertextOrNull($detailHtmlCode->find('p.city-state span.postal-code', 0), '', '');
				$ticketUrl		= $detailUrl;//$this->returnHrefOrNull($detailHtmlCode->find('a.tickets', 0), '', '');
				$ticketPrice	= null;//$this->returnInnertextOrNull($detailHtmlCode->find('p.event-tickets-price', 0), '', '');
				$sponsor		= null;//$this->returnInnertextOrNull($detailHtmlCode->find('p.event-sponsor', 0), '', '');
				$age			= null;//$this->returnInnertextOrNull($detailHtmlCode->find('p.age-restriction', 0), '', '');
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
				$event->setPostalCode($postalCode);
				$event->setTicketUrl($ticketUrl);
				$event->setTicketPrice($ticketPrice);
				$event->setSponsor($sponsor);
				$event->setAge($age);
				// store event into array
				array_push($eventArray, $event);
			}
			$this->nextPage();
			$htmlCode 	= $this->getHtmlCode();
		}while($this->getPage() < 12);
		$this->setEventArray($eventArray);
		$this->storeEvents();
    }
}