<script type="text/javascript" src="<?php  echo base_url();?>bootstrap000/Project_js/select_information.js"></script>  
<script type="text/javascript" src="<?php  echo base_url();?>bootstrap000/Project_js/check_information.js"></script>  
<script>
  $(document).ready(function(){
    $("#staff_form").submit(function(event) {
		  event.preventDefault();
			$.ajax({
		    url:"<?=base_url("index.php/Project_controller/staff_insert/");?>",
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
		    error: function()
		    {
		      alert("error");
		    }
      });
		});
  });
</script>
<div class="col-md-12 text-center" >
  <div class="row text-center">
    <div class="col-md-12">
      <div  class="row">
        <div class="col-md-12 ">
          <h4 class="text-center"><B>เพิ่มพนักงาน</B></h4>
        </div>
        <div class="col-md-12 text-center">
          <form enctype="multipart/form-data" name="staff_form" id="staff_form">
        <div class="row">
          <div class="form-group col-4" align="center">
            <img id="show_image" width="30%" height= "62%" src="<?php  echo base_url()."picture/No_person.jpg"; ?>" alt="your image" style="border: solid 1px #c0c0c0;" /> 
            <figcaption>รูปประจำตัว</figcaption>
            <input onchange="readURL(this);" type="file" class="form-control " name="pic" id="pic" required="">                
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
                    <label for="name">ชื่อ-นามสกุล</label></div>
                  <div class="form-group col-4">
                    <input type="text" class="form-control " id="name" name="name" required="" placeholder="ชื่อ นามสกุล" onchange="check_name(this,'1')">
                    <div id="result_staff_name"></div>
                  </div>
                  <div class="form-group col-md-3">
                    <label for="name">ระดับการศึกษา</label>
                  </div>
                  <div class="form-group col-md-2"> 
                    <select  id="edu_level" name="edu_level" class="form-control" >
                      <?php 
                        foreach ($edu_level->result() as $row) {
                      ?>
                          <option value="<?php echo $row->edu_id; ?>"><?php echo $row->edu_name; ?></option>  
                      <?php } ?>
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
                  <div class="form-group col-md-2">
                    <label>ปีที่เข้าศึกษา</label>
                  </div>   
                  <div class="form-group col-md-3">
                    <input id="yofadmis" name="yofadmis" require  class="form-control "  type="number" placeholder="ปปปป" min="<?php echo date('Y',strtotime('-6 year'))+543; ?>" max="<?php echo date('Y')+543; ?>" require>
                  </div>                
                  <div class="form-group col-md-1">
                    <label for="name" style="width:50px">ที่อยู่</label>
                  </div>   
                  <div class="form-group col-md-6">
                    <input type="text" class="form-control " name="address" id="address" required="" placeholder="บ้านเลขที่ หมู่ ถนน ซอย">
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
                  <option value="">เลือกจังหวัด</option>
                    <?php 
                      foreach ($province->result() as $row) {
                    ?>
                        <option value="<?php echo $row->PROVINCE_ID; ?>"><?php echo $row->PROVINCE_NAME; ?></option>  
                    <?php } ?>
                </select>
              </div>
              <div class="form-group col-md-1">
                <label for="name">อำเภอ</label>
              </div>
              <div class="form-group col-md-3">
                <select  id="AMPHUR_ID" name="AMPHUR_ID" class="form-control" ></select>
              </div>
              <div class="form-group col-md-1">
                <label for="name">ตำบล</label>
              </div>
              <div class="form-group col-md-3">
                <select  id="DISTRICT_CODE" name="DISTRICT_CODE" class="form-control">
                </select>
              </div>                                      
            </div>
            <div class="row">
              <div class="form-group col-md-2">
                <label for="name">รหัสไปรษณีย์</label>
              </div>
              <div class="form-group col-md-2">
                <input type="text" class="form-control " name="zipcode" id="zipcode">
              </div>                                 
              <div class="form-group col-md-1">
                <label for="name">ชื่อผู้ใช้</label>
              </div>  
              <div class="form-group col-md-3">
                <input type="text" class="form-control " name="username" id="username" required="" placeholder="ชื่อผู้ใช้">
                <div id="result_username"></div>
              </div> 
              <div class="form-group col-md-1">
                <label style="width:80px;" for="name">รหัสผ่าน</label>
              </div> 
              <div class="form-group col-md-3">
                <input type="password" class="form-control " name="password" id="password" required="" placeholder="รหัสผ่าน">
              </div>
            </div>
            <div class="row">
              <div class="form-group col-md-12 text-center"><br>
                <a href="<?=base_url("index.php/Project_controller/index_admin");?>" class="btn btn-outline-success">ย้อนกลับ</a>
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
                                  