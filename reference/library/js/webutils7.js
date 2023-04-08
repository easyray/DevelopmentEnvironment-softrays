
function WebUtils7(obj){
	
	var WU = this;
	
	WU.objExists =function(obj){
		var exists = this.jQResult.find(obj).get(0);
		return ( exists !== undefined);
	};


	
	WU.attr = function(first, second){
		var ret = 0;
		
		if(typeof first=="string" && typeof second=="string"){
			ret =  this.jQResult.attr(first,second);
		}else if(typeof first=="string" && second === undefined){
			ret =  this.jQResult.attr(first);
		}else if(typeof first=="string" && typeof second=="function"){
			ret =  this.jQResult.attr(first,second);
		}else if(typeof first=="object" && second === undefined){
			ret =  this.jQResult.attr(first);
		}else {
		
			console.log("The parameters for attr are wrong!!!");
			return 0;
		}

		
		return ret;
	};
	
	WU.find = function(obj){
		
		
		if(!this.objExists(obj)){
		console.log(obj+" not found!!!");
		}
		
		var x = this.jQResult.find(obj);
		return createJQResult(x);
		
	};

	

	WU.children = function(obj){
		
		var x = this.jQResult.children(obj);

		if(x.length === 0){
			console.log(""+this+" Children "+obj+" do not exist");
		}
		return createJQResult( x );
	};


	WU.next = function () {
		return createJQResult( this.jQResult.next() );
		
	};

	WU.nextAll = function () {
		return createJQResult( this.jQResult.nextAll() );
	};

	WU.prev = function () {
		return createJQResult( this.jQResult.prev());
	};

	WU.prevAll = function () {
		return createJQResult( this.jQResult.prevAll());
	};

	WU.siblings = function(obj){
		
		
		var x = this.jQResult.siblings(obj);
		return createJQResult(x);
		
	};
	
	WU.nextUntil = function(obj){
		
		var x = this.jQResult.nextUntil(obj);
		return createJQResult(x) ;
	};

	WU.serializeArray = function(obj){
		
		if( jQuery(obj).length === 0 ){
			console.log(obj +" does not exist, cannot serializeArray!!");
		} 
		
		var x = this.jQResult.serializeArray(obj);
		return createJQResult( x );
	};	
	
	WU.prevUntil = function(obj){
		var x = this.jQResult.prevUntil(obj);
		return createJQResult(x) ;
	};	

	WU.get = function(obj){

		return this.jQResult.get(obj);
	};
	

	WU.bind = function(item,dat,fun){
		
		var ret;
		

		if(!WU.isAnEvent(item)){ console.log(item +" is not an event!!"); }
		if(typeof dat != 'function' &&
		   typeof dat != 'object'){
			console.log(dat +" is of wrong type");
		}
		
		if(typeof dat == 'object'){
			if(typeof fun == 'function'){
				ret = this.jQResult.bind(item,dat,fun);
				return createJQResult(ret);			
			}else{
				console.log(fun +" is not a function");
			}
		}else if(typeof dat == 'function'){
			ret = this.jQResult.bind(item,dat);
			return createJQResult(ret) ;
		}else{
			console.log(dat +" is not a function");
		}
	};

	
	WU.on = function(ev,chld,dat,fun){
	
		var ret;
		
		if(!WU.isAnEvent(ev)){ console.log(ev+" is not an event"); }

		if(typeof chld == 'string'){
			if(typeof dat == 'object'){
				if(typeof(fun) == "function"){
					ret = this.jQResult.on(ev,chld,dat,fun);
				}
			}
		}else if(typeof chld == 'object'){
			if( typeof dat== "function"){
				ret  = this.jQResult.on(ev,chld,dat);
			}else{
				console.log(dat+" is not a function");
			}
		}else if( typeof chld== "function"){
			ret  = this.jQResult.on(ev,chld,dat);
		}else{
			console.log(chld+" is not a function");
		}
		
		return createJQResult( ret ) ;
	};
	
	WU.ready = function(fun){
		
		if(typeof(fun) !='function'){
			console.log(fun+" is not a function!!");
		}
		return createJQResult(this.jQResult.ready(fun) );
	};
	
	
	
	
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
		
	};
	
	WU.unbind = function (evt,fun){
		var ret;
		if(
			evt !== undefined &&
			!WU.isAnEvent(evt)
		){
			console.log(evt +" is not an event!!");
		}
		
		if(
			fun !== undefined &&
			typeof fun !='function'
		){
			console.log(fun + " is not a function");
		}
		
		if(evt !== undefined && fun !== undefined ){
			ret = this.jQResult.unbind(evt, fun);
		}else if(evt !== undefined){
			ret = this.jQResult.unbind(evt);
		}else{
			ret = this.jQResult.unbind();
		}

		return createJQResult(ret);
	};
	
	WU.off = function(evt,selector) {
		var ret;
		if(	evt === undefined || 	WU.isAnEvent(evt)){
			console.log(evt +" is not an event!!");
			return;
		}
		
		if(selector===undefined){
			ret = WU.off(evt);
		}else{
			ret = WU.off(evt,selector);
		}
		return createJQResult(ret) ;
	};
	
	WU.css = function(styl,val){
		if(!WU.isStyle(styl) && typeof styl !="object"){
			console.log(styl + " is not a style or style list");
		}

		if( typeof styl== "object"){
			for(var styles in styl){
				if(!WU.isStyle(styles)){
					console.log(style +" is not a style "); 
				}
			}	
		}
		
		if(typeof styl == "string"){
			if(val === undefined){
				console.log("css value is missing!!!");
			}
		}
		
		return createJQResult(this.jQResult.css(styl,val));

	};
	
	WU.applyCss = function (stylelist) {
		
		var styles;
		if (typeof stylelist != 'object'){
			console.log("The style list "+ stylelist + " is of the wrong type ");
			return;
		}
		
		for(styles in stylelist){
			if(!WU.isStyle(styles)){console.log(style +" is not a style "); }
			this.jQResult.css(styles,stylelist[styles]);
		}	
	};
	
	WU.each = function(fun){

		var ret;
		if(typeof fun !='function'){ console.log(fun +" is not a function"); }
		
		this.jQResult.each(fun);
		
		return createJQResult(ret) ;
	
	};
	
