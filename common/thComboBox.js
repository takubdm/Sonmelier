var thComboBox = new function thComboBox()
{
	var self = this;
	var NEW_VALUE = {
		'dataset': {
			'attr': 'data-new-value',
			'value': 'new-value'
		},
		'selector': '[data-new-value=new-value]'
	};
	var tupple = [];

	var selectOnChange = function(e)
	{
		var select = e.data.select;
		var textbox = e.data.textbox;
		var selectedOption = select.children('option:selected');
		textbox.val(selectedOption.text());
		//e.data.hiddenbox.value = e.data.select.value;
		if (selectedOption.attr(NEW_VALUE.dataset.attr) != NEW_VALUE.dataset.value)
		{
			select.children('option'+NEW_VALUE.selector).remove();
		}
	}
	var textboxOnBlur = function(e)
	{
		var select = e.data.select;
			select.children('option'+NEW_VALUE.selector).remove();
		var textbox = e.data.textbox;
		var textboxValue = textbox.val();

		select.children('option').removeAttr('selected');
		var option = select.children('option[value="'+textboxValue+'"]');
		if (option.length == 0)
		{
			option = $('<option>', {
				'value': textboxValue,
				'text': textboxValue,
				'selected': 'selected'
			}).appendTo(select);
			option.attr(NEW_VALUE.dataset.attr, NEW_VALUE.dataset.value);
		}
		select.val(option.val());
	}
	var resizeComboBox = function()
	{
		for (var i=0, l=tupple.length; i<l; i++)
		{
			var textbox = tupple[i].textbox;
			var select = tupple[i].select;
			var parentNode = select.parent();
			var selectWidth = select.innerWidth();
			var selectHeight = select.innerHeight();
			//$(tupple[i].select).css('width', parentNode.innerWidth()*tupple[i].widthRatio+'px');
			textbox.css('width', selectWidth-selectHeight+'px');
		}
	}
	this.revertComboBox = function()
	{
		for (var i=0, l=tupple.length; i<l; i++)
		{
			var current_tupple = tupple.pop();
			var select = current_tupple.select;
			var textbox = current_tupple.textbox;
			select.attr('name', textbox.attr('name')).css({'color': ''});
			select.parent().css({'position': ''});
			select.val(textbox.val());
			textbox.remove();
		}
	}
	this.defineComboBox = function()
	{
		//this.revertComboBox();
		//
		tupple = [];
		var selects = $('select.thComboBox');
		for (var i=0, l=selects.length; i<l; i++)
		{
			var select = $(selects[i]);
			var textbox = $('<input>', {
				'type': 'text',
				'class': 'thComboBox',
				'name': select.attr('name'),
				'value': select.val()
			});
			/*
			var hiddenbox = $('<input>', {
				'type': 'hidden',
				'name': select[i].name,
				'class': 'thComboBox'
			});
			*/
			textbox.insertBefore(select);
			//hiddenbox.insertBefore(select);
			select.removeAttr('name');
			tupple.push({
				'textbox': textbox,
				//'hiddenbox': hiddenbox[0],
				'select': select,
				'widthRatio': 1.0
			});
		}
		//
		for (var i=0, l=tupple.length; i<l; i++)
		{
			var select = tupple[i].select;
			var textbox = tupple[i].textbox;
			var parentNode = select.parent();
			var selectWidth = select.innerWidth();
			var selectHeight = select.innerHeight();
			parentNode.css('position', 'relative');
			select.css({
				//'position': 'absolute',
				//'top': parseInt(parentNode.css('margin-top'))+parseInt(parentNode.css('padding-top'))+'px',
				//'left': parseInt(parentNode.css('margin-left'))+parseInt(parentNode.css('padding-left'))+'px',
				//'width': selectWidth+'px',
				'color': 'transparent'
			});
			//
			var zIndex = parseInt(select.css('z-index'));
			if (isNaN(zIndex)) zIndex = 0;
			textbox.css({
				'position': 'absolute',
				'top': parseInt(parentNode.css('margin-top'))+parseInt(parentNode.css('padding-top'))+'px',
				'left': parseInt(parentNode.css('margin-left'))+parseInt(parentNode.css('padding-left'))+'px',
				'width': selectWidth-selectHeight+'px',
				'z-index': zIndex+1
			}).val(select.children('option:selected').text());
			textbox.bind('blur', tupple[i], textboxOnBlur);
			select.bind('change', tupple[i], selectOnChange);
			//select.trigger('change');
			//
			//tupple[i].widthRatio = select.innerWidth()/parentNode.innerWidth(); //box-sizing?
			//tupple[i].ratioTextbox = $(tupple[i].textbox).innerWidth()/parentNode.innerWidth(); //box-sizing?
		}
		$(window).resize(resizeComboBox);
	}
}();