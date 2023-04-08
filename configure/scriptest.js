	$("#dom-page-btn").bind("click",getDomPage);
	$("#url-dd").bind("change",urlChanged);

	var G_Addr = "<?php echo $Addr2; ?>";

	function getDomPage(){
		
		$.ajax({ 
			type:"post", 
			url: $("#dom-page-url").val(), 
			success: domPageArrived, 
			error: function(a,b,c){ console.log(a+b+c); } 
		});
	}

	function domPageArrived(dat){
		$("#dom-page-html").html(dat);
	
		window.setTimeout(
			function (){
				consolidate(getIdAndClass($("#dom-page-html")[0]));
			},
			1000
		);

		var DList2 = getIdAndClass($("#dom-page-html")[0]);

		DList2     = DList2.split(",");
		
		var DList  = [], Item;

		for(var i=0; i< DList2.length; i++){
			Item ={};
			Item[i] = DList2[i];
			DList[i]= Item;
		}
		var Json = {
			data: DList,
			onItemSelected: itemChosen
		};
		
		Lv1 = new ListView(Json);
		document.getElementById("list1").appendChild(Lv1.getListView() );
	}

	function itemChosen(){

	}

	function urlChanged(){
		$("#dom-page-url").val(G_Addr+this.value);
	}

	function getIdAndClass(obj,arr,counter){			
		//console.log(counter);
		var counter2, Children,len,index3;
		
		Children = obj.children;
		
		len = Children.length;
		if(len===0){
			return "";
		}
		var ret = '';
		for(counter2 = 0; counter2< len; counter2++){
			ret +='';
			ret += Children[counter2].tagName.toLowerCase();
			if(Children[counter2].id !==""){
				ret += "#"+Children[counter2].id;
			}
			if(Children[counter2].className !==""){
				classesarray = Children[counter2].className.split(' ');
				//console.log (Children[counter2].className );
				//console.log (classesarray );
				
				for(index3 in classesarray){
					ret += "."+classesarray[index3];
				}
			}
			
			if(Children[counter2].name !==undefined){
				ret +='[name='+Children[counter2].name+']';
			}
			ret +=',';

			var inner =getIdAndClass(Children[counter2]);
			if(inner!==""){
				ret += ''+inner+'';
			}

			ret += '';
		}
		
		return ret;
	}	


function consolidate(arr){	
	len = arr.length;
	var str='<div style="height:450px,width:600px" >' ,dv;
	
	str += arr;
	str += '</div>';
	
	str = '<div style="position: fixed; left: 200px; top: 100px; padding :50px; background-color:#fff;overflow:scroll; height: 300px" ><input type="button" value="clear" onclick="removethis()">'+str+'</div>';
	
	
	dv = document.createElement("DIV");
	dv.id = "extract-display";
	dv.innerHTML = str;
	
	document.body.appendChild(dv); 
	
}

function removethis(){
	dv = document.getElementById("extract-display");
	document.body.removeChild(dv);
}		
