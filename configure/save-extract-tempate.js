	
function createModule(Module,Section,Content) {
	var dat; 
	dat = {
		"module":Module,
		"section": Section,
		"content": Content,
		"site-folder": $("#site-folder").val()
	};

	$.ajax({ 
		data: dat,
		type:"post",
		url: "module-create.php",
		success: module_created,
		error: error_function
	});
}

function module_created(dat) {
	//console.log(dat);
	//viewAjaxResult(dat);
}

function error_function(a,b,c){ 
	console.log(a); 
	console.log(b);
	console.log(c);
}

//----------------------------------------------
function evaluate(str){
	return window['eval']("("+str+")");
}
//----------------------------------------------