GElt = {value: ""};
var document = 
{
	vlist:[
		"tbl_nm,$email",
		"$pocket,mynode",
		"pocket,start_up,$strap",
		"conso,$dirname,pssword",
		"$email,concrete,module_x",
		"extension,$concrete,$dirname",
		"$pssword,mynode,$concrete",
		"$concrete,$mynode,module_x"
	],
	clist:[
		"module_x,username",
		"address,module_x",
		"conso,anony,required",
		"extension,pssword,extension",
		"extension,module_x,extension",
		"address,anony,concrete",
		"mynode,required,exports_",
		"conso,required,filename",
	],
	wlist:["VVVVVVVVVVVV"],
	count1: 0,
	count2: 0,
	getElementById: function(str){
		This = document;
		if('selected-1' == str){
			return {value: This.clist[This.count2++]};
		}else if('selected-2' == str){
			return {value: This.vlist[This.count1++]};
		}else if('selected-3' == str){
			return {value: This.clist[This.count1++]};
		}else if('selected-4' == str){
			return {value: This.vlist[This.count1]};
		}else if('var-col' == str){
			return {value: This.wlist[0]};
		}else{
			return GElt;
		}
	}
};

function getTable1(){
	return 'my_table_1';
}

function getTable2(){
	return 'my_tables_2';
}

for(i=1;i<=8; i++){
	createSELECT();
	console.log('-- '+i);
	console.log(document.getElementById("output").value);
}

