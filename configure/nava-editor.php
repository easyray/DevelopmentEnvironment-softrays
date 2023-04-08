<?php 
	if( 
	 	isset($_POST["task"]) &&
		"save-page" == $_POST["task"]
	){
		file_put_contents($_POST["filename"],$_POST["htm-stuff"] );
	}

	$Code = file_get_contents($_POST['filename']);

?><!DOCTYPE html>
<html>
	<head>
		<style>
			.rownr {
				overflow-y: hidden; 
				background-color: rgb(105,105,105); 
				color: white; 
				text-align: right; vertical-align:top
			}
			.txt {
				width: 95%; 
				overflow-x: scroll
			}

			.rownr,.txt{
				font-size: 16px;
			}
		</style>
	</head>
	<body onload="initialize()" onresize="onresize_sub()">
        <iframe style="position: absolute; width: 90%; height: 400px;background-color: #eee; margin-left: 50px; display: none;" src="/front-end/modules/prototype/forms.php" id="form-frame" ></iframe>

        <iframe style="position: absolute; width: 90%; height: 400px;background-color: #eee; margin-left: 50px; display: none;" src="/front-end/modules/prototype/pictures.php" id="pix-frame" ></iframe>
        <iframe style="position: absolute; width: 90%; height: 400px;background-color: #eee; margin-left: 50px; display: none;" src="/front-end/modules/prototype/videos.php" id="video-frame" ></iframe>        
		<h1 style="display:block; text-align: center;">Web Editor</h1>
		<div style="border: thin solid #ccc; 
		min-height: 30px; padding: 10px">
            <input type="button" value="Design" onclick="toggleView(this)" />
            <input type="button" value="Pictures" onclick="showPixFrame(this)" />
            <input type="button" value="Videos" onclick="showVideoFrame(this)" />
			<input type="button" value="Forms" onclick="showFormFrame(this)" />
			<input type="radio" name="f&b" id="object-prepend"  />
			<input type="radio" name="f&b" id="object-append" checked />
		</div>
		<form method="post">
		<div>
			<textarea class="rownr" id="rownr" rows="20" cols="3" readonly="true"></textarea>
			<span>
				<textarea name="htm-stuff" class="txt" id="txt" rows="20" nowrap="nowrap" wrap="off" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" 
			onclick="selectionchanged(this)" onkeyup="keyup(this,event)" 
			oninput="input_changed(this)" 
			onscroll="scroll_changed(this)"><?php 
