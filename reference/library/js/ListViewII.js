function ListView(JsonObject){
	var LV = this;
	
	
	LV.init = function (JsonObject){
		if(         
					JsonObject.adapter         != null       &&
			typeof  JsonObject.adapter.getView != "function"
		){
			console.log('adapter getView is not a function');
			return 0;
		}
		
		if(!LV.isArray(JsonObject.data)){
			console.log('You need to set data array');
			return 0;
		}

		if( 
			JsonObject.adapter          != null &&
			JsonObject.adapter.Data == null
		){
			console.log("The adapter does not have Data attribute");
			return 0;
		}else if(JsonObject.adapter != null){
			JsonObject.adapter.Data = JsonObject.data;
		}/* */
		
		if( typeof JsonObject.onItemSelected != "function" ){
			console.log("You have not set onItemSelected function");
			return 0;
		}
		

		
		this.record  = [];
		this.counter = 0;
		
		this.Data = JsonObject.data;

		var AdapterFunction = "";
		
		if(JsonObject.adapter == null){
			AdapterFunction = LV.getView;
		}else{
			AdapterFunction = JsonObject.adapter.getView;
		}
		
		
		var len = JsonObject.data.length,i,j;
		var div0,div1,div2, id;
		
		div0 = document.createElement("DIV");
		
		for(i=0; i< len; i++){ // Loop throught array
			div1 = document.createElement("DIV");
			for(j in JsonObject.data[i]){
				// Fetch id of current object in array
				id = j; break;
			}

			div2 = AdapterFunction(div1, i, id);

			LV.addEvent(div2,'click', LV.itemListClicked);
			div0.appendChild(div2);
			
			LV.record[i] = id;
		}// end loop through array
		
		LV.lstv = div0;
	}

	
	LV.getView = function(div, index, id){
		div.id = id;
		div.innerHTML = JsonObject.data[index][id];
		if(index%2==0){
			LV.applyCss(div,{
				'backgroundColor':'#aaa',
				'borderBottom': 'thin solid #555'
			});
			LV.addEvent(div,'mouseover', LV.itemMouseOver1);
			LV.addEvent(div,'mouseout', LV.itemMouseOut1); 
		}else{
			LV.applyCss(div,{
				'backgroundColor':'#ccc',
				'borderBottom': 'thin solid #555'
			});		
			LV.addEvent(div,'mouseover', LV.itemMouseOver2);
			LV.addEvent(div,'mouseout',  LV.itemMouseOut2 );
		}
		return div;
	}
	
	LV.itemListClicked = function(){ 
		var index =  LV.getRecIndex(this.getAttribute('id'));
		var id    =  LV.record[index];
		JsonObject.onItemSelected(this,index,id) ;
	}
	
	LV.itemMouseOver1 = function(){
		var div = this;
		LV.applyCss(div,
		{'backgroundColor':'#faa'}
		);
	}

	LV.itemMouseOut1 = function(){
		var div = this;
		LV.applyCss(div,
		{'backgroundColor':'#aaa'}
		)
	}

	LV.itemMouseOver2 = function(){
		var div = this;
		LV.applyCss(div,
		{'backgroundColor':'#fcc'}
		);
		
	}
	
	LV.itemMouseOut2 = function(){
		var div = this;
		LV.applyCss(div,
		{'backgroundColor':'#ccc'}
		)
		
	}
	
	LV.getRecIndex = function(id){
		var i 
		for(i = 0 ; i< LV.record.length; i++){
			if(LV.record[i]== id ) return i;
		}	
		return -1;
	}	

	LV.getListView = function(){
		return this.lstv;
	}
	
	LV.isArray = function (myArray) {
		return myArray.constructor.toString().indexOf("Array") > -1;
	}
	
	LV.addEvent = function(x,evt,myFunction){		

		if (x.addEventListener) {                    // For all major browsers, except IE 8 and earlier
			x.addEventListener(evt, myFunction);
		} else if (x.attachEvent) {                  // For IE 8 and earlier versions
			x.attachEvent("on"+evt, myFunction);
		}		
	}
	
	LV.applyCss = function (elem,cssList){
		for(i in cssList){ 
			elem.style[i] = cssList[i];
		}			
	}



	LV.init(JsonObject);
}