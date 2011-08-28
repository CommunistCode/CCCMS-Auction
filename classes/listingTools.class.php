<?php
	
	require_once($fullPath."/auction/classes/listing.class.php");
	require_once($fullPath."/classes/dbConn.class.php");
	require_once($fullPath."/membership/classes/member.class.php");

	class listingTools {

		public function deliverMessage($user,$message) {

			$db = new dbConn();

			$member = unserialize($_SESSION['member']);

			$result = $db->selectWhere("email","members","username='".$user."'",0);
			$data = $result->fetch_assoc();

			$to = $user ."<". $data['email'] .">";
			$subject = "Email from MantisMarket member: ".$member->getUsername();
			$message = wordwrap($message,70);
			$headers = 'From: MantisMarket Member <no-reply@mantismarket.co.uk>'."\r\n";

			if(mail($to,$subject,$message,$headers)) {

				return 1;

			} else {

				return 0;

			}

		}
		
		public function stopFinishedListings() {

			$db = new dbConn();

			$db->update("runningListings","listingRunning=0","endDate < ".time()."",0);

		}
		
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
									'".addslashes($listing->getTitle())."',
									'".addslashes($listing->getDescription())."',
									'".$listing->getPostage()."',
									'".$listing->getQuantity()."',
									'".$listing->getStartPrice()."',
									'".$listing->getDuration()."'",
									0
									);			

			$newID = $db->mysqli->insert_id;

			return $newID; 

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
									'".addslashes($listing->getTitle())."',
									'".addslashes($listing->getDescription())."',
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

			if (round(($runningListing->getLowestBidAmount()+$highestBidInfo['currentPrice']),2) <= round($amount,2)) {


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

			else {

				echo(($runningListing->getLowestBidAmount()+$highestBidInfo['currentPrice'])."<=".floatval($amount) ."(False)");

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

		public function getPurchases() {

			$member = unserialize($_SESSION['member']);

			$db = new dbConn();

			$result = $db->mysqli->query("SELECT runningListings.listingTitle,
																					 members.username,
																					 purchases.listingID
																		FROM runningListings,
																				 purchases,  
																				 members
																		WHERE (purchases.memberID = '".$member->getID()."' AND
																					purchases.listingID = runningListings.runningListingID AND
																					members.memberID = runningListings.memberID)  
																		ORDER BY purchases.purchaseDate DESC;");

			if (!$result) { echo($db->mysql_error); }

			return $result;	

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

			$formattedTime = "";

			if ($days != 0) {
		
				$formattedTime .= $days . "d ";
			
			}

			if ($hours != 0) {
		
				$formattedTime .= $hours . "h ";
			
			}

			if ($min != 0) {

				$formattedTime .= $min ."m ";

			}

			if ($days == 0 && $hours == 0) {

				$formattedTime .= $seconds ."seconds ";

			}

			return $formattedTime;

		}

		public function renderSavedListings($start, $limit) {

			$db = new dbConn();
			$member = unserialize($_SESSION['member']);

			$result = $db->selectWhere("listingID, listingTitle,listingStartPrice,listingQuantity","listings","memberID=".$member->getID()." ORDER BY editDate DESC",0);

			echo("<table>");

			echo("<th width=400>Title</th>");
			echo("<th width=70>Quantity</th>");
			echo("<th width=70>Price</th>");
			echo("<th></th>");
			echo("<th></th>");
			echo("<th></th>");
			echo("<th></th>");

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
			
			echo("<tr>");
			echo("<th width=300>Title</th>");
			echo("<th width=150>Price</th>");
			echo("<th width=150>Time Remaining</th>");
			echo("<th width=50></th>");
			echo("<th width=50></th>");
			echo("</tr>");

			$db = new dbConn();

			$member = unserialize($_SESSION['member']);

			$result = $db->mysqli->query("SELECT * 
																		FROM runningListings 
																		WHERE memberID=".$member->getID()."
																		ORDER BY endDate DESC"); 
		
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
			$output .= "<th width=400>Title</th>";
			$output .= "<th width=150>Price</th>";
			$output .= "<th width=200>Time Remaining</th>";
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
