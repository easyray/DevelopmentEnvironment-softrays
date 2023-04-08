/*
	function pause(){}
	function resume(){}
	function JsonObj($beforeSend,$Url, $callBack){}
*/
function ChatFinder(JsonObj){
	var JsonObj_, This;
	
	JsonObj_ = JsonObj;
	This     = this;
	This.paused = true;
		
	var DurationCompleted=true, 
		//ContentChanged= false, 
		ContenArrived= true;

	var  init = function(){
		This.findContent();
	}
	
	this.pause = function(){
		This.paused = true;
	}
	this.resume= function(){
		This.paused = false;
		This.reFetch();
	}
	this.reFetch = function(){
		DurationCompleted = false;
		ContenArrived     = false;
		window.setTimeout(This.timeElapsed, 5000);
		This. findContent();
	};

	this.timeElapsed = 	function(){ 
		if(ContenArrived ){
			This.reFetch();
		}else{
			DurationCompleted= true; 
		}
	}

	this.findContent = function (){
		//console.log("Started message fetch")
		if(This.paused){
			return
		}
		
		var dat = JsonObj_.beforeSend();
		//console.log(JSON.stringify(dat));
		jQuery.ajax({
			data: dat,
			url:JsonObj_.Url,
			type:"post",
			success: This.ContentFound
		});
	};

	this.ContentFound = function (dat){
		
		//dat = evaluate(dat);
		var len,str ="";

		JsonObj_.callBack(dat);
		
		if(DurationCompleted ){
			This.reFetch();
		}else{
			ContenArrived = true;
		}
	};

	init();
}
