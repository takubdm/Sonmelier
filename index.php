<?php
	$user_agent = $_SERVER["HTTP_USER_AGENT"];
	$is_mobile = preg_match("/iPhone|Android/i", $user_agent);
	if (isset($_GET['debug']))
	{
		if ($_GET['mode'] == "desktop") $is_mobile = false;
		else if ($_GET['mode'] == "mobile") $is_mobile = true;
	}
	if ($is_mobile)
	{
		include("mobile/index.php");
	}
	else
	{
		include("desktop/index.php");
	}
?>