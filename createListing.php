<?php 

	require_once("../config/config.php");
	require_once("../includes/global.inc.php");
	require_once( $fullPath."/membership/includes/checkLogin.inc.php");	
	require_once( $fullPath."/auction/classes/listingTools.class.php");	

	$editing = FALSE;

	if (!isset($_SESSION['listing']) || isset($_GET['startNew'])) {

		$listingTools = new listingTools();
		$data = "";
		$listing = $listingTools->loadListingSession($data);	

	}

	else if(isset($_SESSION['editing'])) {

		$editing = TRUE;

	}

	$listing = unserialize($_SESSION['listing']);

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
		
				<h1>Create Listing</h1>
				
				<?php

					if ($editing) {

						echo("<p>You are in EDITING mode <a href='createListing.php?startNew=1'>click here</a> to start a new listing.</p>");

					}

				?>
				<form action='previewListing.php' method='post'>
					<br />
					<table>
						<tr>
							<td width='180'>Title</td>
							<td><input type='text' name='listingTitle' value='<?php echo($listing->getTitle()); ?>' /></td>
						</tr>
						<tr>
							<td>Description</td>
							<td><textarea rows='20' cols='40' name='listingDescription'><?php echo($listing->getDescription()); ?></textarea></td>
						</tr>				
						<tr>
							<td>Quantity</td>
							<td><input type='text' name='listingQuantity' value='<?php echo($listing->getQuantity()); ?>' /></td>
						</tr>
						<tr>
							<td>Starting Price (ea)</td>
							<td><input type='text' name='listingStartPrice' value='<?php echo($listing->getStartPrice()); ?>' /></td>
						</tr>
						<tr>
							<td>Postage (ea)</td>
							<td><input type='text' name='listingPostage' value='<?php echo($listing->getPostage()); ?>' /></td>
						</tr>			
						<tr>
							<td>Duration</td>
							<td><input type='text' name='listingDuration' value='<?php echo($listing->getDuration()); ?>' /> Max 14 Days</td>
						</tr>
						<tr>
							<td></td>
							<td><input type='Submit' name='listingSubmit' value='Preview Listing' /></td>
						</td>	
					</table>
				</form>
			<br />
			</div>
			<div id="footer">
				<?php 
					require_once("../includes/footer.inc.php"); 
				?>
			</div>
		</div>
	</body>
</html>



