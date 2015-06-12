<?php
	/* Constants */
	define(CREATE_NEW_CATEGORY, "===Create new category===");
	define(HASH, "#catalog_create");

	//
	$create_catalog_values = array(
		"list_name" => $_POST['list_name'],
		"title" => $_POST['title'],
		"url" => $_POST['url'],
		"category" => $_POST['category'],
		"is_shuffle" => $_POST['is_shuffle'],
		"artists" => $_POST['artists'],
		"is_ajax" => $_POST['is_ajax']
	);

	not_ajax($create_catalog_values);
?>
<?php
	function not_ajax($create_catalog_values)
	{
		if ($create_catalog_values['category'] == CREATE_NEW_CATEGORY)
		{
			session_start();
			$_SESSION['create_catalog_values'] = array(
				"list_name" => $create_catalog_values['list_name'],
				"title" => $create_catalog_values['title'],
				"url" => $create_catalog_values['url'],
				"category" => $create_catalog_values['category'],
				"is_shuffle" => $create_catalog_values['is_shuffle'],
				"artists" => $create_catalog_values['artists'],
				"is_ajax" => $create_catalog_values['is_ajax']
			);
			//
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: ../index.php".HASH);
			die();
		}
		else
		{
			echo "update";
		}
	}
?>
