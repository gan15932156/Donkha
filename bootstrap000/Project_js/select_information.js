var base_url = "http://127.0.0.1/Donkha/Project_controller/";
function readURL(input) {
  	if (input.files && input.files[0]) {
    	var reader = new FileReader();
    	reader.onload = function (e) {
      		$('#show_image').attr('src', e.target.result);
    	}
    	reader.readAsDataURL(input.files[0]);    
  	}
}
function readURL_profile(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $('#show_image_pic').attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
    }
  }
  function readURL_singa(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $('#show_image_signa').attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
    }
  }
$(document).ready(function(){    
    $("#std_code").change(function(){
      var stu_code = $(this).val();
      check_std_code(stu_code);  
    });
    $("#username").change(function(){
      var username = $(this).val();
      check_username(username);  
    });
    $('#PROVINCE_ID').change(function(){
    	var prov_id=$(this).val();
      	$.ajax({
        	url:base_url+"getAmphur/",
        	method:'post',
        	data:{prov_id: prov_id},
        	dataType:'json',
        	success: function(response)
        	{
        		$('#AMPHUR_ID').empty();
        	  	$('#DISTRICT_CODE').empty();
        	  	$('#zipcode').val("");
        	  	$('#AMPHUR_ID').find('option').not(':first').remove();
        	  	$.each(response,function(index,data)
        	  	{
        	    	$('#AMPHUR_ID').append('<option value="'+data['AMPHUR_ID']+'">'+data['AMPHUR_NAME']+'</option>');
        	  	});
        	}
      	});
    });
    $('#AMPHUR_ID').change(function(){
      	var amp_id=$(this).val();
      	$.ajax({
        	url:base_url+"getDist/",
        	method:'post',
        	data:{amp_id: amp_id},
        	dataType:'json',
        	success: function(response)
        	{
          		$('#DISTRICT_CODE').empty();      
          		$('#zipcode').val("");
          		$('#DISTRICT_CODE').find('option').not(':first').remove();
          		$.each(response,function(index,data)
          		{
            		$('#DISTRICT_CODE').append('<option value="'+data['DISTRICT_CODE']+'">'+data['DISTRICT_NAME']+'</option>');
          		});
        	}
      	});
    });
    $('#DISTRICT_CODE').change(function(){
      	var dist_id=$(this).val();
      	if(dist_id != '')
      	{
        	$.ajax({
          		url:base_url+"getZip/",
          		method:"POST",
          		data:{dist_id:dist_id},
          		success:function(data)
          		{
            		$('#zipcode').val("");
            		$('#zipcode').val(data);
          		}
        	});
      	}
      	else
      	{
        	$('#zipcode').val('asdasd');
      	}
    }); 
});