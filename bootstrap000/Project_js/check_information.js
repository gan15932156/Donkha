var base_url = "http://18.140.49.199/Donkha/Project_controller/";
function check_std_code(query){
   	$.ajax({
     	url:base_url+"check_std_code",
    	method:"POST",
     	data:{query:query},
     	success:function(data){
       		$('#result_std_code').html(data);
     	}
   	})
}
function check_username(username){
 	$.ajax({
     	url:base_url+"check_username",
     	method:"POST",
     	data:{username:username},
     	success:function(data){
       		$('#result_username').html(data);
     	}
   	})
} 
function check_name(name,state){
	if(state == "1"){
		$.ajax({
		    url:base_url+"check_staff_name",
		    method:"POST",
		    data:{name:name.value},
		    success:function(data){
		    	$('#result_staff_name').html(data);
		    }
		})
	}
	else{
		$.ajax({
		 	url:base_url+"check_member_name",
		 	method:"POST",
		 	data:{name:name.value},
		 	success:function(data){
		   		$('#result_member_name').html(data);
		 	}
		})
	} 
}
function check_id_card(obj){
    var pid = obj.value;
    pid = pid.toString().replace(/\D/g,'');
    if(pid.length == 13)
    {
    	var sum = 0;
       	for(var i = 0; i < pid.length-1; i++)
       	{
          	sum += Number(pid.charAt(i))*(pid.length-i);
       	}
       	var last_digit = (11 - sum % 11) % 10;
       	$("#id_card").val(pid);
       	if(pid.charAt(12) != last_digit)
       	{
         	$("#id_card").val('');
         	$("#idcard").val("");
         	alert("กรอกเลขบัตรประชาชนไม่ถูกต้อง");
       	}
    }
    else
    {
    	$("#id_card").val('');
       	$("#idcard").val('');
       	alert("กรอกเลขบัตรประชาชนไม่ครบ");
    }
}
function autoTab2(obj,typeCheck){
 	if(typeCheck==1){
    	var pattern=new String("_-____-_____-__-_"); // กำหนดรูปแบบในนี้
       	var pattern_ex=new String("-"); // กำหนดสัญลักษณ์หรือเครื่องหมายที่ใช้แบ่งในนี้     
   	}
   	else{
       	var pattern=new String("___-___-____"); // กำหนดรูปแบบในนี้
       	var pattern_ex=new String("-"); // กำหนดสัญลักษณ์หรือเครื่องหมายที่ใช้แบ่งในนี้                 
    }
   	var returnText=new String("");
   	var obj_l=obj.value.length;
   	var obj_l2=obj_l-1;
   	for(i=0;i<pattern.length;i++){           
   	    if(obj_l2==i && pattern.charAt(i+1)==pattern_ex){
   	        returnText+=obj.value+pattern_ex;
   	        obj.value=returnText;
   	    }
   	}

   	if(obj_l>=pattern.length){
   	    obj.value=obj.value.substr(0,pattern.length);           
   	}
   	
} 
function set_phone_number(obj){
	var phone_numer = obj.value;
	phone_numer = phone_numer.toString().replace(/\D/g,'');
	if(phone_numer.length == 10){
		$("#phone_number").val(phone_numer);
	}
	else{
		alert("กรอกเบอร์โทรศัพท์ไม่ครบ");
		$("#phone_number").val("");
		$("#phonenumber").val("");	
	}
}