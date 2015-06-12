<?php
	$text = "!\"#$%&'()=~|^\`{@[*}:]<>?_,./\\あいうえお実験";


class MySingleton {
        private static $instance;

        //コンストラクタ
        private function __construct() {
        	echo get_class($this);
        }

        //インスタンスを返す
        public static function getInstance() {
                if (!isset(self::$instance)) {
                        self::$instance = new MySingleton();
                }
                return self::$instance;
        }

        /**
         * このインスタンスの複製を許可しないようにする
         */
        public final function __clone() {
                throw new RuntimeException('クローンの作成は許可されていません' . get_class($this));
        }
}

//クライアントの想定
$instance1 = MySingleton::getInstance();
$instance2 = MySingleton::getInstance();
//cloneできないことを確認する
echo 'クローンを作ってみると・・・', PHP_EOL;
///$instance1_clone = clone $instance1;
?>
<html>
<head>
<style>
*
{
	margin: 0;
	padding: 0;
}
html, body
{
	height: 100%;
}
body
{
	margin: 0;
	padding: 0;
}
div#wrapper {
    width: 100%;
    background-color: red;
}
div#main {
    width: 100%;
    float: right;
    background-color: orange;
}
div#mainContent {
    margin-left: 200px;
    background-color: blue;
}
div#sub {
    width: 200px;
    margin-right: -200px;
    float: left;
    background-color: green;
}

</style>
</head>
<body>
	<div id="wrapper">
		<div id="main">
			<div id="mainContent">div#main</div>
		</div>
		<div id="sub">div#sub</div>
	</div>
	<div id="wrapper">
		<div id="main">
			<div id="mainContent">div#main</div>
		</div>
		<div id="sub">div#sub</div>
	</div>
</body>
</html>