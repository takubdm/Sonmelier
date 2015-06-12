<html>
<head>
		<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
		<style>
		*
		{
			font-size: 1em;
			margin: 0;
			padding: 0;
		}
		body
		{
			font-size: 30px;
			font-family: 'メイリオ', Meiryo, 'ＭＳ ゴシック', sans-serif;
			padding: 20px;
			margin: 5px;
		}
input, button, textarea, select {
	-webkit-appearance: none;
	border-radius: 0;
	border: 1px solid black;
	background-color: white;
	height: 1.5em;
	margin: auto;
	padding: auto;
}
form
{
	position: relative
}
		</style>
</head>
<body>
	<table>
		<tr>
			<td>111aaaaaaaaaaaaaaaaaaaa</td>
		</tr>
		<tr>
			<td>123aaaaaaaaaaaaaaaaaaaa</td>
		</tr>
		<tr>
			<td>145aaaaaaaaaaaaaaaaaaaa</td>
		</tr>
		<tr>
			<td>199aaaaaaaaaaaaaaaaaaaa</td>
		</tr>
	</table>
	<form action="./test4.php" method="get">
		<select name="tesuto" class="thComboBox" style="z-index: 34; width: 100%">
			<option value="123">test value 1</option>
			<option value="242">test value 2</option>
			<option value="398" selected="selected">test value 3</option>
			<option value="699">test value 4</option>
			<option value="488">test value 5</option>
		</select>
		<input type="submit" value="submit" />
	</form>
	<form action="./test4.php" class="combo" method="get">
		<select name="jikken" class="thComboBox" style="width: 80%">
			<option value="123">test value 1</option>
			<option value="242">test value 2</option>
			<option value="398">test value 3</option>
			<option value="699">test value 4</option>
			<option value="488">test value 5</option>
		</select>
		<input type="submit" value="submit" />
	</form>
	<form action="./test4.php" method="get">
		<input type="text" name="test" />
		<select name="ta32">
			<option value="123">test value 1</option>
			<option value="242">test value 2</option>
			<option value="398">test value 3</option>
			<option value="699">test value 4</option>
			<option value="488">test value 5</option>
		</select>
		<input type="submit" value="submit" />
	</form>
	<div id="trashbox">trash</div>
	<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
	<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
	<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
	<script src="jquery-1.11.0.min.js" type="text/javascript"></script>
	<script src="jquery-ui.js" type="text/javascript"></script>
	<script src="jquery.ui.touch-punch.min.js" type="text/javascript"></script>
	<script src="./thComboBox.js" type="text/javascript"></script>
	<script>

	function color()
	{
		$('table>tbody>tr>td:even').css('background-color', 'red');
		$('table>tbody>tr>td:odd').css('background-color', 'blue');
	}
color();
	var id;
	var draggingObj = null;
	$('table>tbody>tr').draggable({
		helper: "clone",
		start: function(event, ui) {
			draggingObj = $(this);
			$('.ui-draggable-dragging').css('opacity', 0.5);
			console.log('start');
		},
		drag: function()
		{
			$(window).scrollLeft(0);
		},
		stop: function()
		{
			draggingObj = null;
			//$('table>tbody>tr').draggable('disable');
			console.log('stop');
		}
	});
	$('table>tbody>tr').draggable('disable');
	$('table>tbody>tr').bind('mousedown touchstart', function(){
		var self = $(this);
		id = setTimeout(function(){
			$('table>tbody>tr').draggable('enable');
			self.trigger('mousedown');
			console.log('enabled');
		}, 1000);
	});
	$('table>tbody>tr').bind('mouseup touchend', function(){
		clearTimeout(id);
	});
	$('#trashbox').droppable({
		drop: function( event, ui ) {
			$(this).html( "Dropped!" );
			draggingObj.remove();
			color();
			console.log('drop');
		}
	});
	</script>
</body>
</html>

