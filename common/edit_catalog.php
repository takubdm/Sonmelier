<?php
	/*
	In order to execute this script on non-javascript environment,
	two processes (edit and remove) are coded in this file.
	Whether edit or remove, this script will be executed from same form and
	selects procedure with a value of submit button.

	The form of Controller should be the following;
	<form action="this_script.php">
		<input type="submit" value="edit" />
		<input type="submit" value="remove" />
	</form>
	*/

	/* Constants */
	define(CREATE_NEW_CATEGORY, "===Create new category===");
	define(HASH_EDIT, "#link_catalog_edit");
	define(HASH_REMOVE, "#link_list_catalog");

	require_once("load_info.php");

	$process = $_POST['process'];

	session_start();
	$_SESSION['edit_catalog_values'] = array(
		"list_id" => $_POST['list_id'],
		"list_name" => $_POST['list_name'],
		"title" => $_POST['title'],
		"url" => $_POST['url'],
		"is_shuffle" => (int)($_POST['is_shuffle'] == 'on'),
		"category_name" => $_POST['category_name'],
		"artists" => $_POST['artists']
	);

	$flags = array(
		"process" => array(
			"edit" => 1,
			"remove" => 2
		),
		"ajax" => array(
			false => 4,
			true => 8
		),
		"new_category" => array(
			false => 16,
			true => 32
		)
	);
	$funcs = array(
//	    $flags["process"]["edit"]   | $flags["ajax"][true]  | $flags["new_category"][true]  =>
		$flags["process"]["edit"]   | $flags["ajax"][true]  | $flags["new_category"][false] =>
			array(
				'name' => "edit",
				'arg' => $_SESSION['edit_catalog_values'],
				'next_func' => array(
					'name' => "echo_result_edit",
					'arg' => $_SESSION['edit_catalog_values']['list_id']
				)
			),
		$flags["process"]["edit"]   | $flags["ajax"][false] | $flags["new_category"][true]  =>
			array(
				'name' => "redirect",
				'arg' => HASH_EDIT,
				'next_func' => null
			),
		$flags["process"]["edit"]   | $flags["ajax"][false] | $flags["new_category"][false] =>
			array(
				'name' => "edit",
				'arg' => null,
				'next_func' => array(
					'name' => "redirect",
					'arg' => HASH_EDIT
				)
			),
		$flags["process"]["remove"] | $flags["ajax"][true]  | $flags["new_category"][false] =>
			array(
				'name' => "remove",
				'arg' => $_SESSION['edit_catalog_values']['list_id'],
				'next_func' => array(
					'name' => "echo_result_delete",
					'arg' => $_SESSION['edit_catalog_values']['list_id']
				)
			),
		$flags["process"]["remove"] | $flags["ajax"][false] | $flags["new_category"][false] =>
			array(
				'name' => "remove",
				'arg' => $_SESSION['edit_catalog_values']['list_id'],
				'next_func' => array(
					'name' => "redirect",
					'arg' => HASH_REMOVE
				)
			)
	);
	//
	$flags["process"]      = $flags["process"][$_POST['process']];
	$flags["ajax"]         = $flags["ajax"][(bool)$_POST['is_ajax']];
	$flags["new_category"] = $flags["new_category"][$_POST['category'] == CREATE_NEW_CATEGORY];
	$func_index = $flags["process"] | $flags["ajax"] | $flags["new_category"];
	//
	$func = $funcs[$func_index];
	call_user_func_array($func['name'], array($func['arg'], $func['next_func']));

	//

?>
<?php
	function echo_result_delete($list_id, $dump)
	{
		$dbl = DbLoader::getInstance();
		$dump = array_merge($dump, $dbl->exec_func_chain(array(
			array('name' => 'get_list_infos', 'arg' => null),
			array('name' => 'get_category_list', 'arg' => null)
		)));
		header('Content-type: application/json');
		echo json_encode($dump);
	}
	function echo_result_edit($list_id, $dump)
	{
		$dbl = DbLoader::getInstance();
		$dump = array_merge($dump, $dbl->exec_func_chain(array(
			array('name' => 'get_list_infos', 'arg' => null),
			array('name' => 'get_current_list_info', 'arg' => $list_id),
			array('name' => 'get_category_list', 'arg' => null)
		)));
		header('Content-type: application/json');
		echo json_encode($dump);
	}
	function redirect($hash)
	{
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: ../index.php".$hash);
		die();
	}
	function edit($posted_values, $next_func)
	{
		$dbl = DbLoader::getInstance();
		$dump = $dbl->exec_func_chain(
			array('name' => 'edit_list', 'arg' => $posted_values)
		);
		unset($_SESSION['edit_catalog_values']);
		//
		$next_func['arg'] = is_null($next_func['arg']) ? HASH_EDIT : $next_func['arg'];
		call_user_func($next_func['name'], $next_func['arg'], $dump);
	}
	function remove($list_id, $next_func)
	{
		$dbl = DbLoader::getInstance();
		$dump = $dbl->exec_func_chain(
			array('name' => 'remove_list', 'arg' => $list_id)
		);
		$next_func['arg'] = is_null($next_func['arg']) ? HASH_REMOVE : $next_func['arg'];
		call_user_func($next_func['name'], $next_func['arg'], $dump);
	}
?>
