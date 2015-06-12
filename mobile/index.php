<?php
	/* Constants */
	define(CREATE_NEW_CATEGORY, "===Create new category===");

	session_start();
	if (!isset($_SESSION['ID_LIST'])) $_SESSION['ID_LIST'] = 166;

	//
	$list_catalog = json_decode(exec("php \"".dirname(__FILE__)."\\..\\common\\load_catalog.php\""), true);
	$list_artists = json_decode(exec("php \"".dirname(__FILE__)."\\..\\common\\load_artist.php\" ".$_SESSION['ID_LIST']), true);
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="keywords" content="" />
		<meta name="description" content="" />
		<meta name="author" content="taku" />
		<meta name="copyright" content="All rights reserved at taku." />
		<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
		<title>興味のある音楽リスト</title>
		<link rel="stylesheet" type="text/css" href="./mobile/css/index.css" />
		<link rel="stylesheet" type="text/css" href="./common/catalog_create.css" />
		<link rel="stylesheet" type="text/css" href="./common/list_catalog.css" />
		<link rel="stylesheet" type="text/css" href="./common/list_artist.css" />
		<link rel="stylesheet" type="text/css" href="./common/catalog_edit.css" />
	</head>
	<body>

	<div id="viewport">
		<div id="components">
			<a id="link_catalog_create"></a>
			<a id="link_list_catalog"></a>
			<a id="link_list_artist"></a>
			<a id="link_catalog_edit"></a>
			<div id="catalog_create" class="item">
				<form action="./common/create_catalog.php" method="post">
					<table>
						<tr class="gen_listname">
							<td class="label"><label>List name</label></td>
							<td class="input"><input type="text" name="list_name" class="list_name"></td>
						</tr>
						<tr class="gen_title">
							<td class="label"><label>Title</label></td>
							<td class="input"><input type="text" name="title" class="title"></td>
						</tr>
						<tr class="gen_url">
							<td class="label"><label>Url</label></td>
							<td class="input"><input type="url" name="url" class="url"></td>
						</tr>
						<tr class="gen_category">
							<td class="label"><label>Category</label></td>
							<td class="input">
<?php
	if ($_SESSION['create_catalog_values']['category'] == CREATE_NEW_CATEGORY)
	{
?>
								<input type="text" name="category" class="category" value="Category" />
<?php
	}
	else
	{
?>
								<select id="category" name="category" class="thComboBox">
<?php
		foreach($list_catalog['category'] as $category)
		{
?>
									<option value="<?php echo $category['id'];?>"><?php echo $category['name'];?></option>
<?php
		}
?>
									<option value="===Create new category===">===Create new category===</option>
								</select>
<?php
	}

	$is_shuffle = (bool)$_SESSION['edit_catalog_values']['is_shuffle'] ? "checked=\"checked\"" : "";
?>
							</td>
						</tr>
						<tr class="gen_shuffle">
							<td class="label">Shuffle</td>
							<td class="input">
								<input type="checkbox" name="create_shuffle" id="create_shuffle" <?php echo $is_shuffle;?> />
								<label for="create_shuffle"></label>
							</td>
						</tr>
						<tr class="gen_artists">
							<td class="label"><label>Artists</label></td>
							<td class="input">
								<textarea name="artists" class="artists" rows="5" cols="20"></textarea>
							</td>
						</tr>
						<tr class="gen_submit">
							<td colspan="2">
								<input type="submit" value="create" />
								<input type="reset" value="reset" />
								<input type="hidden" name="is_ajax" value="0" />
							</td>
						</tr>
					</table>
				</form>
			</div>
			<div id="list_catalog" class="item">
			<div class="thSAwrapper">
				<dl>
<?php
	$even_or_odd = array("classname" => array("even", "odd"), "index" => 0);
	foreach($list_catalog['category'] as $category)
	{
		echo "					<dt class=\"category\">
						<span>".$category['name']."</span>
					</dt>
";
		foreach($list_catalog['catalog_info'][$category['name']] as $catalog)
		{
			echo "					<dd class=\"".$even_or_odd['classname'][$even_or_odd['index']++%2]."\">
						<a href=\"./common/change_selected_list.php?id=".$catalog['ID_List']."\">".$catalog['Name']."</a>
					</dd>
";
		}
	}
