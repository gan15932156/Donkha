<script type="text/javascript">
  function logout(){
    location.replace("<?php  echo base_url()."Project_controller/logout"; ?>");
  }
</script>     
<div class="col-md-12 text-center" >
  <div class="row text-center">
    <div class="col-md-12">
      <div  class="row">
        <div class="col-md-12 ">
          <h4 class="text-center"><B>ข้อมูลพนักงาน</B></h4>
        </div>
        <div class="col-md-12 text-center">
          <?php 
          foreach($staff->result() as $row){  
            date_default_timezone_set('Asia/Bangkok');
            $regis_date = $row->staff_regis_date;
            function DateThai($strDate)
            {
              $strYear = date("Y",strtotime($strDate))+543;
              $strMonth= date("n",strtotime($strDate));
              $strDay= date("j",strtotime($strDate));
              $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
              $strMonthThai=$strMonthCut[$strMonth];
              return "$strDay $strMonthThai $strYear";
            }
            $thai_date = DateThai($regis_date);
            ?>
            <div class="row">
              <div class="form-group col-4">                       
                <img id="show_image" width="50%" height= "80%" src="<?php echo $row->staff_pic;?>" alt="your image" style="border: solid 1px #c0c0c0;" /> 
                <figcaption><B>รูปประจำตัว</B></figcaption>
              </div>  
              <div class="form-group col-8" align="left">
                <div class="row">                                      
                  <div class="col-12">
                    <div class="row">  
                      <div class="form-group col-6">
                        <label><B>วันที่สมัคร : </B><?php echo "".$thai_date;?></label>
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-6"><label><B>รหัสนักเรียน : </B><?php echo "".$row->stu_code;?></label></div>
                      <div class="form-group col-6">
                        <label ><B>เลขบัตรประชาชน : </B><?php echo "".$row->staff_id_card;?></label>
                      </div>
                    </div>
                    <div class="row">   
                      <div class="form-group col-md-6">
                        <label><B>ชื่อ : </B><?php echo "".$row->staff_title."".$row->staff_name;?></label>
                      </div>
                      <div class="form-group col-md-6">
                        <label><B>ชื่อผู้ใช้ : </B><?php echo "".$row->username;?></label>
                      </div>
                    </div>  
                    <div class="row">   
                      <div class="form-group col-6">
                        <label><B>ระดับการศึกษา : </B><?php echo "".$row->edu_name;?></label>
                      </div>
                      <div class="form-group col-md-6">
                        <label><B>สถานะ : </B><?php echo "<?php echo $row->level_name;?>".$row->level_name;?></label>
                      </div>  
                    </div> 
                    <div class="row">
                      <div class="form-group col-md-12">
                        <label><B>ที่อยู่ : </B><?php echo "".$row->staff_address." ตำบล".$row->DISTRICT_NAME." อำเภอ".$row->AMPHUR_NAME." จังหวัด".$row->PROVINCE_NAME." รหัสไปรษณีย์ ".$row->zipcode;?></label>
                      </div>                                       
                    </div>                        
                  </div>
                </div>
              </div>
            </div>                                                
            <?php  }  ?> 
          </div>
        </div>
      </div>   
      <div class="col-md-12"> <a href="<?=base_url("index.php/Project_controller/manage_staff");?>" class="btn btn-outline-success">ย้อนกลับ</a></div>                
    </div>        
  </div>                                   
</div>



