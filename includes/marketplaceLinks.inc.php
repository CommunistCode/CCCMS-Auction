<div class='marketplaceLinkHeadingTopDiv'>Market Place</div>

<ul>
	<li><a href='index.php'>Home</a></li>	
	<li><a href='viewListings.php'>View Listings</a></li>
</ul>

<?php
		
	require_once($fullPath."/auction/classes/listingTools.class.php");
		
	if (isset($_SESSION['memberLoggedIn'])) {

		echo ("<div class='marketplaceLinkHeading'>Listing Tools</div>");

		$listingTools = new listingTools();

		$linkArray = $listingTools->getSidebarLinks();

		echo ("<ul>");

		foreach ($linkArray as $link) {

			echo("<li><a href='".$link['href']."'>".$link['anchor']."</a></li>");

		}

		echo("</ul>");

	}

?>
