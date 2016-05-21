<?php
include_once('/master.php');

// web scrapper for ticketrocket.co
class Eventbrite extends Master
{
    function __construct()
    {
        parent::__construct('https://www.eventbrite.com/d/canada--vancouver/arts--events/?crt=regular&page=', '&sort=best&view=list', 1);
    }

    public function scrapEvents()
    {
        $htmlCode = $this->getHtmlCode();
        echo $htmlCode;
    }
}