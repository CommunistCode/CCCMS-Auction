<?php

	$finishedListings = $listingTools->getFinishedListings(10);


	echo("<table>");

		echo("<th width='400'>Listing Title</th>");
		echo("<th width='100'>End Date</th>");
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
			echo("<td>".$finishedListing['buyer']."</td>");
			echo("</tr>");

		}

	}

	echo("</table>");

?>
