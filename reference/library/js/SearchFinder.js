function Content_Finder(JsonObj){
	var JsonObj_, This;
	
	JsonObj_ = JsonObj;
	This     = this;
	
	var DurationCompleted = true, 
		ContentChanged    = false, 
		ContenArrived     = true,
		SearchBox;

	function init(){

		$(JsonObj_.searchbox).bind("keyup",This.searchChanged);
	}
	
	this.searchChanged = function(){
		
		ContentChanged = true;
		SearchBox      = this;

		if(	DurationCompleted &&
			ContenArrived){

			This.reFetch();
		}
	};

	this.reFetch = function(){
		DurationCompleted = false;
		ContenArrived     = false;
		ContentChanged    = false;
		window.setTimeout(This.timeElapsed, 2000);
		This. findContent();
	};

	this.timeElapsed = 	function(){ 
		
		DurationCompleted= true;

		if(ContenArrived &&
			ContentChanged){
			This.reFetch();
		}
	};

	this.findContent = function (){
		//console.log("Started message fetch")
		var dat = {
			code: $(JsonObj_.searchbox).val(),
			"param": $(SearchBox).attr('name')
		};

		jQuery.ajax({
			data:dat,
			url:JsonObj_.Url,
			type:"post",
			success: This.ContentFound
		});
	};

	this.ContentFound = function (dat){
		
		//dat = evaluate(dat);
		var len,str ="";
		ContenArrived = true;
		
		JsonObj_.callBack(dat);
		
		if(DurationCompleted && ContentChanged){
			This.reFetch();
		}
	};


	init();
}
 