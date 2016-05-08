<?php
include_once('./simple_html_dom.php');
include_once('./model/event.php');

// master(parent) web scrapper class for artsvista.com
class Master {
	private $frontHtml;
	private $backHtml;
	private $page;
	private $eventArray;
	private $htmlCode;
	
	/**
	*	insert '' to $backHtml and $page if empty
	*/
	function __construct($frontHtml, $backHtml, $page) { 
		$this->frontHtml 	= $frontHtml;
		$this->backHtml 	= $backHtml;
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
		$this->htmlCode = file_get_html($this->frontHtml . $this->page . $this->backHtml);
	}
	public function returnInnertextOrNull($variable){
		if ($variable == null){
			return null;
		}
		else {
			return $variable->innertext;
		}
	}
	public function returnSrcOrNull($variable){
		if ($variable == null){
			return null;
		}
		else {
			return $variable->src;
		}
	}
	public function scrapEvents(){}
	public function storeEvents(){} // to be implemented to database
}