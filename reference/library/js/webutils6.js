
function WebUtils6(obj){

	
	this.JQuery    = jQuery;
	
	
	var WU = this;
	

	WU.objExists =function(obj){
		return (jQuery(obj).get(0) != null);
	}

	WU.setJQuery = function(jq){
		WU.JQuery = jq;
	}
	
	WU.attr = function(first, second){
		var ret = 0;
		
		if(typeof first=="string" && typeof second=="string"){
			ret =  WU.JQuery.attr(first,second);
		}else if(typeof first=="string" && second == undefined){
			ret =  WU.JQuery.attr(first);
		}else if(typeof first=="string" && typeof second=="function"){
			ret =  WU.JQuery.attr(first,second);
		}else if(typeof first=="object" && second == undefined){
			ret =  WU.JQuery.attr(first);
		}else {
		
			console.log("The parameters for attr are wrong!!!");
			return 0;
		}

		
		return ret;
	}
	
	WU.find = function(obj){
		
		if(!WU.objExists(obj)){
		console.log(obj+" not found!!!");
		}
		
		var x = WU.JQuery.find(obj);
		WU.setJQuery(x);
		return WU;
	}

	

	WU.children = function(obj){
		
		if(!WU.objExists(obj) && obj != undefined){
		console.log("children "+obj+" not found!!!");
		}
		
		var x = WU.JQuery.children(obj);
		WU.setJQuery(x);
		return WU;
	}


	WU.next = function () {
		WU.setJQuery( WU.JQuery.next());
		return WU;
	}

	WU.nextAll = function () {
		WU.setJQuery( WU.JQuery.nextAll());
		return WU;
	}

	WU.prev = function () {
		WU.setJQuery( WU.JQuery.prev());
		return WU;
	}

	WU.prevAll = function () {
		WU.setJQuery( WU.JQuery.prevAll());
		return WU;
	}

	WU.siblings = function(obj){
		
		if(!WU.objExists(obj) && obj != undefined){
		console.log("siblings "+obj+" not found!!!");
		}
		
		var x = WU.JQuery.siblings(obj);
		WU.setJQuery(x);
		return WU;
	}
	
	WU.nextUntil = function(obj){
		
		if(!WU.objExists(obj) && obj != undefined){
		console.log("nextUntil "+obj+" not found!!!");
		}
		
		var x = WU.JQuery.nextUntil(obj);
		WU.setJQuery(x);
		return WU;
	}
	
	WU.prevUntil = function(obj){
		
		if(!WU.objExists(obj) && obj != undefined){
		console.log("prevUntil "+obj+" not found!!!");
		}
		
		var x = WU.JQuery.prevUntil(obj);
		WU.setJQuery(x);
		return WU;
	}	

	WU.get = function(obj){
		
		var ret;
		
		if(WU.JQuery.get(obj) == null){
		console.log("get("+obj+") not found!!!");
		}
		

		return WU.JQuery.get(obj);
	}
	

	WU.bind = function(item,dat,fun){
		
		var ret;
		
	
		if(!WU.isAnEvent(item)){ console.log(item +" is not an event!!") }
		if(typeof dat != 'function' &&
		   typeof dat != 'object'){
			console.log(dat +" is of wrong type");
		}
		
		if(typeof dat == 'object'){
			if(typeof fun == 'function'){
				ret = WU.JQuery.bind(item,dat,fun);
				WU.setJQuery(ret);
				return WU;			
			}else{
				console.error(fun +" is not a function");
			}
		}else if(typeof dat == 'function'){
			ret = WU.JQuery.bind(item,dat);
			WU.setJQuery(ret);
			return WU;
		}else{
			console.error(dat +" is not a function");
		}
	}
	
	WU.on = function(ev,chld,dat,fun){
	
		var ret;
		
		if(!WU.isAnEvent(ev)){ console.log(ev+" is not an event")};

		if(typeof chld == 'string'){
			if(typeof dat == 'object'){
				if(typeof(fun) == "function"){
					ret = WU.JQuery.on(ev,chld,dat,fun);
				}
			}
		}else if(typeof chld == 'object'){
			if( typeof dat== "function"){
				ret  = WU.JQuery.on(ev,chld,dat);
			}else{
				console.error(dat+" is not a function");
			}
		}else if( typeof chld== "function"){
			ret  = WU.JQuery.on(ev,chld,dat);
		}else{
			console.error(chld+" is not a function");
		}
		
		WU.setJQuery(ret);
		return WU;
	}
	
	WU.ready = function(fun){
		
		WU.setJQuery(WU.JQuery.ready(fun));
		return WU;
	}
	
	
	
	
	WU.isAnEvent = function (evt) {
		if(
		evt == 'mouseover' ||
		evt == 'mouseout' ||
		evt == 'mouseover' ||
		evt == 'mouseout' ||
		evt == 'click' ||
		evt == 'contextmenu' ||
		evt == 'dblclick' ||
		evt == 'mousedown' ||
		evt == 'mouseenter' ||
		evt == 'mouseleave' ||
		evt == 'mousemove' ||
		evt == 'mouseover' ||
		evt == 'mouseout' ||
		evt == 'mouseup' ||
		evt == 'keydown' ||
		evt == 'keypress' ||
		evt == 'keyup' ||
		evt == 'abort' ||
		evt == 'beforeunload' ||
		evt == 'error' ||
		evt == 'hashchange' ||
		evt == 'load' ||
		evt == 'pageshow' ||
		evt == 'pagehide' ||
		evt == 'resize' ||
		evt == 'scroll' ||
		evt == 'unload' ||
		evt == 'blur' ||
		evt == 'change' ||
		evt == 'focus' ||
		evt == 'focusin' ||
		evt == 'focusout' ||
		evt == 'input' ||
		evt == 'invalid' ||
		evt == 'reset' ||
		evt == 'search' ||
		evt == 'select' ||
		evt == 'submit' ||
		evt == 'drag' ||
		evt == 'dragend' ||
		evt == 'dragenter' ||
		evt == 'dragleave' ||
		evt == 'dragover' ||
		evt == 'dragstart' ||
		evt == 'drop' ||
		evt == 'copy' ||
		evt == 'cut' ||
		evt == 'paste' ||
		evt == 'afterprint' ||
		evt == 'beforeprint' ||
		evt == 'abort' ||
		evt == 'canplay' ||
		evt == 'canplaythrough' ||
		evt == 'durationchange' ||
		evt == 'emptied' ||
		evt == 'ended' ||
		evt == 'error' ||
		evt == 'loadeddata' ||
		evt == 'loadedmetadata' ||
		evt == 'loadstart' ||
		evt == 'pause' ||
		evt == 'play' ||
		evt == 'playing' ||
		evt == 'progress' ||
		evt == 'ratechange' ||
		evt == 'seeked' ||
		evt == 'seeking' ||
		evt == 'stalled' ||
		evt == 'suspend' ||
		evt == 'timeupdate' ||
		evt == 'volumechange' ||
		evt == 'waiting' ||
		evt == 'end' ||
		evt == 'iteration' ||
		evt == 'start' ||
		evt == 'end' ||
		evt == 'error' ||
		evt == 'message' ||
		evt == 'open' ||
		evt == 'nection' ||
		evt == 'message' ||
		evt == 'mousewheel' ||
		evt == 'wheelevent' ||
		evt == 'line' ||
		evt == 'offline' ||
		evt == 'popstate' ||
		evt == 'show' ||
		evt == 'text' ||
		evt == 'storage' ||
		evt == 'toggle' ||
		evt == 'wheel' ||
		evt == 'touchcancel' ||
		evt == 'touchend' ||
		evt == 'touchmove' ||
		evt == 'touchstart' ||
		evt == 'keypress' ||
		evt == 'keypress' ||
		evt == 'keydown' ||
		evt == 'keyup' ||
		evt == 'keypress' ||
		evt == 'keydown' ||
		evt == 'keyup' 
		)
		return true;
		else return false;
		
	}
	WU.unbind = function (evt,fun){
		var ret;
		if(
			evt != null &&
			!WU.isAnEvent(evt)
		){
			console.log(evt +" is not an event!!");
		}
		
		if(
			fun != null &&
			typeof fun !='function'
		){
			console.log(fun + " is not a function");
		}
		
		if(evt != null && fun != null ){
			ret = WU.JQuery.unbind(evt, fun);
			WU.setJQuery(ret);
			
		}else if(evt != null){
			ret = WU.JQuery.unbind(evt);
			WU.setJQuery(ret);		
		}
		return WU;
	}
	
	WU.off = function(evt,selector) {
		var ret;
		if(	evt == null || 	WU.isAnEvent(evt)){
			console.log(evt +" is not an event!!");
			return
		}
		
		if(selector==null){
			ret = WU.off(evt);
		}else{
			ret = WU.off(evt,selector);
		}
		WU.setJQuery(ret);
		
		return WU;
	}
	
	WU.css = function(styl,val){
		if(!WU.isStyle(styl) && typeof styl !="object") console.log(styl + " is not a style or style list");

		if( typeof styl== "object"){
			for(styles in styl){
				if(!WU.isStyle(styles)){console.log(style +" is not a style "); }
			}	
		}
		
		if(typeof styl == "string"){
			if(val== null){
				console.log("css value is missing!!!");
			}
		}
		
		WU.setJQuery(WU.JQuery.css(styl,val));
		return WU;
	}
	
	WU.applyCss = function (stylelist) {
		
		var styles;
		if (typeof stylelist != 'object'){
			console.log("The style list "+ stylelist + " is of the wrong type ");
			return
		}
		
		for(styles in stylelist){
			if(!WU.isStyle(styles)){console.log(style +" is not a style "); }
			WU.JQuery.css(styles,stylelist[styles]);
		}	
	}
	
	WU.each = function(fun){

		var ret;
		if(typeof fun !='function'){ console.log(fun +" is not a function")};
		
		WU.JQuery.each(fun);
		
		WU.setJQuery(ret);
		return WU;
	
	}
	
	
	WU.html = function (htm){
		
		if(	WU.JQuery.get(0).innerHTML == undefined){
			console.log(WU.JQuery.get(0)+" the object you are trying to apply 'html(..)' to cannot have innerHTML");
		}
		if(WU.JQuery.get(0)== null){
			console.log("You cannot set html for this object");
		}
		
		if(htm != null){
			if(typeof htm != 'string'){
				console.log("You should supply a string for html function" );	
			}
			return (WU.JQuery.html(htm));
		}
		return WU.JQuery.html();
	
	}
	
	WU.text = function (htm){

		if(	WU.JQuery.get(0).innerHTML == undefined){
			console.log(WU.JQuery.get(0)+" the object you are trying to apply 'text(..)' to cannot have innerHTML");
		}
	
		if(	WU.JQuery.get(0)== null ){
			console.log("You cannot set text for this object");
		}	
		
		if(htm != null){
			if(typeof htm != 'string'){
				console.log("You should supply a string for text function" );	
			}
			return (WU.JQuery.text(htm));
		}
		return WU.JQuery.text();
	
	}
	
	WU.val = function (htm){
	
		if(	WU.JQuery.get(0)== null ){
			console.log("You cannot set text for this object");
		}
		
		if(	WU.JQuery.get(0).value == undefined){
			console.log(WU.JQuery.get(0)+" the object you are trying to apply 'val(..)' to does not a value attribute");
		}
		
		if(htm != null){
			if(typeof htm != 'string'){
				console.log("You should supply a string for text function" );	
			}
			return (WU.JQuery.val(htm));
		}
		return WU.JQuery.val();
	
	}
	
	WU.width = function () {
		WU.setJQuery( WU.JQuery.width());
		return WU;
	}

	WU.height = function () {
		WU.setJQuery( WU.JQuery.height());
		return WU;
	}

	WU.innerWidth = function () {
		WU.setJQuery( WU.JQuery.innerWidth());
		return WU;
	}

	WU.innerHeight = function () {
		WU.setJQuery( WU.JQuery.innerHeight());
		return WU;
	}
	
	WU.before = function(content, fun){
		if(!WU.objExists(content)){
			console.log(content +" does not exist!!!");
		}
		
		if((typeof content== 'string' ||typeof content== 'object') && fun == undefined){
			WU.setJQuery(WU.JQuery.before(content));
		}else if((typeof content== 'string' ||typeof content== 'object') && typeof fun == "function"){
			WU.setJQuery(WU.JQuery.before(content,fun));
		}else {
			console.log("JQuery before: problem with arguments");
			return 0;
		}
		
		return WU;
		
	}

	WU.after =function(content, fun){
		if(!WU.objExists(content)){
			console.log(content +" does not exist!!!");
		}
		
		if((typeof content== 'string' ||typeof content== 'object') && fun == undefined){
			WU.setJQuery(WU.JQuery.after(content));
		}else if((typeof content== 'string' ||typeof content== 'object') && typeof fun == "function"){
			WU.setJQuery(WU.JQuery.after(content,fun));
		}else {
			console.log("JQuery before: problem with arguments");
			return 0;
		}
		
		return WU;
		
	}	
	


	WU.append =function(content, fun){
		if(!WU.objExists(content)){
			console.log(content +" does not exist!!!");
		}
		
		if((typeof content== 'string' ||typeof content== 'object') && fun == undefined){
			WU.setJQuery(WU.JQuery.append(content));
		}else if((typeof content== 'string' ||typeof content== 'object') && typeof fun == "function"){
			WU.setJQuery(WU.JQuery.append(content,fun));
		}else {
			console.log("JQuery before: problem with arguments");
			return 0;
		}
		
		return WU;
		
	}	


	WU.outerWidth = function () {
		WU.setJQuery( WU.JQuery.outerWidth());
		return WU;
	}

	WU.outerHeight = function () {
		WU.setJQuery( WU.JQuery.outerHeight());
		return WU;
	}
	
	
	WU.parent = function ()
	{
		WU.setJQuery( WU.JQuery.parent());
		return WU;
	}
	
	WU.parents = function (elem){
		if(!objExists(elem)&& elem != undefined){
			console.log("The element "+elem+" does not exist");
		}
		
		WU.setJQuery( WU.JQuery.parents(elem));
		return WU;		
	}
	
	
	WU.parentsUntil = function (elem){
		if(!objExists(elem)){
			console.log("The element "+elem+" does not exist");
		}
		
		WU.setJQuery( WU.JQuery.parentsUntil(elem));
		return WU;		
	}	
	
	
	WU.first = function (){
		
		WU.setJQuery( WU.JQuery.first());
		return WU;
	
	}
	
	WU.last = function (){
		
		WU.setJQuery( WU.JQuery.last());
		return WU;
	
	}	
	
	WU.remove = function(){
		WU.setJQuery( WU.JQuery.remove());
		return WU;
	}
	
	WU.empty = function(){
		WU.setJQuery( WU.JQuery.empty());
		return WU;
	}


	WU.show = function (tim,ease,fun){
		var ret = WU.retFromTimeEaseFunc(tim,ease,fun,'show');
		WU.setJQuery( ret);
		return WU;		
	}
	
	WU.hide = function (tim,ease,fun){
		var ret = WU.retFromTimeEaseFunc(tim,ease,fun,'hide');
		WU.setJQuery( ret);
		return WU;
		
	}

	WU.retFromTimeEaseFunc = function (tim,ease, fun,jqfn){
		var ret= 0;
		
		if(tim==null&& ease==null && fun==null )
			ret = WU.JQuery[jqfn]();
		if(typeof tim== 'function'&& ease==null && fun== null){
			ret = WU.JQuery[jqfn](400,'linear',tim);
		}
		if((tim=="linear" || tim=="swing")&& ease==null && fun==null){
			ret = WU.JQuery[jqfn](400,ease,function(){});
		}
		if((tim=="linear" || tim=="swing")&& typeof ease=='function' && fun==null){
			ret = WU.JQuery[jqfn](tim,'linear',ease);
		}
		if((tim=="slow" || tim=="fast" || typeof tim =='number')&& 
		  ease==null && fun==null){
		  ret = WU.JQuery[jqfn](tim,'linear',function(){});
		}
		if((tim=="slow" || tim=="fast" || typeof tim =='number')&&
		  typeof ease=='function' && fun==null){
			ret = WU.JQuery[jqfn](tim,'linear',ease);
		}
		if((tim=="slow" || tim=="fast" || typeof tim =='number')&& 
		  (ease=="linear" || ease=="swing") && fun==null){
			ret = WU.JQuery[jqfn](tim,ease,function(){});
		}
		if((tim=="slow" || tim=="fast" || typeof tim =='number')&& 
		  (ease=="linear" || tim=="swing") && typeof fun=='function') {
			ret = WU.JQuery[jqfn](tim,ease,fun);
		}		

		if (ret == 0) console.log("Parameters for "+jqfn+" are wrong!!!");
		return ret;
	}
	
	WU.animate = function(styles,tim,ease, fun){
		
		if(!WU.isStyleList(styles)){
			console.log("{style-params}, is compulsory for animate,please check the structure of the style-list");
			return 0;
		}

		var jqfn = 'animate', ret = 0;

		if(tim==null&& ease==null && fun==null )
			ret = WU.JQuery[jqfn](styles);
		if(typeof tim== 'function'&& ease==null && fun== null){
			ret = WU.JQuery[jqfn](styles,400,'linear',tim);
		}
		if((tim=="linear" || tim=="swing")&& ease==null && fun==null){
			ret = WU.JQuery[jqfn](styles,400,ease,function(){});
		}
		if((tim=="linear" || tim=="swing")&& typeof ease=='function' && fun==null){
			ret = WU.JQuery[jqfn](styles,tim,'linear',ease);
		}
		if((tim=="slow" || tim=="fast" || typeof tim =='number')&& 
		  ease==null && fun==null){
		  ret = WU.JQuery[jqfn](styles,tim,'linear',function(){});
		}
		if((tim=="slow" || tim=="fast" || typeof tim =='number')&&
		  typeof ease=='function' && fun==null){
			ret = WU.JQuery[jqfn](styles,tim,'linear',ease);
		}
		
		if((tim=="slow" || tim=="fast" || typeof tim =='number')&& 
		  (ease=="linear" || ease=="swing") && fun==null){
			ret = WU.JQuery[jqfn](styles,tim,ease,function(){});
		}
		if((tim=="slow" || tim=="fast" || typeof tim =='number')&& 
		  (ease=="linear" || tim=="swing") && typeof fun=='function') {
			ret = WU.JQuery[jqfn](styles,tim,ease,fun);
		}
		
		if(ret==0){console.log("Paremeters for animate are wrong!!!")}
		
		return ret;
	}

	WU.slideUp = function (tim,ease,fun){
		var ret = WU.retFromTimeEaseFunc(tim,ease,fun,'slideUp');
		WU.setJQuery( ret);
		return WU;		
	}	
	
	WU.slideDown = function (tim,ease,fun){
		var ret = WU.retFromTimeEaseFunc(tim,ease,fun,'slideDown');
		WU.setJQuery( ret);
		return WU;
		
	}	
	
	
	WU.slideToggle = function(tim,ease,fun){
		var ret = WU.retFromTimeEaseFunc(tim,ease,fun,'slideToggle');
		WU.setJQuery( ret);
		return WU;	
	}
	
	WU.toggle = function(tim,ease,fun){
		var ret = WU.retFromTimeEaseFunc(tim,ease,fun,'toggle');
		WU.setJQuery( ret);
		return WU;	
	}
	
	WU.fadeToggle = function(tim,ease, fun){
		var ret = WU.retFromTimeEaseFunc(tim,ease,fun,'fadeToggle');
		WU.setJQuery( ret);
		return WU;	
	}
	
	WU.fadeIn = function(tim,ease, fun){
		var ret = WU.retFromTimeEaseFunc(tim,ease,fun,'fadeIn');
		WU.setJQuery( ret);
		return WU;	
	}
	
	WU.fadeOut = function (tim, ease, fun){
		var ret = WU.retFromTimeEaseFunc(tim,ease,fun,'fadeOut');
		WU.setJQuery( ret);
		return WU;	
	}
	
	WU.stylePpt = function(sty){
		var SM = {};
		
		SM['align-content'] = 'alignContent' ;
		SM['align-items'] = 'alignItems' ;
		SM['align-self'] = 'alignSelf' ;
		SM['animation'] = 'animation' ;
		SM['animation-play-state'] = 'animationPlayState' ;
		SM['animation-delay'] = 'animationDelay' ;
		SM['animation-direction'] = 'animationDirection' ;
		SM['animation-duration'] = 'animationDuration' ;
		SM['animation-fill-mode'] = 'animationFillMode' ;
		SM['animation-iteration-count'] = 'animationIterationCount' ;
		SM['animation-name'] = 'animationName' ;
		SM['animation-timing-function'] = 'animationTimingFunction' ;
		SM['animation-play-state'] = 'animationPlayState' ;
		SM['background'] = 'background' ;
		SM['background-attachment'] = 'backgroundAttachment' ;
		SM['background-color'] = 'backgroundColor' ;
		SM['background-image'] = 'backgroundImage' ;
		SM['background-position'] = 'backgroundPosition' ;
		SM['background-repeat'] = 'backgroundRepeat' ;
		SM['background-clip'] = 'backgroundClip' ;
		SM['background-origin'] = 'backgroundOrigin' ;
		SM['background-size'] = 'backgroundSize' ;
		SM['backface-visibility'] = 'backfaceVisibility' ;
		SM['border'] = 'border' ;
		SM['border-bottom'] = 'borderBottom' ;
		SM['border-bottom-color'] = 'borderBottomColor' ;
		SM['border-bottom-left-radius'] = 'borderBottomLeftRadius' ;
		SM['border-bottom-right-radius'] = 'borderBottomRightRadius' ;
		SM['border-bottom-style'] = 'borderBottomStyle' ;
		SM['border-bottom-width'] = 'borderBottomWidth' ;
		SM['border-collapse'] = 'borderCollapse' ;
		SM['border-color'] = 'borderColor' ;
		SM['border-image'] = 'borderImage' ;
		SM['border-image-outset'] = 'borderImageOutset' ;
		SM['border-image-repeat'] = 'borderImageRepeat' ;
		SM['border-image-slice'] = 'borderImageSlice' ;
		SM['border-image-source'] = 'borderImageSource' ;
		SM['border-image-width'] = 'borderImageWidth' ;
		SM['border-left'] = 'borderLeft' ;
		SM['border-left-color'] = 'borderLeftColor' ;
		SM['border-left-style'] = 'borderLeftStyle' ;
		SM['border-left-width'] = 'borderLeftWidth' ;
		SM['border-radius'] = 'borderRadius' ;
		SM['border-right'] = 'borderRight' ;
		SM['border-right-color'] = 'borderRightColor' ;
		SM['border-right-style'] = 'borderRightStyle' ;
		SM['border-right-width'] = 'borderRightWidth' ;
		SM['border-spacing'] = 'borderSpacing' ;
		SM['border-style'] = 'borderStyle' ;
		SM['border-top'] = 'borderTop' ;
		SM['border-top-color'] = 'borderTopColor' ;
		SM['border-top-left-radius'] = 'borderTopLeftRadius' ;
		SM['border-top-right-radius'] = 'borderTopRightRadius' ;
		SM['border-top-style'] = 'borderTopStyle' ;
		SM['border-top-width'] = 'borderTopWidth' ;
		SM['border-width'] = 'borderWidth' ;
		SM['bottom'] = 'bottom' ;
		SM['box-decoration-break'] = 'boxDecorationBreak' ;
		SM['box-shadow'] = 'boxShadow' ;
		SM['box-sizing'] = 'boxSizing' ;
		SM['caption-side'] = 'captionSide' ;
		SM['clear'] = 'clear' ;
		SM['clip'] = 'clip' ;
		SM['color'] = 'color' ;
		SM['column-count'] = 'columnCount' ;
		SM['column-fill'] = 'columnFill' ;
		SM['column-gap'] = 'columnGap' ;
		SM['column-rule'] = 'columnRule' ;
		SM['column-rule-color'] = 'columnRuleColor' ;
		SM['column-rule-style'] = 'columnRuleStyle' ;
		SM['column-rule-width'] = 'columnRuleWidth' ;
		SM['columns'] = 'columns' ;
		SM['column-count'] = 'columnCount' ;
		SM['column-span'] = 'columnSpan' ;
		SM['column-width'] = 'columnWidth' ;
		SM['content'] = 'content' ;
		SM['counter-increment'] = 'counterIncrement' ;
		SM['counter-reset'] = 'counterReset' ;
		SM['cursor'] = 'cursor' ;
		SM['direction'] = 'direction' ;
		SM['display'] = 'display' ;
		SM['empty-cells'] = 'emptyCells' ;
		SM['flex'] = 'flex' ;
		SM['flex-basis'] = 'flexBasis' ;
		SM['flex-direction'] = 'flexDirection' ;
		SM['flex-flow'] = 'flexFlow' ;
		SM['flex-grow'] = 'flexGrow' ;
		SM['flex-shrink'] = 'flexShrink' ;
		SM['flex-wrap'] = 'flexWrap' ;
		SM['float'] = 'cssFloat' ;
		SM['font'] = 'font' ;
		SM['font-family'] = 'fontFamily' ;
		SM['font-size'] = 'fontSize' ;
		SM['font-style'] = 'fontStyle' ;
		SM['font-variant'] = 'fontVariant' ;
		SM['font-weight'] = 'fontWeight' ;
		SM['font-size-adjust'] = 'fontSizeAdjust' ;
		SM['font-stretch'] = 'fontStretch' ;
		SM['hanging-punctuation'] = 'hangingPunctuation' ;
		SM['height'] = 'height' ;
		SM['hyphens'] = 'hyphens' ;
		SM['icon'] = 'icon' ;
		SM['image-orientation'] = 'imageOrientation' ;
		SM['justify-content'] = 'justifyContent' ;
		SM['left'] = 'left' ;
		SM['line-height'] = 'lineHeight' ;
		SM['list-style'] = 'listStyle' ;
		SM['list-style-image'] = 'listStyleImage' ;
		SM['list-style-position'] = 'listStylePosition' ;
		SM['list-style-type'] = 'listStyleType' ;
		SM['margin'] = 'margin' ;
		SM['margin-bottom'] = 'marginBottom' ;
		SM['margin-left'] = 'marginLeft' ;
		SM['margin-right'] = 'marginRight' ;
		SM['margin-top'] = 'marginTop' ;
		SM['max-height'] = 'maxHeight' ;
		SM['max-width'] = 'maxWidth' ;
		SM['min-height'] = 'minHeight' ;
		SM['min-width'] = 'minWidth' ;
		SM['nav-down'] = 'navDown' ;
		SM['nav-index'] = 'navIndex' ;
		SM['nav-left'] = 'navLeft' ;
		SM['nav-right'] = 'navRight' ;
		SM['nav-up'] = 'navUp' ;
		SM['opacity'] = 'opacity' ;
		SM['order'] = 'order' ;
		SM['orphans'] = 'orphans' ;
		SM['outline'] = 'outline' ;
		SM['outline-color'] = 'outlineColor' ;
		SM['outline-offset'] = 'outlineOffset' ;
		SM['outline-style'] = 'outlineStyle' ;
		SM['outline-width'] = 'outlineWidth' ;
		SM['overflow'] = 'overflow' ;
		SM['overflow-x'] = 'overflowX' ;
		SM['overflow'] = 'overflow' ;
		SM['padding'] = 'padding' ;
		SM['padding-bottom'] = 'paddingBottom' ;
		SM['padding-left'] = 'paddingLeft' ;
		SM['padding-right'] = 'paddingRight' ;
		SM['padding-top'] = 'paddingTop' ;
		SM['page-break-after'] = 'pageBreakAfter' ;
		SM['page-break-before'] = 'pageBreakBefore' ;
		SM['page-break-inside'] = 'pageBreakInside' ;
		SM['perspective'] = 'perspective' ;
		SM['perspective-origin'] = 'perspectiveOrigin' ;
		SM['position'] = 'position' ;
		SM['quotes'] = 'quotes' ;
		SM['resize'] = 'resize' ;
		SM['right'] = 'right' ;
		SM['table-layout'] = 'tableLayout' ;
		SM['tab-size'] = 'tabSize' ;
		SM['text-align'] = 'textAlign' ;
		SM['text-align-last'] = 'textAlignLast' ;
		SM['text-decoration'] = 'textDecoration' ;
		SM['text-decoration-color'] = 'textDecorationColor' ;
		SM['text-decoration-line'] = 'textDecorationLine' ;
		SM['text-decoration-style'] = 'textDecorationStyle' ;
		SM['text-indent'] = 'textIndent' ;
		SM['text-justify'] = 'textJustify' ;
		SM['text-overflow'] = 'textOverflow' ;
		SM['text-shadow'] = 'textShadow' ;
		SM['text-transform'] = 'textTransform' ;
		SM['top'] = 'top' ;
		SM['transform'] = 'transform' ;
		SM['transform-origin'] = 'transformOrigin' ;
		SM['transform-style'] = 'transformStyle' ;
		SM['transition'] = 'transition' ;
		SM['transition-property'] = 'transitionProperty' ;
		SM['transition-duration'] = 'transitionDuration' ;
		SM['transition-timing-function'] = 'transitionTimingFunction' ;
		SM['transition-delay'] = 'transitionDelay' ;
		SM['unicode-bidi'] = 'unicodeBidi' ;
		SM['vertical-align'] = 'verticalAlign' ;
		SM['visibility'] = 'visibility' ;
		SM['white-space'] = 'whiteSpace' ;
		SM['width'] = 'width' ;
		SM['word-break'] = 'wordBreak' ;
		SM['word-spacing'] = 'wordSpacing' ;
		SM['word-wrap'] = 'wordWrap' ;
		SM['widows'] = 'widows' ;
		SM['z-index'] = 'zIndex' ;	
		
		return SM[sty];
	}
	
	WU.stop = function(){
		WU.setJQuery(WU.JQuery.stop());
		return WU;
	}
	
	WU.add = function(elem, context){
		if(!WU.isElement(context) && context != undefined){
			console.log("The context("+context+") of add is not an element")
		}
		if(elem== undefined){
			console.log("Nothing to add  ");
			return
		}
		
		WU.setJQuery(WU.JQuery.add(elem,context));
		return WU;
	}
	
	WU.isElement= function(elem){
		if(typeof elem== 'string') return false;
		return elem.toString().indexOf("HTML") > -1;
	}
	
	WU.isStyle = function(sty){
		return (WU.stylePpt(sty)!= null);
	}

	WU.isStyleList = function (stylist){
		
		for(sty in stylist){
			if(!WU.isStyle(sty)) return false;
		}
		return true;
	 }
	

	if(!WU.objExists(obj)){
		console.log(obj+" does not exist");
	}

	
	var rrr = jQuery(obj);
	WU.setJQuery(rrr);
	return WU;	
}




	var WebUtils =  function (obj){
		
		this.fn = new	WebUtils6(obj);
			
	    return this.fn;
	}
	
	
	WebUtils.ajax = function(JsonObject){
		
		if(JsonObject.url == null ||
		typeof JsonObject.url != 'string'
		){
			console.log("bad url "+ url);
		}
		
		if( 
			JsonObject.success != null &&
			typeof JsonObject.success != 'function' 
		){
			console.error(success +" is not a function !!!");
			return ;
		}
	
		if( 
			JsonObject.error != null &&
			typeof JsonObject.error  != 'function' 
		){
			console.error(error +" is not a function !!!");
			return ;
		}		
		
		if(JsonObject.error == null){
			JsonObject.error = function(a,b,c){
				console.log("ajax error: "+b.toString()+"\n " +c.toString());
			}
		}
		
		if(JsonObject.success == null){
			JsonObject.success = function(c){
				console.log("ajax success: "+a);
			}
		}

		jQuery.ajax(JsonObject);
		
	}

$.noConflict();	
//$ = jQuery;
$ = WebUtils;
