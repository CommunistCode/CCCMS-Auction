<?php

	$purchases = $listingTools->getPurchases(10);

?>

<table id='purchaseTable'>
	<tr>
		<th class='item'>Item</th>
		<th class='cost'>Total Cost</th>
		<th class='seller'>Seller</th>
		<th class='contact'></th>
		<th class='feedback'></th>
	</tr>

<?php

	while ($row = $purchases->fetch_assoc()) {

		echo("<tr>");
		echo("<td class='item'><a href='viewListing.php?id=".$row['listingID']."'>".$row['listingTitle']."</a></td>");
		
		echo("<td class='cost'>");
			
			$totalCost = $row['listingPostage'] + $row['currentPrice'];
			$totalCostFormatted = sprintf("%01.2f",$totalCost);
			echo("&pound; ".$totalCostFormatted);

		echo("</td>");
		
		echo("<td class='seller'>".$row['username']."</td>");
		echo("<td class='contact'>
						<form method='post' action='contactMember.php'>
							<input type='hidden' value='".$row['username']."' name='user' /> 
							<input type='submit' value='Contact Seller' name='contactSeller' />
						</form>		
					</td>");
		echo("<td class='feedback'>
						<form method='post' action='leaveFeedback.php'>
							<input type='submit' value='Leave Feedback' name='leaveFeedback' />
						</form>
					</td>");
		echo("</tr>");

	}

?>

</table>
