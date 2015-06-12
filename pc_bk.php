<?php
	$mysql = array(
		'link' => null,
		'server' => 'localhost',
		'username' => 'root',
		'password' => 'ventretky',
		'db' => 'music_list',
		'table' => 'category'
	);
	//
	$mysql['link'] = _mysql_connect($mysql['server'], $mysql['username'], $mysql['password']);
	_mysql_select_db('music_list', $mysql['link']);
	//
	$dump = array();
	$result = _mysql_query("select * from ".$mysql['table'].' order by ID ASC');
	while ($row = mysql_fetch_assoc($result))
	{
		$dump[] = implode("\t", $row);
	}
	//
	mysql_close($mysql['link']);
	//
	//
	//
	session_start();
	if (!isset($_SESSION['ID_LIST'])) $_SESSION['ID_LIST'] = 166;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ja" xml:lang="ja">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="keywords" content="" />
		<meta name="description" content="" />
		<meta name="author" content="taku" />
		<meta name="copyright" content="All rights reserved at taku." />
		<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
		<title>興味のある音楽リスト</title>
		<style>
		<!--
		@import url(style_pc_1279.css) screen and (max-width: 1279px);
		@import url(style_pc_1280.css) screen and (min-width: 1280px);
		-->
		</style>
	</head>
	<body>
		<div id="result"></div>
		<div id="list_wrapper"><div id="list"></div></div>
		<div id="list_info">
			<form id="generate" action="generate_list.php" method="post">
				<table>
					<tr>
						<td class="label">List name</td>
						<td><input type="text"name="list_name" id="list_name" required="required" /></td>
					</tr>
					<tr>
						<td class="label">Title</td>
						<td><input type="text"name="title" id="title" /></td>
					</tr>
					<tr>
						<td class="label">Url</td>
						<td><input type="url"name="url" id="url" /></td>
					</tr>
					<tr>
						<td class="label">Category</td>
						<td>
							<select name="category" id="category">
<?php
	foreach($dump as $id_and_name)
	{
		list($id, $name) = explode("\t", $id_and_name);
		echo "								<option value=\"".$id."\">".$name."</option>\n";
	}
