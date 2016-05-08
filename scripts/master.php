<?php
include_once('./simple_html_dom.php');
include_once('./model/event.php');

// master(parent) web scrapper class for artsvista.com
class Master {
	private $frontUrl;
	private $backUrl;
	private $page;
	private $eventArray;
	private $htmlCode;
	
	/**
	*	insert '' to $backUrl and $page if empty
	*/
	function __construct($frontUrl, $backUrl, $page) { 
		$this->frontUrl 	= $frontUrl;
		$this->backUrl 		= $backUrl;
		$this->page			= $page;
		$this->setHtmlCode();
	}
	
	// getters
	public function getFrontHtml(){
		return $this->frontHtml;
	}
	public function getBackHtml(){
		return $this->backHtml;
	}
	public function getPage(){
		return $this->page;
	}
	public function getEventArray(){
		return $this->eventArray;
	}
	public function getHtmlCode(){
		return $this->htmlCode;
	}
	// setters
	public function setFrontHtml($frontHtml){
		$this->frontHtml = $frontHtml;
	}
	public function setBackHtml($backHtml){
		$this->backHtml = $backHtml;
	}
	public function setPage($page){
		$this->page = $page;
	}
	public function setEventArray($eventArray){
		$this->eventArray = $eventArray;
	}
	public function setHtmlCode(){
		$this->htmlCode = file_get_html($this->frontUrl . $this->page . $this->backUrl);
	}
	// next page
	public function nextPage(){
		$this->page = $this->page + 1;
		$this->setHtmlCode();
	}
	// returns
	public function returnInnertextOrNull($variable, $frontAttach, $backAttach){
		if ($variable == null){
			return null;
		}
		else {
			return strip_tags($frontAttach . $variable->innertext . $backAttach);
		}
	}
	public function returnSrcOrNull($variable, $frontAttach, $backAttach){
		if ($variable == null){
			return null;
		}
		else {
			return strip_tags($frontAttach . $variable->src . $backAttach);
		}
	}
	public function returnHrefOrNull($variable, $frontAttach, $backAttach){
		if ($variable == null){
			return null;
		}
		else {
			return strip_tags($frontAttach . $variable->href . $backAttach);
		}
	}
	public function scrapEvents(){}
	public function storeEvents(){} // to be implemented to database
}