var ZX = {
 
	
	handle : null,

	init : function(handle, group, minX, maxX, minY, maxY, thresholdX, thresholdY) {
		handle.onmousedown = ZX.start;

		handle.group = group && group != null ? group : handle;

		if (isNaN(parseInt(handle.group.style.left))) handle.group.style.left = "0px";
		if (isNaN(parseInt(handle.group.style.top))) handle.group.style.top = "0px";

		handle.minX = typeof minX != 'undefined' ? minX : null;
		handle.minY = typeof minY != 'undefined' ? minY : null;
		handle.maxX = typeof maxX != 'undefined' ? maxX : null;
		handle.maxY = typeof maxY != 'undefined' ? maxY : null;
		handle.thresholdY = typeof thresholdY != 'undefined' ? thresholdY : 0;
		handle.thresholdX = typeof thresholdX != 'undefined' ? thresholdX : 0;

		handle.group.onZXStart = new Function();
		handle.group.onZXEnd = new Function();
		handle.group.onZX = new Function();
	},

	start : function(event) {

		var handle = ZX.handle = this;
		event = ZX.fixEvent(event);
		var x = parseInt(handle.group.style.left);
		var y = parseInt(handle.group.style.top);

		handle.group.onZXStart(x, y, handle.group);

		handle.lastMouseX = handle.startX = event.clientX;
		handle.lastMouseY = handle.startY = event.clientY;

		var offsetLeft = ZX.screenOffsetLeft(handle);
		var offsetTop = ZX.screenOffsetTop(handle);

		
		if (handle.minX != null) 
			handle.minMouseX = event.clientX - x + handle.minX - offsetLeft;
		if (handle.maxX != null) 
			handle.maxMouseX	= handle.minMouseX + handle.maxX - handle.minX;

		if (handle.minY != null) 
			handle.minMouseY = event.clientY - y + handle.minY - offsetTop;
		if (handle.maxY != null) 
			handle.maxMouseY = handle.minMouseY + handle.maxY - handle.minY;

		document.onmousemove	= ZX.drag;
		document.onmouseup		= ZX.end;

		return false;
	},

	drag : function(event) {
		var handle = ZX.handle;
		event = ZX.fixEvent(event);

		if (!handle.isZXging && handle.thresholdY > 0 &&
				Math.abs(event.clientY - handle.startY) < handle.thresholdY) 
			return true;
		if (!handle.isZXging && handle.thresholdX > 0 &&
				Math.abs(event.clientX - handle.startX) < handle.thresholdX) 
			return true;

		handle.isZXging = true;

		var ex	= event.clientX;
		var ey	= event.clientY;
		var x = parseInt(handle.group.style.left);
		var y = parseInt(handle.group.style.top);
		var nx, ny;

		
		if (handle.minX != null) ex = Math.max(ex, handle.minMouseX);
		if (handle.maxX != null) ex = Math.min(ex, handle.maxMouseX);
		if (handle.minY != null) ey = Math.max(ey, handle.minMouseY);
		if (handle.maxY != null) ey = Math.min(ey, handle.maxMouseY);

		nx = x + (ex - handle.lastMouseX); 
		ny = y + (ey - handle.lastMouseY);

		accZ ++;
		handle.group.style["zIndex"] = accZ;
		handle.group.style["left"] = nx + "px";
		handle.group.style["top"] = ny + "px";
		handle.lastMouseX	= ex;
		handle.lastMouseY	= ey;

		var xBefore = ZX.screenOffsetLeft(handle);
		var yBefore = ZX.screenOffsetTop(handle);

		handle.group.onZX(nx, ny, handle.group);

		var xAfter = ZX.screenOffsetLeft(handle);
		var yAfter = ZX.screenOffsetTop(handle);

		if (yBefore != yAfter) {
			var yError = yBefore - yAfter;
			var y = parseInt(handle.group.style.top);
			handle.group.style["top"] =  (y + yError) + "px";
		}
		if (xBefore != xAfter) {
			var xError = xBefore - xAfter;
			var x = parseInt(handle.group.style.left);
			handle.group.style["left"] =  (x + xError) + "px";
		}

		return false;
	},

	end : function() {
		var handle = ZX.handle;
		document.onmousemove = null;
		document.onmouseup   = null;
		handle.group.onZXEnd(
				parseInt(handle.group.style["left"]), 
				parseInt(handle.group.style["top"]), 
				handle.group);
		handle.isZXging = false;
		ZX.handle = null;
		return true;
	},

	fixEvent : function(event) {
		if (typeof event == 'undefined') event = window.event;
		if (typeof event.layerX == 'undefined') event.layerX = event.offsetX;
		if (typeof event.layerY == 'undefined') event.layerY = event.offsetY;
		return event;
	},

	coord : function(x, y) {
		return "(" + x + "," + y + ")";
	},

	screenOffsetTop : function(elem) {
		if (elem.y) return elem.y;  // IE ?

		var offset = 0;
		while (elem.offsetParent) {
			offset += elem.offsetTop;
			elem = elem.offsetParent;
		}
		return offset;
	},

	screenOffsetLeft : function(elem) {
		if (elem.x) return elem.x;  // IE ?

		var offset = 0;
		while (elem.offsetParent) {
			offset += elem.offsetLeft;
			elem = elem.offsetParent;
		}
		return offset;
	}
};