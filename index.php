<?php

	require_once("../config/config.php");
	require_once($fullPath."/classes/pageTools.class.php");
	require_once($fullPath."/auction/classes/listingTools.class.php");

	$listingTools = new listingTools();
	$page = $listingTools->getDynamicContentID();
	
	require_once($fullPath."/includes/global.inc.php");

	$heading = "Auction";
	$content = $pageTools->matchTags($pageContent['text']);

	require_once("themes/".$pageTools->getTheme("auction")."/templates/template.inc.php");

?>
