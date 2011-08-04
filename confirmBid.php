<?php 

	require_once("../config/config.php");
	require_once($fullPath."/includes/global.inc.php");

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
			<div id='navBar'>
				<?php 
					require_once("../includes/links.inc.php"); 
				?>
			</div>

			<div id='bodyContainer'>

				<div class="auctionLinks">
	
					<?php
						require_once("includes/auctionLinks.inc.php");
					?>
	
				</div>

				<div class="auctionBody">
		
					<h1>Confirm Bid</h1>

					<p>Please confirm your bid.</p>

					<form method='post' action='viewListing.php?id=<?php echo($_POST['listingID']); ?>'>
					<input type='hidden' name='bidAmount' value='<?php echo($_POST['bidAmount']); ?>' />
					<input type='submit' name='confirmBid' value='Confirm Bid' />

					</form>

				</div>
	
			</div>

			<div id="footer">
			
				<?php 
					require_once("../includes/footer.inc.php"); 
				?>
			</div>
		</div>
	</body>
</html>