//this is where we stopped	
	WU.html = function (htm){
		
		if(	this.jQResult.get(0).innerHTML === undefined){
			console.log(this.jQResult.get(0)+" the object you are trying to apply 'html(..)' to cannot have innerHTML");
		}
		if(this.jQResult.get(0)=== undefined ){
			console.log("You cannot set html for this object");
		}
		
		if(htm !== undefined){
			if(typeof htm != 'string'){
				console.log("You should supply a string for html function" );	
			}
			return (this.jQResult.html(htm));
		}
		return this.jQResult.html();
	
	};
	
	WU.text = function (htm){

		if(	this.jQResult.get(0).innerHTML === undefined){
			console.log(this.jQResult.get(0)+" the object you are trying to apply 'text(..)' to cannot have innerHTML");
		}
	
		if(	this.jQResult.get(0)=== undefined ){
			console.log("You cannot set text for this object");
		}	
		
		if(htm !== undefined){
			if(typeof htm != 'string'){
				console.log("You should supply a string for text function" );	
			}
			return (this.jQResult.text(htm));
		}
		return this.jQResult.text();
	
	};
	
	WU.val = function (htm){
	
		if(	this.jQResult.get(0) === undefined ){
			console.log("You cannot set text for this object");
		}
		
		if(	this.jQResult.get(0).value === undefined){
			console.log(this.jQResult.get(0)+" the object you are trying to apply 'val(..)' to does not a value attribute");
		}
		
		if(htm !== undefined){
			if(typeof htm != 'string'){
				console.log("You should supply a string for text function" );	
			}
			return (this.jQResult.val(htm));
		}
		return this.jQResult.val();
	
	};
	
	WU.width = function () {
		return createJQResult( this.jQResult.width());
		
	};

	WU.height = function () {
		return createJQResult( this.jQResult.height());
	};

	WU.innerWidth = function () {
		return createJQResult( this.jQResult.innerWidth());
		
	};

	WU.innerHeight = function () {
		return createJQResult( this.jQResult.innerHeight());
	};
	
	WU.before = function(content, fun){
		var ret;
		if(jQuery(content).length === 0){
			console.log(content +" does not exist!!!");
		}
		
		if((typeof content== 'string' ||typeof content== 'object') && fun === undefined){
			ret = createJQResult(this.jQResult.before(content));
		}else if((typeof content== 'string' ||typeof content== 'object') && typeof fun == "function"){
			ret = createJQResult(this.jQResult.before(content,fun));
		}else {
			console.log("JQuery before: problem with arguments");
			return 0;
		}
		
		return createJQResult(ret);
		
	};

	WU.after =function(content, fun){
		var ret;
		
		if(jQuery(content).length===0 ){
			console.log(content +" does not exist!!!");
		}
		
		if((typeof content== 'string' ||typeof content== 'object') && fun === undefined){
			ret = createJQResult(this.jQResult.after(content));
		}else if((typeof content== 'string' ||typeof content== 'object') && typeof fun == "function"){
			ret = createJQResult(this.jQResult.after(content,fun));
		}else {
			console.log("this.jQResult before: problem with arguments");
			return 0;
		}
		
		return createJQResult(ret);
		
	};	
	


	WU.append =function(content, fun){
		
		if((typeof content== 'string' ||typeof content== 'object') && fun === undefined){
			ret = createJQResult(this.jQResult.append(content));
		}else if((typeof content== 'string' ||typeof content== 'object') && typeof fun == "function"){
			ret = createJQResult(this.jQResult.append(content,fun));
		}else {
			console.log("this.jQResult before: problem with arguments");
			return 0;
		}
		
		return createJQResult(ret);
		
	};	


	WU.outerWidth = function () {
		return createJQResult( this.jQResult.outerWidth());
	};

	WU.outerHeight = function () {
		return createJQResult( this.jQResult.outerHeight());
	};
	
	
	WU.parent = function ()
	{
		return createJQResult( this.jQResult.parent());
	};
	
	WU.parents = function (elem){
		return createJQResult( this.jQResult.parents(elem));
	};
	
	
	WU.parentsUntil = function (elem){
		return createJQResult( this.jQResult.parentsUntil(elem));
	};	
	
	
	WU.first = function (){
		return createJQResult( this.jQResult.first());
	};
	
	WU.last = function (){
		return createJQResult( this.jQResult.last());
	};	
	
	WU.remove = function(){
		return createJQResult( this.jQResult.remove());
	};
	
	WU.empty = function(){
		return createJQResult( this.jQResult.empty());
	};


	WU.show = function (tim,ease,fun){
		var ret = this.retFromTimeEaseFunc(tim,ease,fun,'show');
		return createJQResult(ret) ;		
	};
	
	WU.hide = function (tim,ease,fun){
		var ret = this.retFromTimeEaseFunc(tim,ease,fun,'hide');
		return createJQResult(ret) ;
		
	};

	WU.animate = function(styles,tim,ease, fun){
		
		if(!WU.isStyleList(styles)){
			console.log("{style-params}, is compulsory for animate,please check the structure of the style-list");
			return 0;
		}
		var  ret = this.retFromTimeEaseFunc(tim,ease,fun,'animate');
		return createJQResult(ret);
	};

	WU.slideUp = function (tim,ease,fun){
		var ret = this.retFromTimeEaseFunc(tim,ease,fun,'slideUp');
		return createJQResult(ret) ;		
	};	
	
	WU.slideDown = function (tim,ease,fun){
		var ret = this.retFromTimeEaseFunc(tim,ease,fun,'slideDown');
		return createJQResult(ret) ;
		
	};	
	
	
	WU.slideToggle = function(tim,ease,fun){
		var ret = this.retFromTimeEaseFunc(tim,ease,fun,'slideToggle');
		return createJQResult(ret) ;	
	};
	
	WU.toggle = function(tim,ease,fun){
		var ret = this.retFromTimeEaseFunc(tim,ease,fun,'toggle');
		return createJQResult(ret) ;	
	};
	
	WU.fadeToggle = function(tim,ease, fun){
		var ret = this.retFromTimeEaseFunc(tim,ease,fun,'fadeToggle');
		return createJQResult(ret) ;	
	};
	
	WU.fadeIn = function(tim,ease, fun){
		var ret = this.retFromTimeEaseFunc(tim,ease,fun,'fadeIn');
		return createJQResult(ret) ;	
	};
	
	WU.fadeOut = function (tim, ease, fun){
		var ret = this.retFromTimeEaseFunc(tim,ease,fun,'fadeOut');
		return createJQResult(ret) ;	
	};


	WU.retFromTimeEaseFunc = function (tim,ease, fun,jqfn){
		var ret= 0;
		
		if(tim===undefined&& ease===undefined && fun===undefined )
			ret = this.jQResult[jqfn]();
		if(typeof tim== 'function'&& ease===undefined && fun=== undefined){
			ret = this.jQResult[jqfn](400,'linear',tim);
		}
		if((tim=="linear" || tim=="swing")&& ease===undefined && fun===undefined){
			ret = this.jQResult[jqfn](400,ease,function(){});
		}
		if((tim=="linear" || tim=="swing")&& typeof ease=='function' && fun===undefined){
			ret = this.jQResult[jqfn](tim,'linear',ease);
		}
		if((tim=="slow" || tim=="fast" || typeof tim =='number')&& 
		  ease===undefined && fun===undefined){
		  ret = this.jQResult[jqfn](tim,'linear',function(){});
		}
		if((tim=="slow" || tim=="fast" || typeof tim =='number')&&
		  typeof ease=='function' && fun===undefined){
			ret = this.jQResult[jqfn](tim,'linear',ease);
		}
		if((tim=="slow" || tim=="fast" || typeof tim =='number')&& 
		  (ease=="linear" || ease=="swing") && fun===undefined){
			ret = this.jQResult[jqfn](tim,ease,function(){});
		}
		if((tim=="slow" || tim=="fast" || typeof tim =='number')&& 
		  (ease=="linear" || tim=="swing") && typeof fun=='function') {
			ret = this.jQResult[jqfn](tim,ease,fun);
		}		

		if (ret === 0) console.log("Parameters for "+jqfn+" are wrong!!!");
		return ret;
	};
	

	
	WU.stylePpt = function(sty){
		var SM = {};
		
		SM['align-content'] = 'alignContent' ;
		SM['align-items'] = 'alignItems' ;
		SM['align-self'] = 'alignSelf' ;
		SM.animation = 'animation' ;
		SM['animation-play-state'] = 'animationPlayState' ;
		SM['animation-delay'] = 'animationDelay' ;
		SM['animation-direction'] = 'animationDirection' ;
		SM['animation-duration'] = 'animationDuration' ;
		SM['animation-fill-mode'] = 'animationFillMode' ;
		SM['animation-iteration-count'] = 'animationIterationCount' ;
		SM['animation-name'] = 'animationName' ;
		SM['animation-timing-function'] = 'animationTimingFunction' ;
		SM['animation-play-state'] = 'animationPlayState' ;
		SM.background = 'background' ;
		SM['background-attachment'] = 'backgroundAttachment' ;
		SM['background-color'] = 'backgroundColor' ;
		SM['background-image'] = 'backgroundImage' ;
		SM['background-position'] = 'backgroundPosition' ;
		SM['background-repeat'] = 'backgroundRepeat' ;
		SM['background-clip'] = 'backgroundClip' ;
		SM['background-origin'] = 'backgroundOrigin' ;
		SM['background-size'] = 'backgroundSize' ;
		SM['backface-visibility'] = 'backfaceVisibility' ;
		SM.border = 'border' ;
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
		SM.bottom = 'bottom' ;
		SM['box-decoration-break'] = 'boxDecorationBreak' ;
		SM['box-shadow'] = 'boxShadow' ;
		SM['box-sizing'] = 'boxSizing' ;
		SM['caption-side'] = 'captionSide' ;
		SM.clear = 'clear' ;
		SM.clip = 'clip' ;
		SM.color = 'color' ;
		SM['column-count'] = 'columnCount' ;
		SM['column-fill'] = 'columnFill' ;
		SM['column-gap'] = 'columnGap' ;
		SM['column-rule'] = 'columnRule' ;
		SM['column-rule-color'] = 'columnRuleColor' ;
		SM['column-rule-style'] = 'columnRuleStyle' ;
		SM['column-rule-width'] = 'columnRuleWidth' ;
		SM.columns = 'columns' ;
		SM['column-count'] = 'columnCount' ;
		SM['column-span'] = 'columnSpan' ;
		SM['column-width'] = 'columnWidth' ;
		SM.content = 'content' ;
		SM['counter-increment'] = 'counterIncrement' ;
		SM['counter-reset'] = 'counterReset' ;
		SM.cursor = 'cursor' ;
		SM.direction = 'direction' ;
		SM.display = 'display' ;
		SM['empty-cells'] = 'emptyCells' ;
		SM.flex = 'flex' ;
		SM['flex-basis'] = 'flexBasis' ;
		SM['flex-direction'] = 'flexDirection' ;
		SM['flex-flow'] = 'flexFlow' ;
		SM['flex-grow'] = 'flexGrow' ;
		SM['flex-shrink'] = 'flexShrink' ;
		SM['flex-wrap'] = 'flexWrap' ;
		SM.float = 'cssFloat' ;
		SM.font = 'font' ;
		SM['font-family'] = 'fontFamily' ;
		SM['font-size'] = 'fontSize' ;
		SM['font-style'] = 'fontStyle' ;
		SM['font-variant'] = 'fontVariant' ;
		SM['font-weight'] = 'fontWeight' ;
		SM['font-size-adjust'] = 'fontSizeAdjust' ;
		SM['font-stretch'] = 'fontStretch' ;
		SM['hanging-punctuation'] = 'hangingPunctuation' ;
		SM.height = 'height' ;
		SM.hyphens = 'hyphens' ;
		SM.icon = 'icon' ;
		SM['image-orientation'] = 'imageOrientation' ;
		SM['justify-content'] = 'justifyContent' ;
		SM.left = 'left' ;
		SM['line-height'] = 'lineHeight' ;
		SM['list-style'] = 'listStyle' ;
		SM['list-style-image'] = 'listStyleImage' ;
		SM['list-style-position'] = 'listStylePosition' ;
		SM['list-style-type'] = 'listStyleType' ;
		SM.margin = 'margin' ;
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
		SM.opacity = 'opacity' ;
		SM.order = 'order' ;
		SM.orphans = 'orphans' ;
		SM.outline = 'outline' ;
		SM['outline-color'] = 'outlineColor' ;
		SM['outline-offset'] = 'outlineOffset' ;
		SM['outline-style'] = 'outlineStyle' ;
		SM['outline-width'] = 'outlineWidth' ;
		SM.overflow = 'overflow' ;
		SM['overflow-x'] = 'overflowX' ;
		SM.overflow = 'overflow' ;
		SM.padding = 'padding' ;
		SM['padding-bottom'] = 'paddingBottom' ;
		SM['padding-left'] = 'paddingLeft' ;
		SM['padding-right'] = 'paddingRight' ;
		SM['padding-top'] = 'paddingTop' ;
		SM['page-break-after'] = 'pageBreakAfter' ;
		SM['page-break-before'] = 'pageBreakBefore' ;
		SM['page-break-inside'] = 'pageBreakInside' ;
		SM.perspective = 'perspective' ;
		SM['perspective-origin'] = 'perspectiveOrigin' ;
		SM.position = 'position' ;
		SM.quotes = 'quotes' ;
		SM.resize = 'resize' ;
		SM.right = 'right' ;
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
		SM.top = 'top' ;
		SM.transform = 'transform' ;
		SM['transform-origin'] = 'transformOrigin' ;
		SM['transform-style'] = 'transformStyle' ;
		SM.transition = 'transition' ;
		SM['transition-property'] = 'transitionProperty' ;
		SM['transition-duration'] = 'transitionDuration' ;
		SM['transition-timing-function'] = 'transitionTimingFunction' ;
		SM['transition-delay'] = 'transitionDelay' ;
		SM['unicode-bidi'] = 'unicodeBidi' ;
		SM['vertical-align'] = 'verticalAlign' ;
		SM.visibility = 'visibility' ;
		SM['white-space'] = 'whiteSpace' ;
		SM.width = 'width' ;
		SM['word-break'] = 'wordBreak' ;
		SM['word-spacing'] = 'wordSpacing' ;
		SM['word-wrap'] = 'wordWrap' ;
		SM.widows = 'widows' ;
		SM['z-index'] = 'zIndex' ;	
		
		return SM[sty];
	};
	
	WU.stop = function(){
		return createJQResult(this.jQResult.stop());
	};
	
	WU.add = function(elem, context){
		if(!WU.isElement(context) && context !== undefined){
			console.log("The context("+context+") of add is not an element");
		}

		if(elem=== undefined){
			console.log("Nothing to add  ");
			return;
		}
		
		return createJQResult(this.jQResult.add(elem,context));
	};
	
	WU.isElement= function(elem){
		if(typeof elem== 'string') return false;
		return elem.toString().indexOf("HTML") > -1;
	};
	
	WU.isStyle = function(sty){
		return (WU.stylePpt(sty)!== undefined);
	};

	WU.isStyleList = function (stylist){
		
		for(var sty in stylist){
			if(!WU.isStyle(sty)) return false;
		}
		return true;
	 };
	
}


