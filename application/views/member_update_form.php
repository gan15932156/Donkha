<script type="text/javascript" src="<?php  echo base_url();?>bootstrap000/Project_js/select_information.js"></script>  
<script type="text/javascript" src="<?php  echo base_url();?>bootstrap000/Project_js/check_information.js"></script>  
<script type="text/javascript">
  $(document).ready(function()
  { 
    $("#show_image_pic").click(function() {
      $("input[id='pic_member']").click();   
    });
    $("#show_image_signa").click(function() {
      $("input[id='pic_singna']").click();   
    });      
    $("#member_form").submit(function(event) {
			event.preventDefault();
			$.ajax({
		    url: "<?=base_url("index.php/Project_controller/member_update/");?>"+$("#member_id").val(),
		    type:"post",
        data:new FormData(this),
        processData:false,
        contentType:false,
        cache:false,
        async:false,
		    success: function(response){
          alert("บันทึกข้อมูลสำเร็จ");
			    window.open("<?=base_url("index.php/Project_controller/manage_member");?>", "_self");    		
		    },
		    error: function(){ alert("error"); }
      });
		});
  });
</script> 
<div class="col-md-12 text-center" >
  <div class="row text-center">
    <div class="col-md-12">
      <div  class="row scroller">
        <div class="col-md-12 ">
          <h4 class="text-center"><B>แก้ไขสมาชิก</B></h4>
        </div>
        <div class="col-md-12 text-center">
          <?php foreach($member_after->result() as $row){ 
            if($row->std_code == '0'){
              $std_code = '-';
              echo "<script type='text/javascript'>
                $(document).ready(function(){
                $('#edu_level').val('');
                $('#edu_level').prop('disabled', true);
                $('#job option[value=2]').remove();
                });
                </script>"; 
            } 
            else{
              $std_code = $row->std_code;
              echo "<script type='text/javascript'>
                $(document).ready(function(){
                     $('#job').val('นักเรียน');
                     $('#job option[value=2]').attr('selected','selected');
                     $('#job option[value=1]').remove();
                     $('#job option[value=3]').remove();
                 });
                </script>";                 
            }
          ?>
          <form enctype="multipart/form-data" name="member_form" id="member_form">
            <div class="row">
              <div class="form-group col-4" align="center">
                <input type="hidden" name="member_id" id="member_id" value="<?php echo $row->member_id;?>">
                <img onmouseover="this.style.cursor = 'pointer'" id="show_image_pic" name="show_image_pic" width="40%" height= "40%" src="<?php echo $row->member_pic;?>" alt="your image" style="border: solid 1px #c0c0c0;" /> 
                <figcaption>รูปประจำตัว</figcaption>
                <input type="hidden" id="show_member_pic" name="show_member_pic" class="form-control" readonly="" value="<?php echo $row->member_pic; ?>">
                <input style="display: none;" onchange="readURL_profile(this);" type="file" class="form-control " name="pic_member" id="pic_member" >    
                <img onmouseover="this.style.cursor = 'pointer'" id="show_image_signa" width="40%" height= "40%" src="<?php echo $row->member_signa_pic;?>" alt="your image" style="border: solid 1px #c0c0c0;" /> 
                <figcaption>รูปลายเซ็น</figcaption>
                <input type="hidden" id="show_member_signa_pic" name="show_member_signa_pic" class="form-control" readonly="" value="<?php echo $row->member_signa_pic; ?>">
                <input style="display: none;" onchange="readURL_singa(this);" type="file" class="form-control " name="pic_singna" id="pic_singna" > 
              </div>  
              <div class="form-group col-8" align="left">
                <div class="row">
                  <div class="col-12">
                    <div class="row">
                      <div class="form-group col-3"><label for="name">รหัสนักเรียน</label></div>
                      <div class="form-group col-3">
                        <input type="text" class="form-control " id="std_code" name="std_code" placeholder="รหัสนักเรียน" required="" readonly value="<?php echo $std_code; ?>">
                        <div id="result_std_code"></div>
                      </div>
                     
                      <div class="form-group col-md-3">
                        <label for="name">ระดับการศึกษา</label>
                      </div>
                      <div class="form-group col-md-3"> 
                        <select  id="edu_level" name="edu_level" class="form-control" >
                          <?php 
                            foreach ($base_edu_level->result() as $row_edu) {
                          ?>
                              <option value="<?=$row_edu->edu_id;?>" <?php if($row->edu_id== $row_edu->edu_id){echo "selected";}?>> <?=$row_edu->edu_name;?> </option> 
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                    <div class="row">
                    <div class="form-group col-3">
                        <label for="name">คำนำหน้า</label>
                      </div>
                      <div class="form-group col-3">
                        <select  id="title" name="title" class="form-control">
                          <option <?php if($row->member_title=="ด.ช."){echo "selected";}?>>ด.ช.</option>
                          <option <?php if($row->member_title=="ด.ญ."){echo "selected";}?>>ด.ญ.</option>
                          <option <?php if($row->member_title=="นาย"){echo "selected";}?>>นาย</option>
                          <option <?php if($row->member_title=="น.ส."){echo "selected";}?>>น.ส.</option>
                          <option <?php if($row->member_title=="นาง"){echo "selected";}?>>นาง</option>   
                        </select>
                      </div>
                      <div class="form-group col-3">
                        <label for="name">ชื่อ-นามสกุล</label>
                      </div>
                      <div class="form-group col-3">
                        <input type="text" class="form-control " id="name" name="name" required="" value="<?php echo $row->member_name;?>" onchange="check_name(this,'2')">    
                        <div id="result_member_name"></div>
                      </div>
                     
                    </div> 
                    <div class="row">
                      <div class="form-group col-md-3">
                        <label for="name">เลขบัตรประชาชน</label>
                      </div>
                      <div class="form-group col-md-4">
                        <input type="text" class="form-control " name="idcard" id="idcard" required="" onchange="check_id_card(this)" onkeyup="autoTab2(this,1)" placeholder="เลขบัตรประชาชน" value="<?=$row->member_id_card;?>">
                        <input type="hidden" name="id_card" id="id_card" value="<?=$row->member_id_card;?>">
                      </div>
                      <div class="form-group col-md-2">
                        <label for="name">สถานะ</label>
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
                      <div class="form-group col-md-3">
                        <label >วัน/เดือน/ปีเกิด</label>
                      </div>   
                      <div class="form-group col-md-4">
                        <input type="date" class="form-control " name="b_date" id="b_date" required="" value="<?=$row->member_birth_date;?>">
                      </div> 
                      <div class="form-group col-md-2">
                        <label>ปีที่เข้าศึกษา</label>
                      </div>   
                      <div class="form-group col-md-3">
                        <input id="yofadmis" name="yofadmis" require  class="form-control "  type="number" placeholder="ปปปป" min="<?php echo date('Y',strtotime('-6 year'))+543; ?>" max="<?php echo date('Y')+543; ?>" value="<?=intval($row->member_yofadmis)+543;?>">
                      </div>                                 
                    </div>
                    <div class="row">
                      <div class="form-group col-md-3">
                        <label >เบอร์โทรศัพท์</label>
                      </div>   
                      <div class="form-group col-md-4">
                        <input onkeyup="autoTab2(this,0)" onchange="set_phone_number(this)" type="text" class="form-control " name="phonenumber" id="phonenumber" required="" placeholder="เช่น 09xxxxxxxx" value="<?=$row->phone_number;?>">
                        <input type="hidden" name="phone_number" id="phone_number" value="<?=$row->phone_number;?>">
                      </div>      
                      <div class="form-group col-md-2">
                        <label for="name">อาชีพ</label>
                      </div>   
                      <div class="form-group col-md-3">
                        <select class="form-control"  name="job" id="job">
                          <?php 
                            foreach ($base_job->result() as $row_job) {
                          ?>
                              <option value="<?=$row_job->job_id;?>" <?php if($row->job_id== $row_job->job_id){echo "selected";}?> > <?=$row_job->job_name;?> </option> 
                          <?php } ?>
                        </select>
                      </div>                                          
                    </div>
                    <div class="row">
                      <div class="form-group col-md-2">
                        <label for="name">ที่อยู่</label>
                      </div>   
                      <div class="form-group col-md-5">
                        <input type="text" class="form-control " name="address" id="address" required="" placeholder="บ้านเลขที่ หมู่ ถนน ซอย" value="<?=$row->address;?>">
                      </div> 
                      <div class="form-group col-md-1">
                        <label for="name">จังหวัด</label>
                      </div>  
                      <div class="form-group col-md-4">
                        <select  id="PROVINCE_ID" name="PROVINCE_ID" class="form-control" >
                        <?php 
                          foreach ($base_province->result() as $row_pro) {
                        ?>
                          <option value="<?=$row_pro->PROVINCE_ID;?>" <?php if($row->PROVINCE_ID== $row_pro->PROVINCE_ID){echo "selected";}?>> <?=$row_pro->PROVINCE_NAME;?> </option> 
                        <?php } ?>  
                        </select>
                      </div>                                 
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group col-12">
                <div class="row">     
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
                  <div class="form-group col-md-2">
                    <label for="name">ตำบล</label>
                  </div>
                  <div class="form-group col-md-2">
                    <select  id="DISTRICT_CODE" name="DISTRICT_CODE" class="form-control" >
                      <?php 
                        foreach ($base_districts->result() as $row_dist) {                
                      ?>
                          <option value="<?=$row_dist->DISTRICT_CODE;?>" <?php if($row->DISTRICT_CODE== $row_dist->DISTRICT_CODE){echo "selected";}?>> <?=$row_dist->DISTRICT_NAME;?> </option>
                      <?php  } ?>
                    </select>
                  </div>
                  <div class="form-group col-md-2">
                    <label  for="name">ไปรษณีย์</label>
                  </div>
                  <div class="form-group col-md-2">
                    <input type="text" class="form-control " name="zipcode" id="zipcode" value="<?php echo $row->zipcode; ?>">
                  </div>    
                </div>
                <div class="form-group col-12" align="left">
                  <div class="row">
                    <div class="form-group col-md-12 text-center">
                      <a href="<?=base_url("index.php/Project_controller/manage_member");?>" class="btn btn-success">ย้อนกลับ</a>
                      <button type="submit" class="btn btn-primary" id="submit">ตกลง</button>
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