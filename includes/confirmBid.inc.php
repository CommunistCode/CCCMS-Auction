<p>Please confirm your bid.</p>

<form method='post' action='viewListing.php?id=<?php echo($_POST['listingID']); ?>'>
<input type='hidden' name='bidAmount' value='<?php echo($_POST['bidAmount']); ?>' />
<input type='submit' name='confirmBid' value='Confirm Bid' />

</form>