?>
				</dl>
			</div>
			</div>
			<div id="list_artist" class="item">
			<div class="thSAwrapper">
				<dl>
<?php
	$catalog_info = $list_artists['list_info'];
	$catalog_header = $catalog_info['Url'] != "" ? "<a href=\"".$catalog_info['Url']."\" target=\"_blank\">".$catalog_info['Title']."</a>" : "<span>".$catalog_info['Title']."</span>";
	echo "					<dt class=\"category\">
						".$catalog_header."
					</dt>
";
	$even_or_odd = array("classname" => array("even", "odd"), "index" => 0);
	if ((int)$list_artists['list_info']['IsShuffle'])
	{
		shuffle($list_artists['artist_info']);
	}
	//
	foreach($list_artists['artist_info'] as $info_artist)
	{
		$love = array(
			0 => (int)$info_artist['Love'] >= 0 ? "★" : "☆",
			1 => (int)$info_artist['Love'] >= 1 ? "★★" : "☆☆",
			2 => (int)$info_artist['Love'] >= 2 ? "★★★" : "☆☆☆"
		);
		echo "					<dd class=\"".$even_or_odd['classname'][$even_or_odd['index']++%2]."\">
						<div class=\"love\">
							<form action=\"./common/love.php\" method=\"post\">
								<input type=\"hidden\" name=\"id_artist\" value=\"".$info_artist['ID_Artist']."\">
								<input type=\"hidden\" name=\"is_ajax\" value=\"0\">
								<input type=\"submit\" class=\"love\" name=\"rating\" value=\"".$love[0]."\"><!--
								--><input type=\"submit\" class=\"love\" name=\"rating\" value=\"".$love[1]."\"><!--
								--><input type=\"submit\" class=\"love\" name=\"rating\" value=\"".$love[2]."\">
							</form>
						</div>
						<div class=\"name\">
							<a href=\"./common/count.php?id=".$info_artist['ID_Artist']."\" target=\"_blank\">".$info_artist['Name']."</a>
						</div>
					</dd>
";
	}
?>
				</dl>
			</div>
			</div>
<?php

	if (!isset($_SESSION['edit_catalog_values']))
	{
		$_SESSION['edit_catalog_values'] = array(
			"id_list" => $catalog_info['ID_List'],
			"list_name" => $catalog_info['Name'],
			"title" => $catalog_info['Title'],
			"url" => $catalog_info['Url'],
			"category" => $catalog_info['Category'],
			"is_shuffle" => $catalog_info['IsShuffle'],
			"artists" => implode("\n", $list_artists['artist_names'])
		);
	}



?>


			<div id="catalog_edit" class="item">
				<form action="./common/edit_catalog.php" method="post">
					<table>
						<tr class="gen_listname">
							<td class="label">List name</td>
							<td class="input"><input type="text" name="list_name" class="list_name" value="<?php echo $_SESSION['edit_catalog_values']['list_name'];?>"></td>
						</tr>
						<tr class="gen_title">
							<td class="label">Title</td>
							<td class="input"><input type="text" name="title" class="title" value="<?php echo $_SESSION['edit_catalog_values']['title'];?>"></td>
						</tr>
						<tr class="gen_url">
							<td class="label">Url</td>
							<td class="input"><input type="url" name="url" class="url" value="<?php echo $_SESSION['edit_catalog_values']['url'];?>"></td>
						</tr>
						<tr class="gen_category">
							<td class="label">Category</td>
							<td class="input">
<?php
	if ($_SESSION['edit_catalog_values']['category'] == CREATE_NEW_CATEGORY)
	{
?>
								<input type="text" name="category" class="category" />
<?php
	}
	else
	{
?>
								<select id="category" name="category" class="thComboBox">
<?php
		$i = 1;
		foreach($list_catalog['category'] as $category)
		{
			$selected = ($list_artists['list_info']['ID_Category'] == $i) ? "selected=\"selected\"" : "";
?>
									<option value="<?php echo $category['id'];?>" <?php echo $selected;?>><?php echo $category['name'];?></option>
<?php
			$i++;
		}
?>
									<option value="0" class="new_category">===Create new category===</option>
								</select>
<?php
	}

	$is_shuffle = (bool)$_SESSION['edit_catalog_values']['is_shuffle'] ? "checked=\"checked\"" : "";
