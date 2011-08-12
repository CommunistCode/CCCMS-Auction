<?php 

	require_once("../config/config.php");
	require_once("../includes/global.inc.php");
	require_once($fullPath."/auction/classes/listingTools.class.php");

	$listingTools = new listingTools();

	$listingTools->stopFinishedListings();
	
	$content = $listingTools->renderRunningListings("endDate","ASC",10);

	$heading = "Active Listings";

	require_once("includes/template.inc.php");

?>
