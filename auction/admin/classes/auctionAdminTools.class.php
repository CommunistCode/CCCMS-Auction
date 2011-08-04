<?php

	class auctionAdminTools {

		public function createCategory($name,$parent) {

			$db = new dbConn();

			if ($db->insert("auctionCategories","categoryName, parentCategory","'".$name."','".$parent."'")) {

				return $name ." category was sucessfully created!"; 

			}

			else {

				return $name ." category could not be created!";

			}

		}

		public function deleteCategory($id) {

			$db = new dbConn();

			if ($db->delete("auctionCategories","categoryID='".$id."'")) {

				return "Category was sucessfully deleted!";
			
			}

			else {

				return "Category could not be deleted!";

			}

		}

		public function renderMainCategoryList() {

			$db = new dbConn();
		
			$result = $db->selectWhere("categoryID,categoryName","listingCategories","parentCategory='main'",0);

			$render = "<select name='mainCategorySelection'>\n";

			while ($resultArray = $result->fetch_assoc()) {

				$render .= "<option value='".$resultArray['categoryID']."'>".$resultArray['categoryName']."</option>\n";

			}

			$render .= "</select>\n";

			return $render;

		}

		public function renderCategoryList() {

			$db = new dbConn();
		
			$result = $db->select("categoryID,categoryName","listingCategories", 0);

			$render = "<select name='categorySelection'>\n";

			while ($resultArray = $result->fetch_array(MYSQLI_ASSOC)) {

				$render .= "<option value='".$resultArray['categoryID']."'>".$resultArray['categoryName']."</option>\n";

			}

			$render .= "</select>\n";

			return $render;

		}

	}

?>
