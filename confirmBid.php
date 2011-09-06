<?php 

	require_once("../config/config.php");
	require_once($fullPath."/includes/global.inc.php");
	require_once($fullPath."/membership/includes/checkLogin.inc.php");

	$heading = "Confirm Bid";
	$include = "includes/confirmBid.inc.php";

	require_once("themes/".$pageTools->getTheme("auction")."/templates/template.inc.php");

?>
