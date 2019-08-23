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
</head>
<body>
  <h1 class="text-center"><img src="<?php  echo base_url()."picture/donkha.png"; ?>" width="5%" height="22%">ธนาคารโรงเรียนดอนคาวิทยา</h1> 
  <div class="container-fluid h-100" >
    <div class="row">
      <div class="col-md-12">
        <h5 class="text-right" style="margin-top: 5px;background-color: rgb(181, 216, 232);"><B>กรุณาเข้าสู่ระบบ</B></h5>
      </div>  
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-3"></div>
          <div class="col-md-6 border rounded" style="background-color: #EFFEFD;">
            <h5 class="text-center"><B>เข้าสู่ระบบ</B></h5>
            <form method="post" action="<?=base_url();?>index.php/Project_controller/login_check" enctype="multipart/form-data" name="login" id="login">
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="name"><B>ชื่อผู้ใช้</B></label>
                  <input type="text" class="form-control " name="username" required="">
                </div>
                <div class="form-group col-md-6">
                  <label for="name"><B>รหัสผ่าน</B></label>
                  <input type="password" class="form-control " name="password" required="">
                </div>     
              </div>
              <div class="form-row">
                <div class="form-group col-md-12 text-center">
                  <button type="submit" class="btn btn-outline-primary" id="submit">ตกลง</button>
                </div>
              </div>
              <?php  
                echo '<label class="text-danger">'.$this->session->flashdata("error").'</label>';  
              ?> 
            </form>
          </div>               
          <div class="col-md-3"></div> 
        </div>
      </div>               
    </div>
  </div>
</body>
</html>
