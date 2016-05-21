<?php
include_once('./simple_html_dom.php');
include_once('./model/event.php');

// master(parent) web scrapper class for artsvista.com
class Master {
	private $frontUrl;
	private $backUrl;
	private $page;
	private $eventArray = array();
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
	public function returnActionOrNull($variable, $frontAttach, $backAttach) {
		if ($variable == null) {
			return null;
		} else {
			return strip_tags($frontAttach . $variable->action . $backAttach);
		}
	}
    public function returnValueOrNull($variable, $frontAttach, $backAttach) {
        if ($variable == null) {
            return null;
        } else {
            return strip_tags($frontAttach . $variable->value . $backAttach);
        }
    }
	public function returnContentOrNull($variable, $frontAttach, $backAttach) {
		if ($variable == null) {
			return null;
		} else {
			return strip_tags($frontAttach . $variable->content . $backAttach);
		}
	}
	public function returnText($variable){
		if ($variable == null){
			return 'null';
		}
		else {
			return '"' . str_replace('"','\"', $variable) . '"';
		}
	}
	public function returnEqualVariableOrIsNull($variable){
		if ($variable == null){
			return 'IS null';
		}
		else {
			return '= "' . str_replace('"','\"', $variable) . '"';
		}
	}
	public function returnVariableOrNull($variable){
		if ($variable == null){
			return 'null';
		}
		else {
			return str_replace('"','\"', $variable);
		}
	}

	public function scrapEvents(){}
	// database
	public function storeEvents(){
		$servername = "localhost";
		$username 	= "root";
		$password 	= "rf26473156";
		$dbname 	= "artsvista_scrap";


		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);

		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 
		echo "Connected successfully";

		foreach($this->eventArray as $event){
			$eventId 	= $this->insertEvents($conn, $event);
			$venueId 	= $this->insertVenues($conn, $event, $eventId);
			$timeId		= $this->insertTimes($conn, $event, $eventId, $venueId);
		}
		
		//echo mysqli_insert_id($conn);

