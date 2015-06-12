function thScrollArea(_content, _areaWidth, _areaOffset)
{
	var IS_DEBUG_MODE = true;
	//
	var scrollBar;
	var scrollArea;
	var self = this;
	var content = _content;
	var areaWidth = _areaWidth;
	var areaOffset = _areaOffset;
	var contentHeight;
	var BAR_MIN_HEIGHT;
	var BAR_WIDTH;
	var BAR_MARGIN;
	var BAR_OPACITY;
	var TRANSITION_TIME;
	var barOpacity = BAR_OPACITY;
	var constructor = function()
	{
		scrollBar = createScrollBar("iOS7");
		scrollArea = $( "<div>", {
			"class": "thScrollArea",
			"css": {
				"width": areaWidth+"px",
				"height": content.height()+parseInt(content.css('padding-top'))+parseInt(content.css('padding-bottom'))+"px",
				"max-height": "100%",
				"position": "absolute",
				"left": content.offset().left+parseInt(content.css('padding-left'))+parseInt(content.css('padding-right'))+content.width()+"px",
				"top": content.offset().top+"px",
				"margin-left": -areaWidth+"px",
				"user-select": "none"
			}
		});
		self.updateContentHeight(content);
		$(window).resize(function(){
			self.updateContentHeight();
			self.updateContentWidth();
		});
		//
		if (IS_DEBUG_MODE)
		{
			scrollBar.css({
				"opacity": 0.5,
				"z-index": 1
			});
			scrollArea.css({
				"background-color": "red",
				"opacity": 0.7
			});
		}
	}
	var createScrollBar = function(useragent)
	{
		if (useragent == "iOS6")
		{
			BAR_MIN_HEIGHT = 34;
			BAR_WIDTH = 5;
			BAR_MARGIN = 2;
			BAR_OPACITY = 0.5;
			TRANSITION_TIME = 0.35;
		}
		else if (useragent == "iOS7")
		{
			BAR_MIN_HEIGHT = 36;
			BAR_WIDTH = 2.5;
			BAR_MARGIN = 3
			BAR_OPACITY = 0.35;
			TRANSITION_TIME = 0.35;
		}
		return $( "<div>", {
			"class": "thScrollBar",
			"css": {
				//"border": "1px solid rgba(255, 255, 255, 1.0)",
				"background-color": "black",
				"width": BAR_WIDTH+"px",
				"position": "absolute",
				"left": content.offset().left+parseInt(content.css('padding-left'))+parseInt(content.css('padding-right'))+content.width()+"px",
				"top": content.offset().top+BAR_MARGIN+"px",
				"margin-left": -BAR_WIDTH-BAR_MARGIN+"px",
				"opacity": "0",
				"-moz-border-radius": BAR_WIDTH*2+"px",
				"-webkit-border-radius": BAR_WIDTH*2+"px",
				"-o-border-radius": BAR_WIDTH*2+"px",
				"-ms-border-radius": BAR_WIDTH*2+"px",
				"user-select": "none"
			}
		});
	}
	var getNormalizedPageY = function(pageY)
	{
		return pageY-content.offset().top;
		//-parseInt(content.css('padding-left'))-parseInt(content.css('padding-right'));
	}
	var thTouchStart = function(e)
	{
		$(scrollBar).css({
			'transition': '',
			'opacity': BAR_OPACITY
		});
		$(this).trigger('touchmove', e.originalEvent.changedTouches[0].pageY);
		return false;
	}
	var thTouchEnd = function(e)
	{
		$(scrollBar).css({
			'transition': 'opacity '+TRANSITION_TIME+'s',
			'opacity': '0'
		});
		return false;
	}
	var thTouchMove = function(e, pageY)
	{
		e.preventDefault();
		var scroll = {
			"start": 0+areaOffset,
			"end": $(scrollArea).height()-areaOffset,
			"length": ($(scrollArea).height()-areaOffset)-(0+areaOffset)
		};

		// Normalize y if necessary.
		var y = (pageY == null) ? e.originalEvent.changedTouches[0].pageY : pageY;
		y = getNormalizedPageY(y);
		if (y <= scroll.start) y = scroll.start;
		if (y > scroll.end) y = scroll.end;

		//
		var ratio = (y-areaOffset)/scroll.length;
		var truncatedContentHeight = content.height();
		var scrollHeight = contentHeight-truncatedContentHeight;
		content.scrollTop(ratio*scrollHeight);
		//
		var top = ratio*(content.height()+parseInt(content.css("padding-top"))+parseInt(content.css("padding-bottom"))-$(scrollBar).height()-BAR_MARGIN*2)+BAR_MARGIN+content.offset().top;
		scrollBar.css('top', top);
	}
	this.appendScrollArea = function(_content)
	{
		$(scrollBar).appendTo(_content);
		$(scrollArea).appendTo(_content);
		$(scrollArea).bind('touchend', thTouchEnd);
		$(scrollArea).bind('touchstart', thTouchStart);
		$(scrollArea).bind('touchmove', thTouchMove);
	}
	this.createScrollArea = function(_content, _areaWidth, _areaOffset)
	{
		content = _content;
		areaWidth = _areaWidth;
		areaOffset = _areaOffset;
		constructor();
	}
	this.getScrollArea = function()
	{
		return scrollArea;
	}
	this.updateContentHeight = function(_content)
	{
		if (_content) content = _content;
		var originalHeight = content.css('height');
		var originalMaxHeight = content.css('max-height');
		var originalMinHeight = content.css('min-height');

		// Reset height and max-height to get content's height.
		if (originalHeight != '0px') content.css('height', 'auto');
		if (originalMaxHeight != '0px') content.css('max-height', 'none');
		if (originalMinHeight != '0px') content.css('min-height', 'none');

		// Now you got content's height.
		contentHeight = content.height();

		// Revert height and max-height to original value;
		if (originalHeight != '0px') content.css('height', originalHeight);
		if (originalMaxHeight != '0px') content.css('max-height', originalMaxHeight);
		if (originalMinHeight != '0px') content.css('min-height', originalMinHeight);

		// Update scrollbar's style.
		var scrollBarHeight = content.height()*(content.height()/contentHeight);
		if (scrollBarHeight < BAR_MIN_HEIGHT) scrollBarHeight = BAR_MIN_HEIGHT;
		scrollBar.css({
			"height": scrollBarHeight+"px",
			"top": content.offset().top+BAR_MARGIN+"px",
		});
		scrollArea.css({
			"height": content.height()+parseInt(content.css('padding-top'))+parseInt(content.css('padding-bottom'))+"px",
			"top": content.offset().top+"px",
		});
		if (contentHeight <= parseInt(scrollArea.css('height')))
		{
			barOpacity = 0.0;
		}
		else
		{
			barOpacity = BAR_OPACITY;
		}
	}
	this.updateContentWidth = function(_content)
	{
		if (_content) content = _content;

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
			"left": content.offset().left+parseInt(content.css('padding-left'))+parseInt(content.css('padding-right'))+content.width()+"px",
		});
		scrollArea.css({
			"left": content.offset().left+parseInt(content.css('padding-left'))+parseInt(content.css('padding-right'))+content.width()+"px",
		});
	}
	this.getContentHeight = function()
	{
		return contentHeight;
	}
	//
	if (_content && _areaWidth && _areaOffset) constructor();
}