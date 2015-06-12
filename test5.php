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
		</style>
</head>
<body>

<a href="http://www.google.co.jp/" target="_blank">google</a>

<script src="jquery-1.11.0.min.js" type="text/javascript"></script>
	<script>
	$(function(){
/*
		var href = $('a').attr('href');
		$('a').attr('href', 'javascript:void(0);');
		$('a').bind('click', function(e){
			window.open(href);
		});
*/
/*
		$('a').bind('click', {"go": false}, function(e){
			var self = $(this);
			setTimeout(function(){
				self.trigger('click', {"go": true});
			}, 1000);
			return e.data.go;
		});
		*/
		var a = $('a')[0];
		a.addEventListener('click', f(false));

		function f(bool)
		{
			return function()
			{
				return bool;
			}
		}
	});
	</script>
</body>
</html>

