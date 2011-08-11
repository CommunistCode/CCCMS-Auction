<?php 

	require_once("../config/config.php");
	require_once("../includes/global.inc.php");
	require_once($fullPath."/auction/classes/listingTools.class.php");
	require_once($fullPath."/auction/classes/listing.class.php");

	$listingTools = new listingTools();

	if (isset($_POST['confirmBid'])) {

		$listingTools->newBid($_GET['id'],$_POST['bidAmount']);

	}

	$runningListing = $listingTools->getRunningListingObject($_GET['id']);
	$content = $listingTools->renderListing($runningListing);

	$heading = "View Listing";

	require_once("includes/template.inc.php");

?>
