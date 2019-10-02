<script type="text/javascript">
  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $('#show_image').attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);    
    }
  }
  function check_std_code(query){
    $.ajax({
      url:"<?php echo base_url("index.php/Project_controller/check_std_code"); ?>",
      method:"POST",
      data:{query:query},
      success:function(data){
        $('#result_std_code').html(data);
      }
    })
  }
  function check_username(username){
    $.ajax({
      url:"<?php echo base_url("index.php/Project_controller/check_username"); ?>",
      method:"POST",
      data:{username:username},
      success:function(data){
        $('#result_username').html(data);
      }
    })
  } 
  function check_name(name){
    $.ajax({
      url:"<?php echo base_url("index.php/Project_controller/check_staff_name"); ?>",
      method:"POST",
      data:{name:name},
      success:function(data){
        $('#result_staff_name').html(data);
      }
    })
  } 
  $(document).ready(function()
  {   
    $("#staff_form").submit(function(event) {
			event.preventDefault();
			$.ajax({
		    url: "<?=base_url("index.php/Project_controller/staff_update/");?>"+$("#staff_id").val(),
		    type:"post",
        data:new FormData(this),
        processData:false,
        contentType:false,
        cache:false,
        async:false,
		    success: function(response){
          alert("บันทึกข้อมูลสำเร็จ");
			    window.open("<?=base_url("index.php/Project_controller/manage_staff");?>", "_self");    		
		    },
		    error: function(){ alert("error"); }
      });
		}); 
    $("#std_code").change(function(){
      var stu_code = $(this).val();
      check_std_code(stu_code);  
    });
    $("#username").change(function(){
      var username = $(this).val();
      check_username(username);  
    });
    $("#name").change(function(){
      var name = $(this).val();
      check_name(name);  
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
  });
</script>
 <div class="col-md-12 text-center" >
  <div class="row text-center">
    <div class="col-md-12">
      <div  class="row">
        <div class="col-md-12 ">
          <h4 class="text-center"><B>แก้ไขพนักงาน</B></h4>
        </div>
        <div class="col-md-12 text-center">
          <?php foreach($staff->result() as $row){ ?>
            <form enctype="multipart/form-data" name="staff_form" id="staff_form">
              <div class="row">
                <div class="form-group col-4">  
                  <img id="show_image" width="30%" height= "65%" src="<?php echo $row->staff_pic;?>" alt="your image" style="border: solid 1px #c0c0c0;" /><figcaption>รูปประจำตัว</figcaption>
                  <input onchange="readURL(this);" type="file" class="form-control " name="pic" id="pic">                
                </div>  
                <div class="form-group col-8" align="left">
                  <div class="row"> 
                    <div class="col-12">
                      <div class="row">
                        <div class="form-group col-3"><label for="name">รหัสนักเรียน</label></div>
                        <div class="form-group col-4">
                          <input type="hidden" name="staff_id" value="<?php echo $row->staff_id; ?>">
                          <input type="text" class="form-control " id="std_code" name="std_code" readonly="" value="<?php echo $row->stu_code; ?>">
                          <div id="result_std_code"></div>
                        </div>
                        <div class="form-group col-3">
                          <label for="name">คำนำหน้า</label>
                        </div>
                        <div class="form-group col-2">
                          <select  id="title" name="title" class="form-control" >
                            <option <?php if($row->staff_title=="เด็กชาย"){echo "selected";}?>>เด็กชาย</option>
                            <option <?php if($row->staff_title=="เด็กหญิง"){echo "selected";}?>>เด็กหญิง</option>
                            <option <?php if($row->staff_title=="นาย"){echo "selected";}?>>นาย</option>
                            <option <?php if($row->staff_title=="นางสาว"){echo "selected";}?>>นางสาว</option>
                          </select>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-3">
                          <label for="name">ชื่อ-นามสกุล</label></div>
                        <div class="form-group col-4">
                          <input type="text" class="form-control " id="name" name="name" required="" value="<?php echo $row->staff_name; ?>">     
                          <div id="result_staff_name"></div>
                        </div>
                        <div class="form-group col-md-3">
                          <label for="name">ระดับการศึกษา</label>
                        </div>
                        <div class="form-group col-md-2"> 
                          <select  id="edu_level" name="edu_level" class="form-control" >
                            <?php 
                              foreach ($base_edu_level->result() as $row_edu) { ?>      
                                <option value="<?=$row_edu->edu_id;?>" <?php if($row->edu_id== $row_edu->edu_id){echo "selected";}?>> <?=$row_edu->edu_name;?> </option>
                            <?php } ?>
                          </select>
                        </div>
                      </div> 
                      <div class="row">
                        <div class="form-group col-md-3">
                          <label for="name">เลขบัตรประชาชน</label>
                        </div>
                        <div class="form-group col-md-4">
                          <input type="text" class="form-control " name="id_card" id="id_card" required="" value="<?php echo $row->staff_id_card; ?>">
                        </div>
                        <div class="form-group col-md-2">
                          <label for="name">ตำแหน่ง</label>
                        </div> 
                        <div class="form-group col-md-3">
                          <select  id="permiss" name="permiss" class="form-control" >
                            <?php 
                              foreach ($base_permiss->result() as $row_permiss) {
                            ?>
                                <option value="<?=$row_permiss->level_id;?>" <?php if($row->level_id== $row_permiss->level_id){echo "selected";}?>> <?=$row_permiss->level_name;?> </option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>  
                      <div class="row">
                        <div class="form-group col-md-2">
                          <label>ปีที่เข้าศึกษา</label>
                        </div>   
                        <div class="form-group col-md-3">
                          <input id="yofadmis" name="yofadmis" require  class="form-control "  type="number" placeholder="ปปปป" min="<?php echo date('Y',strtotime('-6 year'))+543; ?>" max="<?php echo date('Y')+543; ?>" value="<?=intval($row->staff_yofadmis)+543;?>">
                        </div>                
                        <div class="form-group col-md-1">
                          <label for="name" style="width:50px">ที่อยู่</label>
                        </div>   
                        <div class="form-group col-md-6">
                          <input type="text" class="form-control " name="address" id="address" required="" placeholder="บ้านเลขที่ หมู่ ถนน ซอย" value="<?=$row->staff_address;?>">
                        </div>                                         
                      </div>                                     
                    </div>
                  </div>
                </div>
                <div class="form-group col-12" align="left">
                  <div class="row">
                    <div class="form-group col-md-1">
                      <label for="name">จังหวัด</label>
                    </div>  
                    <div class="form-group col-md-3">
                      <select  id="PROVINCE_ID" name="PROVINCE_ID" class="form-control" >
                        <?php 
                          foreach ($base_province->result() as $row_pro) {
                        ?>
                            <option value="<?=$row_pro->PROVINCE_ID;?>" <?php if($row->PROVINCE_ID== $row_pro->PROVINCE_ID){echo "selected";}?>> <?=$row_pro->PROVINCE_NAME;?> </option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="form-group col-md-1">
                      <label for="name">อำเภอ</label>
                    </div>
                    <div class="form-group col-md-3">
                      <select  id="AMPHUR_ID" name="AMPHUR_ID" class="form-control" >
                        <?php 
                          foreach ($base_amphures->result() as $row_amp) {         
                        ?>
                            <option value="<?=$row_amp->AMPHUR_ID;?>" <?php if($row->AMPHUR_ID== $row_amp->AMPHUR_ID){echo "selected";}?>> <?=$row_amp->AMPHUR_NAME;?> </option>
                        <?php  } ?>                                          
                      </select>
                    </div>
                    <div class="form-group col-md-1">
                      <label for="name">ตำบล</label>
                    </div>
                    <div class="form-group col-md-3">
                      <select  id="DISTRICT_CODE" name="DISTRICT_CODE" class="form-control" >
                        <?php 
                          foreach ($base_districts->result() as $row_dist) {
                        ?>
                            <option value="<?=$row_dist->DISTRICT_CODE;?>" <?php if($row->DISTRICT_CODE== $row_dist->DISTRICT_CODE){echo "selected";}?>> <?=$row_dist->DISTRICT_NAME;?> </option>
                        <?php  } ?>
                      </select>
                    </div>                                      
                  </div>
                  <div class="row">
                    <div class="form-group col-md-2">
                      <label for="name">รหัสไปรษณีย์</label>
                    </div>
                    <div class="form-group col-md-2">
                      <input type="text" class="form-control " name="zipcode" id="zipcode" value="<?php echo $row->zipcode; ?>">
                    </div>                                  
                    <div class="form-group col-md-1">
                      <label style="width:100px">รูปประจำตัว</label>
                    </div> 
                    <div class="form-group col-md-7">
                      <input type="text" id="show_image" name="show_image" class="form-control" readonly="" value="<?php echo $row->staff_pic; ?>">
                    </div>   
                  </div>
                  <div class="row">
                    <div class="form-group col-md-12 text-center"><br>
                      <a href="<?=base_url("index.php/Project_controller/manage_staff");?>" class="btn btn-outline-success">ย้อนกลับ</a>
                      <button type="submit" class="btn btn-outline-primary" id="submit">ตกลง</button>
                    </div>
                  </div>
                </div>   
              </div> 
            </form> 
          <?php  }  ?>   
        </div>
      </div>
    </div>                   
  </div>        
</div>                                   