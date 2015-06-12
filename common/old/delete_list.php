<?php
	/* Constants */
	define(HASH, "#link_list_catalog");

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


<?php
	session_start();
	$is_ajax = !isset($_GET['ajax']);
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
	if ($mysql['link']->connect_errno) kill_me($is_ajax, 'error', $mysql['link']->connect_error);
	//
	$list_id = $mysql['link']->real_escape_string($_POST['list_id']);
	$query = "lock tables `artist_and_list` write, `list` write";
	$result = $mysql['link']->query($query);
	//
	$query = "delete from `list` where `ID`=".$list_id.";";
	$result = $mysql['link']->query($query);
	if (!$result) kill_me($is_ajax, 'error', mysqli_error($mysql['link']));
	//
	$query = "unlock tables";
	$result = $mysql['link']->query($query);
	//
	$mysql['link']->close();
	//
	$msg = 'List "'.unescape($_POST['list_name']).'" has deleted successfully.';
	kill_me($is_ajax, 'success', $msg);
?>
<?php
	function kill_me($is_ajax, $status, $msg)
	{
		if ($is_ajax)
		{
			$_SESSION['list_edit_result'] = array('msg' => $msg, 'status' => $status);
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: ./index.php");

			// Attention!!
			// Despite the redirect is specified in the above lines, further lines will be executed.
			// In order to redirect immediately, use die() to exit this php script.
			die();
		}
		else
		{
			die($msg);
		}
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