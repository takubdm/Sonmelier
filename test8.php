<html>
<head>
		<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
<style>
*
{
	margin: 0;
	padding: 0;
	line-height: 1.0em;
	font-size: 24px;
	box-sizing: border-box;
    -webkit-appearance: none;
    -webkit-border-radius: 0px;
}
html, body
{
	width: 100%;
	height: 100%;
}
body
{
	margin: 0;
	padding: 0;
	font-family: Meiryo, sans-serif;
	width: 100%;
}
input[type=textbox],
select,
textarea
{
	font-family: inherit;
	border: none;
	background: transparent;
	width: 150px;
}
.input
{
	position: relative;
	//left: -140px;
	//background-color: orange;
	width: 100px;
}
input[type=radio]
{
	padding: 7px;
}
.label
{
	background-color: green;
	width: 140px;
	vertical-align: top;
}
table
{
	border-collapse: collapse;
}


td
{
	//padding: 10px;
}
span
{
	display: block;
}
*
{
	line-height: 1.5em;
}
input[type=textbox]
{
	padding: 0 4px;
}
select
{
	//border: 1px solid red;
	padding-left: 4px;
}
.iradio
{
	padding: 1px 0;
}
textarea
{
	padding: 0 1px;
	//border: 1px solid red;
	-webkit-padding-start: -2px;
}
.label
{
	padding: 1px 0px;
	//padding: 11px 10px;
}
td > span
{
	padding: 0 4px;
}
</style>
</head>
<body>
	<table>
		<tr>
			<td class="label">
				<span>ABCDEFG</span>
			</td>
			<td class="input">
				<span>ABCDEFG</span>
			</td>
		</tr>
		<tr>
			<td class="label">
				<span>ABCDEFG</span>
			</td><br />
			<td class="input">
				<input type="textbox" value="ABCDEFG" />
			</td>
		</tr>
		<tr>
			<td class="label">
				<span>ABCDEFG</span>
			</td>
			<td class="input">
				<select>
					<option>ABCDEFG</option>
				</select>
			</td>
		</tr>
		<tr>
			<td class="label">
				<span>A_____</span>
			</td>
			<td class="input iradio">
				<input type="radio" />
				<label>A_____</label><br />
				<input type="radio" />
				<label>A_____</label>
			</td>
		</tr>
		<tr>
			<td class="label">
				<span>ABCDEFG<br />ABCDEFG</span>
			</td>
			<td class="input">
				<textarea>ABCDEFG
ABCDEFG</textarea>
			</td>
		</tr>
	</table>
	<ul>
		<li>input[type=textbox]のheightが1.5emとなる。テキストの縦位置を下げることは出来るが、上げる事は出来ない。</li>
		<li>selectは、上記に加えてheightが+2pxとなる。</li>
		<li>selectとtextareaにて、padding: 0の時の余白の解釈がPC版Chromeとスマホ版Safariで異なる。</li>
		<li>3点目はどうしようもなさそうなので、スマホにおける端末間の差異を無くすことに注力する。</li>
	</ul>
</body>
</html>