<?php

	$finishedListings = $listingTools->getFinishedListings(10);


	echo("<table>");

		echo("<th width='400'>Listing Title</th>");
		echo("<th width='100'>End Date</th>");
		echo("<th width='100'>Buyer</th>");

	if (!count($finishedListings)) {

		echo("<td colspan='3' align='center'>You do not have any finished listings!</td>");

	} else {

		foreach ($finishedListings as $finishedListing) {

			echo("<tr>");	
			echo("<td>".$finishedListing['title']."</td>");
			echo("<td>".date("d-M-y",$finishedListing['date'])."</td>");
			echo("<td>".$finishedListing['buyer']."</td>");
			echo("</tr>");

		}

	}

	echo("</table>");

?>