		$conn->close();
	}
	public function insertEvents($conn, $event){
		$validation	= $this->findEvent($conn, $event->getTitle(), $event->getSubtitle(), $event->getCategory(), $event->getSubcategory());
		if ($validation->num_rows > 0){
			echo 'entry already exist<br>';
			$row 	= $validation->fetch_assoc();
			$id 	= $row['eventId'];
			
			if ($row['description'] ==  null){
				$row['description'] = $event->getDescription();
			}
			if ($row['picture'] ==  null){
				$row['picture'] = $event->getPicture();
			}
			if ($row['videoUrl'] ==  null){
				$row['videoUrl'] = $event->getVideoUrl();
			}
			
			$sql = 'UPDATE events 
					SET description="' . $this->returnVariableOrNull($row['description']) . '", picture="' . $this->returnVariableOrNull($row['picture']) . '", videoUrl="' . $this->returnVariableOrNull($row['videoUrl']) . '"
					WHERE eventId=' . $id;

			if ($conn->query($sql) === TRUE) {
				echo "Record updated successfully";
			} else {
				echo "Error updating record: " . $conn->error;
			}

			return $id;
		}
		else {
			$sql = 'INSERT INTO events (title, subtitle, category, subcategory, description, picture, videoUrl)
			VALUES (' 
			. $this->returnText($event->getTitle()) 		. ','
			. $this->returnText($event->getSubtitle())		. ','
			. $this->returnText($event->getCategory()) 		. ','
			. $this->returnText($event->getSubcategory()) 	. ','
			. $this->returnText($event->getDescription()) 	. ','
			. $this->returnText($event->getPicture()) 		. ','
			. $this->returnText($event->getVideoUrl()) 		. ')';

			if ($conn->query($sql) === TRUE) {
				echo "New record created successfully";
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
			return mysqli_insert_id($conn);
		}
	}
	public function insertTimes($conn, $event, $eventId, $venueId){
		$validation	= $this->findTime($conn, $eventId, $venueId, $event->getStartDate(), $event->getEndDate());
		if ($validation->num_rows > 0){
			echo 'entry already exist<br>';
			$row 	= $validation->fetch_assoc();
			$id 	= $row["timeId"];
			
			if ($row['startTime'] ==  null){
				$row['startTime'] = $event->getStartTime();
			}
			
			$sql = 'UPDATE times			
					SET startTime="' . $this->returnVariableOrNull($row['startTime']) . '"
					WHERE timeId=' . $id;

			if ($conn->query($sql) === TRUE) {
				echo "Record updated successfully";
			} else {
				echo "Error updating record: " . $conn->error;
			}
			
			return $id;
		}
		else {
			$sql = 'INSERT INTO times (eventId, venueId, startDate, endDate, startTime)
			VALUES ('
			. $eventId									. ','
			. $venueId							 		. ','
			. $this->returnText($event->getStartDate()) . ','
			. $this->returnText($event->getEndDate())	. ','
			. $this->returnText($event->getStartTime()) . ')';

			if ($conn->query($sql) === TRUE) {
				echo "New record created successfully";
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
			return mysqli_insert_id($conn);
		}
	}
	public function insertVenues($conn, $event, $eventId){
		$validation	= $this->findVenue($conn, $eventId, $event->getAddress(), $event->getCity());
		if ($validation->num_rows > 0){
			echo 'entry already exist<br>';
			$row 	= $validation->fetch_assoc();
			$id 	= $row["venueId"];
			
			if ($row['province'] ==  null){
				$row['province'] = $event->getProvince();
			}
			if ($row['ticketUrl'] ==  null){
				$row['ticketUrl'] = $event->getTicketUrl();
			}
			if ($row['ticketPrice'] ==  null){
				$row['ticketPrice'] = $event->getTicketPrice();
			}
			
			$sql = 'UPDATE venues 
					SET province="' . $this->returnVariableOrNull($row['province']) . '", ticketUrl="' . $this->returnVariableOrNull($row['ticketUrl']) . '", ticketPrice="' . $this->returnVariableOrNull($row['ticketPrice']) . '"
					WHERE venueId=' . $id;

			if ($conn->query($sql) === TRUE) {
				echo "Record updated successfully<br>";
			} else {
				echo "Error updating record: " . $conn->error;
			}
			
			return $id;
		}
		else {
			$sql = 'INSERT INTO venues (eventId, address, city, province, ticketUrl, ticketPrice)
			VALUES ('
			. $eventId 										. ','
			. $this->returnText($event->getAddress()) 		. ','
			. $this->returnText($event->getCity()) 			. ','
			. $this->returnText($event->getProvince()) 		. ','
			. $this->returnText($event->getTicketUrl()) 	. ','
			. $this->returnText($event->getTicketPrice()) 	. ')';

			if ($conn->query($sql) === TRUE) {
				echo "New record created successfully";
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
			return mysqli_insert_id($conn);
		}
	}
	public function findEvent($conn, $title, $subtitle, $category, $subcategory){
		$sql = 'SELECT 	*
				FROM 	events
				WHERE 	title 		' . $this->returnEqualVariableOrIsNull($title)		. '
				AND		subtitle	' . $this->returnEqualVariableOrIsNull($subtitle)	. '
				AND		category	' . $this->returnEqualVariableOrIsNull($category) 	. '
				AND 	subcategory ' . $this->returnEqualVariableOrIsNull($subcategory);

		$result = $conn->query($sql);
		
		return $result;
	}
	public function findTime($conn, $eventId, $venueId, $startDate, $endDate){
		$sql = 'SELECT 	*
				FROM 	times
				WHERE 	eventId 	' . $this->returnEqualVariableOrIsNull($eventId)	. '
				AND		venueId		' . $this->returnEqualVariableOrIsNull($venueId)	. '
				AND		startDate	' . $this->returnEqualVariableOrIsNull($startDate) 	. '
				AND 	endDate 	' . $this->returnEqualVariableOrIsNull($endDate);

		$result = $conn->query($sql);
		
		return $result;
	}
	public function findVenue($conn, $eventId, $address, $city){
		$sql = 'SELECT 	*
				FROM 	venues
				WHERE 	eventId 	' . $this->returnEqualVariableOrIsNull($eventId)	. '
				AND		address		' . $this->returnEqualVariableOrIsNull($address)	. '
				AND		city		' . $this->returnEqualVariableOrIsNull($city);
		$result = $conn->query($sql);
		
		return $result;
	}
}