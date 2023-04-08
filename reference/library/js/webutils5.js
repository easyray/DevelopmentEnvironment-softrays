
function WU5(){
	var WU = this;
	/*
		FormSubmission
		helps to set u a form for submission 

		We need to supply:
	/*
		FormSubmission
		helps to set u a form for submission 

		We need to supply:
		
		FormId         : #<The id of the form>
		ButtonId       : #<The id of the button to submit>
		successFunction: The function to call on succes
		
		**************************
		Set as attributes of a json object
	*********************************************************/

	this.formSubmission = function (JsonInput)
	{	
		if(JsonInput.FormId    == null || !WU.elementExists(JsonInput.FormId) ) { console.log("Form does not exist"); return }
		if(JsonInput.ButtonId  == null || !WU.elementExists(JsonInput.ButtonId)){ console.log('No submit button'); return ; }
		if(
				   JsonInput.successFunction == null      ||
			typeof JsonInput.successFunction != "function" 
		)
		{ console.log('There is no callback function'); return ; }

		var DataToSend = WU.serializeForm(JsonInput.FormId);
		if(DataToSend=="" || DataToSend == null)
		{
			console.log("Invalid Form");
			return 0;
		}
		
		var TheForm    = WU.getElement(JsonInput.FormId); 
		var JsonAction =  TheForm.action;
		var JsonMethod =  TheForm.method;

		
		WU.addEvent(JsonInput.ButtonId, "click",
			function ()
			{
				DataToSend = WU.serializeForm(JsonInput.FormId);

				WU.ajax({
					data: DataToSend,
					url: JsonAction,
					//dataType: "text",
					method: JsonMethod,
					success: function(dat)
					{
						JsonInput.successFunction(dat);
					},
					error: function(a)
					{
						alert("Error: " + a);
					}	
				});	
			}
		);
		
	}


	/*
		Work like the form submission wiwth the exception that
		it does not require a button to be clicked to fetch data
		
	/**/
	this.formSubmissionDirect = function (JsonInput)
	{	
		if(JsonInput.FormId    == null || !WU.elementExists(JsonInput.FormId) ) { console.log("Form does not exist"); return }
		if(
				   JsonInput.successFunction == null      ||
			typeof JsonInput.successFunction != "function" 
		)
		{ console.log('There is no callback function'); return ; }

		var DataToSend = WU.serializeForm(JsonInput.FormId);

		if(DataToSend=="" || DataToSend == null)
		{
			console.log("Invalid Form");
			return 0;
		}
		
		var TheForm    = WU.getElement(JsonInput.FormId); 
		var JsonAction =  TheForm.action;
		var JsonMethod =  TheForm.method;

		WU.ajax({
			data: DataToSend,
			url: JsonAction,
			//dataType: "text",
			method: JsonMethod,
			success: function(dat)
			{
				JsonInput.successFunction(dat);
			},
			error: function(a)
			{
				alert("Error: " + a);
			}	
		});	
		
		
	}

	/*
		fetches data using ajax
		datasource:     name of the server page to supply data	
		successFunction: function to call on success
	*/
	this.fetchdata=  function (JsonInput)
	{

		if(JsonInput.datasource       ==  null) { alert("you need to supply server page"); return; }		
		if(JsonInput.successFunction  ==  null) { alert('There is no callback function'); return ; }

		var JsonMethod =  "post";

		
			
			//DataToSend = $(JsonInput.FormId).serialize();
			
			WU.ajax({
				data: "",
				url: JsonInput.datasource,
				method: JsonMethod,
				success: function(dat)
				{
					JsonInput.successFunction(dat);
				},
				error: function(a)
				{
					alert("Error: " +a) ;
				}	
			});	
			
		
	}

	/*
		works like fetchdata
		accepts :data
	/**/

	this.fetchdata2 = function (JsonInput)
	{

		if(JsonInput.datasource       ==  null) { alert("you need to supply server page"); return; }		
		if(JsonInput.successFunction  ==  null) { alert('There is no callback function'); return ; }
		if(JsonInput.data             ==  null) { alert('You need to supply data'); return ; }

		var JsonMethod =  "post";

		

			DataToSend = JsonInput.data;
			
			WU.ajax({
				data: DataToSend,
				url: JsonInput.datasource,
				method: JsonMethod,
				success: function(dat)
				{
					JsonInput.successFunction(dat);
				},
				error: function(a)
				{
					alert("Error: " +a) ;
				}	
			});	
			
		
	}




	this.getValue = function (Nstart,Nend)
	{
		var valu;
		valu  = Math.floor(Math.random()*10000);
		valu %= ((Nend-Nstart)*100);

		return Nstart+ valu/100;
		/**/
	}

	this.trim = function (str)
	{
		var c, len, str2= " ";
		var index1, index2, code
		len = str.length;
		
		index1 = 0;
		for(c=0 ; c< len; c++)
		{
			code = str.charCodeAt(c);
			if(code== 32 ||code==9||code== 13||code== 10) index1++;
			else break;
		}
		
		index2 = len;	
		for(c=len-1 ; c>index1 ; c--)
		{
			code = str.charCodeAt(c);
			if(code== 32 ||code==9||code== 13||code== 10) index2--;
			else break;
		}
		
		str2 = str.substring(index1,index2);
		str  =  str2;
		
		return str;
	}

	/*********/


		/*
		Change the value of a select to a predetermined value
		supply the selector for the select object, and the value to set it to
	*/

		this.setSelectOption = function (SelectObject, Value)
		{
			var TheObject 	;
			//alert(SelectObject+", "+ Value);
			TheObject = (SelectObject).get(0);
			//$(SelectObject).each( 	function(){ TheObject = this; 	} );
			
			var OptLength =  TheObject.options.length;
			var count;
			
			
			for(count=0; count< OptLength; count++)
			{
				if(TheObject[count].value == Value ) break;
			}
			
			if(count < OptLength) TheObject.selectedIndex	 = count ;
			
		}



	/*
		create a String formated select-option from a 2d Array
		
		supply JSON containing:

		name :   name of the select
		id:      id of the select
		Array2D: The 2d  array. key as value value as text
		

	*/


	this.createSelectOption = function  (JsonObject)
	{
		
		
		var Slect = "";

		Slect  += '<select name= "'+ JsonObject.name;
		Slect  += '" id = "'+ JsonObject.id;
		Slect  += '" >\n';
		
		
		
		for(key in JsonObject.Array2D)
		{
			Slect += '<option value="'+key;
			Slect += '" >'+JsonObject.Array2D[key];
			Slect += '</option> \n';
		}
		
		Slect += '</select>';
		
		return Slect;
		
	}


	this.inArray1D = function (needle, haystack)
	{
		var ret = false;
		var key;
		
		for(key in haystack){
			if(needle== haystack[key]){
				ret = true;
				break;
			}
		}
		return ret;
	}


	this.timestampToText = function (stamp)
	{
		var dat, tim, tmp,th,N;
		var relate = ['none','January','February','March','April','May','June','July','August','September', 'October','November','December'];
		//"2015-05-27 13:10:49"
		tmp = stamp.split(" ");
		
		dat = tmp[0].split('-');
		tim = tmp[1].split(':');
		console.log(tim[0]);
		ampm= (eval(tim[0])<12)? 'AM': 'PM' ;
		tim[0] =  (tim[0]%12)? tim[0]%12 :12;

		N   = eval(dat[2]);
		     if(N==3 || N==23) th= "rd ";
		else if(N==2 || N==22) th= "nd ";
		else if(N==1 || N==21) th= "st ";
		else                   th= "th ";
		//alert(eval(dat[2]))
		return N+th+" "+relate[eval(dat[1])]+
			   " "+dat[0] +
			   " ("+(tim[0])+":"+tim[1]+
			   ":"+tim[2]+" "+ampm+")";
	}

	this.ThreadJoiner = function (JsonObject)	{
		
		var This = this;
		this.ThreadCount = 0;
		this.successFunction = JsonObject.successFunction
		
		//-----Methods--------
		this.setCount = function(Count) {
			This.ThreadCount = Count;
		}
		
		this.addThread = function()
		{
			This.ThreadCount ++;
			//console.log("Webutils 734: new thread added now"+ This.ThreadCount );
		}
		
		this.join  =  function() {
			This.ThreadCount --;
			//console.log("Web util 739: Thread joined now "+This.ThreadCount+" Thread(s) remaining");
			if( This.ThreadCount <= 0) {
				//console.log("Thread finished Firing success function");
				This.successFunction();
			}
		}
	}

	this.ajax = function (JSONObject) {
		var xmlhttp, WUmethod;
		
		
		if(window.XMLHttpRequest) {
			xmlhttp = new XMLHttpRequest();
		}else {
			xmlhttp = ActiveXObject("Microsoft XMLHTTP");
		}
		
		
		xmlhttp.onreadystatechange= function(){
		
			if(xmlhttp.readyState ==4 && xmlhttp.status==200) {
				JSONObject.success(xmlhttp.responseText);
			}else if(xmlhttp.readyState ==4){
				JSONObject.error(xmlhttp.status);
			}
		}
		
		if(
			JSONObject.method.toUpperCase() == "GET" ||
			JSONObject.method == "" ||
			JSONObject.method == null 
		)
		{ WUmethod ="GET" } else { WUmethod = "POST" ; }
		
		var SerializedData = WU.serializeData(JSONObject.data);
		
		JSONObject.url = (WUmethod == "GET")?JSONObject.url+"?"+SerializedData: JSONObject.url;
		
		xmlhttp.open(WUmethod,JSONObject.url, true);
		
		if(WUmethod == "GET"){
			xmlhttp.send();
		}else{
			xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			xmlhttp.send(SerializedData);
		}
		
	}

	this.serializeData = function (elem) {
		var counter = 0,index,str="";

		function spaceToPlus(strin) {
			//console.log(strin);
			return strin.replace(/ /g,"+")
		}

		
		if(!elem.hasOwnProperty) return elem;
		
		for(index in elem){
			if(counter!=0  ){ str +="&"; };
			counter++;
			str += index+"=";
			str += spaceToPlus(elem[index]);
		}
		
		return str;
	}

	this.htmlentities = function (str) {
		
		str = str.replace(/&/g,"&amp;");
		str = str.replace(/</g,"&lt;");
		str = str.replace(/>/g,"&gt;");
		
		return str;
	}


	this.stringify = function (elem) {
		
		var counter = 0,index,str="";
		
		if(WU.isArray(elem)) return WU.stringifyArray(elem);
		
		str = "{";
		for(index in elem){
			if(counter!= 0  ){ str +=","; };
			counter++;
			
			str += '"'+index+'": ';
			if(WU.isArray(elem[index])) {
				str += stringifyArray(elem[index]);
			}else if(typeof elem[index] == "object") {
				str += stringify(elem[index]);
			}else if ( 
					  typeof elem[index] == "string" ||
					  typeof elem[index] == "number"
					  ){
				str +='"'+ elem[index]+'",\n'
			}
		}
		
		return str + "}";
	}

	this.stringifyArray = function (elem) {
		
		var counter = 0,index,str="";

		str = "[";
		for(index in elem){
			if(counter!= 0  ){ str +=","; };
			counter++;
			
			str += '"'+index+'": ';
			if(isArray(elem[index])) {
				str += stringifyArray(elem[index]);
			}else if(typeof elem[index] == "object") {
				str += stringify(elem[index]);
			}else if ( 
					  typeof elem[index] == "string" ||
					  typeof elem[index] == "number"
					  ){
				str +='"'+ elem[index]+'",\n'
			}
		}
		
		return str + "]";
	}	

	this.isArray = function (myArray) {
		return myArray.constructor.toString().indexOf("Array") > -1;
	}
	
	this.getExtension= function(str) {
		console.log(str);
		var index = str.lastIndexOf(".");
		
		if(index != -1){
			return str.substring(index+1).toLowerCase();
		}else{
			return '';
		}
	}

	this.JsonParse = function (stringyform) {
		return eval("("+stringyform+")");
	}

	this.serializeForm = function (formid) {
		
		
		if(
			formid  == null || 
			!WU.elementExists(formid) 
		) 
		{ console("Form does not exist cannot serialize"); return }	
		
		var formelements = WU.getElement(formid).elements;
		var len =0;
		
		var x,y;
		var obj ="{";
		var counter =0;
		
		len = formelements.length;
		for(index=0; index< len; index++) {
			x = formelements[index].name;
			y = formelements[index].value;
			if(counter ==0){
				obj += '"'+WU.stringEntities(x)+'" : "'+ WU.stringEntities(y)+'"';
			}else{
				obj += ', "'+WU.stringEntities(x)+'" : "'+ WU.stringEntities(y)+'"';
			}
			counter ++;
		}
		obj += "}";
		return eval("("+obj+")");
	}

	this.elementExists = function  (elem) {
		if(typeof elem == "object")        return true;
		if(document.getElementById(elem))  return true;
		if(document.getElementsByClassName(elem)[0]) return true;
		return false;
	}

	this.getElement = function (ElemOrId) {
		if(typeof ElemOrId == "string") return document.getElementById(ElemOrId);
		else return ElemOrId;
	}

	this.getElements_C = function (ElemOrId) {
		if(typeof ElemOrId == "string") return document.getElementsByClassName(ElemOrId);
		else return ElemOrId;
	}

	this.addEvent = function (el, evt, fun ) {

		var el= WU.getElement(el);
		if(typeof fun != 'function'){ console.log("function is not valid cannot attach event"+evt); return 0; }
		if(!WU.elementExists(el))      { console.log("Cannot attach event to this element" ); return 0; }
		if(!WU.isAnEvent(evt) )        { console.log(evt+" is not an event"); return 0; }

		if(el.addEventListener) { 
			el.addEventListener(evt,fun,false); 
		} else if(el.attachEvent) { 
			el.attachEvent('on'+evt,fun); 
		} else{ 
			el['on'+evt] = fun; 
		}
	}



	this.isAnEvent = function (evt) {
		if(
			evt == 'onmouseover' ||
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

	this.Stack = function () {
		//debug	/**/ alert("Line 163 (Cart constructor)");		/****/
		this.collect = [];
		this.counter = 0;

		this.addNew = function (newobject) {
			this.collect[this.counter] = newobject;
			this.counter = this.counter + 1;
		};

		this.vomit = function () {
			return WU.stringify(this.collect);
		};

		this.vomitRaw = function () {
			return this.collect;
		};
	}//~stack




	this.HoverPlugin = function (JsonObject) {
		var Object_Iq, HoverColor, NormalColor, ClickColor;
		
		HoverColor  = JsonObject.HoverColor;
		NormalColor = JsonObject.NormalColor
		ClickColor  = JsonObject.ClickColor;
		
		Object_Iq = $(JsonObject.Selector).get(0);
		
		$(Object_Iq).css("background-color", NormalColor);
		
		
		this.changeColorH = function () {

			$(Object_Iq).css("background-color", HoverColor);
		}

		this.changeColorN = function () {

			$(Object_Iq).css("background-color", NormalColor);
		}

		this.changeColorC = function () {

			$(Object_Iq).css("background-color", ClickColor);
		}
		
		WU.addEvent(Object_Iq, "mouseover" , this.changeColorH );
		WU.addEvent(Object_Iq, "mouseleave", this.changeColorN );
		WU.addEvent(Object_Iq, "mousedown" , this.changeColorH );
		WU.addEvent(Object_Iq, "mouseup"   , this.changeColorH );
	}

	this.ListBox = function (JsonObject) {
		var params, params2;
		var ThisWulist = this;
		
		this.isempty = function(obj){
			return (obj=="" || obj==null || obj == undefined);
		}
		
		if(this.isempty(JsonObject) ){ console.error("Parameter missing in instantiation WUListBox"); return 0; }

		params  = JsonObject;
		
		if(this.isempty(params.successFunction)){ console.error("WUListBox: Success function is missing "); return 0; }
		if(this.isempty(params.DataArray) )     { console.error("WUListBox: DataArray is missing"); return 0; }
		if(this.isempty(params.Key1) )          { console.error("WUListBox: Key1 is missing"); return 0; }
		
		if(this.isempty(params.Class1) )      { console.log("WUListBox: Class1 missing in JsonObject, assuming 'WUClass1' "); params.Class1 = 'WUClass1'; }
		if(this.isempty(params.Class2) )      { params.Class2 = params.Class1; }
		if(this.isempty(params.ClickColor) )  { console.log  ("WUListBox: ClickColor missing in JsonObject, assuming '#E77407' "); params.ClickColor = "#E77407"; }
		if(this.isempty(params.DstSelector) ) { console.log  ("WUListBox: DstSelector  is missing you cannot generate list");  }
		if(this.isempty(params.HoverColor) )  { console.log  ("WUListBox: Hover color is missing assuming '#FFD6AB'"); params.HoverColor = "#FFD6AB"; }
		if(this.isempty(params.Key2) )        { console.log  ("WUListBox: Key is missing assuming " + params.Key1 ); params.Key2 = params.Key1 ; }
		if(this.isempty(params.NormalColor) ) { console.log  ("WUListBox: NormalColor is missing assuming '#B7C3CD'"); params.NormalColor = "#B7C3CD"; }
		if(this.isempty(params.NormalColor2) ){ console.log  ("WUListBox: NormalColor2 is missing assuming '#C1CDD7'"); params.NormalColor2 = "#C1CDD7"; }
		if(this.isempty(params.width) )       { console.log  ("WUListBox: width is missing assuming '300px'"); params.width = "300px"; }

		if(this.isempty(params.successFunction)) {console.log("WUListBox: success function is not a function"); return 0;}
		if(this.isempty($(params.DstSelector).get(0))) { console.log("WUListBox: Destination element does not exist!!") ; return 0; }
		params2 = new HoverColorParams();
		
		params2.NormalColor = params.NormalColor;
		params2.HoverColor  = params.HoverColor;
		params2.ClickColor  = params.ClickColor;
		

		this.generate = function() { 
			if(ThisWulist.isempty(params.DstSelector))  { console.error("Attempt to generate without destination (WUList)" );  return 0; }
			var len, JsonObject, i, constr = "";
			
			JsonObject = params;
			len = JsonObject.DataArray.length;
		
			for (i = 0; i < len; i = i + 1) {
				constr += '<div class = "' + ((i%2 == 0)? JsonObject.Class2: JsonObject.Class1) + '" >' +
					JsonObject.DataArray[i][JsonObject.Key1] + 
					'<form  >' +
					'   <input type = "hidden" name= "kontent" value = "' + JsonObject.DataArray[i][JsonObject.Key2]  + '" />' +
					'</form>' +
					"</div>";
			}
			
			WU.getElement(JsonObject.DstSelector).html(constr);
			
			$("." + params.Class1 +" form" ).css("margin","0px");
			$("." + params.Class2 +" form" ).css("margin","0px");
				
			$("." + JsonObject.Class1).click(JsonObject.successFunction);
			
			$("." + JsonObject.Class1).click(JsonObject.successFunction);
			
			JsonObject = params2;

			$("." + params.Class1).css("width" , params.width);
			$("." + params.Class2).css("width" , params.width);
			
			$("." + params.Class1).each(function() {
				JsonObject.Selector = this;
				new HoverPlugin(JsonObject);
			});

			JsonObject.NormalColor = params.NormalColor2;
			
			$("." + params.Class2).each(function() {
				JsonObject.Selector = this;
				new HoverPlugin(JsonObject);
			});

	   }

		
		this.generateString = function() { 
			
			var len, JsonObject, i, constr = "";
			alert(JSON.stringify(params.DataArray));
			JsonObject = params;
			len = JsonObject.DataArray.length;
		
			for (i = 0; i < len; i = i + 1) {
				constr += '<div class = "' + ((i%2 == 0)? JsonObject.Class2: JsonObject.Class1) + '">' +
					JsonObject.DataArray[i][JsonObject.Key1] + 
					'<form  >' +
					'   <input type = "hidden" name= "content" value = "' + JsonObject.DataArray[i][JsonObject.Key2]  + '" />' +
					'</form>' +
					"</div> \n";
			}
			
			
			return constr;
	   }
	}
	
	this.timeStamp = function() {
		var dd  = new Date();
		var ddd = "";
		
		ddd+= 1900 + dd.getYear()+"-"+
		((1 + dd.getMonth()<10)? "0"+(1 + dd.getMonth()):(1 + dd.getMonth()))+"-"+
		((1 + dd.getDate() <10)? "0"+(1 + dd.getDate() ):(1 + dd.getDate() ))+" "+
		
		((dd.getHours()  <10)? "0"+dd.getHours()  : dd.getHours()  )+":"+
		((dd.getMinutes()<10)? "0"+dd.getMinutes(): dd.getMinutes())+":"+
		((dd.getSeconds()<10)? "0"+dd.getSeconds(): dd.getSeconds());
	
		return ddd;
	}


	this.createObject = function(key,value){
		strversion ='({ "'+key+'" : "'+
			WU.stringEntities(value)+
			'" })'
		;
		
		return eval(strversion);
	}


	
	this.stringEntities = function (Str) {
		var str2 = "";
		if(
			typeof Str !='number' &&
			typeof Str !='string'
		){
			console.log('invalid string');
			return Str;
		}
		
		if(	typeof Str =='number') return Str;
		
		str2 = Str.replace(/\\/g,"\\\\");
		str2 = str2.replace(/\r\n/g,"\\n");
		str2 = str2.replace(/\r/g,"\\n");
		str2 = str2.replace(/\n/g,"\\n");
		str2 = str2.replace(/"/g,"\\\"");
		
		
		return str2;
	}
}


var WU = new WU5();

	ObjecBuilder = function(){
		var OBB = this;
		
		OBB.collect = [];
		OBB.counter = 0;
		
		OBB.addAttrib = function(key_, value_){
			OBB.collect[OBB.counter++]= {key:key_, value:value_ }
		}
		
		OBB.getObject = function (){
			
			var Length = OBB.collect.length,
				counter = 0, strversion;
			
			strversion = '({';
			for(counter=0; counter<Length; counter++){
				if(counter>0){
					strversion +=","
				}
				strversion += '"'+OBB.collect[counter].key+'" : ';
				strversion += '"'+OBB.collect[counter].value+'" ';
			}
			strversion += '})';
			return eval(strversion);
		}
	}