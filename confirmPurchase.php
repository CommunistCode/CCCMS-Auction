<?php 

	require_once("../config/config.php");
	require_once($fullPath."/includes/global.inc.php");
	require_once($fullPath."/membership/includes/checkLogin.inc.php");

	$heading = "Confirm Purchase";
	$include = "includes/confirmPurchase.inc.php";

	require_once("themes/".$pageTools->getTheme("auction")."/templates/template.inc.php");

?>
