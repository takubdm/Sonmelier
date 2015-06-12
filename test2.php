<html>
<head>
		<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
		<style>
		html, body
		{
			margin: 0;
			padding: 0;
		}
		body
		{
			font-size: 30px;
			height: 500000px;
		}
		#cont, #cont2
		{
			background-color: blue;
			overflow-y: scroll;
			-webkit-overflow-scrolling: touch;
		}
		#cont_wrapper
		{
			float: left;
		}
		#cont2_wrapper
		{
			float: right;
		}
		#cont
		{
			height: 300px;
			//min-height: 20%;
			//height: 20%;
			margin: 10px 20px 30px 40px;
			padding: 15px 25px 35px 45px;
			width: 50px;
		}
		#cont2
		{
			height: 200px;
			//min-height: 40%;
			//height: 40%;
			margin: 90px 20px 30px 40px;
			padding: 15px 25px 35px 45px;
			width: 50px;
		}
		</style>
</head>
<body>
	<div id="cont_wrapper">
		<div id="cont">
		1<br />
		2<br />
		3<br />
		4<br />
		5<br />
		6<br />
		7<br />
		8<br />
		9<br />
		10<br />
		11<br />
		12<br />
		13<br />
		14<br />
		15<br />
		16<br />
		17<br />
		18<br />
		19<br />
		20<br />
		21<br />
		22<br />
		23<br />
		24<br />
		25<br />
		26<br />
		27<br />
		28<br />
		29<br />
		30<br />
		31<br />
		32<br />
		33<br />
		34<br />
		35<br />
		36<br />
		37<br />
		38<br />
		39<br />
		40<br />
		41<br />
		42<br />
		43<br />
		44<br />
		45<br />
		46<br />
		47<br />
		48<br />
		49<br />
		50<br />
		51<br />
		52<br />
		53<br />
		54<br />
		55<br />
		56<br />
		57<br />
		58<br />
		59<br />
		60<br />
		61<br />
		62<br />
		63<br />
		64<br />
		65<br />
		66<br />
		67<br />
		68<br />
		69<br />
		70<br />
		71<br />
		72<br />
		73<br />
		74<br />
		75<br />
		76<br />
		77<br />
		78<br />
		79<br />
		80<br />
		</div>
	</div>
	<div id="cont2_wrapper">
	<div id="cont2">
		1<br />
		2<br />
		3<br />
		4<br />
		5<br />
		6<br />
		7<br />
		8<br />
		9<br />
		10<br />
		11<br />
		12<br />
		13<br />
		14<br />
		15<br />
		16<br />
		17<br />
		18<br />
		19<br />
		20<br />
		21<br />
		22<br />
		23<br />
		24<br />
		25<br />
		26<br />
		27<br />
		28<br />
		29<br />
		30<br />
		31<br />
		32<br />
		33<br />
		34<br />
		35<br />
		36<br />
		37<br />
		38<br />
		39<br />
		40<br />
		41<br />
		42<br />
		43<br />
		44<br />
		45<br />
		46<br />
		47<br />
		48<br />
		49<br />
		50<br />
		51<br />
		52<br />
		53<br />
		54<br />
		55<br />
		56<br />
		57<br />
		58<br />
		59<br />
		60<br />
		61<br />
		62<br />
		63<br />
		64<br />
		65<br />
		66<br />
		67<br />
		68<br />
		69<br />
		70<br />
		71<br />
		72<br />
		73<br />
		74<br />
		75<br />
		76<br />
		77<br />
		78<br />
		79<br />
		80<br />
	</div>
	</div>
	<script src="./common/jquery-1.11.0.min.js" type="text/javascript"></script>
	<script src="./common/thScrollArea.js" type="text/javascript"></script>
	<script>
	var th1 = new thScrollArea($('#cont_wrapper>#cont'), 30, 60);
	//th1.appendScrollArea($('#cont_wrapper'));
	var th2 = new thScrollArea($('#cont2_wrapper>#cont2'), 60, 10);
	//th2.appendScrollArea($('#cont2_wrapper'));


	history.pushState(null, "title", "http://192.168.11.60/test/test3.php");
	</script>
</body>
</html>

