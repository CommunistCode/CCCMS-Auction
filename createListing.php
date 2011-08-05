<?php 

	require_once("../config/config.php");
	require_once("../includes/global.inc.php");
	require_once( $fullPath."/membership/includes/checkLogin.inc.php");	
	require_once( $fullPath."/auction/classes/listingTools.class.php");	

	$content = "";

	/******************************************************************************
		PAGE LOGIC
		****************************************************************************/

	if (!isset($_SESSION['listing']) || isset($_GET['startNew'])) {

		$listingTools = new listingTools();
		$data = "";
		$listing = $listingTools->loadListingSession($data);	

	}

	else if (isset($_SESSION['editing'])) {

		$content = "<p>You are in EDITING mode <a href='createListing.php?startNew=1'>click here</a> to start a new listing.</p>";

	}

	$listing = unserialize($_SESSION['listing']);
	


	/******************************************************************************
		PAGE CONTENT
		*****************************************************************************/

	$heading = "Create Listing";
	$include = "includes/createListingForm.inc.php";

	require_once("includes/template.inc.php");

?>
