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
		</tr>
	</table>
</form>

