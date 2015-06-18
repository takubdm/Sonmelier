<?php
	/* Constants */
	define(CREATE_NEW_CATEGORY, "===Create new category===");

	session_start();
	//unset($_SESSION);
	//if (!isset($_SESSION['ID_LIST'])) $_SESSION['ID_LIST'] = 166;

	//
	$list_catalog = json_decode(exec("php \"".dirname(__FILE__)."\\..\\common\\load_catalog.php\""), true);
	$list_artists = json_decode(exec("php \"".dirname(__FILE__)."\\..\\common\\load_artist.php\" ".$_SESSION['ID_LIST']), true);
	$catalog_info = $list_artists['list_info'];

	//
	$_SESSION['ID_LIST'] = $catalog_info['ID_List'];
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
		<link rel="stylesheet" type="text/css" href="./desktop/css/index.css" />
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
							<td class="label">List name</td>
							<td class="input"><input type="text" name="list_name" class="list_name" value="<?php echo $_SESSION['create_catalog_values']['list_name'];?>"></td>
						</tr>
						<tr class="gen_title">
							<td class="label">Title</td>
							<td class="input"><input type="text" name="title" class="title" value="<?php echo $_SESSION['create_catalog_values']['title'];?>"></td>
						</tr>
						<tr class="gen_url">
							<td class="label">Url</td>
							<td class="input"><input type="url" name="url" class="url" value="<?php echo $_SESSION['create_catalog_values']['url'];?>"></td>
						</tr>
						<tr class="gen_category">
							<td class="label">Category</td>
							<td class="input">
<?php
	if ($_SESSION['create_catalog_values']['category'] == CREATE_NEW_CATEGORY)
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
									<option value="<?php echo $category['name'];?>" <?php echo $selected;?>><?php echo $category['name'];?></option>
<?php
			$i++;
		}
?>
									<option value="<?php echo CREATE_NEW_CATEGORY;?>" class="new_category"><?php echo CREATE_NEW_CATEGORY;?></option>
								</select>
<?php
	}
	$is_shuffle = (bool)$_SESSION['create_catalog_values']['create_shuffle'] ? "checked=\"checked\"" : "";
?>
							</td>
						</tr>
						<tr class="gen_shuffle">
							<td class="label">Shuffle</td>
							<td class="input">
								<input type="checkbox" name="shuffle" id="create_shuffle" <?php echo $is_shuffle;?> />
								<label for="create_shuffle"></label>
							</td>
						</tr>
						<tr class="gen_artists">
							<td class="label">Artists</td>
							<td class="input">
								<textarea name="artists" class="artists" rows="5" cols="20"><?php if ($_SESSION['create_catalog_values']['artists']) echo implode("\n", $_SESSION['create_catalog_values']['artists']);?></textarea>
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
	else
	{
		$list_artists['artist_info'] = array_reverse($list_artists['artist_info']);
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
									<option value="<?php echo $category['name'];?>" <?php echo $selected;?>><?php echo $category['name'];?></option>
<?php
			$i++;
		}
