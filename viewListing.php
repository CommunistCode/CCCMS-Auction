<?php 

	require_once("../config/config.php");
	require_once("../includes/global.inc.php");
	require_once($fullPath."/auction/classes/listingTools.class.php");
	require_once($fullPath."/auction/classes/listing.class.php");

	$listingTools = new listingTools();

	if (isset($_POST['confirmBid'])) {

		$listingTools->newBid($_GET['id'],$_POST['bidAmount']);

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
		
				<h1>View Listing</h1>

				<?php
					
					$runningListing = $listingTools->getRunningListingObject($_GET['id']);
					$listingTools->renderListing($runningListing);

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



