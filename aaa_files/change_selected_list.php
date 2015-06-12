<?php
	/* Constants */
	define(HASH, "#list_artist");


	$id = $_GET['id'];
	session_start();
	//
	$mysql = array(
		'link' => null,
		'server' => 'localhost',
		'username' => 'root',
		'password' => 'ventretky',
		'db' => 'music_list',
		'table' => array(
			'artist_info' => 'view_artist_info'
		)
	);
	//
	$mysql['link'] = _mysql_connect($mysql['server'], $mysql['username'], $mysql['password']);
	_mysql_select_db('music_list', $mysql['link']);
	$result = _mysql_query("select * from ".$mysql['table']['artist_info']." where ID_List=".$id." AND Hide=0");
	//
	$_SESSION['ID_LIST'] = $id;
	if (mysql_num_rows($result) == 0)
	{
		$_SESSION['ID_LIST'] = '0';
		kill_me('error', 'Selected table does not exist.');
	}
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: ../index.php".HASH);
?>

<?php
	function kill_me($status, $msg)
	{
		$_SESSION['list_edit_result'] = array('msg' => $msg, 'status' => $status);
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: ./index.php");

		// Attention!!
		// Despite the redirect is specified in the above lines, further lines will be executed.
		// In order to redirect immediately, use die() to exit this php script.
		die();
	}
	function _mysql_connect($server, $username, $password)
	{
		$link = mysql_connect($server, $username, $password);
		if (!$link) kill_me('error', mysql_error());
		return $link;
	}
	function _mysql_select_db($db_name, $link)
	{
		$db_selected = mysql_select_db($db_name, $link);
		if (!$db_selected) kill_me('error', mysql_error());
		//return $db_selected;
	}
	function _mysql_query($query)
	{
		$result = mysql_query($query);
		if (!$result) kill_me('error', mysql_error());
		return $result;
	}
?>