<?php

	require_once($fullPath . "/includes/global.inc.php");
	require_once($fullPath . "/classes/dbConn.class.php");
	require_once($fullPath . "/classes/versionTools.class.php");

	class updateAuction {

		public function update() {

			$db = new dbConn();
			$vt = new versionTools();

			if (!$vt->isVersionGreater("auction","1.2.0")) {

				echo("Already up-to-date at version 1.2.0");
				return;

			}

			if ($this->update_1_2_0($db,$vt)) {

				echo("All updates were sucessful!<br />");

			} else {

				echo("Not all updates were successful<br />");
			
			}
			
		}

		private function update_1_1_0($db, $vt) {

			if (!$vt->isVersionGreater("auction","1.1.0")) {

				return;

			}
			
			$query = "ALTER TABLE listings ADD listingType INT";

			if ($db->mysqli->query($query)) {

				echo("listingType added to listings <br />");

			} else { $error = 1; }

			$query = "ALTER TABLE runningListings ADD listingType INT";

			if ($db->mysqli->query($query)) {

				echo("listingType added to runningListings <br />");

			} else { $error = 1; }

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

			} else { $error = 1; }

			if (!$error) {

				if ($db->updateVersion("auction","1.1.0")) {

					echo("<strong>Updated to 1.1.0</strong><br />");
					return -1;

				} else {

					echo("<strong>Update to version 1.1.0 complete but could not update version database!");
					return -1;

				}

			} else {

				echo("<strong>Update to 1.1.0 failed in some areas</strong>");
				return 1;

			}

		}

		public function update_1_2_0($db, $vt) {

			if (!$vt->isVersionGreater("auction","1.2.0")) {

				return;

			} else {
			
				if (!$this->update_1_1_0($db, $vt)) {

					return -1;

				}

			}

			$query = "ALTER TABLE listings ADD listingPhotos INT";

			if ($db->mysqli->query($query)) {

				echo("listingPhotos added to listing table<br />");

			} else { $error = 1; }	

			$query = "ALTER TABLE runningListings ADD listingPhotos INT";

			if ($db->mysqli->query($query)) {

				echo("listingPhotos added to runningListing table<br />");

			} else { $error = 1; }

			if (!$error) {

				if ($db->updateVersion("auction","1.2.0")) {

					echo("<strong>Updated to 1.2.0</strong><br />");

				} else {

					echo("<strong>Update to version 1.2.0 complete but could not update version database!<br />");

				}

			} else {

				echo("<strong>Update to 1.2.0 failed in some areas</strong><br />");

			}

		}

	}

?>
