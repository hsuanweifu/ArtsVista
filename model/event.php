<?php 
class Event { 
	private $title;
	private $subtitle;
	private $category;
	private $subcategory;
	private $description;
	private $picture;
	private $videoUrl;
	private $startDate;
	private $endDate;
	private $startTime;
	private $address;
	private $city;
	private $province;
	private $ticketUrl;
	private $ticketPrice;

	// constructor
	function __construct() { } 
	
	// getters
	public function getTitle(){
		return $this->title;
	}
	public function getSubtitle(){
		return $this->subtitle;
	}
	public function getCategory(){
		return $this->category;
	}
	public function getSubcategory(){
		return $this->subcategory;
	}
	public function getDescription(){
		return $this->description;
	}
	public function getPicture(){
		return $this->picture;
	}
	public function getVideoUrl(){
		return $this->videoUrl;
	}
	public function getStartDate(){
		return $this->startDate;
	}
	public function getEndDate(){
		return $this->endDate;
	}
	public function getStartTime(){
		return $this->startTime;
	}
	public function getAddress(){
		return $this->address;
	}
	public function getCity(){
		return $this->city;
	}
	public function getProvince(){
		return $this->province;
	}
	public function getTicketUrl(){
		return $this->ticketUrl;
	}
	public function getTicketPrice(){
		return $this->ticketPrice;
	}
	// setters
	public function setTitle($title){
		$this->title = $title;
	}
	public function setSubtitle($subtitle){
		$this->subtitle = $subtitle;
	}
	public function setCategory($category){
		$this->category = $category;
	}
	public function setSubcategory($subcategory){
		$this->subcategory = $subcategory;
	}
	public function setDescription($description){
		$this->description = $description;
	}
	public function setPicture($picture){
		$this->picture = $picture;
	}
	public function setVideoUrl($videoUrl){
		$this->videoUrl = $videoUrl;
	}
	public function setStartDate($startDate){
		$this->startDate = $startDate;
	}
	public function setEndDate($endDate){
		$this->endDate = $endDate;
	}
	public function setStartTime($startTime){
		$this->startTime = $startTime;
	}
	public function setAddress($address){
		$this->address = $address;
	}
	public function setCity($city){
		$this->city = $city;
	}
	public function setProvince($province){
		$this->province = $province;
	}
	public function setTicketUrl($ticketUrl){
		$this->ticketUrl = $ticketUrl;
	}
	public function setTicketPrice($ticketPrice){
		$this->ticketPrice = $ticketPrice;
	}

}
?>