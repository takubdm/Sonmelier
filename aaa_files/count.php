<?php
	session_start();
	$id = $_GET['id'];
	$mode = $_GET['mode'];
	//
	$mysql = array(
		'link' => null,
		'server' => 'localhost',
		'username' => 'root',
		'password' => 'ventretky',
		'db' => 'music_list',
		'table' => array(
			'artist_info' => 'artist_info'
		)
	);
	//
	$mysql['link'] = _mysql_connect($mysql['server'], $mysql['username'], $mysql['password']);
	_mysql_select_db('music_list', $mysql['link']);
	_mysql_query("update ".$mysql['table']['artist_info']." set Count=Count+1 where ID=".$id);
	$result = _mysql_query("select * from ".$mysql['table']['artist_info']." where ID=".$id);
	$row = mysql_fetch_assoc($result);
	echo $row['Count'];
	mysql_close($mysql['link']);
	$_SESSION['ID_ARTIST'] = $id;
	//
	if ($mode != 'ajax') redirect('https://www.youtube.com/results?search_query='.$row['Name']);
?>
<?php
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
	function redirect($link)
	{
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: ".$link);
	}
?>