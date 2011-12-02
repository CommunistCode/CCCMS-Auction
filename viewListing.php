<?php 

	require_once("../config/config.php");
	require_once($fullPath."/includes/global.inc.php");
	require_once($fullPath."/auction/classes/listingTools.class.php");
	require_once($fullPath."/auction/classes/listing.class.php");

	$listingTools = new listingTools();

	if (isset($_POST['confirmBid'])) {

		$listingTools->newBid($_GET['id'],$_POST['bidAmount']);

	}

	if (isset($_POST['confirmPurchase'])) {

		$listingTools->newPurchase($_GET['id']);

	}

	$listing = $listingTools->getRunningListingObject($_GET['id']);
	$include = "includes/listing.inc.php"; 

	$heading = "View Listing";

	require_once("themes/".$pageTools->getTheme("auction")."/templates/template.inc.php");

?>
