<?php

require_once ($fullPath.'/classes/dbConn.class.php');

class listing {
	
	var $id;
	var $type;
	var $title;
	var $description;
	var $quantity;
	var $startPrice;
	var $postage;
	var $duration;
	var $photos;

	function listing($data) {
		
		$this->id = (isset($data['listingID'])) ? $data['listingID'] : "";
		$this->type = (isset($data['listingType'])) ? $data['listingType'] : "";
		$this->title = (isset($data['listingTitle'])) ? $data['listingTitle'] : "";  
		$this->description = (isset($data['listingDescription'])) ? $data['listingDescription'] : "";
		$this->quantity = (isset($data['listingQuantity'])) ? $data['listingQuantity'] : "";
		$this->startPrice = (isset($data['listingStartPrice'])) ? $data['listingStartPrice'] : "";
		$this->postage = (isset($data['listingPostage'])) ? $data['listingPostage'] : "";
		$this->duration = (isset($data['listingDuration'])) ? $data['listingDuration'] : "";
		$this->photos = (isset($data['listingPhotos'])) ? $data['listingPhotos'] : "";

	}
	
	public function update($data) {

		$db = new dbConn();

		$db->update("listings","listingTitle='".$data->getTitle()."'","listingID=".$data->getID(),0);
		$db->update("listings","listingType='".$data->getType()."'","listingType=".$data->getID(),0);
		$db->update("listings","listingDescription='".$data->getDescription()."'","listingID=".$data->getID(),0);
		$db->update("listings","listingQuantity='".$data->getQuantity()."'","listingID=".$data->getID(),0);
		$db->update("listings","listingStartPrice='".$data->getStartPrice()."'","listingID=".$data->getID(),0);
		$db->update("listings","listingPostage='".$data->getPostage()."'","listingID=".$data->getID(),0);
		$db->update("listings","listingDuration='".$data->getDuration()."'","listingID=".$data->getID(),0);
		$db->update("listings","listingPhotos='".$data->getPhotos()."'","listingID=".$data->getID(),0);

		$listingTools = new listingTools();

		$listingTools->moveTempPhotos($data->getID(),$data->getPhotos());

		return 1;

	}
	
	public function getID() {
		
		return $this->id;
	
	}

	public function getType() {

		return $this->type;

	}

	public function getTitle() {

		return $this->title;

	}

	public function getDescription() {

		return $this->description;

	}

	public function getQuantity() {

		return $this->quantity;

	}

	public function getStartPrice() {

		return $this->startPrice;

	}

	public function getPostage() {

		return $this->postage;

	}

	public function getDuration() {

		return $this->duration;

	}

	public function getPhotos() {

		return $this->photos;

	}

	public function isAuction() {

		if ($this->type == 1) {

			return 1;

		}

		else {

			return 0;

		}

	}

}

class runningListing extends listing {

	var $endDate;
	var $startDate;
	var $reservePrice;
	var $listingRunning;
	
	function runningListing($data) {
		
		parent::listing($data);

		$this->id = $data['runningListingID'];
		$this->startDate = (isset($data['startDate']) ? $data['startDate'] : "");
		$this->endDate = $data['endDate'];
		$this->listingRunning = $data['listingRunning'];
		$this->quantity = $data['listingQuantity'];

	}

	public function getTimeRemaining() {

		$listingTools = new listingTools();

		$timeNow = time();

		return $listingTools->calcTimeRemaining($timeNow, $this->endDate);

	}
	
  function getListingRunning() {

		return $this->listingRunning;

	}

	function getLowestBidAmount() {

		$minIncrement = round(($this->startPrice / 100 * 5) * 100);

		if ($minIncrement < 10) {

			$minIncrement = 10;

		}

		return $minIncrement/100;

	}

	function getHighestBid() {

		$db = new dbConn();

		$query=("SELECT bids.bidAmount,
										bids.bidID,
										runningListings.listingStartPrice,
										members.username 
						 FROM bids, 
						 			members,
									runningListings 
						 WHERE (bids.listingID=".$this->id." AND 
						 			 bids.memberID = members.memberID) AND 
									 runningListings.runningListingID = ".$this->id."
						 ORDER BY bids.bidAmount DESC,
						 					bids.bidID ASC 
						 LIMIT 3;");

		$result = $db->mysqli->query($query);

		for ($i=0; $i<3; $i++) {

			$row[$i] = $result->fetch_assoc();

		}
		

		if ($result->num_rows < 1 ) {
		
			$array['currentPrice'] = $this->getStartPrice();

			return $array;

		}

		else if ($result->num_rows == 1) {

			$array['username'] = $row[0]['username'];
			$array['currentPrice'] = $this->getStartPrice();

			return $array;

		}

		else {

			$array['username'] = $row[0]['username'];

			if ((round($row[0]['bidAmount'],2) >= round($row[1]['bidAmount'],2)) && 
							(round($row[1]['bidAmount'],2) != round($row[2]['bidAmount'],2))) {
					
				$array['currentPrice'] = $row[1]['bidAmount'];

			}

			else {

				$array['currentPrice'] = $row[1]['bidAmount'] + $this->getLowestBidAmount();

			}

			return $array;

		} 
	}

	function reduceQuantity($amount) {

		$db = new dbConn();

		$newAmount = $this->quantity - $amount;

		if ($db->update("runningListings","listingQuantity=".$newAmount."","runningListingID=".$this->id."",0)) {

			return true;

		} else {
			
			return false;
		}

	}

	function getSeller() {

		$db = new dbConn();

		$query = "SELECT members.username 
								FROM members,runningListings 
								WHERE members.memberID = runningListings.memberID AND
									runningListingID = ".$this->getID();

		$result = $db->mysqli->query($query);

		$data = $result->fetch_assoc();

		return $data['username'];

	}

}

?>
