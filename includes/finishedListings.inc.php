<?php

	$finishedListings = $listingTools->getFinishedListings(10);

	while ($finishedListing = $finishedListings->fetch_assoc())	{

		echo($finishedListing['listingTitle']."<br/>");

	}

?>
