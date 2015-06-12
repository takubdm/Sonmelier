<?php
	$mysql = array(
		'link' => null,
		'server' => 'localhost',
		'username' => 'root',
		'password' => 'ventretky',
		'db' => 'music_list',
		'table' => 'view_list'
	);
	//
	$mysql['link'] = mysqli_connect($mysql['server'], $mysql['username'], $mysql['password']);
	mysqli_select_db($mysql['link'], 'music_list');
	//
	$dump = array('category_info' => array(), 'category_names' => array());
	$result = mysqli_query($mysql['link'], "select * from ".$mysql['table'].' order by ID_CATEGORY ASC, Name ASC');
	while ($row = mysqli_fetch_assoc($result))
	{
		if (!$dump['category_info'][$row['Category']])
		{
			$dump['category_info'][$row['Category']] = array();
			$dump['category_names'][] = $row['Category'];
		}
		$dump['category_info'][$row['Category']][] = $row;
	}
	//
	mysqli_close($mysql['link']);
	//
	header('Content-type: application/json');
	echo json_encode($dump);
?>