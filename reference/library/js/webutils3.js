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

function formSubmission(JsonInput)
{

	
	this . elementExists = 	function (elem)
	{
			var ItExists = false;
			$(elem).each(function(obj){
				ItExists = true;
			});
			return ItExists;
	}

	if(JsonInput.FormId    == null || !this.elementExists(JsonInput.FormId) ) { alert("Form does not exist"); return }
	if(JsonInput.ButtonId  == null || !this.elementExists(JsonInput.ButtonId)){ alert('No submit button'); return ; }
	if(JsonInput.successFunction  == null ){ alert('There is no callback function'); return ; }
		
	var DataToSend = $(JsonInput.FormId).serialize();
			
	if(DataToSend=="" || DataToSend == null)
	{
		alert ("Invalid Form");
		return 0;
	}
	
	var JsonAction =  $(JsonInput.FormId).attr("action");
	var JsonMethod =  $(JsonInput.FormId).attr("method");

	
	
	$(JsonInput.ButtonId).click(
	function ()
	{
		
		DataToSend = $(JsonInput.FormId).serialize();
		
		$.ajax({
				data: DataToSend,
				url: JsonAction,
				//dataType: "text",
				method: JsonMethod,
				success: function(dat)
				{
					JsonInput.successFunction(dat);
				},
				error: function(a,b,c)
				{
					alert("Error: "+"\n"+a+"\n"+b+"\n"+c);
				}	
		});	
	}
	);
	
}


/*
	Work like the form submission wiwth the exception that
	it does not require a button to be clicked to fetch data
	
/**/

	function formSubmissionDirect(JsonInput)
	{

		
		this . elementExists = 	function (elem)
		{
			var ItExists = false;
			$(elem).each(function(obj){
				ItExists = true;
			});
			return ItExists;
		}

		if(JsonInput.FormId    == null || !this.elementExists(JsonInput.FormId) ) { alert("Form does not exist"); return }
		if(JsonInput.successFunction  == null ){ alert('There is no callback function'); return ; }
			
		var DataToSend = $(JsonInput.FormId).serialize();
			
		if(DataToSend=="" || DataToSend == null)
		{
			alert ("Invalid Form");
			return 0;
		}
		
		var JsonAction =  $(JsonInput.FormId).attr("action");
		var JsonMethod =  $(JsonInput.FormId).attr("method");

		
		
			
		DataToSend = $(JsonInput.FormId).serialize();
		
		$.ajax({
				data: DataToSend,
				url: JsonAction,
				//dataType: "text",
				method: JsonMethod,
				success: function(dat)
				{
					JsonInput.successFunction(dat);
				},
				error: function(a,b,c)
				{
					alert("Error: "+"\n"+a+"\n"+b+"\n"+c);
				}	
		});	

		
		
	}


/*
	fetches data using ajax
	datasource:     name of the server page to supply data	
	successFunction: function to call on success
*/
function fetchdata(JsonInput)
{

	
	this . elementExists = 	function (elem)
	{
			var ItExists = false;
			$(elem).each(function(obj){
				ItExists = true;
			});
			return ItExists;
	}

	if(JsonInput.datasource     ==  null) { alert("you need to supply server page");}		
	if(JsonInput.successFunction  == null ){ alert('There is no callback function'); return ; }
		
	
	var JsonAction =  $(JsonInput.datasource);
	var JsonMethod =  "post";

	
		
		//DataToSend = $(JsonInput.FormId).serialize();
		
		$.ajax({
				//data: DataToSend,
				url: JsonInput.datasource,
				//dataType: "text",
				method: JsonMethod,
				success: function(dat)
				{
					JsonInput.successFunction(dat);
				},
				error: function(a,b,c)
				{
					alert("Error: "+"\n"+a+"\n"+b+"\n"+c);
				}	
		});	
		
	
}

/*
	works like fetchdata
	accepts :data
/**/

function fetchdata2(JsonInput)
{

	
	this . elementExists = 	function (elem)
	{
			var ItExists = false;
			$(elem).each(function(obj){
				ItExists = true;
			});
			return ItExists;
	}

	if(JsonInput.datasource     ==  null) { alert("you need to supply server page");}		
	if(JsonInput.successFunction  == null ){ alert('There is no callback function'); return ; }
		
	
	var JsonAction =  $(JsonInput.datasource);
	var JsonMethod =  "post";

	
		
		DataToSend = JsonInput.data;
		
		$.ajax({
				data: DataToSend,
				url: JsonInput.datasource,
				//dataType: "text",
				method: JsonMethod,
				success: function(dat)
				{
					JsonInput.successFunction(dat);
				},
				error: function(a,b,c)
				{
					alert("Error: "+"\n"+a+"\n"+b+"\n"+c);
				}	
		});	
		
	
}


