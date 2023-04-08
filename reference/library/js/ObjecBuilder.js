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