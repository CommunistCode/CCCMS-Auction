<table>
	<tr>
		<th width=375>Listing</th>
		<th width=100>Max Bid</th>
		<th width=100>Current Price</th>
		<th width=100>Status</th>
		<th width=125>Time Left</th>
	</tr>
	
	<?php

		$db = new dbConn();
		$member = unserialize($_SESSION['member']);

		$query = "SELECT r.listingTitle, 
										 r.runningListingID,
										 r.listingRunning,
										 r.listingQuantity,
										 r.endDate, 
										 max(b.bidAmount) AS maxBid, 
										 b.MemberID
							FROM runningListings r  
							INNER JOIN bids b 
							ON r.runningListingID = b.ListingID 
							WHERE b.memberid = ".$member->getID()."   
							GROUP BY r.listingTitle, 
											 r.endDate, 
											 b.MemberID
							ORDER BY r.endDate ASC";

		$result = $db->mysqli->query($query);

		if ($result->num_rows) {

			while($row = $result->fetch_assoc()) {

				$runningListing = new runningListing($row);

				$highBid = $runningListing->getHighestBid();

				if ($highBid['username'] == $member->getUsername()) {

					$status = "WINNING";

				} else {

					$status = "OUTBID";

				}

				echo("<tr>");
				echo("<td><a href='viewListing.php?id=".$row['runningListingID']."'>".$row['listingTitle']."</a></td>");
				echo("<td>&pound".$row['maxBid']."</td>");
				echo("<td>&pound".$highBid['currentPrice']."</td>");
				echo("<td>".$status."</td>");
				echo("<td>".$listingTools->calcTimeRemaining(time(), $row['endDate'])."</td>");
				echo("</tr>");

			}

		}

		else {

			echo("<tr><td colspan='5' align='center'><strong>You do not currently have any bids on running auctions</strong></td></tr>");

		}

	?>

</table>
