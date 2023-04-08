tabs = function(container,listofelems,styles){
	
	var tb = this;
	this.elems = []; 
	this.Counter = 0;
	this.labels = [];
	this.container = container;
	if(styles !== null){
		this.styles = styles;
	}else{
		this.styles = {};
	}
	
	if(listofelems !== null && typeof listofelems == "object"){
		for(var j in listofelems){
			tb.elems[tb.Counter]    = listofelems[j];
			tb.labels[tb.Counter++] = j;
		}
	}//end if
	
	tb.addElem = function (elem, label){
		tb.elems [tb.Counter]    = elem;
		tb.labels[tb.Counter++]  = label;
	};
	
	tb.addStyles = function(styles){
		tb.styles = styles;
	};
	
	tb.applyStyles = function (){
		var len = tb.elems.length;
		var dv;
		tb.container.innerHTML = "";
		
		for(var i =0; i<len; i++){
			dv = document.createElement("DIV");
			dv.innerHTML  = tb.labels[i];
			for(var j in  tb.styles){
				dv.style[j] =  tb.styles[j];
			}
			tb.addEvent(dv);
			tb.container.appendChild(dv);
		}
		
	};
	
	tb.addEvent = function(elem){
		if (window.addEventListener){
			elem.addEventListener("click", tb.flipOver, false);
		} else if (w.attachEvent){
			var f = function(){
				tb.flipOver.call(elem, window.event);
			};			
			el.attachEvent('onclick', f);
		}
	};
	
	tb.flipOver = function(e, evt){
		//console.log(e);
		elem = this;//e.srcElement;
		var len = tb.elems.length;
		for(var i =0 ; i<len; i++){
			tb.elems[i].style.display = "none";
			if(elem.innerHTML == tb.labels[i])tb.elems[i].style.display = "block";
		}
		//elem.style.display = "block";
	};
	
	tb.show = function(){
		tb.applyStyles();
		tb.container.style.display = "block";
	};
};