<?php
	$basedir = 'http://'.$_SERVER['SERVER_NAME'].dirname($_SERVER['PHP_SELF']).'/';
	$get_list = 'get_list.php';
	$load_list = 'load_list.php';
	//
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
	if (!isset($_SESSION['ID_LIST'])) $_SESSION['ID_LIST'] = 0;
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
		@media screen and (min-width: 1600px) and (max-width: 1919px) { body{ font-size: 20px; } }
		@media screen and (min-width: 1920px) { body{ font-size: 25px; } }
		-->
		</style>
	</head>
	<body>
		<div id="result">
<?php
	$even_odd = array('even', 'odd');
	$even_odd_cnt = 0;
	$artists = parse_data($basedir.$load_list.'?mode=get_contents&id='.$_SESSION['ID_LIST']);
	list($list_info) = array_splice($artists, 0, 1);
	$src = '			<table>
				<thead>
					<tr>
						<th colspan="3">
							<a href="'.$list_info[3].'">'.$list_info[2].'</a>
						</th>
					</tr>
				</thead>
				<tbody>
';
	$rand_order = array();
	$artists_rev =
	$artists = array_reverse($artists);
	if ((int)$list_info[4]) shuffle($artists);
	foreach($artists as $row)
	{
		$love_selected = array(
			'class' => array("love_0", "love_1", "love_2"),
			'star' => array("★", "★★", "★★★")
		);
		$love_selected['class'][(int)$row[3]] .= " love_selected";
		$selected_artist = "";
		if ($row[0] == $_SESSION['ID_ARTIST']) $selected_artist = ' id="selected_artist"';
		$src .= '						<tr class="'.$even_odd[$even_odd_cnt%2].'"'.$selected_artist.'>
							<td class="love">
								<form action="love.php" method="get">
									<div class="star_default">
										<span>'.$love_selected['star'][$row[3]].'</span>
									</div>
									<div class="star_select">
										<span class="empty">☆☆☆</span>
										<input type="submit" class="'.$love_selected['class'][2].'" name="rating" value="★★★" />
										<input type="submit" class="'.$love_selected['class'][1].'" name="rating" value="★★" />
										<input type="submit" class="'.$love_selected['class'][0].'" name="rating" value="★" />
									</div>
									<input type="hidden" name="id_artist" value="'.$row[0].'" />
								</form>
							</td>
							<td class="name">
								<a href="count.php?id='.$row[0].'" target="_blank">'.$row[1].'</a>
							</td>
							<td class="count">'.$row[2].'</td>
						</tr>
';
		$even_odd_cnt++;
	}
	$src .= '

					</tbody>
			</table>
';
	if ($_SESSION['ID_LIST'] != 0) echo $src;
?>
		</div>
		<div id="list_wrapper">
			<div id="list">
<?php
	$even_odd = array('even', 'odd');
	$lists = json_decode(file_get_contents($basedir.$get_list), true);
	foreach($lists as $category)
	{
		$even_odd_cnt = 0;
		$src = '				<table>
					<thead>
						<tr>
							<th class="category">'.$category[0]['Category'].'</th>
						</tr>
					</thead>
					<tbody>
';
		foreach($category as $list)
		{
			$selected_list = "";
			if ($list['ID_List'] == $_SESSION['ID_LIST']) $selected_list = ' id="selected_list"';
			$src .= '						<tr class="'.$even_odd[$even_odd_cnt%2].'"'.$selected_list.'>
							<td>
								<a href="change_selected_list.php?id='.$list['ID_List'].'">'.$list['Name'].'</a>
							</td>
						</tr>
';
			$even_odd_cnt++;
		}
		$src .= '					</tbody>
				</table>
';
		echo $src;
	}
