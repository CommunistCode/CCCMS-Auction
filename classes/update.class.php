<?php

	require_once($fullPath . "/includes/global.inc.php");
	require_once($fullPath . "/classes/dbConn.class.php");

	class updateAuction {

		public function update() {

			$db = new dbConn();	

			if ($this->update_1_2_0($db)) {

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

		public function update_1_2_0($db) {

			$this->update_1_1_0($db);

			$query = "ALTER TABLE listings ADD listingPhotos INT";

			if ($db->mysqli->query($query)) {

				echo("listingPhotos added to listing table<br />");

			} else { $error = 1;}

			$query = "ALTER TABLE runningListings ADD listingPhotos INT";

			if ($db->mysqli->query($query)) {

				echo("listingPhotos added to runningListing table<br />");

			} else {$error = 1;}

			if ($db->updateVersion("auction","1.2.0") && !$error) {
	
				echo("<strong>Updated to 1.2.0</strong><br />");

			} else {

				echo("<strong>Update to 1.2.0 failed in some areas</strong><br />");

			}

		}

	}

?>
