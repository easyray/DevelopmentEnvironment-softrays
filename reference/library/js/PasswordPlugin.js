
(function($){

	$.login = function(options){
		var settings_ = {
			destination  : "",
			processor    : "login.php",
			usernamefield: "#username",
			usernametag  : "username",
			passwordfield: "#password",
			passwordtag  : "password",
			peekbutton   : "",
			messagebox   : "",
			submitbutton : "#loginbutton"
		};
		
		settings_ = $.extend({}, settings_, options);

		

		
		var successFunction = function(dat){
			if(settings_.messagebox !==''){
				if(evaluate(dat) == 1){
					$(settings_.messagebox).html('<span style="color: green"> Login Successful, redirecting </span>');
					document.location.href = settings_.destination;
				}else{
					$(settings_.messagebox).html('<span style="color: red"> Login Successful, redirecting </span>');
				}
				
				window.setTimeout(
					function(){
						$(settings_.messagebox).html('');
					},
					1000
				);
			}
		};
		
		var errorFunction = function(){
			$(settings_.messagebox).html('<span style="color: red">We Could not reach the server </span>');
			window.setTimeout(
				function(){
					$(settings_.messagebox).html('');
				},
				1000
			);
		};
		
		var evaluate = function(str){
			return window["eval"]('('+str+')');
		};
		
		var ajax_params={
			data:{},
			url: settings_.processor,
			type: "post",
			success: successFunction,
			error: errorFunction
		};
		
		var DataMaker = function(){
			this.Attrib  = [];
			this.Value   = [];
			this.Counter = 0;
			
			DM = this;
			
			DM.addItem = function(attr,val){
				DM.Attrib[DM.Counter]   = attr;
				DM.Value [DM.Counter++] = val;
			};
			

			DM.getData = function(){
				
				var str = '{';
			
				for(var counter=0; counter< DM.Counter; counter++){
					if(counter > 0){ 
						str += ',';
					}
					str += ' "'+DM.Attrib[counter]+ '" :'; 
					str += ' "'+DM.Value [counter]+ '"'  ;
				}
				
				str += '}';
				
				return evaluate(str);
			};
		};
		

		$(settings_.submitbutton).bind("click",
			function(){
				var K = new DataMaker();
				
				K.addItem(
				settings_.usernametag, 
				$(settings_.usernamefield).val()
				);
				
				K.addItem(
				settings_.passwordtag,
				$(settings_.passwordfield).val()
				);		
				
			
				ajax_params.data = K.getData();
				
				$.ajax(ajax_params);
			}
		);
		
		var PasswordPeeker = function(passwordfield,peekbutton){
			
			this.InnerText = document.createElement("input");
			
			var PassP = this;
			
			PassP.switchThings = function(){
				//console.log('Hello');
				var Friend = $(passwordfield)[0];
				$(PassP.InnerText).val(Friend.value);
				$(Friend).replaceWith(PassP.InnerText);
				PassP.InnerText = Friend;
			};			
			
			Friend = $(passwordfield)[0];
			$(this.InnerText).attr("class",Friend.className);
			$(this.InnerText).attr("id",Friend.id);
			$(this.InnerText).attr("type",'text');
			
			$(this.peekbutton).bind("mousedown", PassP.switchThings);
			$(this.peekbutton).bind("mouseup"  , PassP.switchThings);
		};
		
		if( settings_.peekbutton !==''){
			new PasswordPeeker(settings_.passwordfield,settings_.peekbutton);
		}

	};
})(jQuery);

	
/*
function doRegistration(){
	var stuff;
	var p1,p2;
	var flag =0;
	var reg;

	//check empty inputs
	$('#register-form input').each(
		function(){
			if(this.value==""){
				markRed(this);
				flag = 1;
			}
		}
	);

	if(flag){ 
		window.setTimeout(UnMark,10000);
		showLoginMsg("Compulsory fields missing",false);
		return 0; 
	}

	//check password match
	p1 = $('#register-form input[name="password"]').val();
	p2 = $('#register-form input[name="password2"]').val();
	if(p1 != p2){
		showLoginMsg("Your passwords do not match", false);
		return 0;
	}


	//Check email box
	reg = /[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}/;
	p1 = $('#register-form input[name="email"]').val();

	if(!reg.test(p1)){
		showLoginMsg("Check the format of your email",false);
		window.setTimeout(UnMark,10000);
		return 0;
	}

	stuff = jQuery("#register-form input").serializeArray();
	$.ajax({
		url:"process.php",
		type:"post",
		data: stuff,
		success: registrationDone

	})
}

function registrationDone(dat){
	dat = evaluate(dat)
	if( dat.msg == "Ok"){
		showLoginMsg("registration successful",true);
	}else{
		showLoginMsg("sorry registration could not be completed "+dat.msg, false)
	}
}


function showLoginMsg(Msg, Ok){
	if(Ok){
		$("#login-msg").css("color","green");
	}else{
		$("#login-msg").css("color","red");
	}

	$("#login-msg").html(Msg);
	window.setTimeout(function(){ $("#login-msg").html("");},5000);
}


function evaluate(str){
	return window['eval']("("+str+")");
}

$(document).ready(
	function(){
		main();
	}
);
*/