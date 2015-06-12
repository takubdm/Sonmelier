/*
	Usage

	[html]
	<div id="contentA">
		<div class="thScrollAreawrapper">
			<some contents></some contents>
		</div>
	</div>

	[JavaScript]
	var thScrollAreacontentA = new thScrollArea($("#contentA>.thScrollAreawrapper"), 10, 20);
*/
var thScrollArea = function(useragent)
{
	//Private variables
	var parent = this;
	var id = 0;

	//Define CONST
	var bar_min_height,
		bar_width,
		bar_margin,
		bar_opacity,
		transition_time;
	if (useragent == "iOS6")
	{
		bar_min_height = 34;
		bar_width = 5;
		bar_margin = 2;
		bar_opacity = 0.5;
		transition_time = 0.35;
	}
	else if (useragent == "iOS7")
	{
		bar_min_height = 36;
		bar_width = 2.5;
		bar_margin = 3
		bar_opacity = 0.35;
		transition_time = 0.35;
	}
	thScrollArea.prototype.BAR_MIN_HEIGHT = bar_min_height;
	thScrollArea.prototype.BAR_WIDTH = bar_width;
	thScrollArea.prototype.BAR_MARGIN = bar_margin;
	thScrollArea.prototype.BAR_OPACITY = bar_opacity;
	thScrollArea.prototype.TRANSITION_TIME = transition_time;

	//Create scroll area
	this.append = function(_content, _areaWidth, _areaOffset)
	{
		var BAR_WIDTH = this.BAR_WIDTH;
		var BAR_MARGIN = this.BAR_MARGIN;
		//
		var vars = this.vars[id] = {};
		vars.contentFullHeight = null;
		vars.content = _content;
		vars.self = this;
		vars.parent = _content.parent();
		vars.areaWidth = _areaWidth;
		vars.areaOffset = _areaOffset;
		vars.barOpacity = bar_opacity;
		vars.scrollBar = $( "<div>", {
			"class": "thScrollBar",
			"css": {
				//"border": "1px solid rgba(255, 255, 255, 1.0)",
				"background-color": "black",
				"width": BAR_WIDTH+"px",
				"position": "relative",
				"left": parseInt(_content.css('margin-left'))+_content.innerWidth()+"px",
				"top": -_content.innerHeight()-parseInt(_content.css('margin-bottom'))+BAR_MARGIN+"px",
				"margin-left": -BAR_WIDTH-BAR_MARGIN+"px",
				"opacity": "0",
				"-moz-border-radius": BAR_WIDTH*2+"px",
				"-webkit-border-radius": BAR_WIDTH*2+"px",
				"-o-border-radius": BAR_WIDTH*2+"px",
				"-ms-border-radius": BAR_WIDTH*2+"px",
				"user-select": "none"
			}
		});
		vars.scrollArea = $( "<div>", {
			"class": "thScrollArea",
			"css": {
				"width": _areaWidth+"px",
				"height": vars.parent.innerHeight()+"px",
				//"max-height": "100%",
				"position": "relative",
				"left": parseInt(_content.css('margin-left'))+_content.innerWidth()-_areaWidth+"px",
				"top": -_content.innerHeight()-parseInt(_content.css('margin-bottom'))-vars.scrollBar.innerHeight()+"px",
				//"margin-left": -areaWidth+"px",
				"user-select": "none"
			}
		});
		//
		parent.updateContentSize(id);
		parent.appendScrollArea(id);
		//
		$(window).resize(function(id){
			return function()
			{
				parent.updateContentSize(id);
			}
		}(id));
		//
		if (parent.IS_DEBUG_MODE)
		{
			vars.scrollBar.css({
				"opacity": 0.5,
				"z-index": 1
			});
			vars.scrollArea.css({
				"background-color": "red",
				"opacity": 0.7
			});
		}
		//
		return new scrollArea(id++);
	}
	this.toggleScrollArea = function(is_enabled)
	{
		var vars = this.vars;
		var cssValue = (is_enabled) ? 'block' : 'none';
		for (var i=0, l=vars.length; i<l; i++)
		{
			vars[i].scrollArea.css('display', cssValue);
			vars[i].scrollBar.css('display', cssValue);
		}
	}

	//Class
	var scrollArea = function(id)
	{
		var vars = parent.vars[id];
		this.updateContentSize = function()
		{
			parent.updateContentSize(id);
		}
	}
}
thScrollArea.prototype.IS_DEBUG_MODE = false;//true;
thScrollArea.prototype.vars = [];
//
thScrollArea.prototype.thTouchStart = function(e)
{
	var self = e.data.self;
	var vars = self.vars[e.data.id];
	var scrollBar = vars.scrollBar;
	var barOpacity = vars.barOpactity;

	//Main procedures.
	$(scrollBar).css({
		'transition': '',
		'opacity': barOpacity
	});
	//$(this).trigger('touchmove', e.originalEvent.changedTouches[0].pageY);
	return false;
};
thScrollArea.prototype.thTouchEnd = function(e)
{
	var self = e.data.self;
	var vars = self.vars[e.data.id];
	var scrollBar = vars.scrollBar;
	var TRANSITION_TIME = self.TRANSITION_TIME;

	//Main procedures.
	$(scrollBar).css({
		'transition': 'opacity '+TRANSITION_TIME+'s',
		'opacity': '0'
	});
	return false;
};
thScrollArea.prototype.thTouchMove = function(e)
{
	var self = e.data.self;
	var vars = self.vars[e.data.id];
	var parent = vars.parent;
	var scrollBar = vars.scrollBar;
	var scrollArea = vars.scrollArea;
	var barOpacity = vars.barOpacity;
	var areaOffset = vars.areaOffset;
	var contentFullHeight = vars.contentFullHeight;
	var content = vars.content;
	var BAR_MARGIN = self.BAR_MARGIN;

	$(scrollBar).css({
		'transition': '',
		'opacity': barOpacity
	});
	e.preventDefault();
	var scroll = {
		"start": 0+areaOffset,
		"end": scrollArea.innerHeight()-areaOffset,
		"length": (scrollArea.innerHeight()-areaOffset)-(0+areaOffset)
	};

	// Normalize y if necessary.
	//var y = (pageY == null) ? e.originalEvent.changedTouches[0].pageY : pageY;
	var y = e.originalEvent.changedTouches[0].pageY-content.offset().top
	if (y <= scroll.start) y = scroll.start;
	if (y > scroll.end) y = scroll.end;

	//
	var ratio = (y-areaOffset)/scroll.length;
	var scrollHeight = contentFullHeight-parent.innerHeight();
	content.scrollTop(ratio*scrollHeight);
	//
	var top = ratio*(content.innerHeight()-scrollBar.innerHeight()-BAR_MARGIN*2)
				-content.innerHeight()-parseInt(content.css('margin-bottom'))+BAR_MARGIN;
	scrollBar.css('top', top);
	return false;
};
thScrollArea.prototype.updateContentHeight = function(id)
{
	var vars = this.vars[id];
	vars.contentFullHeight = vars.content.get(0).scrollHeight;
	//
	var BAR_MIN_HEIGHT = this.BAR_MIN_HEIGHT;
	var BAR_MARGIN = this.BAR_MARGIN;
	var BAR_OPACITY = this.BAR_OPACITY;
	var content = vars.content;
	var contentFullHeight = vars.contentFullHeight;
	var parent = vars.parent;
	var scrollBar = vars.scrollBar;
	var scrollArea = vars.scrollArea;
	var barOpacity = vars.barOpacity;
	//
	content.scrollTop(content.scrollTop());

	// Update scrollbar's style.
	var scrollBarHeight = (parent.innerHeight()/contentFullHeight)*parent.innerHeight();
	if (scrollBarHeight < BAR_MIN_HEIGHT) scrollBarHeight = BAR_MIN_HEIGHT;
	scrollBar.css({
		"top": -parent.innerHeight()+BAR_MARGIN+"px",
		"height": scrollBarHeight+"px",
	});
	scrollArea.css({
		"top": -parent.innerHeight()-scrollBar.innerHeight()+"px",
		"height": parent.innerHeight()+"px",
	});
	if (contentFullHeight <= parseInt(scrollArea.innerHeight()))
	{
		barOpacity = 0.0;
	}
	else
	{
		barOpacity = BAR_OPACITY;
	}
};
thScrollArea.prototype.updateContentWidth = function(id)
{
	var vars = this.vars[id];
	var content = vars.content;
	var scrollBar = vars.scrollBar;
	var scrollArea = vars.scrollArea;
	var areaWidth = vars.areaWidth;

	/*
	var originalWidth = content.css('width');
	var originalMaxWidth = content.css('max-width');

	// Reset height and max-height to get content's height.
	if (originalWidth != '0px') content.css('width', 'auto');
	if (originalMaxWidth != '0px') content.css('max-width', 'none');

	// Now you got content's height.
	contentWidth = content.width();

	// Revert height and max-height to original value;
	if (originalWidth != '0px') content.css('width', originalWidth);
	if (originalMaxWidth != '0px') content.css('max-width', originalMaxWidth);
	*/

	// Update scrollbar's style.
	scrollBar.css({
		"left": parseInt(content.css('margin-left'))+content.innerWidth()+"px"
	});
	scrollArea.css({
		"left": parseInt(content.css('margin-left'))+content.innerWidth()-areaWidth+"px"
	});
};
/*
thScrollArea.prototype.refreshContent = function()
{
	content = $(content.selector);
	parent = content.parent();
	self.updateContentSize();
};
*/
thScrollArea.prototype.updateContentSize = function(id)
{
	this.updateContentHeight(id);
	this.updateContentWidth(id);
};
thScrollArea.prototype.appendScrollArea = function(id)
{
	var vars = this.vars[id];
	var content = vars.content;
	var scrollArea = vars.scrollArea;
	var scrollBar = vars.scrollBar;
	var thTouchStart = this.thTouchStart;
	var thTouchMove = this.thTouchMove;
	var thTouchEnd = this.thTouchEnd;

	//Main procedures.
	content.after($(scrollArea));
	content.after($(scrollBar));
	$(scrollArea).bind('touchend', {'self': this, 'id': id}, thTouchEnd);
	//$(scrollArea).bind('touchstart',  {'self': this, 'id': id}, thTouchStart);
	$(scrollArea).bind('touchmove',  {'self': this, 'id': id}, thTouchMove);
};
var thSA = new thScrollArea("iOS7");