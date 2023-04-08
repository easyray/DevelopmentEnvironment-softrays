function errorFunction(a,b,c){ 
	console.log(a); 
	console.log(b);
	console.log(c); 

}
function sendData(dat){
	$.ajax({ 
		data: dat,
		 type:"post",
		 url: "database-mgr-2.php",
		success: database_backed_up,
		 error: errorFunction
	});
}
function sendData2(dat){
	
	$.ajax({ 
		data: dat,
		 type:"post",
		 url: "database-mgr-2.php",
		success: database_restored,
		 error: errorFunction
	});
}

function database_backed_up(dat) {
	alert(
	 	"database backed up"+
	 	dat
 	);
 	$("#hidden-note>textarea").val("");
 	toggleHiddenNote();
}

function backup_database() {
	var dat; 
	 dat = {
	 	'notes': $("#hidden-note>textarea").val(),
		"task": "backup",
		"root-folder": $("#root-folder").val()
	};

	sendData(dat);

}
$("#bakup").bind("click",backup_database); 

function showImportForm(){
	$('#upload-form').slideDown();
}
$("#impor").bind("click",showImportForm); 
 
function restoreDatabase() {
	var dat; 
	 dat = {
	 	"task": "restore",
		"root-folder": $("#root-folder").val()
	};
	//{"task": "restore", "root-folder": "C:/xampp/htdocs/php-IDE"}
	sendData2(dat);
}

function database_restored (dat){
	$("#hidden-menu").html($("#commands").html());
	$("#commands").html(dat);

	$("#clear-restore").unbind("click"); 
	$("#clear-restore").bind("click",cancelRestore); 
}

function cancelRestore(){
	$("#commands").html($("#hidden-menu").html());
	$("#v-bakup").bind("click",toggleHiddenNote);

	$("#resto").bind("click",restoreDatabase); 
	$("#bakup").bind("click",backup_database);
	$("#cancel-backup").bind("click",cancelBackup); 
}

function toggleHiddenNote(){
	$("#hidden-note").slideToggle();
}
function cancelBackup(){
	toggleHiddenNote();
}
$("#cancel-backup").bind("click",cancelBackup); 
$("#v-bakup").bind("click",toggleHiddenNote); 
$("#resto").bind("click",restoreDatabase); 
$("#bakup").bind("click",backup_database); 

//--------------------------------------------
function processAlterCmdFetch() {
	var dat;

	switch(this.value){
		case 'change-t-name': successFunction = tableRenameControlsFetched ; break;
		case 'change-c-name': successFunction = columnRenameControlsFetched; break;
		case 'add-col'      : successFunction = addColumnControlsFetched   ; break;
		case 'remove-col'   : successFunction = removeColControlsFetchted  ; break;

	}

	dat = {
	 	"command": this.value,
		"root-folder": $("#root-folder").val()
	};

	 $.ajax({ 
		data: dat,
		type:"post",
		url: "ajax-fetch-tables.php",
		success: successFunction,
		error: errorFunction
	});
	 $("#tables-dd").show();
}
//----------------------------------------------
function tableRenameControlsFetched(dat) {
	$("#tables-dd").html(evaluate(dat));
	
	tableNewNameKeyUp();

	$("input[name=new-name]").unbind();
	$("input[name=new-name]").bind("keyup",tableNewNameKeyUp);

	$("#cancel-rename").unbind();
	$("#cancel-rename").bind("click",cancelRename);
}
//-------------------------------------------------
function tableNewNameKeyUp(){
		$("#sql-cmd").val(
		'ALTER TABLE "'+$("select[name=old-name]").val()+'"'+
		' RENAME TO "'+$("input[name=new-name]").val()+'"'
	);	
}
//-----------------------------------------------
function columnRenameControlsFetched(dat){
	$("#tables-dd").html(evaluate(dat));
	
	columnRenameKeyUp();
	$("input[name=new-name]").unbind();
	$("input[name=new-name]").bind("keyup",columnRenameKeyUp);

	$("#cancel-rename").unbind();
	$("#cancel-rename").bind("click",cancelRename);
	$("select[name=old-name]").unbind();
	$("select[name=old-name]").bind("change", tableDDChanged);
}
//-----------------------------------------------
function columnRenameKeyUp(){
	$("#sql-cmd").val(
		'ALTER TABLE "'+$("select[name=old-name]").val()+'"'+
		' CHANGE "'+$("#old-col-name").val()+'" '+
		'"'+$("input[name=new-name]").val()+'" '
	);
}
//-----------------------------------------------

function addColumnControlsFetched(dat){
	$("#tables-dd").html(evaluate(dat));

	addColumnNewNameKeyUp();

	$("input[name=new-name]").unbind();
	$("input[name=new-name]").bind("keyup",addColumnNewNameKeyUp);

	$("#cancel-rename").unbind();
	$("#cancel-rename").bind("click",cancelRename);	

	$("select[name=old-name]").unbind();
	$("#old-col-name")[0].disabled = "true";
	G= $("#old-col-name")[0]
}
//-----------------------------------------------
function addColumnNewNameKeyUp(){
	$("#sql-cmd").val(
		'ALTER TABLE "'+$("select[name=old-name]").val()+'"'+
		' ADD  "'+$("input[name=new-name]").val()+'"'+
		'INTEGER PRIMARY KEY NOT NULL '
	);	
}

//-----------------------------------------------
function removeColControlsFetchted(dat){
	

	$("#tables-dd").html(evaluate(dat));

	$("#old-col-name")        .unbind();
	$("#cancel-rename")       .unbind();
	$("select[name=old-name]").unbind();

	console.log($("#old-col-name")[0]);
	$("#old-col-name")     .bind("change",removeCol_ColumnDDChanged);
	$("#cancel-rename")      .bind("click",cancelRename);
	$("input[name=new-name]")[0].disabled="true";
	$("select[name=old-name]").bind("change",tableDDChangedforCDrop);
	
	removeCol_ColumnDDChanged();
}
//-----------------------------------------------
function tableDDChangedforCDrop(){
	tableDDChanged(addHandlerToColumnDD);
}
//-----------------------------------------------
function addHandlerToColumnDD(dat){
	$("#old-col-name")[0].outerHTML= evaluate(dat);
	$("#old-col-name").unbind();
	$("#old-col-name").bind("change",removeCol_ColumnDDChanged);
}

//-----------------------------------------------
function removeCol_ColumnDDChanged(){
	$("#sql-cmd").val(
		'ALTER TABLE "'+$("select[name=old-name]").val()+'"'+
		' DROP  "'+$("#old-col-name").val()+'"'
	);

}
//-----------------------------------------------
function tableDDChanged(successFunction){
	if(!successFunction){
		successFunction = setNewColsDD;
	}
	var dat;
	dat = {
		"command": "only-columns",
		"root-folder": $("#root-folder").val(),
		"table"   : $("#old-name").val()
	}; 
	
	//{"command": "only-columns", "root-folder": "C:/xampp/htdocs/php-IDE", "table": "student"}
	 $.ajax({ 
		data: dat,
		type:"post",
		url: "ajax-fetch-tables.php",
		success: successFunction,
		error: errorFunction
	});
}
//-----------------------------------------------
function setNewColsDD(dat){
	$("#old-col-name")[0].outerHTML= evaluate(dat);
}



function cancelRename(){
	$("#tables-dd").hide();
}
//-----------------------------------------------
$("#command-dd").bind("change",processAlterCmdFetch);

function evaluate(str){
	return window['eval']('('+str+')');
}

console.log("25th July-13:53");