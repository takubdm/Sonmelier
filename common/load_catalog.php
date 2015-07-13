<?php
	require_once("load_info.php");

/*

	session_start();

	$dbl = DbLoader::getInstance();
	$dump = $dbl->exec_func_chain(
		array('name' => 'get_list_infos', 'arg' => null)
	);

	*/


	$mysql = array(
		'link' => null,
		'server' => 'localhost',
		'username' => 'root',
		'password' => 'ventretky',
		'db' => 'music_list',
		'table' => 'view_list'
	);;
	//
	$mysql['link'] = mysqli_connect($mysql['server'], $mysql['username'], $mysql['password']);
	mysqli_select_db($mysql['link'], 'music_list');
	//
	$dump = array('catalog_info' => array(), 'category' => array());
	$result = mysqli_query($mysql['link'], "select * from ".$mysql['table'].' order by ID_CATEGORY ASC, Name ASC');
	//
	$current_category = null;
	while ($row = mysqli_fetch_assoc($result))
	{
		if ($current_category != $row['Category'])
		{
			$dump['category'][] = array('id' => $row['ID_Category'], 'name' => $row['Category']);
		}
		$dump['catalog_info'][$row['Category']][] = $row;
		$current_category = $row['Category'];
	}
	//
	mysqli_close($mysql['link']);
	//
	header('Content-type: application/json');
	echo json_encode($dump);;
?>