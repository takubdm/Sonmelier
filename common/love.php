<?php
	/* Constants */
	define(HASH, "#link_list_artist");

	$id_artist = $_POST['id_artist'];
	$love = mb_strlen($_POST['rating'], 'UTF-8')-1;
	$is_ajax = (bool)(int)$_POST['is_ajax'];
	$hide = 0;//$_GET['hide'];

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
	$mysql['link'] = mysqli_connect($mysql['server'], $mysql['username'], $mysql['password']);
	mysqli_select_db($mysql['link'], 'music_list');

	/* Update selected artist's love. */
	$result = mysqli_query($mysql['link'], "update ".$mysql['table']['artist_info']." set Love=".$love.", Hide=".$hide." where ID=".$id_artist);

	/* Retreive artist's recent info. */
	//$result = mysqli_query($mysql['link'], "select Love from ".$mysql['table']['artist_info']." where ID=".$id_artist);
	//$row = mysqli_fetch_assoc($result);

	/* Closing */
	if ($is_ajax)
	{
		header('Content-type: application/json');
		echo json_encode($result);
	}
	else
	{
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: ../index.php".HASH);
	}
?>