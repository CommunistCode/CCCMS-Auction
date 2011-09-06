<?php 

	require_once("../config/config.php");
	require_once("../includes/global.inc.php");

	require_once($fullPath."/membership/includes/checkLogin.inc.php");

	$heading = "Purchases";
	$include = "includes/purchasesTable.inc.php";

	require_once("themes/".$pageTools->getTheme("auction")."/templates/template.inc.php");
	
?>
