<?php

	if ($listing->isAuction()) { 
		$actionPage = "confirmBid.php"; 
	}
	else { 
		$actionPage = "confirmPurchase.php"; 
	}

	if($listing->isAuction()) {
	
		$highBidInfo = $listing->getHighestBid();

		if (isset($highBidInfo['username'])) {

			$minBid = $listing->getLowestBidAmount() + $highBidInfo['currentPrice'];
			$minBidFormatted = sprintf("%01.2f", $minBid);

			$price  = "Current Bid: &pound;".sprintf("%01.2f",$highBidInfo['currentPrice']);
			$price .= " (".$highBidInfo['username'].")";

			$input  = "<input type='text' name='bidAmount' value='".$minBidFormatted."' />";
			$input .= "<input type='submit' name='newBid' value='Place Bid' />";

		}

		else {

			$minBid = $listing->getStartPrice() + $listing->getLowestBidAmount();
			$minBidFormatted = sprintf("%01.2f", $minBid);
			
			$price = "Starting Price: &pound".$listing->getStartPrice();

			$input  = "<input type='text' name='bidAmount' value='".$minBidFormatted."' />";
			$input .= "<input type='submit' name='newBid' value='Place Bid' />";

		}

	}

	else {

		$price = "Price: &pound".$listing->getStartPrice()."";
		$input = "<input type='submit' name='buyItem' value='Buy Now!' />";

	}

	if (!$listing->getListingRunning()) {

		$timeRemaining = "<strong>Finished</strong>";
		$input = "<strong>This listing has ended!</strong>";

	}

	else {
		
		$timeRemaining=$listing->getTimeRemaining();

	}

	if ($listing->getPhotos()) {

		$photoLocation = "photos/runningListings/".$listing->getID()."/1.jpg";

	}

?>

<form method="post" action="<?php echo($actionPage); ?>">

	<input type='hidden' name='listingID' value='<?php echo($listing->getID()); ?>' />

	<div id="listing">
	<table>
		<tr>
			<td rowspan="7" class="photo" ><?php if (isset($photoLocation)) { echo("<img src='".$photoLocation."' width=200 />"); } else { echo("Photo"); } ?></td>
			<td class="details" ><h1><?php echo($listing->getTitle()); ?></h1></td>
		</tr>
		<tr>
			<td class="details" ><?php echo($price); ?></td>
		</tr>
		<tr>
			<td class="details" >Available: <?php echo($listing->getQuantity()); ?></td>
		</tr>
		<tr>
			<td class="details" >Postage: &pound<?php echo($listing->getPostage()); ?></td>
		</tr>
		<tr>
			<td class="details" >Time Remaining: <?php echo($timeRemaining); ?></td>
		</tr>
		<tr>
			<td class="details" ><?php echo($input); ?></td>
		</tr>
		<tr>
			<td class="details" >Seller: <?php echo($listing->getSeller()); ?> (<a href='contactMember.php?user=<?php echo($listing->getSeller()); ?>'>Contact</a>)</td>
		</tr>
	</table>

	<div class="body">
		<?php echo(nl2br($listing->getDescription())); ?>
	</div>

	</div>

</form>
