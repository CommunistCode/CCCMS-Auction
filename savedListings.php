<?php 

	require_once("../config/config.php");
	require_once("../includes/global.inc.php");
	require_once($fullPath . "/auction/classes/listingTools.class.php");
	require_once($fullPath . "/membership/includes/checkLogin.inc.php");

	$listingTools = new listingTools();

	if (isset($_POST['listingID'])) {

		$listingTools->loadExistingListing($_POST['listingID'], TRUE);

	}

	if (isset($_POST['edit'])) {

		$_SESSION['editing'] = 1;
		header("Location: createListing.php");

	}

	if (isset($_POST['preview'])) {

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

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title><?php echo("Mantis Market : ".$pageContent['title']); ?></title>
		<link href="../stylesheet/stylesheet.css" rel="stylesheet" type="text/css" />
		<link href="stylesheet/auctionStyle.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<div id="mainContainer">
			<div id="title">
				<?php 
					require_once("../includes/title.inc.php"); 
				?>
			</div>
			<div class='links'>
				<?php 
					require_once("../includes/links.inc.php"); 
				?>
			</div>
			<div class="auctionLinks">
				<?php
					require_once("includes/auctionLinks.inc.php");
				?>
			</div>
			<div class="auctionBody">
		
				<h1>Saved Listings</h1>	

				<?php

					$start = 0;
					$limit = 10;

					$listingTools->renderSavedListings($start, $limit);

				?>

			</div>
			<div id="footer">
				<?php 
					require_once("../includes/footer.inc.php"); 
				?>
			</div>
		</div>
	</body>
</html>



