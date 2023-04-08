	this.getPosition = function (element) {
		var xPosition = 0;
		var yPosition = 0;
	  
		while(element) {
			xPosition += (element.offsetLeft - element.scrollLeft + element.clientLeft);
			yPosition += (element.offsetTop - element.scrollTop + element.clientTop);
			element = element.offsetParent;
		}
		return { x: xPosition, y: yPosition };
	}		
	
/*
The clientLeft property returns the width of the left border of an element, in pixels.

element.offsetLeft	Returns the horizontal offset position of an element

element.scrollLeft	Sets or returns the number of pixels an element's content is scrolled horizontally

Window:
outerHeight	Returns the outer height of a window, including toolbars/scrollbars (there is also innerHeight....)

pageXOffset	Returns the pixels the current document has been scrolled (horizontally) from the upper left corner of the window

offsetWidth offsetHeight client

jQuery:

$("#myDiv").height(); or even $(window).width

The jQuery .offset() method allows us to retrieve the current position of an element relative to the document. Contrast this with .position(), which retrieves the current position relative to the offset parent.
 returns an object with top and left
******/	
