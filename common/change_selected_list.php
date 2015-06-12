<?php
	require_once("load_info.php");
	$dbl = DbLoader::getInstance();

	/* Constants */
	define(HASH, "#link_list_artist");

	$id = $_GET['id'];
	$is_ajax = (bool)(int)$_GET['is_ajax'];

	session_start();
	$result = $dbl->exec_func_chain(
		array('name' => 'get_current_list_info', 'arg' => array($id))
	);
	$list = $result['current_list'];

	$_SESSION['edit_catalog_values'] = array(
		"list_id" => $list['info']['ID_List'],
		"list_name" => $list['info']['Name'],
		"title" => $list['info']['Title'],
		"url" => $list['info']['Url'],
		"category" => $list['info']['ID_Category'],
		"is_shuffle" => $list['info']['IsShuffle'],
		"artists" => implode("\n", $dbl->get_array($list['artists'], 'Name'))
		//"artists" => array_column($list['artists'], 'Name')
	);

	$_SESSION['ID_LIST'] = $id;

	if ($is_ajax)
	{
		echo json_encode($dbl->exec_func_chain(array(
			array('name' => 'get_current_list_info', 'arg' => array($_SESSION['ID_LIST'])),
			array('name' => 'get_category_list', 'arg' => array())
		)));
	}
	else
	{
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: ../index.php".HASH);
	}
?>
<?php
?>