function toggleMenu(MenuIdArray,SubMenuIdArray)
{
	this .MenuIds = MenuIdArray;
	this .SubMenus= SubMenuIdArray;
	this .MenuSize= MenuIdArray.length;
	var thisToggle  = this;
	
	Ll = this .MenuSize;
	
	for(counter =0; counter<Ll; counter++)
	{	
		//alert(MenuIdArray[counter]);
		$('#'+MenuIdArray[counter]).click(function() { thisToggle.setupSlide(this);}	);
	}

	
	
	this . setupSlide =	function (obj)
	{
		
		MenuToShow = this .findMenu($(obj).attr('id')) ;
		//alert(MenuToShow);
		$('#'+this .SubMenus[MenuToShow]).slideDown();
		
		
		for(MenuCount = 0; MenuCount< this .MenuSize; MenuCount++)
		{
			if(MenuCount != MenuToShow)
			{
				$('#'+this .SubMenus[MenuCount]).slideUp();
			}
		}
	}
	
	this .findMenu = function(str)
	{
		
		for(i=0; i< this .MenuSize ; i++)
		{
			if(this .MenuIds[i]== str) break ;
		}
		
		return	i;
	}
	
}

function getValue(Nstart,Nend)
{
	var valu;
	valu  = Math.floor(Math.random()*10000);
	valu %= ((Nend-Nstart)*100);

	return Nstart+ valu/100;
	/**/
}

function trim(str)
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
Accepts data from a form repeatedly and saves it into a cart
the intent being to provide the information back in Json array

supply JsonInput having the  following

FormId           :  The form containing 
AddButton        :  The selector for the button to 
                    click to add data to cart  
GetButton        :	The button to click to return the cart data
successFunction  :  The function to call if the GetButton or 
                    AddButton is clicked; When called, The parameters
					are The selector of the object clicked, followed
					by the instance of this Object
					
					You can call the following methods on that instance:
				add()   : Adds data from the form
				vomit() : Returns a String format of the stored data
				vomitRaw: Returns a the raw array
				
				
*/

function CumulativeFormSubmit(JsonInput) {
	this.isempty = function(obj){
		return (obj=="" || obj==null || obj == undefined);
	}	

	//check if the parameters are present
	if( this.isempty(JsonInput.FormId)     )    { console.log("You forgot FormId"    );    return 0;}
	if( this.isempty(JsonInput.AddButton)  )    { console.log("You forgot Add Button");    return 0;}
	if( this.isempty(JsonInput.GetButton)  )    { console.log("You forgot GetButton" );    return 0;}
	if( this.isempty(JsonInput.successFunction)){ console.log("You forgot OutputDiv");  return 0;}

	// static variables
	var FormId          = JsonInput.FormId;
	var GetButton       = JsonInput.GetButton;
	var AddButton       = JsonInput.AddButton;
	var successFunction = JsonInput.successFunction;
	var ThisObject      = this;
	
	//Check if they exist
	if( !elementExists(FormId    ) ) { console.log(FormId   +" does not exist"); return 0;}
	if( !elementExists(GetButton ) ) { console.log(GetButton+" does not exist"); return 0;}
	if( !elementExists(AddButton ) ) { console.log(AddButton+" does not exist"); return 0;}

	//Create inner Cart Object
	this.Cart = function() 	{
		//debug	/**/ alert("Line 163 (Cart constructor)");		/****/
		this.collect = new Array();
		this.counter = 0;
		
		this.addNew= function(newobject)
		{
			this.collect[this.counter++] = newobject;
		}
		
		this.vomit = function()
		{
			return JSON.stringify(this.collect);
		}
		
		this.vomitRaw = function()
		{
			return this.collect;
		}		
	}//~Cart
	
	

	this.vomit    = function () { return CartObject.vomit();    }
	this.vomitRaw = function () { return CartObject.vomitRaw(); }
	
	
	this.add = function() {
		var myobjectStr = "{";
		var Objective = $(FormId).serializeArray();	
		//alert($(stt).attr('id'));
		var counter2, len;
		len = Objective.length;
		
		for(counter2 = 0;counter2<len;counter2++)
		{
			if(counter2 !=0) myobjectStr+= ",";
			myobjectStr += ' "'+Objective[counter2].name+'" ' ;
			myobjectStr += " : ";
			myobjectStr += ' "'+Objective[counter2].value+'" ' ;			
		}
		
		myobjectStr += " } ";
		myobject = JSON.parse(myobjectStr);
		CartObject.addNew(myobject);
		
	}



	//debug	/**/ alert("Line 238");		/****/
	var CartObject  = new this.Cart;
	
	$(GetButton).click(
		function () {
			successFunction(GetButton,ThisObject)
		}
	);
	
	
	$(AddButton).click(
		function(){
			ThisObject.add();
			successFunction(AddButton,ThisObject);
		}
	);
	
}

	function elementExists(elem)	{
		return $(elem).get(0);
	}