?>
							</select>
						</td>
					</tr>
					<tr>
						<td class="label">Shuffle</td>
						<td>
							<label><input type="radio" name="shuffle" value="1" id="shuffle_1" required="required" />yes</label>
							<label><input type="radio" name="shuffle" value="0" id="shuffle_0" />no</label>
						</td>
					</tr>
					<tr id="gen_artists">
						<td class="label">Artists</td>
						<td>
							<textarea name="artists" id="artists" rows="5" cols="35" required="required"></textarea>
							<input type="hidden" name="artists_before" id="artists_before" />
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<input type="submit" value="generate" />
							<input type="reset" value="reset">
							<input type="hidden" name="list_id" id="list_id" value="" />
						</td>
					</tr>
					<tr id="gen_result">
						<td colspan="2">
							<div id="list_edit_result" class="<?php echo $_SESSION['list_edit_result']['status'];?>"><?php echo $_SESSION['list_edit_result']['msg'];?></div>
						</td>
					</tr>
				</table>
			</form>
		</div>
		<script src="jquery-1.11.0.min.js" type="text/javascript"></script>
		<script type="text/javascript">
		<!--
		$(function()
		{
			var music_list = new MusicList();
			music_list.get_list(false);
			music_list.load_list(true, <?php echo $_SESSION['ID_LIST']?>);
		});
		function MusicList()
		{
			var self = this;
			var selected_ID_List = "<?php echo $_SESSION['ID_LIST'];?>";
			var selected_ID_Artist = "<?php echo $_SESSION['ID_ARTIST'];?>";
			var selected_list = null;
			var selected_artist = null;
			var loading = function(is_load_start)
			{
				if (is_load_start)
				{
					var div = document.createElement('div');
						div.id = 'load_screen';
					var icon = document.createElement('img');
						icon.id = 'load_screen_icon';
						icon.src = 'loading.gif';
						icon.style.marginTop = '-16px';
						icon.style.marginLeft = '-16px';
					$("body")[0].appendChild(div);
					$("body")[0].appendChild(icon);
				}
				else
				{
					$("body")[0].removeChild($("body>#load_screen")[0]);
					$("body")[0].removeChild($("body>#load_screen_icon")[0]);
				}
			}
			this.get_list = function(is_retry)
			{
				var retry = is_retry ? "&retry" : "";
				var cache_clear = "&"+new Date().getTime();
				$.ajax({
					type: "GET",
					url: "get_list.php?"+retry+cache_clear,
					}).done(function(result){
						var table = document.createElement('table');
						//
						var current_category = "";
						var result_rows = result.split("\n");
						for (var r=0, rl=result_rows.length, oe=0; r<rl; r++, oe++)
						{
							var result_row = result_rows[r];
							var result_cols = result_row.split("\t");
							var results = {
								"ID": result_cols[0],
								"Category": result_cols[6]
							};
							if (current_category != results.Category)
							{
								var tr = document.createElement('tr');
								var td_category = document.createElement('td');
									td_category.className = 'category';
									td_category.innerHTML = results.Category;
								tr.appendChild(td_category);
								table.appendChild(tr);
								current_category = results.Category;
								oe++;
							}
							var tr = document.createElement('tr');
								tr.className = ['even', 'odd'][oe%2];
								if (results.ID == selected_ID_List) tr.id = 'selected_list';
							var td_name = document.createElement('td');
							var a = document.createElement('a');
								a.innerHTML = result_cols[1];
								a.href = 'javascript:void(0);';
								a.onclick = function(id){ return function() { selected_list = this; self.load_list(false, id); } }(results.ID);
							td_name.appendChild(a);
							tr.appendChild(td_name);
							table.appendChild(tr);
						}
						//
						if ($('#list>table').length) $('#list')[0].removeChild($('#list>table')[0]);
						$("#list")[0].appendChild(table);
					});
			}
			this.load_list = function(is_first, id)
			{
				if ($("#love_screen")[0]) $("#love_screen")[0].onclick();
				if (selected_list)
				{
					$('#selected_list')[0].removeAttribute('id');
					selected_list.parentNode.parentNode.id = 'selected_list';
				}
				selected_ID_List = id;
				loading(true);
				//
				var cache_clear = "&"+new Date().getTime();
				$.ajax({
					type: "GET",
					url: "load_list.php?id="+id+cache_clear,
					}).done(function(result){
						if (result == 'retry')
						{
							get_list(true);
							return;
						}
						//
						var result_rows = result.split("\n");
						var result_header = result_rows.splice(0, 1)[0].split("\t");
						var headers = {
							"ID_List": result_header[0],
							"Name": result_header[1],
							"Title": result_header[2],
							"Url": result_header[3],
							"IsShuffle": result_header[4],
							"ID_Category": result_header[5],
							"Category": result_header[6]
						};
						$('#list_id')[0].value = headers.ID_List;
						$('#list_name')[0].value = headers.Name;
						$('#title')[0].value = headers.Title;
						$('#url')[0].value = headers.Url;
						$('#shuffle_'+headers.IsShuffle)[0].checked = true;
						$('#category>option')[parseInt(headers.ID_Category)-1].selected = true;
						//
						var table = document.createElement('table');
						var thead = document.createElement('thead');
						var tr_title = document.createElement('tr');
						var th_title = document.createElement('th');
							th_title.colSpan = 3;
						var a_title = document.createElement('a');
							a_title.innerHTML = headers.Title;
						th_title.appendChild(a_title);
						tr_title.appendChild(th_title);
						thead.appendChild(tr_title);
						table.appendChild(thead);
						//
						result_rows = result_rows.reverse();
						var artists = [];
						for (var r=0, rl=result_rows.length; r<rl; r++)
						{
							var result_row = result_rows[r];
							var result_cols = result_row.split("\t");
							var results = {
								"ID": result_cols[0],
								"Name": result_cols[1],
								"Count": result_cols[2],
								"Love": result_cols[3]
							};
							artists.push(results.Name);
						}
						artists = artists.join("\n");
						$('#artists_before')[0].value =
						$('#artists')[0].value = artists;
						//
						var tr_list = [];
						var tbody = document.createElement('tbody');
						if (parseInt(headers.IsShuffle))
						{
							result_rows = result_rows.shuffle();
						}
						for (var r=0, rl=result_rows.length; r<rl; r++)
						{
							var result_row = result_rows[r];
							var result_cols = result_row.split("\t");
							var results = {
								"ID": result_cols[0],
								"Name": result_cols[1],
								"Count": result_cols[2],
								"Love": result_cols[3]
							};
							var tr = document.createElement('tr');
								tr.className = ['even', 'odd'][r%2];
								if (results.ID == selected_ID_Artist) tr.id = "selected_artist";
							var td_love = document.createElement('td');
								td_love.className = 'love';
							var a_love = document.createElement('a');
								a_love.className = 'love_'+results.Love;
								a_love.innerHTML = '&hearts;';
								a_love.href = 'javascript:void(0);';
								a_love.onclick = function(id, row, love){ return function() { func_love(id, row, love); } }(results.ID, r, results.Love);
							var td_name = document.createElement('td');
								td_name.className = 'name';
							var a_name = document.createElement('a');
								a_name.innerHTML = results.Name;
								a_name.href = 'javascript:void(0);';
								a_name.onclick = function(id, name, row){ return function() { selected_artist = this; count(id, name, row); } }(results.ID, results.Name, r);
							var td_count = document.createElement('td');
								td_count.className = 'count';
								td_count.innerHTML = results.Count;
							//td_name.appendChild(a);
							td_love.appendChild(a_love);
							tr.appendChild(td_love);
							td_name.appendChild(a_name);
							tr.appendChild(td_name);
							tr.appendChild(td_count);
							tr_list.push(tr);
						}
						for (var i=0, l=tr_list.length; i<l; i++)
						{
							tbody.appendChild(tr_list[i]);
						}
						table.appendChild(tbody);
						//
						if (!is_first)
						{
							$('#list_edit_result')[0].className = "";
							$('#list_edit_result')[0].innerHTML = "";
						}
						if ($("#result>table")[0]) $("#result")[0].removeChild($("#result>table")[0]);
						$("#result")[0].appendChild(table);
						loading(false);
				});
			}
			var func_love = function(id, row, love)
			{
				var div = document.createElement('div');
					div.id = 'love_screen';
					div.style.cursor = 'pointer';
					div.onclick = close;
				var base = document.createElement('div');
					base.id = 'love_base';
					base.style.width = $('#result')[0].offsetWidth/2+"px";
					//base.style.height = window.outerHeight/2+"px";
					base.style.backgroundColor = "#fff";
					base.style.left = $('#result')[0].offsetWidth/2+'px';
				var form = document.createElement('form');
					form.onsubmit = submit;
				var input_id = document.createElement('input');
					//input_id.name = 'id';
					input_id.id = 'input_id';
					input_id.type = 'hidden';
					input_id.value = id;
					form.appendChild(input_id);
				var input_love = document.createElement('input');
					//input_love.name = 'love';
					input_love.id = 'input_love';
					input_love.type = 'hidden';
					input_love.value = love;
					form.appendChild(input_love);
					for (var i=0, l=2; i<=l; i++)
					{
						var a = document.createElement('a');
						a.innerHTML = ['Normal', 'Like', 'Love'][i];
						a.className = 'radiobox_'+a.innerHTML;
						a.onclick = function(i)
						{
							return function()
							{
								$('#input_love')[0].value = i;
							}
						}(i);
						form.appendChild(a);
					}
				var input_hide = document.createElement('input');
					input_hide.type = 'hidden';
					//input_hide.name = 'hide';
					input_hide.id = 'input_hide';
					input_hide.value = 0;
					form.appendChild(input_hide);
				var a_hide = document.createElement('a');
					a_hide.innerHTML = 'Hide';
					a_hide.className = ['checkbox_unchecked', 'checkbox_checked'][input_hide.value];
					a_hide.onclick = function()
					{
						$('#input_hide')[0].value = (parseInt($('#input_hide')[0].value)+1)%2;
						a_hide.className = ['checkbox_unchecked', 'checkbox_checked'][$('#input_hide')[0].value];
					}
					form.appendChild(a_hide);
				var a_submit = document.createElement('a');
					a_submit.innerHTML = 'Submit';
					a_submit.onclick = form.onsubmit;
					form.appendChild(a_submit);
				base.appendChild(form);
				$("body")[0].appendChild(div);
				$("body")[0].appendChild(base);
				base.style.marginTop = -base.offsetHeight/2+"px";
				base.style.marginLeft = -base.offsetWidth/2+"px";
				//
				function close()
				{
					$("body")[0].removeChild($("#love_screen")[0]);
					$("body")[0].removeChild($("#love_base")[0]);
				}
				function submit()
				{
					var id = $('#input_id')[0].value;
					var love = $('#input_love')[0].value;
					var hide = $('#input_hide')[0].value;
					var cache_clear = "&"+new Date().getTime();
					$.ajax({
						type: "GET",
						url: "love.php?id="+id+"&love="+love+"&hide="+hide+cache_clear,
						}).done(function(result){
							$('.love>a')[row].className = 'love_'+result;
							$("#love_screen")[0].onclick();
						});
					return false;
				}
			}
			var resize_love_screen = function()
			{
				var base = $('#love_base')[0];
				if (!base) return false;
				//
				base.style.left = $('#result')[0].offsetWidth/2+'px';
				base.style.marginTop = -base.offsetHeight/2+"px";
				base.style.marginLeft = -base.offsetWidth/2+"px";
			}
			var count = function(id, name, row)
			{
				var cache_clear = "&"+new Date().getTime();
				$.ajax({
					type: "GET",
					url: "count.php?id="+id+cache_clear,
					}).done(function(result){
						selected_ID_Artist = id;
						if ($('#selected_artist')[0]) $('#selected_artist')[0].removeAttribute('id');
						selected_artist.parentNode.parentNode.id = 'selected_artist';
						$('.count')[row].innerHTML = result;
						window.open('http://m.youtube.com/results?q='+escape(name), 'external');
					});
			}
			//
			$('#generate')[0].onsubmit = function()
			{
				// Validation: if valid each value will be 0 and the sum must be 0.
				var is_invalid =
					$('#list_name')[0].value != "" ? 0 : 1 +
						//$('#title')[0].value != "" ? 0 : 1 +
						//$('#url')[0].value != null ? 0 : 1 +
						//$('#category')[0].value != null ? 0 : 1 +
					($('#shuffle_1')[0].checked || $('#shuffle_0')[0].checked) ? 0 : 1 +
					$('#artists')[0].value.replace(/[ 　\t\n\r\0\x0B]/g, "") != "" ? 0 : 1
				;
				if (!is_invalid)
				{
					var post_data =
						'list_id='+$('#list_id')[0].value+'&'+
						'list_name='+escape($('#list_name')[0].value)+'&'+
						'title='+escape($('#title')[0].value)+'&'+
						'url='+escape($('#url')[0].value)+'&'+
						'category='+$('#category')[0].value+'&'+
						'shuffle='+($('#shuffle_1')[0].checked ? $('#shuffle_1')[0].value : $('#shuffle_0')[0].value)+'&'+
						'artists='+escape($('#artists')[0].value)+'&'+
						'artists_before='+escape($('#artists_before')[0].value)
					;
					var cache_clear = "&"+new Date().getTime();
					//
					$.ajax({
						type: "POST",
						url: "generate_list.php?ajax"+cache_clear,
						data: post_data
						}).done(function(result){
							$('#list_edit_result')[0].innerHTML = result;
							$('#list_edit_result')[0].className = result.match(/successfully\.$/) ? 'success' : 'error';
							self.get_list(false);
							self.load_list(true, selected_ID_List);
						});
					return false;
				}
				return false;
			};
			//
			//
			// Constructor
			window.addEventListener('resize', function() {
				$('body')[0].style.fontSize = window.innerWidth > 1280 ? (window.innerWidth/1280)*16+'px' : '16px';
				resize_love_screen();
			});
			window.dispatchEvent(new Event('resize'));
		}
		//シャッフルのアルゴリズム prototypeで拡張しておく
		Array.prototype.shuffle = function() {
		    var i = this.length;
		    while (i) {
		        var j = Math.floor(Math.random() * i);
		        var t = this[--i];
		        this[i] = this[j];
		        this[j] = t;
		    }
		    return this;
		}
		//-->
		</script>

	</body>
</html>
<?php
	function _mysql_connect($server, $username, $password)
	{
		$link = mysql_connect($server, $username, $password);
		if (!$link) die(mysql_error());
		return $link;
	}
	function _mysql_select_db($db_name, $link)
	{
		$db_selected = mysql_select_db($db_name, $link);
		if (!$db_selected) die(mysql_error());
		//return $db_selected;
	}
	function _mysql_query($query)
	{
		$result = mysql_query($query);
		if (!$result) die(mysql_error());
		return $result;
	}
	//
	$_SESSION['list_edit_result'] = array('msg' => '', 'status' => '');
?>
