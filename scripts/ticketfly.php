<?php
include_once('/master.php');

// web scrapper for ticketrocket.co
class Ticketfly extends Master
{
    function __construct()
    {
        parent::__construct('http://www.ticketfly.com/search/?q=Vancouver', '', null);
    }

    public function scrapEvents()
    {
        $htmlCode 	= $this->getHtmlCode();
		$eventArray	= array();
		
		foreach($htmlCode->find('li.list-view-item') as $article){
			$event			= new Event();
			$detailUrl		= $this->returnHrefOrNull($article->find('div.event-results-content a', 0), 'http://www.ticketfly.com/', '');;
			$detailHtmlCode	= file_get_html($detailUrl);
			// event model variables
			$title 			= $this->returnInnertextOrNull($detailHtmlCode->find('h1.headliners', 0), '', '');
			$subtitle		= $this->returnInnertextOrNull($detailHtmlCode->find('div.event-titles h3', 0), '', '');
			$category		= null;
			$subcategory	= null;
			$description	= $this->returnInnertextOrNull($detailHtmlCode->find('p.bio', 0), '', ' -www.ticketfly.com');
			$picture 		= $this->returnSrcOrNull($detailHtmlCode->find('img.photo', 0), 'http:', '');
			$videoUrl		= null;
			$startDate		= $this->returnInnertextOrNull($detailHtmlCode->find('p.event-date-day-of-week', 0), '', '') . ' ' . $this->returnInnertextOrNull($detailHtmlCode->find('p.event-date-month', 0), '', '') . ' ' . $this->returnInnertextOrNull($detailHtmlCode->find('p.event-date-day', 0), '', '');
			$endDate		= null;
			$startTime		= $this->returnInnertextOrNull($detailHtmlCode->find('p.event-start-time span', 0), '', '');
			$address		= $this->returnInnertextOrNull($detailHtmlCode->find('h5.venue a', 0), '', '') . ' ' . $this->returnInnertextOrNull($detailHtmlCode->find('p.city-state span.street-address', 0), '', '');
			$city			= $this->returnInnertextOrNull($detailHtmlCode->find('p.city-state span.locality', 0), '', '');
			$province		= $this->returnInnertextOrNull($detailHtmlCode->find('p.city-state span.region', 0), '', '');
			$postalCode		= $this->returnInnertextOrNull($detailHtmlCode->find('p.city-state span.postal-code', 0), '', '');
			$ticketUrl		= $this->returnHrefOrNull($detailHtmlCode->find('a.tickets', 0), '', '');
			$ticketPrice	= $this->returnInnertextOrNull($detailHtmlCode->find('p.event-tickets-price', 0), '', '');
			$sponsor		= $this->returnInnertextOrNull($detailHtmlCode->find('p.event-sponsor', 0), '', '');
			$age			= $this->returnInnertextOrNull($detailHtmlCode->find('p.age-restriction', 0), '', '');
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
		$this->setEventArray($eventArray);
		$this->storeEvents();
    }
}