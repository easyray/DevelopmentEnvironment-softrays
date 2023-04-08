function TreeParser(_src){
	
	var TP = this;
	this.Index  =0 
	this.Source = _src+' ';
	
	this.Stack  = function(){
		var  Stk    = this;
		Stk.Index   = 0;
		Stk.Content = [];
		
		Stk.popS  = function(){
			if(Stk.Index>0){
				return Stk.Content[--Stk.Index];
			}
		}
		Stk.pushS = function(stuff){
			Stk.Content[Stk.Index++] = stuff;
		} 
		
	}
	
	TP.stk = new TP.Stack();
	
	TP.isSpace = function(){
		var x = TP.Source.charAt(TP.Index);
		return (
		TP.Source.charAt(TP.Index) == ' ' ||
		TP.Source.charAt(TP.Index) == '\t' ||
		TP.Source.charAt(TP.Index) == '\r' ||
		TP.Source.charAt(TP.Index) == '\n' 
		);
	}
	TP.removeSpace = function(){
		while(TP.isSpace()){
			TP.Index ++;
		}
	}

	TP.readAttribs= function(){
		var classes =[], TagName ='',counter = 0, IdName='', ClassName='';
		
			while(TP.Source.charAt(TP.Index) !='#' && 
				  TP.Source.charAt(TP.Index) !='.' && 
				  TP.Source.charAt(TP.Index) !=' ' && 
				  TP.Source.charAt(TP.Index) !='(' && 
				  TP.Source.charAt(TP.Index) !=')'  
				  
			){

			TagName += TP.Source.charAt(TP.Index++);
		}	  
		
		if(TagName==''){ TagName= 'div'; }
		
		TP.removeSpace();
		
		x = TP.Source.charAt(TP.Index);
		
		if(TP.Source.charAt(TP.Index)=='#'){
			TP.Index ++;
			while(TP.Source.charAt(TP.Index) !='#' && 
				  TP.Source.charAt(TP.Index) !='.' && 
				  TP.Source.charAt(TP.Index) !=' ' && 
				  TP.Source.charAt(TP.Index) !='(' && 
				  TP.Source.charAt(TP.Index) !=')'  
				  
			){
				IdName += TP.Source.charAt(TP.Index++);
			}

		}
		//xxz();
		TP.removeSpace();
		while(TP.Source.charAt(TP.Index)=='.'){
			TP.Index++;
			TP.removeSpace();
			while(TP.Source.charAt(TP.Index) !='#' && 
				  TP.Source.charAt(TP.Index) !='.' && 
				  TP.Source.charAt(TP.Index) !=' ' && 
				  TP.Source.charAt(TP.Index) !='(' && 
				  TP.Source.charAt(TP.Index) !=')'  
				  
			){
				ClassName += TP.Source.charAt(TP.Index++);
				//console.log(ClassName);
			}
			//rxi()
			classes[counter++] = ClassName;
			ClassName = '';
			TP.removeSpace();
		}

		var result = "", Len = classes.length;
		result += '<'+TagName+' ';
		if(IdName != ''){
			result += 'id="'+IdName+'"'
		}
		
		if(Len>0){
			result += ' class = "';
			for(counter = 0 ; counter<Len ; counter++){
				result += classes[counter]+' ';
			}
			result += '" ';
		}
		
		result += ' >'
		TP.stk.pushS(TagName);
		return result;
	}
	
	TP.closeTag = function(){
		return '</'+TP.stk.popS()+' >';
	}
	TP.parse = function(){
		var retval ="";
		var x = "";
		TP.removeSpace();
		while(
		TP.Source.charAt(TP.Index)=='(' ||
		TP.Source.charAt(TP.Index)==')'
		){
			x = TP.Source.charAt(TP.Index);

			 
			if(TP.Source.charAt(TP.Index)=='(' ){
				TP.Index++;
				TP.removeSpace();				
				retval += TP.readAttribs();
			}else{
				TP.Index++;
				TP.removeSpace();				
				retval += TP.closeTag();
			}
			TP.removeSpace();
		}
		
		return retval;
	}

}