createJQResult = function(jq){
	var ret = [], len = jq.length,c;

	for(c=0; c<len; c++){
		ret[c] = jq[c];
		}

	ret.__proto__ = new WebUtils7();

	ret.jQResult = jq;

	return ret;
};



jQFunction = function(obj){
	var res1= jQuery(obj);
	//console.log(obj+" "+res1);
	if(res1.length==0){
		console.log(obj+" does not exist");
	}


	var res = createJQResult(res1);
	return res;
};
	

jQFunction.ajax = function(JsonObject){
	
	if(JsonObject.url === undefined ||
	typeof JsonObject.url != 'string'
	){
		console.log("bad url "+ url);
	}
	
	if( 
		JsonObject.success !== undefined &&
		typeof JsonObject.success != 'function' 
	){
		console.error(success +" is not a function !!!");
		return ;
	}

	if( 
		JsonObject.error !== undefined &&
		typeof JsonObject.error  != 'function' 
	){
		console.error(JsonObject.error +" is not a function !!!");
		return ;
	}		
	
	if(JsonObject.error === undefined){
		JsonObject.error = function(a,b,c){
			console.log("ajax error: "+b.toString()+"\n " +c.toString());
		};
	}
	
	if(JsonObject.success === undefined){
		JsonObject.success = function(c){
			console.log("ajax success: "+a);
		};
	}

	return jQuery.ajax(JsonObject);
	
};

$.noConflict();	
$ = jQFunction;
