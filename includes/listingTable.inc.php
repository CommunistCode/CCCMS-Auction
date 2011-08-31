<?php 

	$member = unserialize($_SESSION['member']); 
	$photoLocation = "photos/tempPhotos/".$member->getID()."-1.jpg";

?>

<div id="listing">
	<table>
		<tr>
			<td rowspan="7" class="photo" ><img width=200 src="<?php echo($photoLocation) ?>" /></td>
			<td class="details" ><h1><?php echo($listing->getTitle()); ?></h1></td>
		</tr>
		<tr>
			<td class="details" >Price: &pound<?php echo(sprintf("%01.2f",$listing->getStartPrice())); ?></td>
		</tr>
		<tr>
			<td class="details" >Available: <?php echo($listing->getQuantity()); ?></td>
		</tr>
		<tr>
			<td class="details" >Postage: &pound<?php echo($listing->getPostage()); ?></td>
		</tr>
		<tr>
			<td class="details" >Time Remaining: <?php echo($listing->getDuration()); ?></td>
		</tr>
		<tr>
			<td class="details" >
				<?php 
					if(!$listing->getType()) { 
						echo("<input type='button' value='Buy Now!'/>");
					} else {
						echo("<input type='text' /><input type='button' value='Bid' />");
					}
				?>
			</td>
		</tr>
		<tr>
			<td class="details" >Seller: Preview (<a href='#'>Contact</a>)</td>
		</tr>
	</table>

	<div class="body">
		<?php echo(nl2br($listing->getDescription())); ?>
	</div>

</div>
