<html>
<head>
		<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
		<style>
		*
		{
			font-size: 16px;
			margin: 0;
			padding: 0;
		}
		body
		{
			width: 100%;
			font-family: Meiryo, sans-serif;
		}
		#s1 input, #s2 input
		{
			color: orange;
			font-size: 1.5em;
			border: none;
			background-color: transparent;
			padding: 0.5em 0.0625em;
			-webkit-appearance: none;
			border-radius: 0;
		}
		#s2
		{
			position: relative;
			top: -30px;
		}
		#s2 input
		{
			letter-spacing: 0.125em;
			width: 1.125em;
		}
		#s3 input
		{
			-webkit-appearance: none;
			border-radius: 0;
			border: none;
			border-bottom: 2px solid black;
			background: transparent;
			margin-left: -88px;
		}
		#s3 #text, #s3 input
		{
			//letter-spacing: 0.125em;
			font-family: inherit;
		}
		</style>
</head>
<body>
	<span id="s1">
		<input type="submit" id="t1" value="☆" /><!--
		--><input type="submit" id="t2" value="☆" /><!--
		--><input type="submit" id="t3" value="☆" />
	</span>
	<br />
	<span id="s2">
		<input type="submit" id="tt1" value="☆" /><!--
		--><input type="submit" id="tt2" value="☆☆" /><!--
		--><input type="submit" id="tt3" value="☆☆☆" />
	</span>
	<span id="s3">
		<span id="text">ListName</span>
		<input type="text" value="ListName" />
	</span>
</body>
</html>

