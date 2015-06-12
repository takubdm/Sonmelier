<?php
	session_start();
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
?>
<?php
	function kill_me($mode, $status, $msg)
	{
		switch ($mode)
		{
			case 'ajax':
				die($msg);
				break;
			case 'get_contents':
				$_SESSION['list_edit_result'] = array('msg' => $msg, 'status' => $status);
				die();
				break;
				/*
			default:
				header("HTTP/1.1 301 Moved Permanently");
				header("Location: ./index.php");

				// Attention!!
				// Despite the redirect is specified in the above lines, further lines will be executed.
				// In order to redirect immediately, use die() to exit this php script.
				die();
				*/
		}
	}
	function _mysql_connect($server, $username, $password)
	{
		$link = mysql_connect($server, $username, $password);
		if (!$link) die(mysql_error());
		return $link;
	}
	function _mysql_select_db($db_name, $link)
	{
		$db_selected = mysql_select_db($db_name, $link);
		if (!$db_selected) die(mysql_error());
		//return $db_selected;
	}
	function _mysql_query($query)
	{
		$result = mysql_query($query);
		if (!$result) die(mysql_error());
		return $result;
	}
?>