?>
			</div>
		</div>
		<div id="list_info">
			<form id="generate" action="generate_list.php" method="post">
				<table>
					<tr id="gen_listname">
						<td class="label">List name</td>
						<td class="input"><input type="text"name="list_name" id="list_name" required="required" value="<?php echo $list_info[1];?>" /></td>
					</tr>
					<tr id="gen_title">
						<td class="label">Title</td>
						<td class="input"><input type="text"name="title" id="title" value="<?php echo $list_info[2];?>" /></td>
					</tr>
					<tr id="gen_url">
						<td class="label">Url</td>
						<td class="input"><input type="url"name="url" id="url" value="<?php echo $list_info[3];?>" /></td>
					</tr>
					<tr id="gen_category">
						<td class="label">Category</td>
						<td class="input">
							<select name="category" id="category" class="thComboBox">
<?php
	foreach($dump as $id_and_name)
	{
		$selected_category = "";
		list($id, $name) = explode("\t", $id_and_name);
		if ($id == (int)$list_info[5]) $selected_category = ' selected="selected"';
		echo "								<option value=\"".htmlspecialchars($name)."\"".$selected_category.">".$name."</option>\n";
	}
?>
							</select>
						</td>
					</tr>
					<tr id="gen_shuffle">
						<td class="label">Shuffle</td>
						<td class="input">
							<input type="radio" name="shuffle" value="1" id="shuffle_1" required="required" <?php if ($list_info[4] == 1) echo 'checked="checked"';?> /><label for="shuffle_1">yes</label>
							<input type="radio" name="shuffle" value="0" id="shuffle_0" <?php if ($list_info[4] == 0) echo 'checked="checked"';?> /><label for="shuffle_0">no</label>
						</td>
					</tr>
					<tr id="gen_artists">
						<td class="label">Artists</td>
						<td class="input">
<?php
	$artists_before = "";
	for ($i=0, $l=count($artists_rev); $i<$l-1; $i++)
	{
		$artists_before .= $artists_rev[$i][1]."\n";
	}
	$artists_before .= $artists_rev[$i][1];
