	function getIdAndClass(obj,arr,counter){			
		
		var counter2, Children,len,index3;
		
		Children = obj.children;
		
		len = Children.length;
		var ret;
		for(counter2 = 0; counter2< len; counter2++){
			ret = getIdAndClass(Children[counter2],arr,counter);
			counter = ret[1];
			if(Children[counter2].id !=""){
				arr[counter++] = ""+Children[counter2].id;
			}


		}
		
		return [arr,counter];
	}	

function consolidate(arr){	
	var str;
	str = arr.join();	
	document.getElementById('lemont').value = str
}


consolidate(
	getIdAndClass(
		document.getElementById('xml-pageb87c9a66be256a833d5b627023733552'), 
		[],
		0
	)[0]
);
