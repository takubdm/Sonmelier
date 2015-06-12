<html>
<head>
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />
	<style type="text/css">
	form>*
	{
		display: block;
	}
	</style>
</head>
<body>
	<form action="#">
		<input type="text" data-thvalidator="notnull lowercase" value="123test" />
		<input type="text" data-thvalidator="notnull lowercase" value="12Test32" />
		<input type="text" data-thvalidator="number" value="" />
		<textarea data-thvalidator="notnull">
		</textarea>
		<textarea data-thvalidator="notnull">

	a

		</textarea>
		<input type="submit" value="submit" />
	</form>
	<script src="common/jquery-1.11.0.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="common/thValidator.js"></script>
	<script>

	</script>
</body>
</html>