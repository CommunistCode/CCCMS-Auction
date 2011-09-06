<?php 

	require_once("../config/config.php");
	require_once($fullPath."/includes/global.inc.php");

	$heading = "Contact Member";

	if (isset($_POST['sendMessage'])) {

		$include = "includes/deliverMessage.inc.php";

	} else {
		
		$include = "includes/contactMember.inc.php";

	}

	require_once("themes/".$pageTools->getTheme("auction")."/templates/template.inc.php");

?>
