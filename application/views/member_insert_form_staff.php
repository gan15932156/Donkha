<style type="text/css"> 
  .scroller{
    height:80vh;
    overflow:auto;
  }                                 
</style>
<script type="text/javascript" src="<?php  echo base_url();?>bootstrap000/Project_js/select_information.js"></script>  
<script type="text/javascript" src="<?php  echo base_url();?>bootstrap000/Project_js/check_information.js"></script>  
<script type="text/javascript">
  $(document).ready(function()
  {    
    $("#member_form").submit(function(event) {
			event.preventDefault();
			$.ajax({
		     url: "<?=base_url("index.php/Project_controller/member_insert_staff");?>",
		     type:"post",
         data:new FormData(this),
         processData:false,
         contentType:false,
         cache:false,
         async:false,
		     success: function(response){
            alert("บันทึกข้อมูลสำเร็จ");
            $("#response").html(response);
		       },
		    error: function()
		    {
		     alert("error");
		    }
      });
		});
    $('#member_form').hide();
    $('#career').change(function(){
      var career = $(this).val();
      if(career == 'นักเรียน'){
        $('#member_form').show();
        $('#career').remove();
        $('#job').val('นักเรียน');
        $('#job option[value=2]').attr('selected','selected');
        $('#job option[value=1]').remove();
        $('#job option[value=3]').remove();
      }
      else{
        $('#member_form').show();
        $('#career').remove();
        $('#std_code').val("0");
        $('#std_code').prop('readonly', true);
        $('#yofadmis').val("0");
        $('#yofadmis').prop('readonly',true);
        $("#edu_level").val("");
        $('#edu_level').prop('disabled', true);
        $('#job option[value=2]').remove();
      }
    });
  });
