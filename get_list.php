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
	$mysql['link'] = _mysql_connect($mysql['server'], $mysql['username'], $mysql['password']);
	_mysql_select_db('music_list', $mysql['link']);
	//
	$dump = array();
	$result = _mysql_query("select * from ".$mysql['table'].' order by ID_CATEGORY ASC, Name ASC');
	while ($row = mysql_fetch_assoc($result))
	{
		if (!$dump[$row['Category']]) $dump[$row['Category']] = array();
		$dump[$row['Category']][] = $row;
	}
	mysql_close($mysql['link']);
	//
	header('Content-type: application/json');
	echo json_encode($dump);
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
?>