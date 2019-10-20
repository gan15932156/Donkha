<script>
  $(document).ready(function(){
    $("#account_form").submit(function(event) {
      event.preventDefault(); 
      var connn = confirm("ยืนยันการเปิดบัญชีหรือไม่");
      if(connn){
        $.ajax({
		    url: "<?=base_url("Project_controller/account_insert_staff/");?>",
		    type:"post",
        data:new FormData($(this)[0]),
        processData:false,
        contentType:false,
        cache:false,
        async:false,
        dataType: "JSON",		
        error: function(){ alert("error"); }
        }).done(function(data){
          alert(data.message);
          window.open("<?=base_url("Project_controller/account_detail/");?>"+$("#ac_code").val(), "_self");
        });
      }
		});
  });
</script>
<div class="col-md-12 text-center" >
  <div class="row text-center">
    <div class="col-md-12">
      <div  class="row">
        <div class="col-md-12 ">
          <h4 class="text-center"><B>เปิดบัญชี</B></h4>
        </div>
        <div class="col-md-12 text-center"><br>
      <?php foreach($member->result() as $row){ 
        if($row->std_code == '0'){
          $new_stu_code = "ไม่มี";
        }
        else{
          $new_stu_code = $row->std_code;
        }
        ?>
      <form  enctype="multipart/form-data" name="account_form" id="account_form">
        <div class="row">
        <div class="form-group col-4" align="center">        
          <img id="show_image_pic" width="200px" height= "250px" src="<?php  echo $row->member_pic; ?>" alt="your image" style="border: solid 1px #c0c0c0;" />
          <figcaption>รูปประจำตัว</figcaption>   
          <input type="hidden" name="staff_id" id="staff_id" value="<?php echo $this->session->userdata('id'); ?>">  
          <input type="hidden" name="member_id" id="member_id" value="<?php echo $row->member_id; ?>">
          </div>  
          <div class="form-group col-8" align="left">
            <div class="row">                       
              <div class="col-12">
                <div class="row">
                  <div class="form-group col-3"><label>วันที่ทำรายการ</label></div>
                  <div class="form-group col-3">
                    <?php
                      function DateThai($strDate)
                      { 
                        $strYear = date("Y",strtotime($strDate))+543;
                        $strMonth= date("n",strtotime($strDate));
                        $strDay= date("j",strtotime($strDate));
                        $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
                        $strMonthThai=$strMonthCut[$strMonth];
                        return "$strDay $strMonthThai $strYear";
                      } 
                      date_default_timezone_set('Asia/Bangkok');
                      $regis_date = date('Y-m-d');
                      $now_time= date('H:i:s');
                      $thai_date=DateThai($regis_date);
                      $b_date=DateThai($row->member_birth_date);
                    ?>
                    <input type="text" class="form-control" value="<?php echo $thai_date; ?>" id="now_date" name="now_date" readonly="">
                    <input type="hidden" class="form-control" value="<?php echo $regis_date; ?>" id="date" name="date" readonly="">
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-3"><label>รหัสนักเรียน</label></div>
                  <div class="form-group col-3">
                    <input type="text" class="form-control " id="std_code" name="std_code" placeholder="รหัสนักเรียน" readonly="" value="<?php echo $new_stu_code; ?>">
                    <div id="result_std_code"></div>
                  </div>
                  <div class="form-group col-2">
                    <label style="width: 90px;">ชื่อ-นามสกุล</label>
                  </div>
                  <div class="form-group col-4">
                    <input type="text" placeholder="ชื่อ-นามสกุล" class="form-control " id="name" name="name" readonly="" value="<?php echo $row->member_name; ?>">
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-3">
                    <label>วัน/เดือน/ปีเกิด</label>
                  </div>
                  <div class="form-group col-3">
                    <input type="text" placeholder="วัน/เดือน/ปีเกิด" class="form-control " id="b_date" name="b_date" readonly="" value="<?php echo $b_date; ?>">    
                  </div>
                  <div class="form-group col-md-2">
                    <label style="width: 95px;">เบอร์โทรศัพท์</label>
                  </div>
                  <div class="form-group col-md-4"> 
                    <input type="text" placeholder="เบอร์โทรศัพท์" class="form-control " id="tel" name="tel" readonly="" value="<?php echo $row->phone_number; ?>">
                  </div>
                </div> 
                <div class="row">
                  <div class="form-group col-md-3">
                    <label for="name">ชื่อบัญชี</label>
                  </div>
                  <div class="form-group col-md-4">
                    <input type="text" class="form-control " name="ac_name" id="ac_name" required="" placeholder="ชื่อบัญชี" value="<?php echo $row->member_name; ?>">
                  </div>
                  <div class="form-group col-md-2">
                    <label  for="name">จำนวนเงิน</label>
                  </div> 
                  <div class="form-group col-md-3">
                    <input type="text" class="form-control " name="money" id="money" required="" placeholder="จำนวนเงิน" onKeyUp="if(this.value*1!=this.value){ alert('กรุณากรอกเฉพาะตัวเลข'); this.value='';}">
                  </div>
                </div>  
                <div class="row">
                  <div class="form-group col-md-3">
                    <label>หมายเลขบัญชี</label>
                  </div>   
                  <div class="form-group col-md-3">
                    <input type="text" class="form-control " name="ac_code" id="ac_code" placeholder="เลขที่บัญชี" readonly="" value="<?php echo $accode; ?>">
                  </div>                                          
                </div> 
              </div>
            </div>
          </div>
          <div class="form-group col-12" align="left">
            <div class="row">
              <div class="form-group col-md-12 text-center">
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