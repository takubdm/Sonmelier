<?php
	/* Constants */
	define(CREATE_NEW_CATEGORY, "===Create new category===");
	define(HASH_CREATE, "#link_list_catalog");

	require_once("load_info.php");

	session_start();
	$_SESSION['create_catalog_values'] = array(
		//"list_id" => $_POST['list_id'],
		"list_name" => $_POST['list_name'],
		"title" => $_POST['title'],
		"url" => $_POST['url'],
		"is_shuffle" => (int)($_POST['is_shuffle'] == 'on'),
		"category_name" => $_POST['category_name'],
		"artists" => $_POST['artists']
	);

	$flags = array(
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
		//$flags["ajax"][true]  | $flags["new_category"][true]  =>
		$flags["ajax"][true]  | $flags["new_category"][false] =>
			array(
				'name' => "create",
				'arg' => $_SESSION['create_catalog_values'],
				'next_func' => array(
					'name' => "echo_result_create",
					'arg' => null
				)
			),
		$flags["ajax"][false] | $flags["new_category"][true]  =>
			array(
				'name' => "redirect",
				'arg' => HASH_CREATE,
				'next_func' => null
			),
		$flags["ajax"][false] | $flags["new_category"][false] =>
			array(
				'name' => "create",
				'arg' => null,
				'next_func' => array(
					'name' => "redirect",
					'arg' => HASH_CREATE
				)
			)
	);


	//
	$flags["ajax"]         = $flags["ajax"][(bool)$_POST['is_ajax']];
	$flags["new_category"] = $flags["new_category"][$_POST['category'] == CREATE_NEW_CATEGORY];
	$func_index = $flags["ajax"] | $flags["new_category"];
	//
	$func = $funcs[$func_index];
	call_user_func_array($func['name'], array($func['arg'], $func['next_func']));

	//

?>
<?php
	function echo_result_create($list_id, $dump)
	{
		//
		//$_SESSION['ID_LIST'] = $list_id;
		//
		$dbl = DbLoader::getInstance();
		$dump = array_merge($dump, $dbl->exec_func_chain(array(
			array('name' => 'get_list_infos', 'arg' => array()),
			array('name' => 'get_category_list', 'arg' => array())
		)));
		header('Content-type: application/json');
		echo json_encode($dump);
	}
	function redirect($hash)
	{
		//$_SESSION['ID_LIST'] = $list_id;
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: ../index.php".$hash);
		die();
	}
	function create($posted_values, $next_func)
	{
		//
		$dbl = DbLoader::getInstance();
		$dump = $dbl->exec_func_chain(
			array('name' => 'create_list', 'arg' => $posted_values)
		);
		unset($_SESSION['create_catalog_values']);

		//
		$next_func['arg'] = is_null($next_func['arg']) ? HASH_CREATE : $next_func['arg'];
		call_user_func($next_func['name'], $next_func['arg'], $dump);
	}
?>