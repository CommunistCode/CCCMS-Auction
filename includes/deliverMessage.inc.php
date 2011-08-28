<?php 

	if ($listingTools->deliverMessage($_POST['user'],$_POST['message'])) {

		echo("Message was sent to <strong>".$_POST['user']."</strong>");

	} else {

		echo("An error occurred please try again!");

	}

?>