echo htmlentities($Code);
			?></textarea>
				<br/>
				<br/>
				<label>Current position:</label>
				<input id="sel_in" style="border-style:none" readonly="true"/>
				<input id="selector_in" style="border-style:none" readonly="true"/>
			</span>
			<iframe id="myframe" height="500" style="overflow: scroll; width: 98%; display: none;"></iframe>
		</div>

		<input type="hidden" name="filename" value="<?php echo  $_POST["filename"] ; ?>" />
		<input type="submit" value="Save" />
		<input type="hidden" name="task" value="save-page" />
		</form>
	<script type="text/javascript">
		//------------------------------------
		function input_changed(obj_txt){

			obj_rownr = obj_txt.parentElement.parentElement.getElementsByTagName('textarea')[0];
			cntline = count_lines(obj_txt.value);
			if(cntline == 0) cntline = 1;
			tmp_arr = obj_rownr.value.split('\n');
			cntline_old = parseInt(tmp_arr[tmp_arr.length - 1], 10);
			// if there was a change in line count
			if(cntline != cntline_old)
			{
				obj_rownr.cols = cntline.toString().length; // new width of txt_rownr
				//populate_rownr(obj_rownr, cntline);
				scroll_changed(obj_txt);
			}
			selectionchanged(obj_txt);
			
			

			//x.contentDocument.innerHTML = obj_txt.parentElement.parentElement.getElementsByTagName('textarea')[1].value;

		}
		//------------------------------------
		function scroll_changed(obj_txt)
			{
				obj_rownr = obj_txt.parentElement.parentElement.getElementsByTagName('textarea')[0];
				scrollsync(obj_txt,obj_rownr);
			}
			
		//------------------------------------
		function scrollsync(obj1, obj2)
			{
				// scroll text in object id1 the same as object id2
				obj2.scrollTop = obj1.scrollTop;
			}
		//------------------------------------
		function selectionchanged(obj)
		{
			var substr = obj.value.substring(0,obj.selectionStart).split('\n');
			var row = substr.length;
			var col = substr[substr.length-1].length;
			var tmpstr = '(' + row.toString() + ',' + col.toString() + ')';
			// if selection spans over
			if(obj.selectionStart != obj.selectionEnd)
			{
				substr = obj.value.substring(obj.selectionStart, obj.selectionEnd).split('\n');
				row += substr.length - 1;
				col = substr[substr.length-1].length;
				tmpstr += ' - (' + row.toString() + ',' + col.toString() + ')';
			}
			obj.parentElement.getElementsByTagName('input')[0].value = tmpstr;
		}

		//------------------------------------
		function keyup(obj, e)
		{
				if(e.keyCode >= 33 && e.keyCode <= 40) // arrows ; home ; end ; page up/down
					selectionchanged(obj, e.keyCode);
		}

		//------------------------------------
		function initialize(){
			var LineNumBox = document.getElementsByClassName('rownr')[0];
			var LineNumString = "";
			for(var i=1; i< 5000; i++){
				LineNumString += i + "\n";
			}
			LineNumBox.value = LineNumString;

			document.getElementById("myframe").
			contentDocument.
			addEventListener('click',function(e){
				var Str = "";
				G_Elem = e.target;

				Str = G_Elem.tagName.toLowerCase();
				if(G_Elem.id ){
					Str+="#"+G_Elem.id;
				}
				if(G_Elem.className){
					Str += "."+G_Elem.className;
				}
				document.getElementById('selector_in').value = Str;

			 }
			);
			addCSS();

			document.getElementById("myframe").
			contentDocument.addEventListener(
				"keypress",
				editFrameText
			);

            document.getElementById("myframe").
            contentDocument.addEventListener(
                "keydown",
                checkSpeciakey
            );

		}

		//------------------------------------
		function count_lines(str){
			return str.split('\n').length;
		}

		//------------------------------------
		function addCSS(){
			
			var cssLink = document.createElement("link");
			cssLink.href = "/front-end/css/prototype.css?v="+(new Date().getTime()); 
			cssLink.rel = "stylesheet"; 
			cssLink.type = "text/css"; 
			document.getElementById("myframe").contentDocument.head.appendChild(cssLink);

			cssLink = document.createElement("link");
			cssLink.href = "/front-end/css/main.css?"+(new Date().getTime()); 
			cssLink.rel = "stylesheet"; 
			cssLink.type = "text/css";
			document.getElementById("myframe").contentDocument.head.appendChild(cssLink);

		}


		//------------------------------------
		function toggleView(button){
			//debugger;
			var obj_txt = document.getElementById("txt");
			var TxtCode;

			if('Design' == button.value){
				document.getElementById("rownr").style.display="none";
				document.getElementById("txt").style.display="none";
				document.getElementById("myframe").style.display="block";
				button.value = "Source Code";
				TxtCode = obj_txt.parentElement.parentElement.getElementsByTagName('textarea')[1].value.replace(/-->/g,"-- >");
				//TxtCode = TxtCode.replace(/(<\?php)(([^?]|\?[^>])*)(\?)>/g,'<!--php $2 -->');
				TxtCode=TxtCode.replace(/(<\?php)/g,'<!--php');
				TxtCode=TxtCode.replace(/(\?)>/g,'?-->');

				TxtCode = TxtCode.replaceAll('submit','button');
				document.getElementById("myframe").contentDocument.body.innerHTML = TxtCode;
			}else{
				document.getElementById("rownr").style.display="inline-block";
				document.getElementById("txt").style.display="inline-block";
				document.getElementById("myframe").style.display="none";
				button.value = "Design";
				
				TxtCode = document.getElementById("myframe").contentDocument.body.innerHTML;
				TxtCode = TxtCode.replace(/<!--php/g,'<'+'?php');
				TxtCode = TxtCode.replace(/\?-->/g,'?'+'>');
				TxtCode = TxtCode.replace(/-- >/g,'-->');
				document.getElementById("txt").value = TxtCode;
			}
		}

	function relish(str){
		str = str.replace(/<\?php/g, '<img width="25" src="photos/Capture.PNG" /><'+'?php ' );
		console.log(str);
		return str;
	}


		//------------------------------------
		function editFrameText(e){
			var ch;
			if('Enter'==e.key){
				ch = '<br />\n';
			}else{
				ch = e.key;
			}


			if(G_Elem.value){
				if(document.getElementById('object-append').checked){
					if(G_Elem.type=="text"){
						G_Elem.outerHTML+=ch ;
					}else{
						G_Elem.value+= ch;
					}
				}else{
					if(G_Elem.type=="text"){
						G_Elem.outerHTML=ch+G_Elem.outerHTML ;
					}else{
						G_Elem.value = ch+G_Elem.value;
					}
				}
			}else if(G_Elem.innerHTML){
				if(document.getElementById('object-append').checked){
					G_Elem.innerHTML+=ch ;
				}else{
					G_Elem.innerHTML = ch+G_Elem.innerHTML;
				}
			}
		}