</script>
<div class="col-md-12 text-center" >
  <div class="row text-center">
    <div class="col-md-12">
      <div  class="row scroller">
        <div class="col-md-12 ">
          <h4 class="text-center"><B>เพิ่มสมาชิก</B></h4>
        </div>
        <div class="col-md-12 ">
          <div class="row">
            <div class="col-4"></div>
            <div class="col-4">
              <select class="form-control" id="career" name="career">
                <option >เลือกสถานภาพ</option>
                <option value="นักเรียน">นักเรียน</option>
                <option value="บุคลากร">บุคลากร</option>
              </select>
            </div>
            <div class="col-4"></div>
          </div>
        </div>                      
        <div class="col-md-12 text-center">
          <form  enctype="multipart/form-data" name="member_form" id="member_form">
            <div class="row">
              <div class="form-group col-4" align="center">
                <img id="show_image_pic" width="120px" height= "140px" src="<?php  echo base_url()."picture/No_person.jpg"; ?>" alt="your image" style="border: solid 1px #c0c0c0;" /> 
                <figcaption>รูปประจำตัว</figcaption>
                <input onchange="readURL_profile(this);" type="file" class="form-control " name="pic_member" id="pic_member" required=""><br>
                <img id="show_image_signa" width="120px" height= "140px" src="<?php  echo base_url()."picture/blague-Monsieur-et-Madame-27-300x300.jpg"; ?>" alt="your image" style="border: solid 1px #c0c0c0;" /> 
                <figcaption>รูปลายเซ็น</figcaption>
                <input onchange="readURL_singa(this);" type="file" class="form-control " name="pic_singna" id="pic_singna" required="">                                                  
              </div>  
              <div class="form-group col-8" align="left">
                <div class="row">
                  <div class="col-12">
                    <div class="row">
                      <div class="form-group col-3"><label for="name">รหัสนักเรียน</label></div>
                      <div class="form-group col-4">
                        <input type="text" class="form-control " id="std_code" name="std_code" placeholder="รหัสนักเรียน" required="" onKeyUp="if(this.value*1!=this.value){ alert('กรุณากรอกเฉพาะตัวเลข'); this.value='';}">
                        <div id="result_std_code"></div>
                      </div>
                      <div class="form-group col-3">
                        <label for="name">คำนำหน้า</label>
                      </div>
                      <div class="form-group col-2">
                        <select  id="title" name="title" class="form-control">
                          <option value="ด.ช.">ด.ช.</option>
                          <option value="ด.ญ.">ด.ญ.</option>
                          <option value="นาย">นาย</option>
                          <option value="น.ส.">น.ส.</option>
                          <option value="นาง">นาง</option>
                        </select>
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-3">
                        <label for="name">ชื่อ-นามสกุล</label>
                      </div>
                      <div class="form-group col-4">
                        <input type="text" class="form-control " id="name" name="name" required="" placeholder="ชื่อ นามสกุล" onchange="check_name(this,'2')">     
                        <div id="result_member_name"></div>
                      </div>
                      <div class="form-group col-md-3">
                        <label for="name">ระดับการศึกษา</label>
                      </div>
                      <div class="form-group col-md-2"> 
                        <select  id="edu_level" name="edu_level" class="form-control" >
                          <?php 
                          foreach ($edu_level->result() as $row) {
                          ?>
                          <option value="<?php echo $row->edu_id; ?>"><?php echo $row->edu_name; ?></option><?php } ?>
                        </select>
                      </div>
                    </div> 
                    <div class="row">
                      <div class="form-group col-md-3">
                        <label for="name">เลขบัตรประชาชน</label>
                      </div>
                      <div class="form-group col-md-4">
                        <input type="text" class="form-control " name="idcard" id="idcard" required="" onchange="check_id_card(this)" onkeyup="autoTab2(this,1)" placeholder="เลขบัตรประชาชน">
                        <input type="hidden" name="id_card" id="id_card">
                      </div>
                      <div class="form-group col-md-2">
                        <label for="name">ตำแหน่ง</label>
                      </div> 
                      <div class="form-group col-md-3">
                        <select  id="permiss" name="permiss" class="form-control" >
                        <?php 
                          foreach ($permiss->result() as $row) {
                        ?>
                          <option value="<?php echo $row->level_id; ?>"><?php echo $row->level_name; ?></option>  
                        <?php } ?>
                        </select>
                      </div>
                    </div>  
                    <div class="row">
                      <div class="form-group col-md-3">
                        <label >วัน/เดือน/ปีเกิด</label>
                      </div>   
                      <div class="form-group col-md-4">
                        <input type="date" class="form-control " name="b_date" id="b_date" required="">
                      </div> 
                      <div class="form-group col-md-2">
                        <label>ปีที่เข้าศึกษา</label>
                      </div>   
                      <div class="form-group col-md-3">
                        <input id="yofadmis" name="yofadmis" require  class="form-control "  type="number" placeholder="ปปปป" min="<?php echo date('Y',strtotime('-6 year'))+543; ?>" max="<?php echo date('Y')+543; ?>">
                      </div>                                   
                    </div>
                    <div class="row">
                    <div class="form-group col-md-3">
                        <label >เบอร์โทรศัพท์</label>
                      </div>   
                      <div class="form-group col-md-4">
                        <input onkeyup="autoTab2(this,0)" onchange="set_phone_number(this)" type="text" class="form-control " name="phonenumber" id="phonenumber" required="" placeholder="เช่น 09xxxxxxxx">
                        <input type="hidden" name="phone_number" id="phone_number">
                      </div>      
                      <div class="form-group col-md-2">
                        <label for="name">อาชีพ</label>
                      </div>   
                      <div class="form-group col-md-3">
                        <select class="form-control"  name="job" id="job">
                          <?php 
                            foreach ($job->result() as $row) {
                          ?>
                              <option value="<?php echo $row->job_id; ?>"><?php echo $row->job_name; ?></option>  
                          <?php } ?>
                        </select>
                      </div>                          
                    </div>
                    <div class="row">
                      <div class="form-group col-md-2">
                        <label for="name">ที่อยู่</label>
                      </div>   
                      <div class="form-group col-md-10">
                        <input type="text" class="form-control " name="address" id="address" required="" placeholder="บ้านเลขที่ หมู่ ถนน ซอย">
                      </div>                                  
                    </div>
                    <div class="row">
                      <div class="form-group col-md-2">
                        <label for="name">จังหวัด</label>
                      </div>  
                      <div class="form-group col-md-4">
                        <select  id="PROVINCE_ID" name="PROVINCE_ID" class="form-control" >
                          <option value="">เลือกจังหวัด</option>
                        <?php 
                          foreach ($province->result() as $row) {
                        ?>
                          <option value="<?php echo $row->PROVINCE_ID; ?>"><?php echo $row->PROVINCE_NAME; ?></option>  
                        <?php } ?>
                        </select>
                      </div>
                      <div class="form-group col-md-2">
                        <label for="name">อำเภอ</label>
                      </div>
                      <div class="form-group col-md-4">
                        <select  id="AMPHUR_ID" name="AMPHUR_ID" class="form-control" ></select>
                      </div>                                         
                    </div> 
                    <div class="row">
                      <div class="form-group col-md-2">
                        <label for="name">ตำบล</label>
                      </div>
                    <div class="form-group col-md-4">
                      <select  id="DISTRICT_CODE" name="DISTRICT_CODE" class="form-control"></select>
                    </div>
                    <div class="form-group col-md-2">
                      <label style="width:100px;" for="name">รหัสไปรษณีย์</label>
                    </div>
                    <div class="form-group col-md-4">
                      <input type="text" class="form-control " name="zipcode" id="zipcode">
                    </div>    
                  </div>
                  <div class="row">
                    <div class="form-group col-md-2">
                     <label for="name">ชื่อผู้ใช้</label>
                    </div>  
                    <div class="form-group col-md-4">
                      <input type="text" class="form-control " name="username" id="username" required="" placeholder="ชื่อผู้ใช้">
                      <div id="result_username"></div>
                    </div> 
                    <div class="form-group col-md-2">
                      <label  for="name">รหัสผ่าน</label>
                    </div> 
                    <div class="form-group col-md-4">
                      <input type="password" class="form-control " name="password" id="password" required="" placeholder="รหัสผ่าน">
                    </div>   
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group col-12" align="left">
              <div class="row">
                <div class="form-group col-md-12 text-center">
                  <a href="<?=base_url("index.php/Project_controller/index_staff");?>" class="btn btn-outline-success">ย้อนกลับ</a>
                  <button type="submit" class="btn btn-outline-primary" id="submit">ตกลง</button>
                </div>
              </div>
            </div>                          
          </div>                                                
        </form> 
        </div>
      </div>
    </div>                   
  </div>        
</div>          

<div id="response"></div>