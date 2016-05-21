<?php
include_once('/master.php');

// web scraper for eventful.com
class eventful extends Master
{
    function __construct()
    {
        parent::__construct('http://eventful.com/events/categories#!category=music&location=city_id%7C200160&subcategory=all&page_number=', '', 1);
    }

    public function scrapEvents()
    {
        $htmlCode = $this->getHtmlCode();
        $eventArray	= array();
        ini_set('max_execution_time', 900);

        while(count($htmlCode->find('li.clearfix')) != 0) {
            foreach ($htmlCode->find('li.clearfix') as $article) {
                $event = new Event();

                $detailUrl		= $this->returnHrefOrNull($article->find('li a', 0), '', '');
                $detailHtmlCode	= file_get_html($detailUrl);

                $title          = $this->returnInnertextOrNull($article->find('a span', 0), '', '');
                $subtitle       = null;
                $category		= 'Events';
                $subcategory    = 'Concerts';
                $description    = $this->returnInnertextOrNull($detailHtmlCode->find('p.description', 0), '', '') . ' -www.eventful.com';
                $picture 		= $this->returnSrcOrNull($detailHtmlCode->find('li a img', 0), '', '');
                $videoUrl       = null;
                $startDate      = $this->returnInnertextOrNull($detailHtmlCode->find('div.startDate', 0), '', '');
                $endDate        = $this->returnInnertextOrNull($detailHtmlCode->find('div.event-meta-details meta-details p span', 0), '', '');
                $startTime      = $this->returnInnertextOrNull($detailHtmlCode->find('div.event-meta-details meta-details p', 0), '', '');
                $address        = $this->returnInnertextOrNull($detailHtmlCode->find('span.streetAddress', 0), '', '');
                $city           = 'Victoria';
                $province       = 'British Columbia';
                $ticketUrl		= $this->returnHrefOrNull($detailHtmlCode->find('ul.tickets li a', 0), '', '');
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
        var_dump($eventArray);
    }

}