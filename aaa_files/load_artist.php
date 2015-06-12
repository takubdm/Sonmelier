<?php
	$id = $_GET['id'] ? $_GET['id'] : $argv[1];
	$mode = $_GET['mode'] ? $_GET['mode'] : $argv[2];
	//
	$mysql = array(
		'link' => null,
		'server' => 'localhost',
		'username' => 'root',
		'password' => 'ventretky',
		'db' => 'music_list',
		'table' => array(
			'list_info' => 'view_list',
			'artist_info' => 'view_artist_info'
		)
	);
	//
	$mysql['link'] = mysqli_connect($mysql['server'], $mysql['username'], $mysql['password']);
	mysqli_select_db($mysql['link'], 'music_list');

	//Get data of each artists.
	$artist_names = array();
	$dump = array();
	$result = mysqli_query($mysql['link'], "select * from ".$mysql['table']['artist_info']." where ID_List=".$id." AND Hide=0");
	while ($row = mysqli_fetch_assoc($result))
	{
		$dump['artist_info'][] = $row;
		$artist_names[] = $row['Name'];
	}
	$artist_names = array_reverse($artist_names);

	//Get a header; information of the catalog.
	$result = mysqli_query($mysql['link'], "select * from ".$mysql['table']['list_info']." where ID_List=".$id);
	while ($row = mysqli_fetch_assoc($result))
	{
		$dump['list_info'][] = $row;
	}
	$dump = array(
		'list_info' => $dump['list_info'][0],
		'artist_info' => array_reverse($dump['artist_info']),
		'artist_names' => $artist_names
	);
	//
	mysqli_close($mysql['link']);
	//
	header('Content-type: application/json');
	echo json_encode($dump);

	die();
?>

	$id = $_GET['id'];
	$mode = $_GET['mode'];
	$is_retry = isset($_GET['retry']);
	//
	$mysql = array(
		'link' => null,
		'server' => 'localhost',
		'username' => 'root',
		'password' => 'ventretky',
		'db' => 'music_list',
		'table' => array(
			'list_info' => 'view_list',
			'artist_info' => 'view_artist_info'
		)
	);
	//
	$mysql['link'] = _mysql_connect($mysql['server'], $mysql['username'], $mysql['password']);
	_mysql_select_db('music_list', $mysql['link']);
	//
	$dump = array(
		'list_info' => array(), 'artist_info' => array()
	);
	$result = _mysql_query("select * from ".$mysql['table']['artist_info']." where ID_List=".$id." AND Hide=0");
	if (mysql_num_rows($result) == 0)
	{
		$_SESSION['ID_LIST'] = '0';
		kill_me($mode, 'error', 'not found');
	}
	while ($row = mysql_fetch_assoc($result))
	{
		array_splice($row, 0, 1);
		$dump['artist_info'][] = implode("\t", $row);
	}
	//
	$result = _mysql_query("select * from ".$mysql['table']['list_info']." where ID_List=".$id);
	while ($row = mysql_fetch_assoc($result))
	{
		$dump['list_info'][] = implode("\t", $row);
	}
	//$dump['artist_info'] = array_reverse($dump['artist_info']);
	echo implode("\n", array_merge($dump['list_info'], $dump['artist_info']));
	//
	mysql_close($mysql['link']);
	$_SESSION['ID_LIST'] = $id;