<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ธนาคารโรงเรียนดอนคาวิทยา</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script type="text/javascript" src="<?php  echo base_url();?>bootstrap000/js/jquery.min.js"></script>
  <script type="text/javascript" src="<?php  echo base_url(); ?>bootstrap000/js/popper.min.js"></script>
  <script type="text/javascript" src="<?php  echo base_url(); ?>bootstrap000/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="<?php  echo base_url(); ?>bootstrap000/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style type="text/css">
        html,body {
      background:
      url("<?php  echo base_url()."picture/school.jpg"; ?>") no-repeat center center fixed;
      -webkit-background-size: cover;
      -moz-background-size: cover;
      -o-background-size: cover;
      background-size: cover;
      height: 91%;
    }
    .container-fluid{
      background-color: rgba(199, 223, 255,.9);
      width:97%;
      height:100%;
      filter: alpha(opacity=40); /* For IE8 and earlier */
    }            
  </style>
  <script type="text/javascript">
    function logout(){
      location.replace("<?php  echo base_url()."Project_controller/logout"; ?>");
    }
  </script>
</head>
<body>
  <h1 class="text-center"><img src="<?php  echo base_url()."picture/donkha.png"; ?>" width="5%" height="22%">ธนาคารโรงเรียนดอนคาวิทยา</h1>
  <div class="container-fluid" >
    <div class="row">
      <div class="col-md-12">
        <h5 class="text-right" style="margin-top: 5px;background-color: rgb(181, 216, 232);"><?php echo "<B>ยินดีต้อนรับคุณ </B>".$this->session->userdata('sname'); ?>&nbsp</h5>
      </div>
      <div class="col-md-2" align="center" >
        <h4><a style="color: black" href="<?php  echo base_url("Project_controller/index_staff/"); ?>"><B>หน้าแรก</B></a></h4>
        <img style="border-radius: 50%;" src="<?php  echo $this->session->userdata('spic'); ?>" width="165px" height="180px">
        <h5><?php echo $this->session->userdata('sname');  ?></h5>
        <h5><?php echo "<B>ตำแหน่ง </B>".$this->session->userdata('slevel');  ?></h5>
        <button onclick="logout()" type="submit" class="btn btn-outline-danger" id="submit">ออกจากระบบ</button>
      </div>          
      <div class="col-md-10">
        <div class="row" style="margin-right:1px ;background-color: #EFFEFD;height:500px;">
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
                $std_code = 'ไม่มี';
                $edu_id = 'ไม่มี';
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
                $strMonth= date("n",strtotime($strDate));
                $strDay= date("j",strtotime($strDate));
                $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
                $strMonthThai=$strMonthCut[$strMonth];
                return "$strDay $strMonthThai $strYear";
              }
              $register_thai_date = DateThai($regis_date);
              $birth_thai_date  = DateThai($birth_date);
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
                      <div class="form-group col-6"><label><B>วันที่สมัคร : </B><?php echo "".$register_thai_date;?></label></div>
                      <div class="form-group col-6"><label><B>วัน/เดือน/ปีเกิด : </B><?php echo "".$birth_thai_date;?></label></div>
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
                        <label><B>ตำแหน่ง : </B><?php echo "<?php echo $row->level_name;?>".$row->level_name;?></label>
                      </div> 
                    </div>
                    <div class="row">
                      <div class="form-group col-md-12">
                        <label><B>ที่อยู่ : </B><?php echo "".$row->address." ตำบล".$row->DISTRICT_NAME." อำเภอ".$row->AMPHUR_NAME;?></label>
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-md-12">
                        <label><?php echo "จังหวัด".$row->PROVINCE_NAME." รหัสไปรษณีย์ ".$row->zipcode;?></label>
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
        </div>
      </div>                     
    </div>
  </div>  
</body>
</html>