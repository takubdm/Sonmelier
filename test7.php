<html>
<head>
		<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">

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
	overflow: hidden;
}
#w
{
	width: 100%;
	overflow: hidden;
	padding-bottom: 2em;
}
#wrapper {
	//border: 1px solid red;
	width: 100%;
	height: 100%;
	//padding-bottom: 2em;
	//box-sizing: border-box;
}
h1,
.contents {
	//border: 1px solid blue;
	width: 25%;
	float: left;
	min-height: 100%;
	//transition: margin-left 3.1s ease-out 0;
}
h1
{
	display: none;
}
#c1
{
	background-color: red;
}
#c2
{
	background-color: blue;
}
#c3
{
	background-color: orange;
}
#c4
{
	background-color: purple;
}
/*
#dummy:after,
#wrapper:after{
	content: "";
	clear: both;
	display: block;
}
*/
#navigation
{
	clear: both;
	background-color: green;
	height: 2em;
	//position: absolute;
	//top: 100%;
	margin-top: -2em;
	opacity: 0.5;
}
a
{
	margin: 0px 30px;
}

#d1:target ~ #c1 { //margin-left: -25%; }
#d1:target ~ #c2,
#d1:target ~ #c3,
#d1:target ~ #c4 { max-height: 100%; }

#d2:target ~ #c2 { margin-left: -25%; }
#d2:target ~ #c1,
#d2:target ~ #c3,
#d2:target ~ #c4 { max-height: 100%; }

#d3:target ~ #c2 { margin-left: -50%; }
#d3:target ~ #c3 { margin-left: -25%; }
#d3:target ~ #c1,
#d3:target ~ #c2,
#d3:target ~ #c4 { max-height: 100%; }

#d4:target ~ #c2 { margin-left: -75%; }
#d4:target ~ #c3 { margin-left: -50%; }
#d4:target ~ #c4 { margin-left: -25%; }
#d4:target ~ #c1,
#d4:target ~ #c2,
#d4:target ~ #c3 { max-height: 100%; }

/*
#d1:target ~ #c2,
#d1:target ~ #c3,
#d1:target ~ #c4
{
	//display: none;
}
#d2:target ~ #c1,
#d2:target ~ #c3,
#d2:target ~ #c4
{
	//display: none;
}
#d3:target ~ #c1,
#d3:target ~ #c2,
#d3:target ~ #c4
{
	//display: none;
}
#d4:target ~ #c1,
#d4:target ~ #c2,
#d4:target ~ #c3
{
	//display: none;
}
*/

</style>
</head>
<body>
<div id="w">
	<div id="wrapper">
		<h1 id="d1">1</h1>
		<h1 id="d2">2</h1>
		<h1 id="d3">3</h1>
		<h1 id="d4">4</h1>
		<div class="contents" id="c1" style="">1<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /></div>
		<div class="contents" id="c2" style="">2<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /></div>
		<div class="contents" id="c3" style="">3<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /></div>
		<div class="contents" id="c4" style="">4<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /></div>
	</div>
</div>
	<div id="navigation">
		<a href="#d1">c1</a>
		<a href="#d2">c2</a>
		<a href="#d3">c3</a>
		<a href="#d4">c4</a>
	</div>
</body>
</html>