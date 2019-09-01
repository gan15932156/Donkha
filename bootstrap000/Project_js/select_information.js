$(document).ready(function()
{
    function logout(){
      location.replace("<?php  echo base_url().'Project_controller/logout'; ?>");
    }
    function readURL(input) {
        if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e) {
            $('#show_imagee').attr('src', e.target.result);
          }
          reader.readAsDataURL(input.files[0]);
        }          
    }
    function check_std_code(query){
        $.ajax({
          url:"<?php echo base_url('index.php/Project_controller/check_std_code'); ?>",
          method:"POST",
          data:{query:query},
          success:function(data){
            $('#result_std_code').html(data);
          }
        })
      }
    function check_username(username){
      $.ajax({
        url:"<?php echo base_url('index.php/Project_controller/check_username'); ?>",
        method:"POST",
        data:{username:username},
        success:function(data){
          $('#result_username').html(data);
        }
      })
    }
    $("#id_card").blur(function()
    {
      var pid = $(this).val();
      pid = pid.toString().replace(/\D/g,'');
      if(pid.length == 13)
      {
        var sum = 0;
        for(var i = 0; i < pid.length-1; i++)
        {
          sum += Number(pid.charAt(i))*(pid.length-i);
        }
        var last_digit = (11 - sum % 11) % 10;
        if(pid.charAt(12) != last_digit)
        {
          $("#id_card").val("กรอกไม่ถูกต้อง");
        }
      }
      else
      {
        $("#id_card").val('กรอกไม่ครบ');
      }
    }); 
    $("#std_code").keyup(function(){
      var stu_code = $(this).val();
      check_std_code(stu_code);  
    });
    $("#username").keyup(function(){
      var username = $(this).val();
      check_username(username);  
    });
    $('#PROVINCE_ID').change(function(){
      var prov_id=$(this).val();
      $.ajax({
        url:'<?=base_url("index.php/Project_controller/getAmphur/")?>',
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
        url:'<?=base_url("index.php/Project_controller/getDist/")?>',
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
          url:"<?=base_url()?>index.php/Project_controller/getZip/",
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