<div class="col-md-12 text-center" >
  <div class="row text-center">
    <div class="col-md-12">
      <div  class="row">
        <div class="col-md-12 ">
          <h4 class="text-center"><B>ข้อมูลสมาชิก</B></h4>
        </div>                
        <div class="col-md-12 text-center">
          <?php foreach($member_after->result() as $row){ 
            if($row->std_code == '0'){
              $std_code = '-';
              $edu_id = '-';
              $job = $row->job_name;
            } 
            else{
              $std_code = $row->std_code;
              $edu_id = $row->edu_name;
              $job = 'นักเรียน';
            }
            date_default_timezone_set('Asia/Bangkok');
            $regis_date = $row->member_regis_date;
            $birth_date = $row->member_birth_date;
            function DateThai($strDate)
            { 
              $strYear = date("Y",strtotime($strDate))+543;
              $thaiyear = "พ.ศ. ". $strYear;
              $strMonth= date("n",strtotime($strDate));
              $strDay= date("j",strtotime($strDate));
              $strMonthCut = Array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
              $strMonthThai=$strMonthCut[$strMonth];
              return "$strDay $strMonthThai $thaiyear";
      	    } 
          ?>      
          <div class="row">
            <div  class="form-group col-4" align="center">
              <img id="show_image_pic" width="200px" height= "200px" src="<?php echo $row->member_pic;?>" alt="your image" style="border: solid 1px #c0c0c0;" /> 
              <figcaption><B>รูปประจำตัว</B></figcaption>
              <img id="show_image_signa" width="200px" height= "200px" src="<?php echo $row->member_signa_pic;?>" alt="your image" style="border: solid 1px #c0c0c0;" /> 
              <figcaption><B>รูปลายเซ็น</B></figcaption>
            </div>  
            <div class="form-group col-8" align="left">
              <div class="row">
                <div class="col-12">
                  <div class="row">
                    <div class="form-group col-6"><label><B>วันที่สมัคร : </B><?php echo "".DateThai($regis_date);?></label></div>
                    <div class="form-group col-6"><label><B>วัน/เดือน/ปีเกิด : </B><?php echo "".DateThai($birth_date);?></label></div>
                  </div>
                  <div class="row">
                    <div class="form-group col-6"><label><B>รหัสนักเรียน : </B><?php echo "".$std_code;?></label></div>
                    <div class="form-group col-6">
                      <label><B>เลขบัตรประชาชน : </B><?php echo "".$row->member_id_card;?></label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-6">
                      <label><B>ชื่อ : </B><?php echo "".$row->member_title."".$row->member_name;?></label>
                    </div>
                  </div>
                  <div class="row">   
                    <div class="form-group col-6">
                      <label><B>ระดับการศึกษา : </B><?php echo "".$edu_id;?></label>
                    </div>
                    <div class="form-group col-6">
                      <label><B>สถานะ : </B><?php echo "".$row->level_name;?></label>
                    </div> 
                  </div>
                  <div class="row">
                    <div class="form-group col-md-12">
                      <label><B>ที่อยู่ : </B><?php echo "".$row->address." ตำบล".$row->DISTRICT_NAME." อำเภอ".$row->AMPHUR_NAME." จังหวัด".$row->PROVINCE_NAME." รหัสไปรษณีย์ ".$row->zipcode;?></label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-6">
                      <label><B>อาชีพ : </B><?php echo "".$job;?></label>
                    </div>
                    <div class="form-group col-md-6">
                      <label><B>ชื่อผู้ใช้ : </B><?php echo "".$row->username;?></label>
                    </div> 
                  </div>  
                  <div class="row">
                    <div class="form-group col-md-4"></div>
                    <div class="form-group col-md-4">
                      <a href="<?=base_url("index.php/Project_controller/manage_member_staff");?>" class="btn btn-outline-success">ย้อนกลับ</a>
                    </div> 
                    <div class="form-group col-md-4"></div>
                  </div>  
                </div>
              </div>
            </div> 
          </div>      
        <?php  }  ?> 
      </div>
    </div>
  </div>                   
</div>        
</div>                                   