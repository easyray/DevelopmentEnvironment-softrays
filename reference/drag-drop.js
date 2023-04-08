var  G_C;
var  G_Ids     = [];
var  G_Counter = 0;
var  G_DLEFT, G_DTOP;
var  G_CLeft, G_CTop;

function createDialog(){
	var dv = document.createElement("DIV");
	var k  = {};

	dv.id  = $("#D_ID").val();
	dv.style.border = "thin solid #999";
	dv.style.width  = "640px";
	dv.style.height = "400px";
	dv.style.backgroundColor = "#ccc";


	//This is the stuff that allows drag and drop
	dv.ondragover=allowDrop;
	dv.ondrop    =drop;
	
	document.getElementById("main-pane").append(dv);
}

function addControl(){
	//......
	/*

	....
	..
	.
	.

	*/
	//this makes the item draggable
	control.draggable = "true";
	document.getElementById(getID(G_Ids[0])).append(control);

	$(control).bind("dragstart",beginDrag);
	$(control).bind("click",beginDrag);	
}

function beginDrag(ev){
	G_C = this;
	
	$("#cc-width").val (this.style.width);
	$("#cc-height").val(this.style.height);
	$("#cc-txt").val(this.value);
	$("#cc-X").val(""+(parseInt(this.style.left)- parseInt(G_DLEFT)));
	$("#cc-Y").val(""+(parseInt(this.style.top) - parseInt(G_DTOP) ));	
}

function allowDrop(ev){

	ev.preventDefault();
	G_CLeft = ev.pageX;
	G_CTop  = ev.pageY;
	
	$("#cc-X").val(""+(parseInt(G_CLeft)- parseInt(G_DLEFT)));
	$("#cc-Y").val(""+(parseInt(G_CTop) - parseInt(G_DTOP) ));
}

function drop(ev){

	var control;
	ev.preventDefault();

	control  = G_C;
	control.style.left  = G_CLeft+"px";
	control.style.top   = G_CTop +"px";
}