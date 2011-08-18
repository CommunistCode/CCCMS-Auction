<?php 

	require_once("../config/config.php");
	require_once("../includes/global.inc.php");
	require_once($fullPath."/auction/classes/listingTools.class.php");
	require_once($fullPath."/membership/includes/checkLogin.inc.php");

	$listingTools = new listingTools();
	
	$listing = unserialize($_SESSION['listing']);

	if ($listing->getID() == NULL) {

		$newID = $listingTools->saveListing($listing);
		$listingTools->loadExistingListing($newID, TRUE);
		$listing = unserialize($_SESSION['listing']);

	}

	$listingTools->publishListing($listing);

	$listingTools->unsetListing();

	$heading = "Publish Listing";
	$content = "Your listing was sucessfully published to the Marketplace!";

	require_once("includes/template.inc.php");

?>
