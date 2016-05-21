<?php
include_once('/master.php');

// web scrapper for ticketrocket.co
class Viff extends Master
{
    function __construct()
    {
        parent::__construct('http://www.viff.org/theatre/now-playing-coming-soon', '', null);
    }

    public function scrapEvents()
    {
        $htmlCode 	= $this->getHtmlCode();
		$eventArray	= array();
		
		foreach($htmlCode->find('div#primary div.clearfix div.view-content div.views-field div.field-content a') as $article){
			$event			= new Event();
			// Going into the secondary (detailed) page
			$detailUrl		= $this->returnHrefOrNull($article, 'http://www.viff.org', '');
			if ($this->removeLocationLink($detailUrl)){
				$detailHtmlCode	= file_get_html($detailUrl);
				// event model variables
				$title 			= $this->returnInnertextOrNull($detailHtmlCode->find('div.film-title h1', 0), '', '');
				$subtitle		= null;
				$category		= null;//$this->returnInnertextOrNull($article->find('p.isawyou--details a', 0), '', '');
				$subcategory	= null;
				$description	= $this->returnInnertextOrNull($detailHtmlCode->find('div.film-synopsis', 0), '', '') . ' -www.viff.org';
				$picture 		= $this->returnSrcOrNull($detailHtmlCode->find('div.field-item img', 0), 'http://www.viff.org', '');
				$videoUrl		= null;
				$startDate		= $this->returnInnertextOrNull($detailHtmlCode->find('div.buy-ticket-date', 0), '', '');
				$endDate		= null;//$this->returnInnertextOrNull($article->find('p.event-day', 0), '', '');
				$startTime		= null;
				$address		= 'Vancity Theatre 1181 Seymour Street';
				$city			= 'Vancouver';//$this->explodeAddress($longAddress, 1);
				$province		= 'British Columbia';
				$postalCode		= 'V6B3M7';
				$ticketUrl		= $detailUrl;//$this->returnHrefOrNull($detailHtmlCode->find('div.event--links small a.button', 0), '', '');
				$ticketPrice	= null;//$this->returnInnertextOrNull($detailHtmlCode->find('section.box span', 0), '', '');
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
				// store event into array
				array_push($eventArray, $event);
			}
		}
		$this->setEventArray($eventArray);
		$this->storeEvents();
    }
	public function removeLocationLink($link){
		if (strcmp($link, 'http://www.viff.org/theatre/venues/vancity-theatre') == 0){
			return false;
		}
		else{
			return true;
		}
	}
}