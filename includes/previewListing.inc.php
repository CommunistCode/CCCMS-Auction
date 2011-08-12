<table>

	<tr>
		<td><?php echo($listing->getType()); ?></td>
	</tr>
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
