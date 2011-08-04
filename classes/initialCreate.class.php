<?php

	require_once("../includes/global.inc.php");
	require_once($fullPath . "/classes/dbConn.class.php");

	class initialCreateAuction {
	
		public function createTables() {

			$db = new dbConn();

			$query = "

				CREATE TABLE listings (
        listingID INT NOT NULL AUTO_INCREMENT,
				memberID INT,
				listingTitle TEXT,
        listingDescription TEXT,
        listingPostage DECIMAL(10,2),
        listingQuantity SMALLINT,
        listingStartPrice DECIMAL(10,2),
        listingDuration INT,
				editDate INT,
				PRIMARY KEY(listingID)
        );";	
			
			if ($db->mysqli->query($query)) {

				echo("listings table created<br />");

			}

			else {

				echo($db->mysqli->error . "<br />");

			}

			$query = "

				CREATE TABLE runningListings (
				runningListingID INT NOT NULL AUTO_INCREMENT,
				memberID INT,
				listingTitle TEXT,
				listingDescription TEXT,
				listingPostage TEXT,
				listingQuantity INT,
				listingStartPrice DECIMAL(10,2),
				listingDuration INT,
				startDate INT,
				endDate INT,
				currentPrice DECIMAL(10,2),
				reserverPrice DECIMAL(10,2),
				listingRunning BOOL,
				PRIMARY KEY(runningListingID)
				);";

			if($db->mysqli->query($query)) {

				echo("runningListings table created <br />");

			}

			else {

				echo($db->mysqli->error . "<br />");

			}

			$query = "

				CREATE TABLE bids (
				bidID INT NOT NULL AUTO_INCREMENT,
				listingID INT,
				memberID INT,
				bidAmount DECIMAL(10,2),
				bidDate INT,
				PRIMARY KEY(bidID)
				);";

			if($db->mysqli->query($query)) {

				echo("bids table created <br />");

			}

			else {

				echo($db->mysqli->error . "<br \>");

			}
			
			$query = "

				CREATE TABLE listingCategories (
				categoryID INT NOT NULL AUTO_INCREMENT,
				categoryName TEXT,
				parentCategory TEXT,
				PRIMARY KEY(categoryID)
				);";

			if ($db->mysqli->query($query)) {

				echo("auctionCategories table created<br />");

			}

			else {

				echo($db->mysqli->error ."<br />");

			}

		}

		public function populateTables() {

			$db = new dbConn();

			if ($db->checkExists("adminContent","name","Auction Module")) {

				echo("adminContent already populated with Auction Module<br />");

			}
			
			else {
	
				$query = "

					INSERT INTO adminContent (
						name,
						link,
						category
					) values (
						'Auction Module',
						'/auction/admin/auctionModule.php',
						'main'
					), (
						'Manage Categories',
						'/auction/admin/manageCategories.php',
						'Auction Module'
					);";

				if ($db->mysqli->query($query)) {

					echo("adminContent populated<br />");

				}

			}

			if ($db->checkExists("dContent","title","Auction")) {

				echo("dContent already populated with auction link <br />");

			}

			else {

				$query = "

					INSERT INTO dContent (
						title,
						linkName,
						directLink
					) values (
						'Auction',
						'Auction',
						'auction/index.php'
					);";

				if ($db->mysqli->query($query)) {

					echo("dContent populated");

				}

			}

			if ($db->checkExists("memberLinks","linkName","Create Listing")) {

				echo("memberLinks already populated <br />");

			}

			else {

				$query = "

					INSERT INTO memberLinks (
						linkName,
						destination,
						category	
					) values (
						'Create Listing',
						'../auction/createListing.php',
						'Listing Tools'), (
						'Saved Listings',
						'../auction/savedListings.php',
						'Listing Tools'), (
						'Running Listings',
						'../auction/runningListings.php',
						'Listing Tools'), (
						'My Bids',
						'../auction/myBids.php',
						'Listing Tools'), (
						'Purchases',
						'../auction/purchases.php',
						'Listing Tools'
					);";

				if ($db->mysqli->query($query)) {

					echo("memberLinks populated");

				}

			}

		}

	}

?>