//$.post(url_to_send, data, function(json){})
/*********/

function CumulativeFormSubmit2(JsonInput) {
	this.isempty = function(obj){
		return (obj=="" || obj==null || obj == undefined);
	}	

	//check if the parameters are present
	if( this.isempty(JsonInput.FormId)     )    { console.log("You forgot FormId"    );    return 0;}
	//if( this.isempty(JsonInput.successFunction)){ console.log("You forgot OutputDiv");  return 0;}

	// static variables
	var FormId          = JsonInput.FormId;
	var GetButton       = JsonInput.GetButton;
	var AddButton       = JsonInput.AddButton;
	var successFunction = JsonInput.successFunction;
	var ThisObject      = this;
	
	//Check if they exist
	if( !elementExists(FormId    ) ) { console.log(FormId   +" does not exist"); return 0;}


	//Create inner Cart Object
	this.Cart = function() 	{
		//debug	/**/ alert("Line 163 (Cart constructor)");		/****/
		this.collect = new Array();
		this.counter = 0;
		
		this.addNew= function(newobject)
		{
			this.collect[this.counter++] = newobject;
		}
		
		this.vomit = function()
		{
			return JSON.stringify(this.collect);
		}
		
		this.vomitRaw = function()
		{
			return this.collect;
		}		
	}//~Cart
	
	

	this.vomit    = function () { return CartObject.vomit();    }
	this.vomitRaw = function () { return CartObject.vomitRaw(); }
	
	
	this.add = function() {
		var myobjectStr = "{";
		var Objective = $(FormId).serializeArray();	
		//alert($(stt).attr('id'));
		var counter2, len;
		len = Objective.length;
		
		for(counter2 = 0;counter2<len;counter2++)
		{
			if(counter2 !=0) myobjectStr+= ",";
			myobjectStr += ' "'+Objective[counter2].name+'" ' ;
			myobjectStr += " : ";
			myobjectStr += ' "'+Objective[counter2].value+'" ' ;			
		}
		
		myobjectStr += " } ";
		myobject = JSON.parse(myobjectStr);
		CartObject.addNew(myobject);
		
	}



	//debug	/**/ alert("Line 238");		/****/
	var CartObject  = new this.Cart;
	
	
}




