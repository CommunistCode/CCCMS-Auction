<?php 

	require_once("../config/config.php");
	require_once("../includes/global.inc.php");
	require_once("classes/listingTools.class.php");
	require_once($fullPath."/membership/includes/checkLogin.inc.php");

	$listingTools = new listingTools();
	
	if (isset($_SESSION['listing']) && !isset($_POST['listingSubmit'])) {

		$listing = unserialize($_SESSION['listing']);
	
	}

	else if (!isset($_POST['listingSubmit'])) {

		header("Location: createListing.php");	

	}
	
	else {
	
		if (isset($_SESSION['listing'])) {
		
			$data['listingID'] = unserialize($_SESSION['listing'])->getID();

		}

		$data['listingTitle'] = $_POST['listingTitle'];
		$data['listingDescription'] = $_POST['listingDescription'];
		$data['listingQuantity'] = $_POST['listingQuantity'];
		$data['listingStartPrice'] = $_POST['listingStartPrice'];
		$data['listingPostage'] = $_POST['listingPostage'];
		$data['listingDuration'] = $_POST['listingDuration'];

		$listingTools->loadListingSession($data);
		$listing = unserialize($_SESSION['listing']);

	}

	$heading = "Auction Preview";
	$include = "includes/previewListing.inc.php";

	require_once("includes/template.inc.php");

?>
