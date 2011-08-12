<?php
	
	require_once($fullPath."/auction/classes/listing.class.php");
	require_once($fullPath."/classes/dbConn.class.php");
	require_once($fullPath."/membership/classes/member.class.php");

	class listingTools {

		public function getDynamicContentID() {

			$db = new dbConn();

			$result = $db->selectWhere("dContentID","dContent","directLink='auction/index.php'",0);

			$row = $result->fetch_assoc();

			return $row['dContentID'];

		}

		public function getRunningListingObject($id) {

			$db = new dbConn();

			$result = $db->selectWhere("*", "runningListings", "runningListingID=".$id,0);

			return new runningListing($result->fetch_assoc());

		}
		
		public function loadExistingListing($id, $session) {

			$db = new dbConn();

			$result = $db->selectWhere("*", "listings", "listingID=".$id, 0);

			if ($session == TRUE) {

				$this->loadListingSession($result->fetch_assoc());

			}

			else {

				return serialize(new listing($result->fetch_assoc()));

			}

		}

		public function loadListingSession($data) {

			$_SESSION['listing'] = serialize(new listing($data));

		}

		public function deleteListing($id) {

			$db = new dbConn();

			$db->delete("listings","listingID=".$id);

		}

		public function saveListing($listing) {

			$member = unserialize($_SESSION['member']);

			$db = new dbConn();

			$db->insert("listings",
									"memberID,
									 listingType,
									 listingTitle,
									 listingDescription,
								   listingPostage,
									 listingQuantity,
									 listingStartPrice,
									 listingDuration",
									"'".$member->getID()."',
									'".$listing->getType()."',
									'".$listing->getTitle()."',
									'".$listing->getDescription()."',
									'".$listing->getPostage()."',
									'".$listing->getQuantity()."',
									'".$listing->getStartPrice()."',
									'".$listing->getDuration()."'",
									0
									);			

			return $db->mysqli->insert_id;

		}

		public function publishListing($listing) {

			$db = new dbConn();

			$member = unserialize($_SESSION['member']);

			$startTime = time();
			$endTime = (time() + ($listing->getDuration() * 24 * 60 * 60));

			$db->insert("runningListings",
									"memberID,
									startDate,
									endDate,
									listingType,
									listingQuantity,
									listingStartPrice,
									listingTitle,
									listingDescription,
									listingPostage,
									listingRunning",
									"".$member->getID().",
									".$startTime.",
									".$endTime.",
									".$listing->getType().",
									".$listing->getQuantity().",
									".$listing->getStartPrice().",
									'".$listing->getTitle()."',
									'".$listing->getDescription()."',
									'".$listing->getPostage()."',
									1",
									0
								);

		}

		public function newBid($id, $amount) {
	
			$db = new dbConn();

			$timeNow = time();

			$member = unserialize($_SESSION['member']);

			$runningListing = $this->getRunningListingObject($id);

			$highestBidInfo = $runningListing->getHighestBid();

			if (($runningListing->getLowestBidAmount()+$highestBidInfo['bidAmount']) > $amount) {

			}

			else {

				$db->insert("bids",
										"listingID,
										memberID,
										bidAmount,
										bidDate",
										"".$id.",
										".$member->getID().",
										".$amount.",
										".$timeNow,
										0 );

			}

		}

		public function newPurchase($id) {
	
			$db = new dbConn();

			$timeNow = time();

			$member = unserialize($_SESSION['member']);

			$runningListing = $this->getRunningListingObject($id);

			$db->insert("purchases",
									"listingID,
									memberID,
									purchaseDate",
									"".$id.",
									".$member->getID().",
									".$timeNow,
									0 );

			if (($runningListing->getQuantity() -1)  == 0) {

				$runningListing->reduceQuantity(1);
				$this->stopRunningListing($id);

			}

		}

		public function stopRunningListing($id) {

			$db = new dbConn();

			$db->update("runningListings","listingRunning=0","runningListingID=".$id,0);

		}

		public function startStoppedListing($id) {

			$db = new dbConn();

			$db->update("runningListings","listingRunning=1","runningListingID=".$id,0);

		}

		public function unsetListing() {

			unset($_SESSION['listing']);

		}

		public function renderLinks() {

			$db = new dbConn();

			$result = $db->selectWhere("linkName,destination","memberLinks","category='Listing Tools'",0);

			while ($row=$result->fetch_assoc()) {

				echo("<li><a href='".$row['destination']."'>".$row['linkName']."</a></li>");

			}
		
		}

		public function calcTimeRemaining($start, $end) {

			$time = $end - $start;

			if ($time <= 0) {

				return "Finished!";

			}

			$days = floor($time/86400); 
			$time = $time - ($days*86400); 
			$hours = floor($time/3600); 
			$time = $time - ($hours*3600); 
			$min = floor($time/60); 
			$sec = $time - ($min*60); 

			return $days."d ".$hours."h ".$min."m";

		}

		public function renderListing($listing) {

			if($listing->isAuction()) { 
				$output  = "<form method='post' action='confirmBid.php'>";
			}
			else {
				$output = "<form method='post' action='confirmPurchase.php'>";
			}
			$output .= "<input type='hidden' name='listingID' value='".$listing->getID()."' />";
			$output .= "<table>";
			$output .= "<tr>";
			$output .= "<td>Listing ID: ".$listing->getID()."</td>";
			$output .= "</tr>";
			$output .= "<tr>";
			$output .= "<td>".$listing->getTitle()."</td>";
			$output .= "</tr>";
			$output .= "<tr>";
			$output .= "<td>".$listing->getDescription()."</td>";
			$output .= "</tr>";
			$output .= "<tr>";
			$output .= "<td>";

			$highBidInfo = $listing->getHighestBid();

			if($listing->isAuction()) {

				if ($highBidInfo) {

					$output .= "<input type='text' size='10' name='bidAmount' value='".$highBidInfo['currentPrice']."' />";
					$output .= "<input type='submit' name='newBid' value='Place Bid' />";
		
					$minBid = $listing->getLowestBidAmount()+$highBidInfo['currentPrice'];
					$minBidFormatted = sprintf("%01.2f", $minBid);

					$output .= " - Min Bid: ".$minBidFormatted;
					$output .= "(".$highBidInfo['username'].")";	

				}

				else {

					$output .= "<input type='text' size='10' name='bidAmount' value='".$listing->getStartPrice()."' />";
					$output .= "<input type='submit' name='newBid' value='Place Bid' />";

					$minBid = $listing->getStartPrice() + $listing->getLowestBidAmount();
					$minBidFormatted = sprintf("%01.2f", $minBid);

					$output .= " - Min Bid: ".$minBidFormatted;

				}

			}

			else {

				$output .= $listing->getStartPrice();
				$output .= "<input type='submit' name='buyItem' value='Buy Now!' />";

			}

			$output .= "</td>";
			$output .= "</tr>";
			$output .= "<tr>";
			$output .= "<td>".$listing->getTimeRemaining()."</td>";
			$output .= "</tr>";
			$output .= "</table>";
			$output .= "</form>";
			$output .= "<br />";

			return $output;

		}
		
		public function renderSavedListings($start, $limit) {

			$db = new dbConn();
			$member = unserialize($_SESSION['member']);

			$result = $db->selectWhere("listingID, listingTitle,listingStartPrice,listingQuantity","listings","memberID=".$member->getID()." ORDER BY editDate DESC",0);

			echo("<table>");

			echo("<td width=400>Title</td>");
			echo("<td width=70>Quantity</td>");
			echo("<td width=70>Price</td>");
			echo("<td></td>");
			echo("<td></td>");
			echo("<td></td>");

			while ($row=$result->fetch_assoc()) {

				echo("<tr>");
				echo("<form method='post' action='savedListings.php'>");
				echo("<input type='hidden' name='listingID' value='".$row['listingID']."' />");
				echo("<td>".$row['listingTitle']."</td>");
				echo("<td>".$row['listingQuantity']."</td>");
				echo("<td>".$row['listingStartPrice']."</td>");
				echo("<td><input type='submit' name='edit' value='Edit' /></td>");
				echo("<td><input type='submit' name='preview' value='Preview' /></td>");
				echo("<td><input type='submit' name='publish' value='Publish' /></td>");
				echo("<td><input type='submit' name='delete' value='Delete' /></td>");
				echo("</form>");
				echo("</tr>");

			}

			echo("</table>");

		}

		public function renderMemberRunningListings() {

			echo("<table>");
			
			echo("<tr class='tableHeader'>");
			echo("<td width=300>Title</td>");
			echo("<td width=150>Price</td>");
			echo("<td width=150>Time Remaining</td>");
			echo("<td width=50></td>");
			echo("<td width=50></td>");
			echo("</tr>");

			$db = new dbConn();

			$member = unserialize($_SESSION['member']);

			$result = $db->mysqli->query("SELECT * 
																		FROM runningListings 
																		WHERE memberID=".$member->getID()); 
		
			while ($row = $result->fetch_assoc()) {

				$runningListing = new runningListing($row);

				$highestBidInfo = $runningListing->getHighestBid();

				echo("<form method='post' action='runningListings.php'>");
				echo("<input type='hidden' name='listingID' value='".$runningListing->getID()."' />");
				echo("<tr>");
				echo("<td><a href='viewListing.php?id=".$runningListing->getID()."'>".$runningListing->getTitle()."</a></td>");

				if ($highestBidInfo) {

					echo("<td>".$highestBidInfo['currentPrice']."</td>");

				}

				else {

					echo("<td>".$runningListing->getStartPrice()."</td>");

				}

				echo("<td>".$runningListing->getTimeRemaining()."</td>");

				if ($runningListing->getListingRunning()) {
					echo("<td><input type='submit' name='stopRunning' value='Stop' /></td>");
				}
				else {
					echo("<td><input type='submit' name='startRunning' value='Start' /></td>");
				}
				echo("<td><input type='submit' name='deleteRunning' value='Delete' /></td>");
				echo("</tr>");
				echo("</form>");

			}
	
			echo("</table>");

		}

		public function renderRunningListings($orderBy, $inOrder, $limit) {

			$output  = "<table>";
			$output .= "<tr>";
			$output .= "<td width=400>Title</td>";
			$output .= "<td width=150>Price</td>";
			$output .= "<td width=200>Time Remaining</td>";
			$output .="</tr>";

			$db = new dbConn();

			$result = $db->mysqli->query("SELECT *  
																		FROM runningListings 
																		WHERE listingRunning=1 
																		ORDER BY ".$orderBy." ".$inOrder." 
																		LIMIT ".$limit); 

			while ($row = $result->fetch_assoc()) {

				$runningListing = new runningListing($row); 

				$highestBidInfo = $runningListing->getHighestBid();

				$output .= "<tr>";
				$output .= "<td><a href='viewListing.php?id=".$runningListing->getID()."'>".$runningListing->getTitle()."</a></td>";

				if ($highestBidInfo) {

					$output .= "<td>".$highestBidInfo['currentPrice']."</td>";

			
				}

				else {

					$output .= "<td>".$runningListing->getStartPrice()."</td>";

				}

				$output .= "<td>".$runningListing->getTimeRemaining()."</td>";
				$output .= "</tr>";

			}
	
			$output .= "</table>";

			return $output;

		}

	}

?>
