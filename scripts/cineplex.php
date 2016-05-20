<?php
include_once('/master.php');

// web scrapper for ticketrocket.co
class Cineplex extends Master
{
    function __construct()
    {
        parent::__construct('http://www.cineplex.com/Showtimes/any-movie/vancouver-bc', '', '0');
    }

    public function scrapEvents()
    {
        $htmlCode = $this->getHtmlCode();
        $eventArray	= array();
        ini_set('max_execution_time', 900);

        foreach ($htmlCode->find('div.showtime-single') as $movie) {
            $event = new Event();

            $title = $this->returnInnertextOrNull($movie->find('a.movie-details-link-click', 0), '', '');
            $subtitle = null;
            $category = 'Movie';
            $subcategory = null;
            $description = null;
            $picture = $this->returnSrcOrNull($movie->find('img.dbsmallposter', 0), '', '');
            $videoUrl = null;
            $startDate = $this->returnContentOrNull($movie->find('meta[itemprop=startDate]', 0), '', '');
            $endDate = null;
            $startTime = $this->returnInnerTextOrNull($movie->find('a.showtime', 0), '', '');
            $address = $this->returnContentOrNull($movie->find('meta[itemprop=address]', 0), '', '');
            $city = 'Vancouver';
            $province = 'British Columbia';
            $ticketUrl = 'www.cineplex.com' . ' ' . $this->returnHrefOrNull($movie->find('a.showtime', 0), '', '');;
            $ticketPrice = null;

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
        $htmlCode->clear();
        unset($htmlCode);
        var_dump($eventArray);
    }
}