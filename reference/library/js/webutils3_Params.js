//formSubmissionDirect(JsonInput)
function FormSubmissionParams() {
	this.FormId = "";
	this.ButtonId = "";
	this.successFunction = "";
}

//fetchdata/fetchdata2(JsonInput)
function FetchDataParams() {	
	this.datasource = "";
	this.successFunction = "";
	this.data ="";
}


//new CumulativeFormSubmit
function CumulativeFormSubmitParams() {
	this.FormId = "";
	this.MessageBox = "";
	this.Action = "";
	this.ButtonId = "";
	this.OutputDiv = "";
	this.AddButtonId = "";
}


/*
Form:     Selector for the form
inputs:   JSON containing the selector for external fields as keys, names of form field 
          to put the  data as values
SubmitButton: Selector for the submit button


	formPool(JsonObject)
*/
function FormPoolParams() {
	this.Form = "";
	this.inputs = "";
	this.SubmitButton = "";
}


//new HoverPlugin(JsonObject) {
function HoverColorParams() {
	this.HoverColor = "";
	this.NormalColor = "";
	this.ClickColor = "";
	this.Selector = "";
}

//new WUListBox(JsonObject).generate();
function WUListBoxParams() {
	this.HoverColor  = "";
	this.NormalColor = "";
	this.NormalColor2 = "";
	this.ClickColor  = "";
	this.Class1      = "";
	this.width       = "";
	this.Class2      = "";
	this.DstSelector = "";
	this.DataArray   = "";
    this.Key1        = "";
    this.Key2        = "";
    this.successFunction = "";
    this.valuecallback = "";
    this.formcallback  = "";
}

function WUbindParams() {
    this.Handler  = "";
    this.Button   = "";
    this.BindEvent= "";
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
				add()     : Adds data from the form
				vomit()   : Returns a String format of the stored data
				vomitRaw(): Returns a the raw array
				
				


function CumulativeFormSubmit(JsonInput) {
*/

function CumulativeFormSubmitParams(){
	this.AddButton = "";
	this.GetButton = "";
	this.successFunction = "";
}

function WUajaxParams(){
	this.data =   "";
	this.destination ="";
	this.successFunction = "";
}
