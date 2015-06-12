<?php
	$id = $_GET['id'] ? $_GET['id'] : $argv[1];
	$mode = $_GET['mode'] ? $_GET['mode'] : $argv[2];
	//

	require_once("load_info.php");
	$dbl = DbLoader::getInstance();
	$current_list = $dbl->exec_func_chain(array(
		array('name' => 'get_current_list_info', 'arg' => $id)
	));

	// If $id is invalid, choose list randomly.
	if ($current_list["current_list"]["info"] == null)
	{
		$list_infos = $dbl->exec_func_chain(array(
			array('name' => 'get_list_infos', 'arg' => null)
		));
		$rand_idx = rand(0, count($list_infos['list_infos']));
		$rand_list = $list_infos['list_infos'][$rand_idx];

		$id = $rand_list["ID_List"];
		$current_list = $dbl->exec_func_chain(array(
			array('name' => 'get_current_list_info', 'arg' => $id)
		));
	}

	//
	$current_list = $current_list['current_list'];
	$list_info = $current_list['info'];
	$artist_info = array_reverse($current_list['artists']);
	$artist_names = array_column_org($artist_info, 'Name');
	$dump = array(
		'list_info' => $list_info,
		'artist_info' => $artist_info,
		'artist_names' => $artist_names
	);

	// Output
	header('Content-type: application/json');
	echo json_encode($dump);
?>
<?php
	// Original function for php less than v5.5.0
	function array_column_org($arrays, $col)
	{
		$result = array();
		foreach($arrays as $arr)
		{
			$result[] = $arr[$col];
		}
		return $result;
	}
?>