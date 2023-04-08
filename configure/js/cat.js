//category
    function editItem(obj,prefix,prefix2){
    
    
        var MyId = obj.id.split("-");
        var len = MyId.length;

        MyId = MyId[len-1];
        
        var spanid1 = prefix+ MyId;
        var spanid2 = prefix2 + MyId;
        console.log(spanid1);

        document.getElementById(spanid1).innerHTML = "";
        
        var  FrmBox = document.getElementById(spanid2);
        
        FrmBox.style.display = "inline" ;
        var Frm = FrmBox.getElementsByTagName("form")[0];
        
    }//~function editItem

    function saveup(cls){
        var P   = document.getElementsByClassName(cls);
        var len = P.length;

        var J = new JsonCreator();

        for(var i = 0 ; i<len; i++){
            J.add(  getIdFrom(P[i].id) , P[i].value  );
            J.next();
        }

        var frm = document.getElementById('saveup-form');

        frm.parents.value = J.getString();
        frm.submit();

    }

    function getIdFrom(str){

        var MyId = str.split("-");
        var len = MyId.length;

        return MyId[len-1];
    }

   function JsonCreator(){
        
        this.Keys    = [];
        this.Values  = [];
        this.JsonStr = "";
        this.Counter1= 0;
        this.Counter2= 0;
        

        this.add = function(key,value){
            
            this.Keys  [this.Counter1] = key;
            this.Values[this.Counter1] = value;

            this.Counter1 +=1;

        };

        this.next = function(){
            
            if(this.Counter2 !== 0){
        
                this.JsonStr +=", ";
                
            }else{
                this.Counter2 = 1;
            }

           this.JsonStr +="{";

            var len = this.Keys.length;
            for(var i=0 ; i<len; i++){

                this.JsonStr +='"'+this.Keys[i]+'": "'+this.Values[i]+'"';

                if(i < (len-1) ){
                    this.JsonStr += ',';
                }
            }

            this.JsonStr += "}";
            
            this.Keys   = [];
            this.Values = [];
            this.Counter1 = 0;

        }; //~  function next

        this.getString = function (){
            if(this.Keys.length){
                this.next();
            }

            return '['+this.JsonStr+']';
        };//~function getString

    }    