?>
									<option value="<?php echo CREATE_NEW_CATEGORY;?>" class="new_category"><?php echo CREATE_NEW_CATEGORY;?></option>
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
								<input type="checkbox" name="shuffle" id="edit_shuffle" <?php echo $is_shuffle;?> />
								<label for="edit_shuffle"></label>
							</td>
						</tr>
						<tr class="gen_artists">
							<td class="label">Artists</td>
							<td class="input">
								<textarea name="artists" class="artists" rows="5" cols="20"><?php if ($_SESSION['edit_catalog_values']['artists']) echo $_SESSION['edit_catalog_values']['artists'];?></textarea>
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
		<script src="./common/jquery.mousewheel.min.js" type="text/javascript"></script>
		<script src="./common/thScrollArea.js" type="text/javascript"></script>
		<script src="./common/thComboBox.js" type="text/javascript"></script>
		<script type="text/javascript">
		<!--
			var thSA_list_catalog = thSA.append($("#list_catalog>.thSAwrapper"), 30, 30);
			var thSA_list_artist = thSA.append($("#list_artist>.thSAwrapper"), 30, 30);
			var flipsnap;
			var FLIPSNAP_HASH_POINT;
			var evacuated_item = [];
			var current_catalog = {
				'link': null
			};

				var hash_point = {};
				var point_hash = {};
			var debug;

			$(window).load(function()
			{
				thSA.toggleScrollArea(false);
				load_css();
				append_ComboBox();
				append_load_catalog($("#list_catalog>.thSAwrapper"), $("#list_artist>.thSAwrapper"));
				append_love($("#list_artist form"));
				overwrite_reset($("#catalog_create>form"));
				append_form_event(
					$("#catalog_create>form"),
					$("#catalog_create>form").find("input[type=submit][value=create]")
				);
				append_form_event(
					$("#catalog_edit>form"),
					$("#catalog_edit>form").find("input[type=submit][value=edit]")
				);
				append_form_event(
					$("#catalog_edit>form"),
					$("#catalog_edit>form").find("input[type=submit][value=remove]")
				);
				append_fs_event();
				disableFormEnter($("#catalog_create>form"), true);
				disableFormEnter($("#catalog_edit>form"), true);
				appendWheelEvent();
				//append_fs_disabler();
				//
				//alert($("body").width());
			});
			function disableFormEnter(_form, _isSwapToTab)
			{
				var isSwapToTab = _isSwapToTab; //(isSwapToTab != null) _isSwapToTab : false;
				var inputs = $.makeArray(_form.find(
					"input[type=text]," +
					"input[type=url]"
				));
				for (var i=0, l=inputs.length; i<l; i++)
				{
					$(inputs[i]).bind('keypress', function(e){
						if (e.keyCode == 13)
						{
							//Not implemented yet.
							/*
							if (isSwapToTab)
							{
								$(this).trigger(
								    $.Event('keydown', {'keyCode': 63})
								);
							}
							*/
							return false;
						}
					});
				}
			}
			function overwrite_reset(form)
			{
				form.find("input[type=reset]").bind('click', function(){
					form.get(0).reset();
					//form.find("input.thComboBox").val(form.find("option:first").text());
                    thComboBox.revertComboBox();
                    form.find("option[data-new-value=true]").remove();
                    form.find("select").val(form.find("option:first").val());
                    thComboBox.defineComboBox();
                    return false;
				});
			}
			function refresh_category_list(_selects, _category_list)
			{
				//Change _target to array if it is not.
				//if (!$.isArray(_selects)) _selects = [_selects];
                thComboBox.revertComboBox();
				//_selects = $.makeArray(_selects);

				//Procedures for each select.
				for (var i=0, l=_selects.length; i<l; i++)
				{
					//Definition
					var select = $(_selects[i]);
					var currentVal = select.val();

					//Main procedure
					select.children('option').remove();
					for (var i2=0, l2=_category_list.length; i2<l2; i2++)
					{
						var category = _category_list[i2];
						select.append($('<option>', {
							'text': category.Name,
							'value': category.Name
						}));
					}
					select.val(currentVal);
				}
                thComboBox.defineComboBox();
                _selects.trigger('change');
			}
			function append_form_event(form, submitButton, appUrl)
			{
				var new_category = form.find("option").last().val();
				submitButton.bind('click', function(){
				/*
					if (form.find("input[name=category]").val() == new_category)
					{
						alert("you cannot.");
						form.find("input[name=category]").val("");
						return false;
					}
					*/
					//
                    form.find('input, select, textarea').attr('disabled', true);
					var process = $(this).val();
					form.submit(function()
					{
						$.ajax({
							"type": "POST",
							"url": form.attr('action'),
							"data": {
								"process":        process,
								"list_name":      form.find("input[name=list_name]").val(),
								"title":          form.find("input[name=title]").val(),
								"url":            form.find("input[name=url]").val(),
								//"category_id":    form.find("input[name=category]").val(),
								"category_name":  form.find("input[name=category]").val(),
								"is_shuffle":     form.find("input[name=shuffle]:checked").val(),
								"artists":        form.find("textarea[name=artists]").val(),
								"list_id":        form.find("input[type=hidden][name=list_id]").val(),
								"is_ajax":        true
							}
						}).done(function(result){
							if (result.status == 'success')
							{
								post_process[form.parent().attr('id')][process](result);
							}
							else
							{
								alert(result.result);
							}
                            form.find('input, select, textarea').attr('disabled', false);
							//location.hash = result;
						});
						form.unbind('submit');
						return false;
					});
				});
			}
			var post_process = {
				'catalog_create':
				{
					'create': function(catalog_info){
                        refresh_category_list($("select"), catalog_info.category);
						refresh_catalog_list($("#list_catalog>.thSAwrapper"), catalog_info);
						showCurrentCatalogOnScreen(catalog_info.result);
						$("#catalog_create>form").find("input[type=reset]").click();
					}
				},
				'catalog_edit':
				{
					'remove': function(catalog_info){
						refresh_catalog_list($("#list_catalog>.thSAwrapper"), catalog_info);
						catalog_selected(false);
						$("#a_list_artist").attr('href', '#').text('○');
						$("#a_catalog_edit").attr('href', '#').text('○');
						location.href = $("#a_list_catalog").attr('href');
						flipsnap.maxPoint = 0;
						flipsnap.refresh();
						thSA_list_catalog.updateContentSize();
						append_fs_disabler();
					},
					'edit': function(catalog_info /* , is_new_category */){
						thComboBox.revertComboBox();
						thComboBox.defineComboBox();
						refresh_category_list($("select"), catalog_info.category);


						refresh_catalog_list($("#list_catalog>.thSAwrapper"), catalog_info);
						showCurrentCatalogOnScreen(catalog_info.result);
						load_catalog($("#list_artist>.thSAwrapper"), catalog_info);



						//update_edit($('#catalog_edit'), catalog_info);
						//
						/*
						if (is_new_category)
						{
							//load_category();
						}
						*/
					}
				}
			};
			function showCurrentCatalogOnScreen(list_id)
			{
				var elem_catalog = $("#list_catalog>.thSAwrapper");
				var href = "./common/change_selected_list.php?id="+list_id;
				elem_catalog.animate(
					{'scrollTop': elem_catalog.scrollTop()+elem_catalog.find("a[href='"+href+"']").parent().offset().top}
				);
			}
			function evacuate_item(elems)
			{
				elems = $.isArray(elems) ? elems : [elems];
				for (var i=0, l=elems.length; i<l; i++)
				{
					var elem = elems[i];
					evacuated_item.push({
						'item': elem,
						'parent': elem.parent()
					});
					elem.remove();
				}
			}
			function catalog_selected(is_catalog_selected)
			{
				if (is_catalog_selected)
				{
					if (evacuated_item.length > 0)
					{
						$("#components>.no-contents").remove();
						for (var i=0, l=evacuated_item.length; i<l; i++)
						{
							var ei = evacuated_item.shift();
							ei.parent.append(ei.item);
						}
						append_love($("#list_artist form"));
						append_form_event(
							$("#catalog_edit>form"),
							$("#catalog_edit>form").find("input[type=submit][value=edit]")
						);
						append_form_event(
							$("#catalog_edit>form"),
							$("#catalog_edit>form").find("input[type=submit][value=remove]")
						);
						$("#components").css("width", "");
						$("#components>.item").css("width", "");
						thSA_list_artist = thSA.append($("#list_artist>.thSAwrapper"), 30, 30);
						//$("#catalog_edit option[data-new-value=new-value]").remove();
						thComboBox.defineComboBox();
						append_fs_disabler();
						//flipsnap.maxPoint = 3;
						flipsnap.refresh();
					}
				}
				else
				{
					thComboBox.revertComboBox();
					evacuate_item([
						$("#list_artist"), $("#catalog_edit")
					]);
					$("#components").append(
						$("<div>", {
							id: "list_artist",
							class: "no-contents",
							text: "Please select catalog."
						})
					).append(
						$("<div>", {
							id: "catalog_edit",
							class: "no-contents"
						})
					);
					//$("#components").css("width", "100%");
					//$("#components>.item").css("width", "50%");
					//flipsnap.maxPoint = 1;
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
			function appendWheelEvent()
			{
				$(window).mousewheel(function(e){
					if (e.deltaX != 0)
					{
						var nextPoint;
						if (e.deltaX > 0)
						{
							location.hash = point_hash[flipsnap.currentPoint+1];
						}
						else
						{
							location.hash = point_hash[flipsnap.currentPoint-1];
						}
					}
				});
    		}
			function append_fs_event()
			{
				flipsnap = Flipsnap('#components', {
					maxPoint: getMaxPoint(),
					distance: $("#catalog_create").innerWidth(),
					transitionDuration: 0,
					//threshold: 150
				});


				$(window).on('popstate', function() {
					flipsnap.moveToPoint(hash_point[location.hash], 350);
				});

				$(window).resize(function() {
					flipsnap.maxPoint = getMaxPoint();
					flipsnap.distance = $("#catalog_create").innerWidth();
					flipsnap.refresh();
				});

				//
				if (hash_point[location.hash] === undefined)
				{
					location.hash = point_hash[1];
				}
				flipsnap.moveToPoint(hash_point[location.hash]);
				//$(window).trigger('popstate');

				//flipsnap.element.removeEventListener('mousedown', Flipsnap, false);

				flipsnap.element.addEventListener('fstouchend', function(ev) {
					location.hash = point_hash[ev.newPoint];
				}, false);
			}
			function getMaxPoint()
			{
				hash_point = {};
				point_hash = [];
				var links = $("#navigator>a");
				var maxPoint = 0;
				for (var i=0, l=links.length; i<l; i++)
				{
					var link = $(links[i]);
					if (link.css("display") != "none")
					{
						hash_point[link.attr("href")] = maxPoint;
						point_hash[maxPoint] = link.attr("href");
						maxPoint++;
					}
				}
				point_hash[-1] = point_hash[0];
				point_hash[maxPoint] = point_hash[maxPoint-1];
				return maxPoint-1;
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
				//flipsnap.maxPoint = 1;
				flipsnap.refresh();
				//flipsnap.moveToPoint(1);
				location.hash = "#link_catalog_edit";
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
				elem_edit.find('select').val(info.Category);
				elem_edit.find('textarea[name=artists]').val(artist_names.join("\n"));
				elem_edit.find('input[name=list_id]').val(info.ID_List);
				//
				if (info.IsShuffle == 1)
				{
					elem_edit.find('input[name=shuffle]').val(['on']);
				}
				else
				{
					elem_edit.find('input[name=shuffle]').attr('checked', false);
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
	//unset($_SESSION['ID_LIST']);
	unset($_SESSION['create_catalog_values']);
	//unset($_SESSION['edit_catalog_values']);
?>