<?php
include_once('/master.php');

// web scrapper for ticketrocket.co
class TicketRocket extends Master
{
    function __construct()
    {
        parent::__construct('http://www.ticketrocket.co/search/events/2/arts-theatre?page=', '', 1);
    }

    public function scrapEvents()
    {
        $htmlCode = $this->getHtmlCode();
        $eventArray	= array();
        ini_set('max_execution_time', 900);

        while(count($htmlCode->find('tr.searchResults_row')) != 0) {
            foreach ($htmlCode->find('tr.searchResults_row') as $article) {
                $event = new Event();

                $detailUrl		= 'http://www.ticketrocket.co' . $this->returnHrefOrNull($article->find('td a', 0), '', '');;
                $detailHtmlCode	= file_get_html($detailUrl);

                $title          = $this->returnInnertextOrNull($article->find('a.resultTitle', 0), '', '');
                $subtitle       = null;
                $category		= 'Arts & Theatre';
                $subcategory    = null;
                $searchDescription = $detailHtmlCode->find('div.EventNotes p');
                $description    = $this->returnInnertextOrNull($detailHtmlCode->find('div.EventNotes p', sizeof($searchDescription) - 5), '', '') . ' -www.ticketrocket.co';
                $picture 		= 'http://www.ticketrocket.co' . $this->returnSrcOrNull($detailHtmlCode->find('div.image img', 0), '', '');
                $videoUrl       = null;
                // separate TicketRocket's time/day of week/day/month/year format into the $date variable
                $date           = explode(",", $this->returnInnertextOrNull($article->find('td.date', 0), '', ''));
                $startDate      = $date[1] . ', ' . $date[2];
                $endDate        = null;
                $startTime      = $date[0];
                // separate TicketRocket's location format into the $location variable
                $location       = explode(",", $this->returnInnertextOrNull($article->find('td b', 0), '', ''));
                $address        = $location[1];
                $city           = $location[2];
                $province       = 'British Columbia';
                $ticketUrl		= $this->returnActionOrNull($detailHtmlCode->find('div.bar form', 0), '', '');
                $ticketPrice    = null;

                $event->setTitle($title);
                $event->setSubtitle($subtitle);
                $event->setCategory($category);
                $event->setSubcategory($subcategory);
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

                array_push($eventArray, $event);
            }
            $this->nextPage();
            $htmlCode 	= $this->getHtmlCode();
        }
		$this->setEventArray($eventArray);
		$this->storeEvents();
    }
}