//---------------------------------------
        function checkSpeciakey(e){
            switch(e.keyCode){
                case 8: 
                    if(G_Elem.value){
                        G_Elem.value= G_Elem.value.substr(0,G_Elem.value.length-1) ;
                    }else if(G_Elem.innerHTML){
                        G_Elem.innerHTML= G_Elem.innerHTML.substr(0,G_Elem.innerHTML.length-1);
                    }
                break;
            }
        }
//---------------------------------------
    function removePixFrame(){
        if(undefined != window.G_Elem &&
            undefined !=window.G_Elem.innerHTML
        ){
            G_Elem.innerHTML+= '<img src="'+
            document.getElementById("pix-frame").contentDocument.
            getElementById("picture").value+
            '" width="100" />';
        }
        document.getElementById("pix-frame").style.display="none";
    }

//-----------------------------------------------
function removeVIdeoFrame(){
        if(undefined != window.G_Elem &&
            undefined !=window.G_Elem.innerHTML
        ){
            G_Elem.innerHTML+=
	'<video controls autoplay  >'+ 
	'<source src="/front-end/videos/'+
	document.getElementById("video-frame").contentDocument.
            getElementById("video-dd").value+
	'" type="video/mp4" />'+
 	'</video>';
 	document.getElementById("video-frame").style.display="none";
 	}
}
//-----------------------------------------------
    function showPixFrame(){
        document.getElementById("pix-frame").style.display="block";   
    }
//--------------------------------------------
	function showVideoFrame(){
		document.getElementById('video-frame').style.display = "block";
	}
//--------------------------------------------
    function closeFormFrame(){
        if(undefined != window.G_Elem &&
            undefined !=window.G_Elem.innerHTML
        ){
            G_Elem.innerHTML+= 
            document.getElementById("form-frame").contentDocument.
            getElementById("content").value;
        }
        document.getElementById("form-frame").style.display="none";        
    }
//---------------------------====================
    function showFormFrame(){
        document.getElementById("form-frame").style.display="block";   
    }
</script>
	</body>
</html><?php

function removeHComment($str){
	#code
	$str = str_replace('?'.'>', '?-->' , $str);
	return str_replace('<'.'?', '<!--?', $str);
}
