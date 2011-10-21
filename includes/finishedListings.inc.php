<?php

	$finishedListings = $listingTools->getFinishedListings(10);


	echo("<table>");

		echo("<th width='400'>Listing Title</th>");
		echo("<th width='200'>End Date</th>");
		echo("<th width='100'>Buyer</th>");

	if (!$finishedListings) {

		echo("<tr>");
		echo("<td colspan='3' align='center'>You do not have any finished listings!</td>");
		echo("</tr>");

	} else {

		foreach ($finishedListings as $finishedListing) {

			echo("<tr>");	
			echo("<td><a href='viewListing.php?id=".$finishedListing['id']."'>".$finishedListing['title']."</a></td>");
			echo("<td>".date("d-M-y H:i",$finishedListing['date'])."</td>");
			

			// Check if the listing sold, if so then setup link to contact buyer
			if (strcmp($finishedListing['buyer'],"Didn't Sell") == 0) {

				echo("<td>".$finishedListing['buyer']."</td>");

			} else {
			
				echo("<td><a href='contactMember.php?user=".$finishedListing['buyer']."'>".$finishedListing['buyer']."</a></td>");

			}

			echo("</tr>");

		}

	}

	echo("</table>");

?>
