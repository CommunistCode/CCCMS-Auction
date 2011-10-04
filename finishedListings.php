<?php 

	require_once("../config/config.php");
	require_once("../includes/global.inc.php");
	require_once($fullPath."/membership/includes/checkLogin.inc.php");
	require_once($fullPath."/auction/classes/listingTools.class.php");

	$listingTools = new listingTools();

	$heading = "Finished Listings";
	$include = "includes/finishedListings.inc.php";

	require_once("themes/".$pageTools->getTheme("auction")."/templates/template.inc.php");

?>
