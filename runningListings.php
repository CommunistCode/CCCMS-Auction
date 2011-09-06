<?php 

	require_once("../config/config.php");
	require_once("../includes/global.inc.php");
	require_once($fullPath."/membership/includes/checkLogin.inc.php");
	require_once($fullPath."/auction/classes/listingTools.class.php");

	$listingTools = new listingTools();

	if (isset($_POST['stopRunning'])) {

		$listingTools->stopRunningListing($_POST['listingID']);

	}

	if (isset($_POST['startRunning'])) {

		$listingTools->startStoppedListing($_POST['listingID']);

	}

	$heading = "Running Listings";
	$include = "includes/runningListings.inc.php";

	require_once("themes/".$pageTools->getTheme("auction")."/templates/template.inc.php");

?>