?>
							<textarea name="artists" id="artists" rows="5" cols="35" required="required"><?php echo $artists_before;?></textarea>
							<input type="hidden" name="artists_before" id="artists_before" value="<?php echo htmlspecialchars($artists_before);?>" />
						</td>
					</tr>
					<tr id="gen_submit">
						<td colspan="2">
							<input type="submit" value="generate" />
							<input type="reset" value="reset">
							<input type="hidden" name="list_id" id="list_id" value="<?php echo $list_info[0];?>" />
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
		<script src="jquery-ui.js" type="text/javascript"></script>
		<script src="jquery.ui.touch-punch.min.js" type="text/javascript"></script>
		<script src="thComboBox.js" type="text/javascript"></script>
		<script type="text/javascript">
		<!--
		$(function()
		{
			var selected_ID_List = <?php echo $_SESSION['ID_LIST'];?>;
			var music_list = new MusicList();
			music_list.get_list(false);
			if (selected_ID_List != 0)
			{
				music_list.load_list(true, selected_ID_List);
			}
		});
		function MusicList()
		{
			var self = this;
			var selected_ID_List = "<?php echo $_SESSION['ID_LIST'];?>";
			var selected_ID_Artist = "<?php echo $_SESSION['ID_ARTIST'];?>";
			var selected_list = null;
			var selected_artist = null;
			var draggingObj = null;
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
			/*
			this.overwrite_a = function()
			{
				a.bind('click', {id: list['ID_List']}, function(e){
					selected_list = $(this);
					self.load_list(false, e.data.id);
				});
			}
			*/
			var dragging = function(is_dragging)
			{
				if (is_dragging)
				{
					$('<div>', {
						'id': 'screen_dragging',
						'css': {
							'position': 'absolute',
							'background-color': 'black',
							'opacity': 0.7,
							'top': 0,
							'left': 0,
							'width': '100%',
							'height': '100%',
							'z-index': 9000
						}
					})
					.droppable({
						drop: function(event, ui) {
							draggingObj.remove();
							$('#list>table>tbody>tr:even').attr('class', 'even');
							$('#list>table>tbody>tr:odd').attr('class', 'odd');
						}
					})
					.appendTo($('#list_info'));
				}
				else
				{
					$('#screen_dragging').remove();
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
						$('#list>table').remove();
						//
						var lists = eval(result);
						for (var category in result)
						{
							var my_category = lists[category];
							var table = $('<table>').appendTo($('#list'));
							var thead = $('<thead>').appendTo(table);
							var thead_tr = $('<tr>').appendTo(thead);
							var thead_th = $('<th>', {
								'text': category,
								'class': 'category'
							}).appendTo(thead_tr);
							//
							var tbody = $('<tbody>').appendTo(table);
							for (var i=0, l=my_category.length; i<l; i++)
							{
								var list = my_category[i];
								var tr = $('<tr>').appendTo(tbody);
								var td = $('<td>').appendTo(tr);
								var a = $('<a>', {
									'text': list['Name'],
									'href': 'change_selected_list.php?id='+list['ID_List']
								}).appendTo(td);
								a.bind('click', {id: list['ID_List']}, function(e){
									selected_list = $(this);
									self.load_list(false, e.data.id);
									return false;
								});
								if (list['ID_List'] == selected_ID_List)
								{
									tr.attr('id', 'selected_list');
									selected_list = a;
								}
							}
						}
						//
						$('#list>table>tbody>tr').draggable({
								helper: "clone",
								start: function(event, ui)
								{
									dragging(true);
									draggingObj = $(this);
									$('.ui-draggable-dragging').css({
										'opacity': 0.7,
										'z-index': 9999,
										'width': draggingObj.width()
									});
									$('body').css('overflow', 'hidden');
									$('#list_info').css('position', 'relative');
								},
								drag: function(event, ui)
								{
									$(window).scrollLeft(0);
								},
								stop: function(event, ui)
								{
									dragging(false);
									draggingObj = null;
									$('body').css('overflow', 'auto');
									$('#list_info').css('position', 'static');
								}
						});
						//
						$('#list>table>tbody>tr:even').attr('class', 'even');
						$('#list>table>tbody>tr:odd').attr('class', 'odd');
					});
			}
			this.load_list = function(is_first, id)
			{
				if ($('#selected_list')[0]) $('#selected_list')[0].removeAttribute('id');
				if (selected_list) selected_list.parent().parent().attr('id', 'selected_list');
				selected_ID_List = id;
				loading(true);
				//
				var cache_clear = "&"+new Date().getTime();
				$.ajax({
					type: "GET",
					url: "load_list.php?mode=ajax&id="+id+cache_clear,
					}).done(function(result){
						if (result == 'not found')
						{
							loading(false);
							//
							$('#list_id').val(0);
							$('#list_name').val('');
							$('#title').val('');
							$('#url').val('');
							$('#shuffle_0').attr('checked', 'checked');
							thComboBox.select($('#category>option:first'));
							$('#artists_before').val('');
							$('#artists').val('');
							//
							selected_ID_List = null;
							selected_ID_Artist = null;
							selected_list = null;
							selected_artist = null;
							$('#result>table').remove();
							//
							self.get_list();
							$('#list_edit_result').text('Selected table does not exist.');
							$('#list_edit_result').attr('class', 'error');
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
						$('#list_id').val(headers.ID_List);
						$('#list_name').val(headers.Name);
						$('#title').val(headers.Title);
						$('#url').val(headers.Url);
						$('#shuffle_'+headers.IsShuffle).attr('checked', 'checked');
						thComboBox.select($('#category>option[value="'+headers.Category+'"]'));
						thComboBox.defineComboBox();
						//
						//
						var table = $('<table>');
							var thead_title = $('<thead>');
								var tr_title = $('<tr>', {
									'id': headers.ID_List
								});
									var th_title = $('<th>', {
										'colspan': 3
									});
										var inner_title = headers.Url ? $('<a>') : $('<span>');
										inner_title.text(headers.Title);
										if (headers.Url) inner_title.attr('href', headers.Url);

									th_title.append(inner_title);
								tr_title.append(th_title);
							thead_title.append(tr_title);
						table.append(thead_title);
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
						$('#artists_before').val(artists);
						$('#artists').val(artists);
						//
						var tr_list = [];
						var tbody = $('<tbody>');
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

							// Create elements
							var tr = $('<tr>');
								var td_love = $('<td>');
									var form = $('<form>');
										var div_star_default = $('<div>');
											var span_default = $('<span>');
										var div_star_select = $('<div>');
											var span_empty = $('<span>');
											var input_love = [
												$('<input>'),
												$('<input>'),
												$('<input>')
											];
								var td_name = $('<td>');
									var a_name = $('<a>');
								var td_count = $('<td>');

							// Set elements' attribute
							if (results.ID == selected_ID_Artist) tr.attr("id", "selected_artist");
							td_love.className = 'love';
								form.action = 'love.php';
								form.method = 'get';
								form.onsubmit = function(){return false;}
									div_star_default.className = 'star_default';
										span_default.innerHTML = '★'.repeat(parseInt(results.Love)+1);
									div_star_select.className = 'star_select';
										span_empty.className = 'empty';
										span_empty.innerHTML = '☆☆☆';
										input_love[0].className = 'love_0';
										input_love[0].type = 'submit';
										input_love[0].value = '★';
										input_love[0].addEventListener('click', func_love(results.ID, r, 0));
										input_love[1].className = 'love_1';
										input_love[1].type = 'submit';
										input_love[1].value = '★★';
										input_love[1].addEventListener('click', func_love(results.ID, r, 1));
										input_love[2].className = 'love_2';
										input_love[2].type = 'submit';
										input_love[2].value = '★★★';
										input_love[2].addEventListener('click', func_love(results.ID, r, 2));
										input_love[results.Love].className += ' love_selected';
							td_name.className = 'name';
								a_name.innerHTML = results.Name;
								a_name.href = "count.php?id="+results.ID;
								a_name.target = '_blank';
								a_name.addEventListener('click', func_count(results.ID, results.Name, r));
							td_count.className = 'count';
							td_count.innerHTML = results.Count;

							// Append elements
							tr.appendChild(td_love);
								td_love.appendChild(form);
									form.appendChild(div_star_default);
										div_star_default.appendChild(span_default);
									form.appendChild(div_star_select);
										div_star_select.appendChild(span_empty);
										div_star_select.appendChild(input_love[2]);
										div_star_select.appendChild(input_love[1]);
										div_star_select.appendChild(input_love[0]);
							tr.appendChild(td_name);
								td_name.appendChild(a_name);
							tr.appendChild(td_count);

							// Push tr to tr_list
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
				return function()
				{
					loading(true);
					var cache_clear = "&"+new Date().getTime();
					$.ajax({
						type: "GET",
						url: "love.php?mode=ajax&id_artist="+id+"&rating="+'★'.repeat(love+1)+cache_clear,
						}).done(function(result){
							$('#result>table>tbody>tr:eq('+row+')>.love>form>.star_default>span')[0].innerHTML = '★'.repeat(love+1);
							$('#result>table>tbody>tr:eq('+row+')>.love>form>.star_select>.love_selected')[0].className = $('#result>table>tbody>tr:eq('+row+')>.love>form>.star_select>.love_selected')[0].className.replace(/ love_selected/, '');
							$('#result>table>tbody>tr:eq('+row+')>.love>form>.star_select>.love_'+love)[0].className += ' love_selected';
							loading(false);
						});
				}
			}
			var func_count = function(id, name, row)
			{
				return function()
				{
					selected_artist = this;
					var cache_clear = "&"+new Date().getTime();
					$.ajax({
						type: "GET",
						url: "count.php?ajax&id="+id+cache_clear,
						}).done(function(result){
							selected_ID_Artist = id;
							if ($('#selected_artist')[0]) $('#selected_artist')[0].removeAttribute('id');
							selected_artist.parentNode.parentNode.id = 'selected_artist';
							$('.count')[row].innerHTML = result;
						});
					return false;
				}
			}
			//
			$('#generate')[0].onsubmit = function()
			{
				// Validation: if valid each value will be 0 and the sum must be 0.
				var is_valid =
					$('#list_name')[0].value != "" &&
						//$('#title')[0].value != "" &&
						//$('#url')[0].value != null &&
					$('#gen_category>td.input>input.thComboBox:eq(1)').val().replace(/[ 　\t\n\r\0\x0B]/g, "") != "" &&
					($('#shuffle_1')[0].checked || $('#shuffle_0')[0].checked) &&
					$('#artists')[0].value.replace(/[ 　\t\n\r\0\x0B]/g, "") != ""
				;
				if (is_valid)
				{
					loading(true);
					//
					var post_data =
						'list_id='+$('#list_id')[0].value+'&'+
						'list_name='+escape($('#list_name')[0].value)+'&'+
						'title='+escape($('#title')[0].value)+'&'+
						'url='+escape($('#url')[0].value)+'&'+
						'category='+$('#gen_category>td.input>input.thComboBox:eq(1)').val()+'&'+
						'shuffle='+($('#shuffle_1')[0].checked ? $('#shuffle_1')[0].value : $('#shuffle_0')[0].value)+'&'+
						'artists='+escape($('#artists')[0].value)+'&'+
						'artists_before='+escape($('#artists_before')[0].value)
					;
					var cache_clear = "&"+new Date().getTime();
					//
					$.ajax({
						type: "POST",
						url: "generate_list.php?mode=ajax"+cache_clear,
						data: post_data
						}).done(function(json){
							loading(false);
							var result = eval(json);
							$('#list_edit_result')[0].innerHTML = result.message;
							$('#list_edit_result')[0].className = result.status;
							self.get_list(false);
							reload_category(result.categories);
							if ($('#list_id')[0].value == selected_ID_List)
							{
								self.load_list(true, selected_ID_List);
							}
						});
				}
				return false;
			};
			var reload_category = function(categories)
			{
				$('#gen_category>td.input>select>option').remove();
				for (var i=0, l=categories.length; i<l; i++)
				{
					var category = categories[i];
					var option = $('<option>', {
						'value': category.Name,
						'text': category.Name
					});
					if (category.Selected)
					{
						option.attr('selected', 'selected');
					}
					option.appendTo($('#gen_category>td.input>select'));
				}
				thComboBox.defineComboBox();
			}
			$('#generate').bind('reset', function(){
				loading(true);
				var post_data = 'list_id='+$('#list_id')[0].value;
				var cache_clear = "&"+new Date().getTime();
				$.ajax({
					type: "POST",
					url: "delete_list.php?ajax"+cache_clear,
					data: post_data
				}).done(function(result){
					loading(false);
					$('#list_edit_result')[0].innerHTML = result;
					$('#list_edit_result')[0].className = result.match(/successfully\.$/) ? 'success' : 'error';
					self.get_list(false);
					self.load_list(true, selected_ID_List);
				});
			});
			/*
			$('#generate').bind('reset', function(){
				$('#list_id')[0].value = '0';
				$('#list_name')[0].value = '';
				$('#title')[0].value = '';
				$('#url')[0].value = '';
				$('#shuffle_0')[0].checked = true;
				$('#category>option')[0].selected = true;
				$('#artists_before')[0].value = '';
				$('#artists')[0].value = '';
				return false;
			});
			*/
			//
			//
			// Constructor
			$(window).resize(function() {
				$('body')[0].style.fontSize = window.innerWidth > 1280 ? (window.innerWidth/1280)*16+'px' : '16px';
			});
			$(window).trigger('resize');
		}
		//
		String.prototype.repeat = function(num) {
			return Array(num + 1).join(this);
		};
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
	function parse_data($func)
	{
		$parsed_data = array();
//var_dump(file_get_contents($func));die();
		$row = explode("\n", file_get_contents($func));
		foreach($row as $r)
			$parsed_data[] = explode("\t", $r);
		return $parsed_data;
	}
?>
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
