<?php 

	require_once("../../config/config.php");
	require_once($fullPath . "/admin/includes/global.inc.php");
	require_once($fullPath . "/auction/admin/classes/auctionAdminTools.class.php");
	require_once($fullPath . "/admin/includes/checkLogin.inc.php");

	$auctionAdminTools = new auctionAdminTools();
	$message = NULL;

	if (isset($_POST['newCatSubmit'])) {

			$message = $auctionAdminTools->createCategory($_POST['newCategory'],"main");

	}

	if (isset($_POST['newSubCatSubmit'])) {

		$message = $auctionAdminTools->createCategory($_POST['newSubCat'],$_POST['mainCategorySelection']);

	}

	if (isset($_POST['delCatSubmit'])) {

		$message = $auctionAdminTools->deleteCategory($_POST['categorySelection']);

	}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title>Admin Area - Home</title>
		<link href="../../admin/stylesheet/stylesheet.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<div id="mainContainer">
			<div id="title">
				<?php 
					require_once($fullPath . "/admin/includes/title.inc.php");
				?>
			</div>
			<div id="body">
				<h1>
					Auction Category Management	
				</h1>
				<?php
					
					if ($message != NULL) {

						echo("<p><strong>".$message."</strong></p>");

					}

				?>
				<p>
					Attend to the action you wish to perform below:
				</p>

				<p>
					Create new category:
				</p>
				<form action='manageCategories.php' method='post'>
					<input type='text' name='newCategory' /><br /><br />
					<input type='submit' name='newCatSubmit' value='Create Category' />
				</form>
				<p>
					Create sub category:
				</p>
				<form action='manageCategories.php' method='post'>
					<p> Select parent category: </p>
					<?php echo($auctionAdminTools->renderMainCategoryList()); ?><br /><br />
					<input type='text' name='newSubCat' /><br /><br />
					<input type='submit' name='newSubCatSubmit' value='Create Sub Category' />
				</form>
				<form action='manageCategories.php' method='post'>
					<p> Delete category: </p>
					<?php echo($auctionAdminTools->renderCategoryList()); ?><br /><br />
					<input type='submit' name='delCatSubmit' value='Delete Category' />
				</form>
			</div>
			<div id="links">
				<?php 

					$page=0;

					require_once($fullPath . "/admin/includes/adminLinks.inc.php"); 

				?>
			</div>
			<div id="footer">
				<?php 
					require_once($fullPath . "/admin/includes/footer.inc.php"); 
				?>
			</div>
		</div>
	</body>
</html>



