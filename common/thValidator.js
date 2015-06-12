var thValidator = new function thValidator()
{
	var registeredObj = [];
	var CONDITIONS = {
		'notnull': function(_val){
			var result = true;
			if (_val.replace(/ Å@\t\n/g, "") == "")
			{
				result = false;
			}
			return result;
		},
		'number': function(_val, _blacklist){
			var result = true;
			if (_val.match(/[^+-.0-9]/))
			{
				result = false;
			}
			if ($.isArray(_blacklist))
			{
				for (var i=0, l=_blacklist.length; i<l; i++)
				{
					if (_val == _blacklist[i])
					{
						result = false;
						break;
					}
				}
			}
			return result;
		},
		'lowercase': function(_val, _blacklist){
			var result = true;
			if (_val.match(/[A-Z]/))
			{
				result = false;
			}
			if ($.isArray(_blacklist))
			{
				for (var i=0, l=_blacklist.length; i<l; i++)
				{
					if (_val == _blacklist[i])
					{
						result = false;
						break;
					}
				}
			}
			return result;
		},
		'uppercase': function(_val, _blacklist){
			var result = true;
			if (_val.match(/[a-z]/))
			{
				result = false;
			}
			if ($.isArray(_blacklist))
			{
				for (var i=0, l=_blacklist.length; i<l; i++)
				{
					if (_val == _blacklist[i])
					{

						result = false;
						break;
					}
				}
			}
			return result;
		}
	};
	this.appendCondition = function(_condition, _function)
	{
		CONDITIONS._condition = _function;
	};
	this.removeCondition = function(_condition)
	{
		delete CONDITIONS._condition;
	};
	this.registerForm = function(_form)
	{
		var children = $.makeArray(_form.find('[data-thvalidator]'));
		for (var i=0, l=children.length; i<l; i++)
		{
			registeredObj[i] = children[i];
		}
	}
	this.clearRegisteredObj = function()
	{
		registeredObj = [];
	}
	/*
	this.registerItem = function(_items)
	{
		var items = $.makeArray(_form.find('[data-thvalidator]'));
		for (var i=0, l=children.length; i<l; i++)
		{
			registeredObj[i] = children[i];
		}
	}
	*/
	this.validate = function(_val)
	{
		var result = true;
		loopObj: for (var i=0, l=registeredObj.length; i<l; i++)
		{
			var obj = $(registeredObj[i]);
			var myConditions = obj.data('thvalidator').split(' ');
			for (var i2=0, l2=myConditions.length; i2<l2; i2++)
			{
				var myCondition = myConditions[i2];
				var validationFunc = CONDITIONS[myCondition];
				if (validationFunc(obj.val()) == false)
				{
					console.log(myCondition+" != "+obj.val());
					result = false;
					continue loopObj;
				}
			}
		}
		return result;
	}
	//data-thvalidator =
}();