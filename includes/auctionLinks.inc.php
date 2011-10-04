<ul>
	<li><a href='index.php'>Marketplace</a></li>	
	<li><a href='viewListings.php'>View Listings</a></li>


	<?php
		
		require_once($fullPath."/auction/classes/listingTools.class.php");
		
		if (isset($_SESSION['memberLoggedIn'])) {

			echo ("<li><strong>Listing Tools</strong></li>");

			$listingTools = new listingTools();

			$listingTools->renderLinks();

		}

	?>
	
</ul>
