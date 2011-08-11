<?php

	require_once("../includes/global.inc.php");
	require_once($fullPath . "/classes/dbConn.class.php");

	class updateAuction {

		public function update() {

			$db = new dbConn();	

			if ($this->update_1_0_1()) {

				echo("All updates were sucessful!<br />");

			}
			
		}

		private function update_1_0_1() {

			$query = "ALTER TABLE listings ADD listingType INT";

			if ($db->mysqli->query($query)) {

				echo("listingType added to listings <br />");

			}

			else {

				echo("Update 1.0.1 failed!<br />");
				echo("<strong>" . $db->mysqli->error . "</strong><br />");

			}

		}

	}

?>
