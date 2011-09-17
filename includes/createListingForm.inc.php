<?php $member = unserialize($_SESSION['member']); ?>

<form action='previewListing.php' method='post' enctype="multipart/form-data">
	<br />
	<table id='createForm'>
		<tr>
			<th>Listing Type</th>
			<td>
				<select name="listingType" >
					<option value="0" <?php if ($listing->getType()==0) { echo("SELECTED"); } ?> >Set Price</option>
					<option value="1" <?php if ($listing->getType()==1) { echo("SELECTED"); } ?> >Auction</option>
				</select>
			</td>
		</tr>
		<tr>
			<th>Category</th>
			<td><p>Coming Soon!</p></td>
		</tr>
		<tr>
			<th width='180'>Title</th>
			<td><input type='text' size='83' name='listingTitle' value='<?php echo($listing->getTitle()); ?>' /></td>
		</tr>
		<tr>
			<th>Description</th>
			<td><textarea rows='10' cols='60' name='listingDescription'><?php echo($listing->getDescription()); ?></textarea></td>
		</tr>
		<?php 

			if ($listing->getPhotos()) {

				echo("<tr>
								<th>Current Photo</td>
								<td><img width=100 src='photos/tempPhotos/".$member->getID()."-1.jpg' /></td>
							</tr>");
			}

		?>
		<tr>
			<th>Photo</th>
			<td><input type='file' name='photos[]' /></td>
		</tr>
		<tr>
			<th>Quantity</th>
			<td><input type='text' name='listingQuantity' size='4' value='<?php echo($listing->getQuantity()); ?>' /></td>
		</tr>
		<tr>
			<th>Starting Price (ea)</th>
			<td>&pound; <input type='text' name='listingStartPrice' size='6' value='<?php echo($listing->getStartPrice()); ?>' /></td>
		</tr>
		<tr>
			<th>Postage (ea)</th>
			<td>&pound; <input type='text' name='listingPostage' size='6' value='<?php echo($listing->getPostage()); ?>' /></td>
		</tr>			
		<tr>
			<th>Duration</th>
			<td>
				<select name='listingDuration' />
					<?php
						
						for ($i=1; $i<=14; $i++) {

							if ($i == $listing->getDuration()) {
								
								echo("<option selected>".$i."</option>");

							} else {

								echo("<option>".$i."</option>");

							}

						}

					?>
				</select> Day(s)
			<td>
		</tr>
		<tr>
			<td></td>
			<td><input type='Submit' name='listingSubmit' value='Preview Listing' /></td>
		</tr>
	</table>
</form>