?>
							</td>
						</tr>
						<tr class="gen_shuffle">
							<td class="label">Shuffle</td>
							<td class="input">
								<input type="checkbox" name="edit_shuffle" id="edit_shuffle" <?php echo $is_shuffle;?> />
								<label for="edit_shuffle"></label>
							</td>
						</tr>
						<tr class="gen_artists">
							<td class="label">Artists</td>
							<td class="input">
								<textarea name="artists" class="artists" rows="5" cols="20"><?php echo $_SESSION['edit_catalog_values']['artists'];?></textarea>
							</td>
						</tr>
						<tr class="gen_submit">
							<td colspan="2">
								<input type="submit" name="process" value="edit" />
								<input type="submit" name="process" value="remove" />
								<input type="hidden" name="list_id" value="<?php echo $list_artists['list_info']['ID_List'];?>" />
								<input type="hidden" name="is_ajax" value="0" />
							</td>
						</tr>
					</table>
				</form>
			</div>
		</div>

		</div>

		<div id="navigator">
			<a id="a_catalog_create" href="#link_catalog_create">●</a>
			<a id="a_list_catalog" href="#link_list_catalog">●</a>
			<a id="a_list_artist" href="#link_list_artist">●</a>
			<a id="a_catalog_edit" href="#link_catalog_edit">●</a>
		</div>


		<!-- JavaScript -->
		<script src="./common/jquery-1.11.0.min.js" type="text/javascript"></script>
		<script src="./common/flipsnap.min.js" type="text/javascript"></script>
		<script src="./common/thScrollArea.js" type="text/javascript"></script>
		<script src="./common/thComboBox.js" type="text/javascript"></script>
		<script type="text/javascript">
		<!--

			//var thSA_list_catalog = new thScrollArea($("#list_catalog>.thSAwrapper"), 30, 30);
			//var thSA_list_artist = new thScrollArea($("#list_artist>.thSAwrapper"), 30, 30);
			var thSA_list_catalog = thSA.append($("#list_catalog>.thSAwrapper"), 30, 30);
			var thSA_list_artist = thSA.append($("#list_artist>.thSAwrapper"), 30, 30);
			var flipsnap;
			var FLIPSNAP_HASH_POINT;
			var evacuated_item = [];
			var current_catalog = {
				'link': null
			};
			var debug;

			$(window).load(function()
			{
				load_css();
				append_ComboBox();
				append_load_catalog($("#list_catalog>.thSAwrapper"), $("#list_artist>.thSAwrapper"));
				append_love($("#list_artist form"));
				overwrite_reset($("#catalog_create>form"));
				append_edit($("#catalog_edit>form"));
				append_fs_event();
				//append_fs_disabler();
				//
				//alert($("body").width());
			});
			function overwrite_reset(form)
			{
				form.find("input[type=reset]").bind('click', function(){
					form.get(0).reset();
					form.find("input.thComboBox").val(form.find("option:first").text());
					form.find("select").val(form.find("option:first").val());
					form.find("option[value=0]").remove();
					return false;
				});
			}
			function append_edit(form)
			{
				var new_category = form.find("option").last().val();
				form.find("input[type=submit]").bind('click', function(){
					if (form.find("input[name=category]").val() == new_category)
					{
						alert("you cannot.");
						form.find("input[name=category]").val("");
						return false;
					}
					//
					var process = $(this).val();
					form.submit(function()
					{
						$.ajax({
							"type": "POST",
							"url": "./common/edit_catalog.php",
							"data": {
								"process":        process,
								"list_name":      form.find("input[name=list_name]").val(),
								"title":          form.find("input[name=title]").val(),
								"url":            form.find("input[name=url]").val(),
								//"category_id":    form.find("input[name=category]").val(),
								//"category_name":  form.find("input[name=category]").val(),
								"is_shuffle":     form.find("input[name=is_shuffle]:checked").val(),
								"artists":        form.find("textarea[name=artists]").val(),
								"artists_before": form.find("input[type=hidden][name=artists_before]").val(),
								"list_id":        form.find("input[type=hidden][name=list_id]").val(),
								"is_ajax":        true
							}
						}).done(function(result){
							edit_post_process[process](result, form.find("#category").val() == 0);
							//location.hash = result;
						});
						form.unbind('submit');
						return false;
					});
				});
			}
			var edit_post_process = {
				'remove': function(catalog_info){
					refresh_catalog_list($("#list_catalog>.thSAwrapper"), catalog_info);
					catalog_selected(false);
					$("#a_list_artist").attr('href', '#').text('○');
					$("#a_catalog_edit").attr('href', '#').text('○');
					append_fs_disabler();
					flipsnap.moveToPoint(1);
				},
				'edit': function(catalog_info, is_new_category){
					load_catalog($("#list_artist>.thSAwrapper"), catalog_info);
					refresh_catalog_list($("#list_catalog>.thSAwrapper"), catalog_info);
					if (is_new_category)
					{
						//load_category();
					}
				}
			};
			function evacuate_item(elem)
			{
				evacuated_item.push({
					'item': elem,
					'parent': elem.parent()
				});
			}
			function catalog_selected(is_catalog_selected)
			{
				if (is_catalog_selected)
				{
					if (evacuated_item.length > 0)
					{
						for (var i=0, l=evacuated_item.length; i<l; i++)
						{
							var ei = evacuated_item.shift();
							ei.parent.append(ei.item);
						}
						append_love($("#list_artist form"));
						append_edit($("#catalog_edit>form"));
						$("#components").css("width", "");
						$("#components>.item").css("width", "");
						thSA_list_artist = thSA.append($("#list_artist>.thSAwrapper"), 30, 30);
						$("#catalog_edit option[value=0]").remove();
						thComboBox.defineComboBox();
						append_fs_disabler();
						flipsnap.maxPoint = 3;
						flipsnap.refresh();
					}
				}
				else
				{
					evacuate_item($("#list_artist"));
					evacuate_item($("#catalog_edit"));
					$("#list_artist").remove();
					$("#catalog_edit").remove();
					$("#components").css("width", "200%");
					$("#components>.item").css("width", "50%");
					flipsnap.maxPoint = 1;
					flipsnap.refresh();
				}
			}
			function append_ComboBox()
			{
				$.each($("select.thComboBox"), function() {
					$(this).find("option:last").remove();
				});
				thComboBox.defineComboBox();
				append_fs_disabler();
			}
			function append_fs_disabler()
			{
				//Unbind focus events
				$('input[type=text]').unbind('focus', fs_disableTouch);
				$('input[type=url]').unbind('focus', fs_disableTouch);
				$('select').unbind('focus', fs_disableTouch);
				$('textarea').unbind('focus', fs_disableTouch);

				//Unbind blur events
				$('input[type=text]').unbind('blur', fs_disableTouch);
				$('input[type=url]').unbind('blur', fs_disableTouch);
				$('select').unbind('blur', fs_disableTouch);
				$('textarea').unbind('blur', fs_disableTouch);

				//Bind focus events
				$('input[type=text]').bind(
					'focus',
					{'disableTouch': true},
					fs_disableTouch
				);
				$('input[type=url]').bind(
					'focus',
					{'disableTouch': true},
					fs_disableTouch
				);
				$('select').bind(
					'focus',
					{'disableTouch': true},
					fs_disableTouch
				);
				$('textarea').bind(
					'focus',
					{'disableTouch': true},
					fs_disableTouch
				);

				//Bind blur events
				$('input[type=text]').bind(
					'blur',
					{'disableTouch': false},
					fs_disableTouch
				);
				$('input[type=url]').bind(
					'blur',
					{'disableTouch': false},
					fs_disableTouch
				);
				$('select').bind(
					'blur',
					{'disableTouch': false},
					fs_disableTouch
				);
				$('textarea').bind(
					'blur',
					{'disableTouch': false},
					fs_disableTouch
				);
			}
			function fs_disableTouch(e)
			{
				flipsnap.disableTouch = e.data.disableTouch;
			}
			function append_fs_event()
			{
				flipsnap = Flipsnap('#components', {
					maxPoint: 3,
					//threshold: 150
				});

				var hash_point = {};
				var point_hash = {};
				var i = 0;
				$.each($("#navigator>a"), function() {
					hash_point[$(this).attr("href")] = i;
					point_hash[i] = $(this).attr("href");
					i++;
				});


				$(window).on('popstate', function() {
					flipsnap.moveToPoint(hash_point[location.hash]);
				});

				$(window).resize(function() {
					flipsnap.refresh();
				});

				//
				if (hash_point[location.hash] == undefined)
				{
					location.hash = point_hash[1];
				}
				$(window).trigger('popstate');



				flipsnap.element.addEventListener('fstouchend', function(ev) {
					location.hash = point_hash[ev.newPoint];
				}, false);
/*
				flipsnap.element.addEventListener('fstouchstart', function() {
				    alert("O");
}, false);
*/
			}
			function append_love(elem)
			{
				elem.find("input[type='submit']").bind('click', function()
				{
					var form = $(this).parent();
					var id_artist = form.find("input[name='id_artist']").val();
					var rating = $(this).val();
					form.submit(function(id_artist, rating){
						return function()
						{
							var self = $(this);
							$.ajax({
								"type": "POST",
								"url": "./common/love.php",
								"data": {
									"id_artist": id_artist,
									"rating": rating,
									"is_ajax": 1
								}
							}).done(function(result){
								var rating_value = rating.length;
								self.find("input[type='submit']:eq(0)").val(
									rating_value >= 1 ? "★" : "☆"
								);
								self.find("input[type='submit']:eq(1)").val(
									rating_value >= 2 ? "★★" : "☆☆"
								);
								self.find("input[type='submit']:eq(2)").val(
									rating_value >= 3 ? "★★★" : "☆☆☆"
								);
							});
							//
							$(this).unbind("submit");
							return false;
						}
					}(id_artist, rating));
				});
			}
			function refresh_catalog_list(elem_catalog, catalog_info)
			{
				var list_infos = catalog_info.list_infos;
				var even_odd = {
					'i': 0,
					'className': ['even', 'odd']
				};
				var current_category_id = null;
				//
				var dl = $("<dl>");
				for (var i=0, l=list_infos.length; i<l; i++)
				{
					var list_info = list_infos[i];
					if (current_category_id != list_info.ID_Category)
					{
						dl.append(
							$("<dt>", {
								"class": "category"
							}).append(
								$("<span>", {
									"text": list_info.Category
								})
							)
						);
						current_category_id = list_info.ID_Category;
						even_odd.i = 0;
					}
					dl.append(
						$("<dd>", {
							"class": even_odd.className[even_odd.i++%2]
						}).append(
							$("<a>", {
								"href": "./common/change_selected_list.php?id="+list_info.ID_List,
								"text": list_info.Name
							})
						)
					);
				}
				elem_catalog.find("dl").remove();
				elem_catalog.append(dl);
				append_load_catalog($("#list_catalog>.thSAwrapper"), $("#list_artist>.thSAwrapper"));
			}
			function load_catalog(elem_catalog, catalog_info)
			{
				var info = catalog_info.current_list.info;
				var artists = catalog_info.current_list.artists.concat();	//Copy array
				var dl = $("<dl>").append(
					$("<dt>", {
						"class": "category"
					}).append(
						(info.Url) ? $("<a>", {"href": info.Url, "target": "_blank"}).text(info.Title) : $("<span>").text(info.Title)
					)
				);

				//for
				var i = 0;
				var artist_info;
				if (info.IsShuffle == 1)
				{
					artists = artists.shuffle();
				}
				//
				for (var i=0, l=artists.length; i<l; i++)
				{
					artist_info = artists[i];
					dl.append(
						$("<dd>", {
							"class": (i%2 == 0) ? "even" : "odd"
						}).append(
							$("<div>", {
								"class": "love"
							}).append(
								$("<form>", {
									"action": "./common/love.php",
									"method": "post"
								}).append(
									$("<input>", {
										"type": "hidden",
										"name": "id_artist",
										"value": artist_info.ID_Artist
									})
								).append(
									$("<input>", {
										"type": "submit",
										"class": "love",
										"name": "rating",
										"value": get_love_label(artist_info.Love, 0)
									})
								).append(
									$("<input>", {
										"type": "submit",
										"class": "love",
										"name": "rating",
										"value": get_love_label(artist_info.Love, 1)
									})
								).append(
									$("<input>", {
										"type": "submit",
										"class": "love",
										"name": "rating",
										"value": get_love_label(artist_info.Love, 2)
									})
								)
							)
						).append(
							$("<div>", {
								"class": "name"
							}).append(
								$("<a>", {
									"href": "./common/count.php?id="+artist_info.ID_Artist,
									"target": "_blank"
								}).text(artist_info.Name)
							)
						)
					)
				}
				//
				elem_catalog.find("dl").remove();
				elem_catalog.append(dl);
				elem_catalog.scrollTop(0);
				//
				thSA_list_catalog.updateContentSize();
				thSA_list_artist.updateContentSize();
				append_love($("#list_artist form"));
				//
				$("#a_list_artist").attr('href', '#link_list_artist').text('●');
				$("#a_catalog_edit").attr('href', '#link_catalog_edit').text('●');
				flipsnap.moveToPoint(2);
			}
			function update_edit(elem_edit, catalog_info)
			{
				var info = catalog_info.current_list.info;
				var artists = catalog_info.current_list.artists;
				var artist_names = [];
				for (var i=0, l=artists.length; i<l; i++)
				{
					artist_names.push(artists[i].Name);
				}
				//
				elem_edit.find('input[name=list_name]').val(info.Name);
				elem_edit.find('input[name=title]').val(info.Title);
				elem_edit.find('input[name=url]').val(info.Url);
				elem_edit.find('input[name=category]').val(info.Category);
				elem_edit.find('select').val(info.ID_Category);
				elem_edit.find('textarea[name=artists]').val(artist_names.join("\n"));
				elem_edit.find('input[name=list_id]').val(info.ID_List);
				//
				if (info.IsShuffle == 1)
				{
					elem_edit.find('input[name=edit_shuffle]').val(['on']);
				}
				else
				{
					elem_edit.find('input[name=edit_shuffle]').attr('checked', false);
				}
			}
			function append_load_catalog(elem_catalogs, elem_catalog)
			{
				elem_catalogs.find($("a")).bind("click", function()
				{
					$.ajax({
						type: "GET",
						url: "./common/change_selected_list.php?id="+parse_search(this.href).id+"&is_ajax=1",
						}).done(function(result){
							var catalog_info = JSON.parse(result);
							catalog_selected(true);
							load_catalog(elem_catalog, catalog_info);
							update_edit($('#catalog_edit'), catalog_info);
						});
					return false;
				});
			}
			function load_css()
			{
				var CSS_FILE = "./mobile/css/with_js.css";
				$("head").append($("<link>", {
					"rel": "stylesheet",
					"type": "text/css",
					"href": CSS_FILE
				}));
			}
			function get_love_label(selected_value, level)
			{
				var label = (selected_value >= level) ? "★" : "☆";
				return Array(level+2).join(label);
			}
			function parse_search(url)
			{
				var obj = {};
				var kv_split = url.substr(url.indexOf("?")+1).split("&");
				for (var i=0, l=kv_split.length; i<l; i++)
				{
					var kv = kv_split[i].split("=");
					var key = kv[0];
					var value = kv[1];
					obj[key] = value;
				}
				return obj;
			}
			Array.prototype.shuffle = function()
			{
				var i = this.length;
				while(i)
				{
					var j = Math.floor(Math.random()*i);
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
	unset($_SESSION['create_catalog_values']);
	unset($_SESSION['edit_catalog_values']);
?>