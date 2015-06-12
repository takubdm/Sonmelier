<?php
	session_start();
	$mode = $_GET['mode'];
	$is_artist_invalid = !remove_empty_line($_POST['artists']);
	if ($is_artist_invalid) kill_me($mode, array('status'=>'error', 'message'=>'Invalid data has been sent: Artists must not be null. All lines will be trimmed.'));
	//
	$mysql = array(
		'link' => null,
		'server' => 'localhost',
		'username' => 'root',
		'password' => 'ventretky',
		'db' => 'music_list',
		'table' => array(
			'list' => 'list',
			'artists' => 'artist_and_list'
		)
	);
	//
	$mysql['link'] = new mysqli($mysql['server'], $mysql['username'], $mysql['password'], $mysql['db']);
	if ($mysql['link']->connect_errno) kill_me($mode, array('status'=>'error', 'message'=>$mysql['link']->connect_error));
	//
	$delimiter = '\r\n';
	$list_id = $mysql['link']->real_escape_string($_POST['list_id']);
	$list_name = $mysql['link']->real_escape_string(unescape($_POST['list_name']));
	$title = $mysql['link']->real_escape_string(unescape($_POST['title']));
	$url = $mysql['link']->real_escape_string($_POST['url']);
	$shuffle = $mysql['link']->real_escape_string($_POST['shuffle']);
	$category = $mysql['link']->real_escape_string(unescape($_POST['category']));
	$artists = $mysql['link']->real_escape_string(remove_empty_line(unescape($_POST['artists']))).'\r\n';
	$artists_before = $mysql['link']->real_escape_string(remove_empty_line(unescape($_POST['artists_before']))).'\r\n';
	//
	$query = "lock tables `artist_and_list` write, `artist_info` write, `category` write, `list` write, `temp_db_before` write, `temp_db_current` write, `temp_db_minus` write";
	$result = $mysql['link']->query($query);
	//
	$query = "call edit_list(".$list_id.", '".$list_name."', '".$title."', '".$url."', ".$shuffle.", '".$category."', '".$delimiter."', '".$artists."', '".$artists_before."');";
	$result = $mysql['link']->query($query);
	$operation = array_values($result->fetch_assoc());
	if (!$result) kill_me($mode, array('status'=>'error', 'message'=>mysqli_error($mysql['link'])));
	//
	$query = "unlock tables";
	$result = $mysql['link']->query($query);
	$mysql['link']->close();
	//
	$categories = array();
	$mysql['link'] = new mysqli($mysql['server'], $mysql['username'], $mysql['password'], $mysql['db']);
	if ($mysql['link']->connect_errno) kill_me($mode, array('status'=>'error', 'message'=>$mysql['link']->connect_error));
	$query = "select `Name` from `category` order by `ID` ASC;";
	$result = $mysql['link']->query($query);
	if (!$result) kill_me($mode, array('status'=>'error', 'message'=>mysqli_error($mysql['link'])));
	while ($row = $result->fetch_assoc())
	{
		$is_selected = $row['Name'] == unescape($_POST['category']);
		$categories[] = array(
			'Name' => $row['Name'],
			'Selected' => $is_selected
		);
	}
	//
	$msg = 'List "'.unescape($_POST['list_name']).'" has '.$operation[0].' successfully.';
	kill_me($mode, array('status'=>'success', 'message'=>$msg, 'categories'=>$categories));
?>
<?php
	function kill_me($mode, $dump)
	{
		switch ($mode)
		{
			case 'ajax':
				header('Content-type: application/json');
				echo json_encode($dump);
				die();
				break;
			default:
				$_SESSION['list_edit_result'] = array('msg' => $dump['message'], 'status' => $dump['status']);
				header("HTTP/1.1 301 Moved Permanently");
				header("Location: ./index.php");

				// Attention!!
				// Despite the redirect is specified in the above lines, further lines will be executed.
				// In order to redirect immediately, use die() to exit this php script.
				die();
		}
	}
	function remove_empty_line($text)
	{
		$removed_array = array();
		//
		$array = explode("\n", $text);
		foreach($array as $line)
			if (!preg_match("/^[ 　\r]+$/", $line))
				$removed_array[] = trim($line, " 　\t\n\r\0\x0B");
		return implode("\r\n", array_reverse($removed_array));
	}

function unescape($source, $iconv_to = 'UTF-8') {
    $decodedStr = '';
    $pos = 0;
    $len = strlen ($source);
    while ($pos < $len) {
        $charAt = substr ($source, $pos, 1);
        if ($charAt == '%') {
            $pos++;
            $charAt = substr ($source, $pos, 1);
            if ($charAt == 'u') {
                // we got a unicode character
                $pos++;
                $unicodeHexVal = substr ($source, $pos, 4);
                $unicode = hexdec ($unicodeHexVal);
                $decodedStr .= code2utf($unicode);
                $pos += 4;
            }
            else {
                // we have an escaped ascii character
                $hexVal = substr ($source, $pos, 2);
                $decodedStr .= chr (hexdec ($hexVal));
                $pos += 2;
            }
        }
        else {
            $decodedStr .= $charAt;
            $pos++;
        }
    }

    if ($iconv_to != "UTF-8") {
        $decodedStr = iconv("UTF-8", $iconv_to, $decodedStr);
    }

    return $decodedStr;
}

/**
* Function coverts number of utf char into that character.
* Function taken from: http://sk2.php.net/manual/en/function.utf8-encode.php#49336
*
* @param int $num
* @return utf8char
*/
function code2utf($num){
    if($num<128)return chr($num);
    if($num<2048)return chr(($num>>6)+192).chr(($num&63)+128);
    if($num<65536)return chr(($num>>12)+224).chr((($num>>6)&63)+128).chr(($num&63)+128);
    if($num<2097152)return chr(($num>>18)+240).chr((($num>>12)&63)+128).chr((($num>>6)&63)+128) .chr(($num&63)+128);
    return '';
}
?>