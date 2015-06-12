var thComboBox = new function()
{
	var self = this;
	var tupple = [];

	var constructor = function()
	{
		self.defineComboBox();
	}
	var selectOnChange = function(e)
	{
		e.data.textbox.value = getSelectedOption(e.data.select).text();
		e.data.hiddenbox.value = e.data.select.value;
	}
	var textboxOnChange = function(e)
	{
		e.data.hiddenbox.value = this.value;
	}
	var getSelectedOption = function(select)
	{
		var selectedOption;
		var options = $(select).children('option');
		for (var i=0, l=options.length; i<l; i++)
		{
			if (options[i].selected)
			{
				selectedOption = options[i];
				break;
			}
		}
		return $(selectedOption);
	}
	var revertComboBox = function()
	{
		for (var i=0, l=tupple.length; i<l; i++)
		{
			tupple[i].select.name = tupple[i].hiddenbox.name;
		}
		//
		$('input.thComboBox').unbind('change', selectOnChange);
		$('input.thComboBox').remove();
	}
	var resizeComboBox = function()
	{
		for (var i=0, l=tupple.length; i<l; i++)
		{
			var parentNode = $(tupple[i].select).parent();
			var selectHeight = $(tupple[i].select).height();
			$(tupple[i].select).css('width', parentNode.width()*tupple[i].widthRatio+'px');
			$(tupple[i].textbox).css('width', parentNode.width()*tupple[i].widthRatio-selectHeight+'px');
		}
	}
	this.select = function(elem)
	{
		elem.attr('selected', 'selected');
		elem.parent().trigger('change');
	}
	this.defineComboBox = function()
	{
		revertComboBox();
		//
		tupple = [];
		var select = $('form .thComboBox');
		for (var i=0, l=select.length; i<l; i++)
		{
			var textbox = $('<input>', {
				'type': 'text',
				'class': 'thComboBox'
			});
			var hiddenbox = $('<input>', {
				'type': 'hidden',
				'name': select[i].name,
				'class': 'thComboBox'
			});
			textbox.insertBefore(select[i]);
			hiddenbox.insertBefore(select[i]);
			$(select[i]).removeAttr('name');
			tupple.push({'textbox': textbox[0], 'hiddenbox': hiddenbox[0], 'select': select[i], 'widthRatio': 1.0});
		}
		//
		for (var i=0, l=tupple.length; i<l; i++)
		{
			var parentNode = $(tupple[i].select).parent();
			var selectWidth = $(tupple[i].select).width();
			var selectHeight = $(tupple[i].select).height();
			parentNode.css('position', 'relative');
			$(tupple[i].select).css({
				'position': 'absolute',
				'top': parseInt(parentNode.css('margin-top'))+parseInt(parentNode.css('padding-top'))+'px',
				'left': parseInt(parentNode.css('margin-left'))+parseInt(parentNode.css('padding-left'))+'px',
				'width': selectWidth+'px'
			});
			//
			var zIndex = parseInt($(tupple[i].select).css('z-index'));
			if (isNaN(zIndex)) zIndex = 0;
			$(tupple[i].textbox).css({
				'position': 'absolute',
				'top': parseInt(parentNode.css('margin-top'))+parseInt(parentNode.css('padding-top'))+'px',
				'left': parseInt(parentNode.css('margin-left'))+parseInt(parentNode.css('padding-left'))+'px',
				'width': selectWidth-selectHeight+'px',
				'z-index': zIndex+1
			});
			$(tupple[i].textbox).bind('change', tupple[i], textboxOnChange);
			$(tupple[i].select).bind('change', tupple[i], selectOnChange);
			$(tupple[i].select).trigger('change');
			//
			tupple[i].widthRatio = $(tupple[i].select).width()/parentNode.width(); //box-sizing?
			tupple[i].ratioTextbox = $(tupple[i].textbox).width()/parentNode.width(); //box-sizing?
			$(window).bind('resize', resizeComboBox);
		}
	}
	//
	constructor();
};