/*

Function to fill in the gaps within a form. Some times layout does not allow
all the input fields to be put into the same form. so data has to be collected
from external fields and put in the form

supply a JSON containing:

Form:     Selector for the form
inputs:   JSON containing the selector for external fields as keys, names of form field 
          to put the  data as values
SubmitButton: Selector for the submit button



/**/
	function formPool(JsonObject)
	{

		$(JsonObject.SubmitButton).click(
			function(){
				var TheForm;
				$(JsonObject.Form).each( function(){ TheForm = this;});

				for(key in JsonObject.inputs)
				{
					//alert(key+"  " +JsonObject.inputs[key]+"\n")
					//alert(TheForm[JsonObject.inputs[key]]);
					TheForm[JsonObject.inputs[key]].value = $(key).val();
				}
			
				var DataToSend = $(JsonObject.Form).serialize();
				var JsonAction = $(TheForm).attr("action");
				var	JsonMethod = $(TheForm).attr("method");
			
				$.ajax(
						{
							data: DataToSend,
							url: JsonAction,
							dataType: "text",
							method: JsonMethod,
							success: function(dat)
							{
								JsonObject.successFunction(dat);
							},
							error: function(a,b,c)
							{
								alert("Error: "+"\n"+a+"\n"+b+"\n"+c);
							}	
						}			
				);	
			}
		);

	}

	
	
	
	function formPool2(Json_Object)
	{	
	
		var JsonObject = Json_Object;

			/*		
			for(key in JsonObject.inputs)
			{
				alert("Source "+JsonObject.inputs[key].src+
				"\n Destination "+JsonObject.inputs[key].dst
				);
			}
			
			alert("Submit button "+ JsonObject.SubmitButton);
			alert("sucess function "+ JsonObject.successFunction);
			/****/			

		$(JsonObject.SubmitButton).click(
				function(){
					var TheForm, TheComponent;
					$(JsonObject.Form).each( function(){ TheForm = this;});

					for(key in JsonObject.inputs)
					{
						$(JsonObject.inputs[key].src).each(function(){TheComponent= this; });
						TheForm[JsonObject.inputs[key].dst].value = TheComponent.value;	
					}
					
					var DataToSend = $(JsonObject.Form).serialize();
					var JsonAction = $(TheForm).attr("action");
					var	JsonMethod = $(TheForm).attr("method");
				
					$.ajax(
						{
							data: DataToSend,
							url: JsonAction,
							dataType: "text",
							method: JsonMethod,
							success: function(dat)
							{
								JsonObject.successFunction(dat);
							},
							error: function(a,b,c)
							{
								alert("Error: "+"\n"+a+"\n"+b+"\n"+c);
							}	
						}			
					);	
				}
		);

	}


	function formPoolIcmsCrAr(Json_Object)
	{	
	
		var JsonObject = Json_Object;

			/*		
			for(key in JsonObject.inputs)
			{
				alert("Source "+JsonObject.inputs[key].src+
				"\n Destination "+JsonObject.inputs[key].dst
				);
			}
			
			alert("Submit button "+ JsonObject.SubmitButton);
			alert("sucess function "+ JsonObject.successFunction);
			/****/			

		$(JsonObject.SubmitButton).click(
				function(){
					var TheForm, TheComponent;
					$(JsonObject.Form).each( function(){ TheForm = this;});

					for(key in JsonObject.inputs)
					{
						$(JsonObject.inputs[key].src).each(function(){TheComponent= this; });
						TheForm[JsonObject.inputs[key].dst].value = TheComponent.value;	
					}
					
					TheForm.htmltext.value = document.getElementById('korrect').contentDocument.getElementById('wysihtml5-editor').value;
					var DataToSend = $(JsonObject.Form).serialize();
					var JsonAction = $(TheForm).attr("action");
					var	JsonMethod = $(TheForm).attr("method");
				
					$.ajax(
						{
							data: DataToSend,
							url: JsonAction,
							dataType: "text",
							method: JsonMethod,
							success: function(dat)
							{
								JsonObject.successFunction(dat);
							},
							error: function(a,b,c)
							{
								alert("Error: "+"\n"+a+"\n"+b+"\n"+c);
							}	
						}			
					);	
				}
		);

	}
	
	
	/*
	Change the value of a select to a predetermined value
	supply the selector for the select object, and the value to set it to
*/

	function setSelectOption(SelectObject, Value)
	{
		var TheObject 	;
		//alert(SelectObject+", "+ Value);
		TheObject = $(SelectObject).get(0);
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


	function  createSelectOption(JsonObject)
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
	

	function inArray1D(needle, haystack)
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
	
	
	function timestampToText(stamp)
	{
		var dat, tim, tmp;
		var relate = ['none','January','February','March','April','May','June','July','August','September', 'October','November','December'];
		//"2015-05-27 13:10:49"
		tmp = stamp.split(" ");
		
		dat = tmp[0].split('-');
		tim = tmp[1].split(':');
		ampm = (tim[0]<12)? 'Pm': 'Am' ;
		//alert(eval(dat[2]))
		return dat[1]+" "+relate[eval(dat[1])]+
		       " "+dat[0] +
			   "("+(tim[0]%12)+":"+tim[1]+
			   ":"+tim[2]+" "+ampm+")";
	}
	
	function ThreadJoiner(JsonObject)	{
		
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




function HoverPlugin(JsonObject) {
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
    
    $(Object_Iq).mouseover(this.changeColorH);
    $(Object_Iq).mouseleave(this.changeColorN);
    $(Object_Iq).mousedown(this.changeColorC);
    $(Object_Iq).mouseup(this.changeColorN);
}

function WUListBox(JsonObject) {
   var params, params2;
    var ThisWulist = this;
    this.isempty = function(obj){
        return (obj=="" || obj==null || obj == undefined);
    }
    
    if(this.isempty(JsonObject) ){ console.error("Parameter missing in instantiation WUListBox"); return 0; }
    

    params  = new WUListBoxParams();
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
        
        $(JsonObject.DstSelector).html(constr);
        
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

function   WUbind(JsonObjet) {
    
	this.isempty = function(obj)
	{
        return (obj=="" || obj==null || obj == undefined);
    }
    
    var params = new WUbindParams();
    params = JsonObjet ;
    
    if (this.isempty(params.BindEvent)) { console.log("could not bind event , no BindEvent specified"); return 0; }
    if (this.isempty(params.Button))    { console.log("could not bind event , Button not specified"  ); return 0; }
    if (this.isempty(params.Handler))   { console.log("could not bind event , Handler not specified"  ); return 0; }

    
    if (this.isempty($(params.Button).get(0)))     { console.log("could not bind event, " + params.Button+ " does not exist! "  ); return 0; }
    if(typeof params.Handler != "function")
	{ console.log("could not bind event,  handler is not a function "  ); return 0; }
    
    if (
        params.BindEvent != "click" &&
        params.BindEvent != "mouseover" &&
        params.BindEvent != "mouseout" &&
        params.BindEvent != "change" &&
        params.BindEvent != "blur" &&
        params.BindEvent != "mouseup" &&
        params.BindEvent != "mousedown" && 
        params.BindEvent != "keypress" &&
        params.BindEvent != "focusin" &&
        params.BindEvent != "focusout"
        
    )
        {
            console.log("could not bind (unrecognized event " + params.BindEvent + ")");
            return;
        }
        
        $(params.Button).bind(params.BindEvent,params.Handler );
}

function WUCustomListBox(JsonObject) {
   var params, params2;
    var ThisWulist = this;
    this.isempty = function(obj){
        return (obj=="" || obj==null || obj == undefined);
    }
    
    if(this.isempty(JsonObject) ){ console.error("Parameter missing in instantiation WUListBox"); return 0; }
    

    params  = new WUListBoxParams();
    params  = JsonObject;
    var   Myself = this;
	this.successFunction = JsonObject.successFunction;
	
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

    if(!params.successFunction) {console.log("WUListBox: success function is not a function"); return 0;}
    if(!params.formcallback)  {console.log("WUListBox: form callback function is not a function"); return 0;}
    if(!params.valuecallback) {console.log("WUListBox: value callback function is not a function"); return 0;}
    
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
                JsonObject.valuecallback(i) + 
                '<form  >' +
                JsonObject.formcallback(i) +
                '</form>' +
                "</div>";
        }
        
        $(JsonObject.DstSelector).html(constr);
        
        $("." + params.Class1 +" form" ).css("margin","0px");
        $("." + params.Class2 +" form" ).css("margin","0px");
        
        
        
        $("." + JsonObject.Class1).click(JsonObject.successFunction);

        $("." + JsonObject.Class2).click(JsonObject.successFunction);
        
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


function  WUajax(JsonObject)	{
	
	//alert(JSON.stringify(JsonObject));

	this.isempty = function(obj){
		return (obj=="" || obj==null || obj == undefined);
	}	

	if(this.isempty(JsonObject.data)) { 
	console.log("data not provided");  JsonObject.data = ""; 
	}

	if(this.isempty(JsonObject.destination)) { 
	console.log("Destination  not specified"); return 0; 
	}

	if(this.isempty(JsonObject.successFunction)) { 
	console.log("successFunction  not specified"); return 0; 
	}
	
	$.ajax({
		data: JsonObject.data,
		url:  JsonObject.destination,
		//dataType: "text",
		method: "post",
		success: function(dat)
		{
			JsonObject.successFunction(dat);
		},
		error: function(a,b,c)
		{
			alert("Error: "+"\n"+a+"\n"+b+"\n"+c);
		}	
	});	
}


