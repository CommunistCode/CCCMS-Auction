<?php 

	require_once("../config/config.php");
	require_once("../includes/global.inc.php");
	require_once($fullPath . "/auction/classes/listingTools.class.php");
	require_once($fullPath . "/membership/includes/checkLogin.inc.php");

	$listingTools = new listingTools();

	if (isset($_POST['listingID'])) {

		$listingTools->loadExistingListing($_POST['listingID'], TRUE);
		$listing = unserialize($_SESSION['listing']);

	}

	if (isset($_POST['edit'])) {

    $listingTools->moveTempPhotos($listing->getID(),$listing->getPhotos(),1);
		$_SESSION['editing'] = 1;
		header("Location: createListing.php");

	}

	if (isset($_POST['preview'])) {

    $listingTools->moveTempPhotos($listing->getID(),$listing->getPhotos(),1);
		$_SESSION['editing'] = 1;
		header("Location: previewListing.php");

	}

	if (isset($_POST['publish'])) {

		header("Location: publishListing.php");

	}

	if (isset($_POST['delete'])) {

		$listingTools->deleteListing($_POST['listingID']);
		$listingTools->unsetListing();

	}

	$heading = "Saved Listings";
	$include = "includes/savedListings.inc.php";

	require_once("includes/template.inc.php");

?>
