function ListView(JsonObject){
	var LV = this;
	
	if(         JsonObject.adapterfunction != null &&
	    typeof  JsonObject.adapterfunction != "function"
	){
		console.log('adapterfunction is not a function');
		return 0;
	}
	
	if( typeof JsonObject.onItemSelected != "function" ){
		console.log("You have not set onItemSelected function");
		return 0;
	}
	
	if(!LV.isArray(JsonObject.data)){
		console.log('You need to set data array');
		return 0;
	}
	
	this.record  = [];
	this.counter = 0;
	
	this.getView = function(div, index, id){
		div.id = id;
		div.innerHTML = JsonObject.data[index][id];
		if(index%2==0){
			LV.applyCss(div,{
				'backgroundColor':'#aaa',
				'borderBottom': 'thin solid #555'
			});
			LV.addEvent(div,'mouseover',
				function(){
					LV.applyCss(div,
					{'backgroundColor':'#faa'}
					);
				}
			);
			LV.addEvent(div,'mouseout',
				function(){
					LV.applyCss(div,
					{'backgroundColor':'#aaa'}
					)
				}
			);			
		}else{
			LV.applyCss(div,{
				'backgroundColor':'#ccc',
				'borderBottom': 'thin solid #555'
			});		
			LV.addEvent(div,'mouseover',
				function(){
					LV.applyCss(div,
					{'backgroundColor':'#fcc'}
					);
				}
			);
			LV.addEvent(div,'mouseout',
				function(){
					LV.applyCss(div,
					{'backgroundColor':'#ccc'}
					)
				}
			);			
			
		}
		return div;
	}
	
	this.isArray = function (myArray) {
    return myArray.constructor.toString().indexOf("Array") > -1;
	}
	
	this.addEvent = function(x,evt,myFunction){		

		if (x.addEventListener) {                    // For all major browsers, except IE 8 and earlier
			x.addEventListener(evt, myFunction);
		} else if (x.attachEvent) {                  // For IE 8 and earlier versions
			x.attachEvent("on"+evt, myFunction);
		}		
	}
	
	this.applyCss = function (elem,cssList){
		for(i in elem){ 
			elem.style[i] = cssList[i];
		}			
	}
	
	
	this.getRecIndex = function(id){
		var i 
		for(i = 0 ; i< LV.record.length; i++){
			if(LV.record[i]== id ) return i;
		}	
		return -1;
	}
	
	if(JsonObject.adapterfunction == null){ JsonObject.adapterfunction = LV.getView; }
	
	var len = JsonObject.data.length,i,j;
	var div0,div1,div2, id;
	
	div0 = document.createElement("DIV");
	
	for(i=0; i< len; i++){
		div1 = document.createElement("DIV");
		for(j in JsonObject.data[i]){
			id = j;
			break;
		}
		
		div2 = JsonObject.adapterfunction(div1, i, id);
		
		LV.record[i] = id;
		LV.addEvent(
			div2, 
			'click', 
			function(){ 
				var index =  LV.getRecIndex(this.getAttribute('id'));
				var id    =  LV.record[index];
				JsonObject.onItemSelected(this,index,id) ;
			}
		);
		
		div0.appendChild(div2);
	}
	
	
	this.lstv = div0;
	
	this.getListView = function(){
		return this.lstv;
	}

	
}