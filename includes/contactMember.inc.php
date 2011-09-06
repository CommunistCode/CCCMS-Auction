<form method='post' action='contactMember.php'>

<?php

	if(isset($_POST['user'])) {
	
		$user = $_POST['user'];

	} else if (isset($_GET['user'])) {

		$user = $_GET['user'];

	}

?>

	<input type='hidden' name='user' value='<?php echo($user); ?>' />

	<table id='contactSeller'>
		<tr>
			<th>User</td>
			<td>
				<?php 

						

					if ($user) {

						echo($user);
					
					} else {

						echo("<font color='red'>An error has occurred, please try again!</font>");

					}
					
				?>
			</td>
			<td class='submit'><input type='submit' value='Send Message' name='sendMessage' />
		</tr>
		<tr>
			<th class='messageHeading'>Message</td>
			<td class='messageText' colspan='2'><textarea rows='30' cols='87' name='message'></textarea></td>
		</tr>
	</table>

</form>
