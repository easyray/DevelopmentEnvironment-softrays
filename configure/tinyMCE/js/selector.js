// JavaScript Document
$(document).ready(function()
{ 
    $('#rooms').hide(); // hides  room facility on document load
	$('#hall').hide();  // hides  hall facility on document load
	
/*  This method deletes the booking the customer wants to delete */  

$('.delete').click(function()
		 {
			 var bookingID = $(this).val();
			 alert(bookingID);
			 $.ajax({
				 url:'tryCart.php',
				 type:"GET",
				 data:{'key':bookingID},
				 success: function(data)
				 {
					 document.location='tryCart.php';
				 }
				 });
				 return false;
		 });
		 
		 /*  Ends here   */
			
  /*  This methos determine the available facility type chosen by the customer */
  
	$('#facility').change(function()
	{
		var facilityType = $(this).val();
		
		if (facilityType=='Rooms')
		{
			$('#rooms').show();
			$('#hall').hide();
		}else if (facilityType=='Hall'){
			$('#rooms').hide();
			$('#hall').show();
		} else {
			$('#rooms').hide();
			$('#hall').hide();
		}
		
		var id = $("#facility option:selected").attr('id');
		var facilityOption;
		//alert(id);
		$.ajax({
			url:"facilityType.php",
			type:"POST",
			dataType:"JSON",
			data:{'idx':id},
			success: function(data)
			{
				facilityOption= '<select name="roomType" id="roomType"><option>--Select Facility--</option>';
				$.each(data,function(key,value){
					
				facilityOption +='<option id='+value.idx+'>'+value.TypeName+'</option>';
			 });
			  facilityOption += '</select>'; 
			  //alert(facilityOption);
			  $('#roomType').hide();
			  $('#opt').html(facilityOption);
			}
			});
	});
	
	
	/*   Ends here  */
	
	/*  This method takes care of the room type choosn bY The customer and generates amount based on it*/
	
	/*$("#roomType").change(function()
	{
		var roomType = $("#roomType option:selected").attr("id"); // the id from the option box
		alert(roomType);
		$.ajax({url:"roomAmount.php",
		type:"POST",
		data:{'room':roomType},
		success: function(data)
		{
			$('#faciltyTypeAmount').val(data);
		    var totalAmount = parseFloat($('#numberofrooms').val() * data);
			//alert(id);
		    $('#totalamount').val(totalAmount);
		},
		complete: function(data)
		{
			$('form')
			.find('input')
			.filter(':not(#email):not(#firstname):not(#middlename):not(#surname):not(#phonenumber):not(#email):not(#contactaddress):not(#faciltyTypeAmount):not(.key)')
			.val('');
		}
			});
	});*/
	
	/*      Ends here        */
	
	/*  This method takes care of the room type choosn bY The customer and generates amount based on it*/
	
	$(document).delegate("#roomType","change",function()
	{
		var roomType = $("#roomType option:selected").attr("id");  // the id from the option box
		//alert(roomType);
		$.ajax({url:"roomAmount.php",
		type:"POST",
		data:{'room':roomType},
		success: function(data)
		{
			//alert(data);
			$('#faciltyTypeAmount').val(data);
		    var totalAmount = parseFloat($('#numberofrooms').val() * data);
			//alert(id);
		    $('#totalamount').val(totalAmount);
		},
		complete: function(data)
		{
			$('form')
			.find('input')
			.filter(':not(#email):not(#firstname):not(#middlename):not(#surname):not(#phonenumber):not(#email):not(#contactaddress):not(#faciltyTypeAmount):not(.key)')
			.val('');
		}
			});
	});
	
	/*      Ends here        */
	
	/*  This method makes an ajax call to the server and calculate the number of days the visitor is willing to spend*/
	
	$('#checkoutdate').blur(function()
	{
		var checkindate = $('#checkindate').val();
		var checkoutdate = $(this).val();
		var faciltyTypeAmount = $('#faciltyTypeAmount').val();
		$.ajax({url:"calculateDate.php",
		type:"GET",
		data:{'checkindate':checkindate,'checkoutdate':checkoutdate},
		success: function(data)
		{
		var totalAmount = parseFloat(data* faciltyTypeAmount*$('#numberofrooms').val());
		$('#totalamount').val('');
		$('#totalamount').val(totalAmount);
		}
		});
		
	});
	
	/*   Ends here        */
	
	
	/*  this method calculates amount based on the previous booking made for editing*/
	
	    var checkindate  =  $('#checkindate').val();
		var checkoutdate =  $('#checkoutdate').val();
		var faciltyTypeAmount = $('#faciltyTypeAmount').val();
		$.ajax({url:"calculateDate.php",
		type:"GET",
		data:{'checkindate':checkindate,'checkoutdate':checkoutdate},
		success: function(data)
		{
		var totalAmount = parseFloat(data* faciltyTypeAmount*$('#numberofrooms').val());
		$('#totalamount').val('');
		$('#totalamount').val(totalAmount);
		}
		});
	          /* End of document ready method call  */
			  
			  
	    /* This method brings back the room types available            */
		
		
		var id = $("#facility option:selected").attr('id');
		var facilityOption;
		var choosenRoom = $('#choosenRoom').val();
		$.ajax({
			url:"facilityType.php",
			type:"POST",
			dataType:"JSON",
			data:{'idx':id},
			success: function(data)
			{
				facilityOption= '<select name="roomType" id="roomType"><option>--Select Facility--</option>';
				if(choosenRoom!='')
					{
						facilityOption +='<option selected="selected">'+choosenRoom+'</option>';
					}
				$.each(data,function(key,value){
				facilityOption +='<option id='+value.idx+'>'+value.TypeName+'</option>';
			 });
			  facilityOption += '</select>'; 
			  $('#roomType').hide();
			  $('#opt').html(facilityOption);
			}
			});
		
		/*     Ends here      */
			  
			  
			  /*  This method calculates the total amount based on number of room chosen   */
	
	$('#numberofrooms').blur(function()
	{   var daysToSpend = $('#daysToSpend').val();
		var faciltyTypeAmount = $('#faciltyTypeAmount').val();
		if (daysToSpend!=0)
		var totalAmount = parseFloat($(this).val() * faciltyTypeAmount*daysToSpend);
		else 
		var totalAmount = parseFloat($(this).val() * faciltyTypeAmount);
		$('#totalamount').val('');
		$('#totalamount').val(totalAmount);
		
	});
	
	
	/*   Ends here           */
	
	
	
	/* This area takes take of the return errors and mark them with border color red  */
	
	
	$('input,textarea').css({border:"1px solid #e8e8e8"});
				
			var erlog = $(".tabErrorLog").val();	
			if(erlog !=''){
				var errorArray = erlog.split(",");
				
				for(var i =0; i < errorArray.length; i++)
				{
					
					$('input[name='+errorArray[i]+'],textarea[name='+errorArray[i]+'],select[name='+errorArray[i]+']').css({border:"1px solid #A00"});
					
				}
			}	
			
			/*       Ends here         */
			
			
  /*  This method takes care of more booking and clear all form inputs required for the new booking   */
			
			$('#morebooking').click(function()
			{
				$('form').find('input').filter(':not(#email):not(#firstname):not(#middlename):not(#surname):not(#phonenumber):not(#email):not(#contactaddress):not(#faciltyTypeAmount):not(.key)')
				.val('');
				return false;
			});	
			
	/*    Ends here           */
		
	});