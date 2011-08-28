<?php

	$purchases = $listingTools->getPurchases();

?>

<table>
	<tr>
		<th>Item</th>
		<th>Total Cost</th>
		<th>Seller</th>
		<th></th>
	</tr>

<?php

	while ($row = $purchases->fetch_assoc()) {

		echo("<tr>");
		echo("<td><a href='viewListing.php?id=".$row['listingID']."'>".$row['listingTitle']."</a></td>");
		echo("<td></td>");
		echo("<td>".$row['username']."</td>");
		echo("<td></td>");
		echo("</tr>");

	}

?>

</table>
