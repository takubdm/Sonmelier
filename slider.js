function Slider()
{
	// Private variables
	var current_obj = null;
	var default_value = null;
	var values = null;
	var cancel_area = [0, 0];
	var change_area = [0, $(window).width()];

	// Public functions
	this.bind_obj = function(obj)
	{
		obj.bind('touchstart', func_start);
		obj.bind('touchmove', func_move);
		obj.bind('touchend', func_end);
	}
	this.unbind_obj = function(obj)
	{
		obj.unbind('touchstart', func_start);
		obj.unbind('touchmove', func_move);
		obj.unbind('touchend', func_end);
	}
	this.regist_cancel_area = function(from, to)
	{
		if (typeof from == 'string') throw 'Invalid argument(s) has passed.';
		if (typeof to == 'string') throw 'Invalid argument(s) has passed.';
		if (from < 0) throw 'Invalid argument(s) has passed.';
		if (to < from) throw 'Invalid argument(s) has passed.';
		//
		cancel_area = [from, to];
	}
	this.regist_change_area = function(from, to)
	{
		if (typeof from == 'string') throw 'Invalid argument(s) has passed.';
		if (typeof to == 'string') throw 'Invalid argument(s) has passed.';
		if (from < 0) throw 'Invalid argument(s) has passed.';
		if (to < from) throw 'Invalid argument(s) has passed.';
		//
		change_area = [from, to];
	}
	this.regist_values = function(vals)
	{
		if (!Array.isArray(vals)) throw 'Invalid argument(s) has passed.';
		if (vals.length < 1) throw 'Invalid argument(s) has passed.';
		values = vals;
	}

	// Private functions
	var get_selected_range = function(num)
	{
		var range_id = 0;
		var offset = change_area[0];
		var distance = change_area[1]/values.length;
		for (var i=0, l=values.length; i<l; i++)
		{
			if (offset+distance*i <= num && num < offset+distance*(i+1))
			{
				range_id = i;
			}
		}
		return range_id;
	}
	var func_start = function(e)
	{
		current_obj = $(this);
		default_value = current_obj.text();
	}
	var func_end = function(e)
	{
		var pageX = e.originalEvent.changedTouches[0].pageX;
		var pageY = e.originalEvent.changedTouches[0].pageY;
		//
		if (cancel_area[0] <= pageX && pageX < cancel_area[0]+cancel_area[1])
		{
			current_obj.html(default_value);
		}
		else
		{
			if (values[get_selected_range(pageX)].value != default_value)
			{
				current_obj.html(values[get_selected_range(pageX)].value);
				values[get_selected_range(pageX)].func(current_obj);
			}
		}
	}
	var func_move = function(e)
	{
		e.preventDefault();
		e.stopPropagation();
		var pageX = e.originalEvent.changedTouches[0].pageX;
		var pageY = e.originalEvent.changedTouches[0].pageY;
		//
		if (cancel_area[0] <= pageX && pageX < cancel_area[1])
		{
			current_obj.html(default_value);
		}
		else
		{
			current_obj.html(values[get_selected_range(pageX)].value);
		}
	}
}