<?php 

	require_once("../config/config.php");
	require_once("../includes/global.inc.php");
	require_once( $fullPath ."/auction/classes/listingTools.class.php");

	$listingTools = new listingTools();
	$listing = unserialize($_SESSION['listing']);

	if (isset($_SESSION['editing'])) {

		if ($listing->update($listing)) {

			$content = "Listing updated!";
	
			unset($_SESSION['editing']);

		}

	}

	else {

		if ($listingTools->saveListing($listing)) {

			$content = "Listing saved!";

		}
	
	}
		
	$listingTools->unsetListing();

	$heading = "Save Listing";

	require_once("includes/template.inc.php");

?>
