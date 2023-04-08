function ColorPicker(JsonData){
/*
	JsonData.Canvas
	JsonData.ImageUrl
	JsonData.RgbSelector
	JsonData.HexSelector
	JsonData.SampleBox
*/
	var canvas      = $(JsonData.Canvas).get(0).getContext("2d");
	var colorpicker = this;
	
	
	// create an image object and get it’s source
	var img = new Image();
	img.src = JsonData.ImageUrl ;
	
	
	
	// copy the image to the canvas
	$(img).load(function(){
		//console.log(canvas.toString());
		canvas.drawImage(img,0,0);
	});

	this.rgbToHex = function(R,G,B) {
		return this.toHex(R)+this.toHex(G)+ this.toHex(B)
	}
	
	this.toHex = function(n) {
		n = parseInt(n,10);
		if (isNaN(n)) return "00";
		n = Math.max(0,Math.min(n,255));
		
		return "0123456789ABCDEF".charAt((n-n%16)/16)  + 
		"0123456789ABCDEF".charAt(n%16);
	}
	
	$(JsonData.Canvas).click(function(event){
	  //getting user coordinates
	  var x = event.pageX - this.offsetLeft;
	  var y = event.pageY - this.offsetTop;
	  
	  
	  //getting image data and RGB values
	  var img_data= canvas.getImageData(x, y, 1, 1).data;
	  var R       = img_data[0];
	  var G       = img_data[1];
	  var B       = img_data[2];  
	  var rgb     = R + ',' + G + ',' + B;
	  
	  var bgcolor;

	  // convert RGB to HEX
	  var hex = colorpicker.rgbToHex(R,G,B);

	  // making the color the value of the input
	  $(JsonData.RgbSelector).val(rgb);
	  $(JsonData.HexSelector).val('#' + hex);
	  
	  bgcolor = "#"+hex;
	  
	  $(JsonData.SampleBox).get(0).style.backgroundColor = bgcolor;
	  
	});
	
}
