<?php

	include ("functions.php");

	
	


 ?><!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/style.css" />
</head>
<body>
    <div id="container">
        
        <div id="my-logo"><img src="pix/logo.png" /> </div>
		<?php include("menu.php"); ?>
		<h2> Module Routing</h2>
        <div id="our-slide-show">
			<h1>Default Module</h1>
		
        </div>
	</div>
	<script >
		function editItem(obj,prefix,prefix2){
		
		
			var MyId = obj.id.split("-")
			var len = MyId.length;

			MyId = MyId[len-1];
			
			var spanid1 = prefix+ MyId;
			var spanid2 = prefix2 + MyId;
			console.log(spanid1);

			document.getElementById(spanid1).innerHTML = "";
			
			var  FrmBox = document.getElementById(spanid2);
			
			FrmBox.style.display = "inline" ;
			var Frm = FrmBox.getElementsByTagName("form")[0];
			
		}
	</script>
</body>
</html>