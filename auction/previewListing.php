<?php 

	require_once("../config/config.php");
	require_once("../includes/global.inc.php");
	require_once("classes/listingTools.class.php");
	require_once($fullPath."/membership/includes/checkLogin.inc.php");

	$listingTools = new listingTools();
	
	if (isset($_SESSION['listing']) && !isset($_POST['listingSubmit'])) {

		$listing = unserialize($_SESSION['listing']);
	
	}

	else if (!isset($_POST['listingSubmit'])) {

		header("Location: createListing.php");	

	}
	
	else {
	
		if (isset($_SESSION['listing'])) {
		
			$data['listingID'] = unserialize($_SESSION['listing'])->getID();

		}

		$data['listingTitle'] = $_POST['listingTitle'];
		$data['listingDescription'] = $_POST['listingDescription'];
		$data['listingQuantity'] = $_POST['listingQuantity'];
		$data['listingStartPrice'] = $_POST['listingStartPrice'];
		$data['listingPostage'] = $_POST['listingPostage'];
		$data['listingDuration'] = $_POST['listingDuration'];

		$listingTools->loadListingSession($data);
		$listing = unserialize($_SESSION['listing']);

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
		
				<h1>Auction Preview</h1>	
				<table>
					<tr>
						<td><?php echo($listing->getTitle()); ?></td>
					</tr>
					<tr>
						<td><?php echo($listing->getDescription()); ?></td>
					</tr>
					<tr>
						<td><?php echo($listing->getQuantity()); ?></td>
					</tr>
					<tr>
						<td><?php echo($listing->getStartPrice()); ?></td>
					</tr>
					<tr>
						<td><?php echo($listing->getPostage()); ?></td>
					</tr>
					<tr>
						<td><?php echo($listing->getDuration()); ?></td>
					</tr>
					<tr>
						<td>
							<?php
							
								include("includes/previewListSubmits.inc.php");

							?>
						</td>
					</tr>
				</table>
			</div>
			<div id="footer">
				<?php 
					require_once("../includes/footer.inc.php"); 
				?>
			</div>
		</div>
	</body>
</html>



