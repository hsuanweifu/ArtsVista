<?php
include_once('/master.php');

// web scrapper for brownpaper.com
class Brownpaper extends Master
{
    function __construct()
    {
        parent::__construct('http://www.brownpapertickets.com/browse.html?&page=', '', 1);
    }

    public function scrapEvents()
    {
        $htmlCode = $this->getHtmlCode();
        $eventArray	= array();
        while(count($htmlCode->find('a.plainblack')) != 0) {
            foreach ($htmlCode->find('a.plainblack') as $article) {
                $event = new Event();

                $detailUrl		= $this->returnHrefOrNull($article, '', '');
                $detailHtmlCode	= file_get_html($detailUrl);

                if (is_bool($detailHtmlCode) == true)
                    continue;

                $title          = $this->returnInnertextOrNull($detailHtmlCode->find('td[valign=TOP] div[style*=font-size]', 0), '', '');
                $subtitle       = null;
                $category		= $this->returnInnertextOrNull($detailHtmlCode->find('div[style*=font-weight] table tbody tr td a', 0), '', '');
                $subcategory    = $this->returnInnertextOrNull($detailHtmlCode->find('div[style*=font-weight] table tbody tr td a', 1), '', '');;
                $description    = $this->returnInnertextOrNull($detailHtmlCode->find('td[valign=TOP]', 9), '', '') . ' -www.brownpapertickets.com';
                $picture 		= 'www.brownpapertickets.com' . $this->returnSrcOrNull($detailHtmlCode->find('img', 0), '', '');
                $videoUrl       = $this->returnValueOrNull($detailHtmlCode->find('param[name=movie]', 0), '', '');;;
				$date           = null;
                $time           = null;
                if (count($detailHtmlCode->find('select[name=date_id]')) != 0) {
                    $date = explode(",", $this->returnInnertextOrNull($detailHtmlCode->find('select[name=date_id]', 0), '', ''));
                }
                if (count($detailHtmlCode->find('td.bpt_widget_date')) != 0) {
                    $date = explode(",", $this->returnInnertextOrNull($detailHtmlCode->find('td.bpt_widget_date', 0), '', ''));
                }

                $time = explode(" ", $date[1]);

                $startDate      = $date[0];
                $endDate        = null;
                $startTime      = $time[2] . " " . $time[3];

                $locationString = $this->returnInnertextOrNull($detailHtmlCode->find('td[valign=TOP]', 10), '', '');
                $location       = null;
                preg_match("/\(View\)(.*)Vancouver|Victoria/", $locationString, $location);
                $address        = 'error';//$location[1];
                preg_match("/Vancouver|Victoria/", $locationString, $location);
                $city           = 'error';//$location[0];
                $province       = 'BC';

                $ticketUrl		= $detailUrl;
                $ticketPrice    = null;
				
				$ticketUrl  = 'http://www.brownpapertickets.com/ref/1730358/event/' . $this->returnValueOrNull($detailHtmlCode->find('input[name=event_id]', 0), '', '');


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

                array_push($eventArray, $event);
            }
            $this->nextPage();
            $htmlCode 	= $this->getHtmlCode();
        }
        $this->setEventArray($eventArray);
		$this->storeEvents();
    }
}
