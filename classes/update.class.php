<?php

	require_once($fullPath . "/includes/global.inc.php");
	require_once($fullPath . "/classes/dbConn.class.php");

	class updateAuction {

		public function update() {

			$db = new dbConn();	

			if ($this->update_1_1_0($db)) {

				echo("All updates were sucessful!<br />");

			}
			
		}

		private function update_1_1_0($db) {

			$query = "ALTER TABLE listings ADD listingType INT";

			if ($db->mysqli->query($query)) {

				echo("listingType added to listings <br />");

			}

			else {

				echo("Update 1.1.0 failed!<br />");
				echo("<strong>" . $db->mysqli->error . "</strong><br />");

			}

			$query = "ALTER TABLE runningListings ADD listingType INT";

			if ($db->mysqli->query($query)) {

				echo("listingType added to runningListings <br />");

			}

			else {

				echo("Update 1.1.0 failed!<br />");
				echo("<stront>" . $db->mysqli->error ."</strong><br />");

			}

			$query = "CREATE TABLE purchases (
									purchaseID INT NOT NULL AUTO_INCREMENT,
									listingID INT,
									memberID INT,
									purchaseDate INT,
									quantity INT,
									PRIMARY KEY(purchaseID)
									);";

			if ($db->mysqli->query($query)) {

				echo("purchases table created <br />");

			}

			else {

				echo("Update 1.1.0 failed!<br />");
				echo("<stront>" . $db->mysqli->error ."</strong><br />");

			}

			$db->updateVersion("auction","1.1.0");
			echo("<strong>Updated to 1.1.0</strong><br />");

		}

	}

?>
